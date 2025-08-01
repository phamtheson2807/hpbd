<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

require_once 'config.php';

try {
    $shortId = $_GET['id'] ?? '';
    
    if (empty($shortId)) {
        throw new Exception('ID không hợp lệ');
    }
    
    $pdo = DatabaseConfig::getConnection();
    
    // Lấy thông tin sinh nhật
    $stmt = $pdo->prepare("
        SELECT id, short_id, name, age, birth_date, title, music_filename, music_original_name, music_size, created_at
        FROM birthday_data 
        WHERE short_id = ?
    ");
    $stmt->execute([$shortId]);
    $birthday = $stmt->fetch();
    
    if (!$birthday) {
        throw new Exception('Không tìm thấy trang sinh nhật');
    }
    
    // Lấy danh sách lời chúc
    $stmt = $pdo->prepare("
        SELECT wish_text 
        FROM birthday_wishes 
        WHERE birthday_id = ? 
        ORDER BY order_index ASC
    ");
    $stmt->execute([$birthday['id']]);
    $wishes = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    // Tăng view count (tùy chọn)
    $stmt = $pdo->prepare("
        INSERT INTO birthday_views (birthday_id, ip_address, user_agent) 
        VALUES (?, ?, ?)
    ");
    $stmt->execute([
        $birthday['id'], 
        $_SERVER['REMOTE_ADDR'] ?? 'unknown',
        $_SERVER['HTTP_USER_AGENT'] ?? 'unknown'
    ]);
    
    // Chuẩn bị URL nhạc
    $musicUrl = null;
    if ($birthday['music_filename']) {
        $uploadConfig = DatabaseConfig::getUploadConfig();
        $musicUrl = $uploadConfig['upload_dir'] . $birthday['music_filename'];
    }
    
    // Trả về dữ liệu
    echo json_encode([
        'success' => true,
        'data' => [
            'name' => $birthday['name'],
            'age' => $birthday['age'],
            'date' => $birthday['birth_date'],
            'title' => $birthday['title'],
            'wishes' => $wishes,
            'music' => $musicUrl ? [
                'url' => $musicUrl,
                'name' => $birthday['music_original_name'],
                'size' => $birthday['music_size']
            ] : null,
            'created_at' => $birthday['created_at']
        ]
    ]);
    
} catch (Exception $e) {
    http_response_code(404);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}
?>
