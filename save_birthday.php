<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

require_once 'config.php';

// Chỉ cho phép POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

try {
    $pdo = DatabaseConfig::getConnection();
    $uploadConfig = DatabaseConfig::getUploadConfig();
    
    // Tạo thư mục upload nếu chưa có
    if (!is_dir($uploadConfig['upload_dir'])) {
        mkdir($uploadConfig['upload_dir'], 0755, true);
    }
    
    // Lấy dữ liệu từ form
    $name = trim($_POST['name'] ?? '');
    $age = intval($_POST['age'] ?? 0);
    $date = trim($_POST['date'] ?? '');
    $title = trim($_POST['title'] ?? '');
    $wishes = json_decode($_POST['wishes'] ?? '[]', true);
    
    // Validate dữ liệu cơ bản
    if (empty($name) || $age <= 0 || empty($date) || empty($title)) {
        throw new Exception('Vui lòng nhập đầy đủ thông tin');
    }
    
    if (!is_array($wishes) || count($wishes) === 0) {
        throw new Exception('Vui lòng thêm ít nhất 1 lời chúc');
    }
    
    // Validate ngày sinh
    if (!preg_match('/^\d{2}\.\d{2}\.\d{2}$/', $date)) {
        throw new Exception('Định dạng ngày sinh không hợp lệ (DD.MM.YY)');
    }
    
    // Tạo short_id unique
    do {
        $shortId = generateShortId();
        $stmt = $pdo->prepare("SELECT id FROM birthday_data WHERE short_id = ?");
        $stmt->execute([$shortId]);
    } while ($stmt->fetch());
    
    // Xử lý file nhạc
    $musicFilename = null;
    $musicOriginalName = null;
    $musicSize = null;
    
    if (isset($_FILES['music']) && $_FILES['music']['error'] === UPLOAD_ERR_OK) {
        $musicFile = $_FILES['music'];
        
        // Validate file type
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $musicFile['tmp_name']);
        finfo_close($finfo);
        
        if (!in_array($mimeType, $uploadConfig['allowed_types'])) {
            throw new Exception('Định dạng file nhạc không được hỗ trợ');
        }
        
        // Validate file size
        if ($musicFile['size'] > $uploadConfig['max_file_size']) {
            throw new Exception('File nhạc quá lớn (tối đa 10MB)');
        }
        
        // Tạo tên file unique
        $extension = pathinfo($musicFile['name'], PATHINFO_EXTENSION);
        $musicFilename = $shortId . '_' . time() . '.' . $extension;
        $uploadPath = $uploadConfig['upload_dir'] . $musicFilename;
        
        // Upload file
        if (!move_uploaded_file($musicFile['tmp_name'], $uploadPath)) {
            throw new Exception('Không thể upload file nhạc');
        }
        
        $musicOriginalName = $musicFile['name'];
        $musicSize = $musicFile['size'];
    }
    
    // Bắt đầu transaction
    $pdo->beginTransaction();
    
    try {
        // Insert birthday data
        $stmt = $pdo->prepare("
            INSERT INTO birthday_data (short_id, name, age, birth_date, title, music_filename, music_original_name, music_size) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([$shortId, $name, $age, $date, $title, $musicFilename, $musicOriginalName, $musicSize]);
        
        $birthdayId = $pdo->lastInsertId();
        
        // Insert wishes
        $stmt = $pdo->prepare("INSERT INTO birthday_wishes (birthday_id, wish_text, order_index) VALUES (?, ?, ?)");
        
        foreach ($wishes as $index => $wish) {
            $wish = trim($wish);
            if (!empty($wish)) {
                $stmt->execute([$birthdayId, $wish, $index]);
            }
        }
        
        $pdo->commit();
        
        // Trả về kết quả thành công
        echo json_encode([
            'success' => true,
            'short_id' => $shortId,
            'url' => 'home.php?id=' . $shortId,
            'message' => 'Tạo trang sinh nhật thành công!'
        ]);
        
    } catch (Exception $e) {
        $pdo->rollBack();
        
        // Xóa file đã upload nếu có lỗi
        if ($musicFilename && file_exists($uploadConfig['upload_dir'] . $musicFilename)) {
            unlink($uploadConfig['upload_dir'] . $musicFilename);
        }
        
        throw $e;
    }
    
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}

function generateShortId($length = 8) {
    $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    $result = '';
    for ($i = 0; $i < $length; $i++) {
        $result .= $chars[rand(0, strlen($chars) - 1)];
    }
    return $result;
}
?>
