# Birthday Page Generator 🎂

## 📖 Mô tả
Hệ thống tạo trang sinh nhật đẹp mắt với hiệu ứng đặc biệt:
- 🎂 Form tạo trang sinh nhật dễ sử dụng
- 🎵 Upload nhạc nền (MP3, WAV, OGG)
- 💝 Lời chúc tùy chỉnh 
- 🎆 Hiệu ứng pháo hoa và animation
- 📱 Responsive design cho mọi thiết bị
- 🔗 Chia sẻ link dễ dàng

## 🚀 Demo
- [🔗 Live Demo](https://your-domain.com) 
- [📺 Video Demo](link-video)

## 📁 Phiên bản

### 1️⃣ localStorage Version (index.html + home.html)
- ✅ **Hoàn thành** và sẵn sàng sử dụng
- 💾 Lưu trữ trên trình duyệt (localStorage)
- 📏 Giới hạn: 5MB, chỉ xem được trên máy tạo
- 🎵 Nén nhạc tự động xuống 15-30 giây
- 🎯 **Phù hợp**: Sử dụng cá nhân, demo nhanh

### 2️⃣ PHP/MySQL Version (Mới phát triển)
- 🏗️ **Đang phát triển** cho hosting chuyên nghiệp
- 🗄️ Lưu trữ trên server MySQL
- ♾️ Không giới hạn dung lượng 
- 🎵 Upload file nhạc nguyên bản
- 🌐 Chia sẻ toàn cầu qua URL
- 🎯 **Phù hợp**: Website thương mại, hosting

## 🛠️ Cài đặt

### Phiên bản localStorage (Khuyên dùng)
```bash
1. Tải về index.html và home.html
2. Mở index.html trong trình duyệt
3. Tạo trang sinh nhật
4. Chia sẻ link home.html?id=xxx
```

### Phiên bản PHP/MySQL (Hosting)
```bash
1. Upload tất cả files lên hosting
2. Tạo database MySQL
3. Import database_hosting.sql
4. Cấu hình config.php
5. Truy cập domain.com
```

## ⚙️ Công nghệ
- **Frontend**: HTML5, CSS3, Vanilla JavaScript
- **Backend**: PHP 7.4+, MySQL 5.7+
- **Audio**: Web Audio API, AudioContext
- **Database**: PDO MySQL với prepared statements
- **Security**: CSRF protection, XSS prevention

## 📋 Files

### Core Files
- `index.html` - Trang tạo sinh nhật (localStorage)
- `home.html` - Trang hiển thị sinh nhật (localStorage)  
- `home.php` - Trang hiển thị sinh nhật (PHP version)

### PHP Backend  
- `config.php` - Cấu hình database
- `save_birthday.php` - API lưu dữ liệu
- `get_birthday.php` - API lấy dữ liệu
- `database_hosting.sql` - Cấu trúc database

### Config Files
- `.htaccess` - URL rewrite và security
- `README.md` - Hướng dẫn này

## 🎵 Tính năng âm thanh
- Hỗ trợ: MP3, WAV, OGG
- localStorage: Tự động nén 15-30s, 8kHz mono
- PHP: Lưu file gốc, tối đa 10MB
- Chạm để phát nhạc (Web Audio API)

## 🔒 Bảo mật
- ✅ SQL Injection protection (PDO)
- ✅ XSS prevention 
- ✅ File upload validation
- ✅ CSRF protection
- ✅ Directory traversal protection

## 📱 Responsive
- 📱 Mobile: < 768px
- 💻 Tablet: 768px - 1024px  
- 🖥️ Desktop: > 1024px

## 🤝 Đóng góp
1. Fork repository
2. Tạo branch mới
3. Commit changes
4. Push và tạo Pull Request

## 📄 License
MIT License - Sử dụng tự do cho mọi mục đích

## 👨‍💻 Tác giả
- **GitHub**: [your-username]
- **Email**: your-email@domain.com
- **Website**: [your-website.com]

---
⭐ **Star repo này nếu hữu ích!** ⭐
