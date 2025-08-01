<?php
// Template cấu hình database - Copy và rename thành config.php
class DatabaseConfig {
    // Thay đổi thông tin sau theo hosting của bạn
    private static $host = 'localhost';                    // Database host
    private static $database = 'your_database_name';       // Tên database
    private static $username = 'your_username';            // Username database  
    private static $password = 'your_password';            // Password database
    private static $charset = 'utf8mb4';
    
    public static function getConnection() {
        $dsn = "mysql:host=" . self::$host . ";dbname=" . self::$database . ";charset=" . self::$charset;
        
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];
        
        try {
            return new PDO($dsn, self::$username, self::$password, $options);
        } catch (PDOException $e) {
            error_log("Database connection failed: " . $e->getMessage());
            throw new PDOException("Không thể kết nối database");
        }
    }
    
    // Cấu hình upload
    public static function getUploadConfig() {
        return [
            'max_file_size' => 10 * 1024 * 1024, // 10MB
            'allowed_types' => ['audio/mpeg', 'audio/wav', 'audio/ogg', 'audio/mp3'],
            'upload_dir' => 'uploads/music/',
            'max_duration' => 45 // giây
        ];
    }
}
?>
