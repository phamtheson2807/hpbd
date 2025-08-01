<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title id="pageTitle">Chúc Mừng Sinh Nhật</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            overflow: hidden;
            position: relative;
            cursor: pointer;
        }
        .container {
            position: relative;
            width: 100%;
            height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            z-index: 2;
        }
        .birthday-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            padding: 40px;
            box-shadow: 0 8px 32px rgba(31, 38, 135, 0.37);
            max-width: 600px;
            width: 90%;
            animation: cardFloat 3s ease-in-out infinite alternate;
        }
        @keyframes cardFloat {
            0% { transform: translateY(0px); }
            100% { transform: translateY(-10px); }
        }
        .birthday-title {
            font-size: 3rem;
            font-weight: 700;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 20px;
            animation: titlePulse 2s ease-in-out infinite;
        }
        @keyframes titlePulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        .birthday-name {
            font-size: 2.5rem;
            color: #374151;
            margin-bottom: 10px;
            font-weight: 600;
        }
        .birthday-age {
            font-size: 1.5rem;
            color: #64748b;
            margin-bottom: 30px;
        }
        .wishes-container {
            margin-top: 30px;
        }
        .wish-item {
            font-size: 1.2rem;
            color: #374151;
            margin: 15px 0;
            padding: 15px;
            background: rgba(255, 255, 255, 0.7);
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            opacity: 0;
            transform: translateY(20px);
            animation: wishAppear 0.8s ease-out forwards;
        }
        @keyframes wishAppear {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .music-controls {
            position: fixed;
            bottom: 30px;
            right: 30px;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 50px;
            padding: 15px 20px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
            display: none;
            align-items: center;
            gap: 10px;
            z-index: 1000;
        }
        .music-btn {
            background: none;
            border: none;
            font-size: 1.5rem;
            color: #667eea;
            cursor: pointer;
            transition: transform 0.2s;
        }
        .music-btn:hover {
            transform: scale(1.2);
        }
        .music-info {
            font-size: 0.9rem;
            color: #64748b;
        }
        .fireworks {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 1;
        }
        .firework {
            position: absolute;
            width: 4px;
            height: 4px;
            border-radius: 50%;
            animation: fireworkAnim 1s ease-out forwards;
        }
        @keyframes fireworkAnim {
            0% {
                transform: scale(0);
                opacity: 1;
            }
            100% {
                transform: scale(20);
                opacity: 0;
            }
        }
        .tap-instruction {
            position: fixed;
            bottom: 50%;
            left: 50%;
            transform: translate(-50%, 50%);
            background: rgba(0, 0, 0, 0.7);
            color: white;
            padding: 15px 25px;
            border-radius: 25px;
            font-size: 1rem;
            animation: tapPulse 2s ease-in-out infinite;
            z-index: 1000;
        }
        @keyframes tapPulse {
            0%, 100% { opacity: 0.7; transform: translate(-50%, 50%) scale(1); }
            50% { opacity: 1; transform: translate(-50%, 50%) scale(1.1); }
        }
        .loading {
            text-align: center;
            color: white;
            font-size: 1.5rem;
        }
        .error {
            text-align: center;
            color: #ef4444;
            background: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 16px;
            margin: 20px;
        }
        @media (max-width: 768px) {
            .birthday-card {
                padding: 30px 20px;
                margin: 20px;
            }
            .birthday-title {
                font-size: 2.5rem;
            }
            .birthday-name {
                font-size: 2rem;
            }
            .wish-item {
                font-size: 1.1rem;
                padding: 12px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="loading" id="loading">
            <i class="fas fa-spinner fa-spin"></i><br>
            Đang tải trang sinh nhật...
        </div>
        
        <div class="birthday-card" id="birthdayCard" style="display: none;">
            <h1 class="birthday-title" id="title">Chúc Mừng Sinh Nhật</h1>
            <h2 class="birthday-name" id="name">Tên</h2>
            <p class="birthday-age" id="ageInfo">Tuổi • Ngày sinh</p>
            
            <div class="wishes-container" id="wishesContainer">
                <!-- Wishes sẽ được tải từ JavaScript -->
            </div>
        </div>
        
        <div class="error" id="error" style="display: none;">
            <i class="fas fa-exclamation-triangle"></i><br>
            <span id="errorMessage">Không tìm thấy trang sinh nhật</span>
        </div>
    </div>
    
    <div class="fireworks" id="fireworks"></div>
    
    <div class="tap-instruction" id="tapInstruction">
        <i class="fas fa-hand-pointer"></i> Chạm để bắt đầu nhạc
    </div>
    
    <div class="music-controls" id="musicControls">
        <button class="music-btn" id="playPauseBtn" onclick="toggleMusic()">
            <i class="fas fa-pause"></i>
        </button>
        <div class="music-info" id="musicInfo">Đang phát nhạc</div>
    </div>
    
    <audio id="backgroundMusic" loop></audio>
    
    <script>
        let birthdayData = null;
        let audioElement = null;
        let isPlaying = false;
        let userInteracted = false;
        
        // Lấy ID từ URL
        const urlParams = new URLSearchParams(window.location.search);
        const birthdayId = urlParams.get('id');
        
        if (!birthdayId) {
            showError('Không tìm thấy ID trang sinh nhật');
        } else {
            loadBirthdayData();
        }
        
        async function loadBirthdayData() {
            try {
                const response = await fetch(`get_birthday.php?id=${encodeURIComponent(birthdayId)}`);
                const result = await response.json();
                
                if (result.success) {
                    birthdayData = result.data;
                    displayBirthdayData();
                    setupMusic();
                } else {
                    throw new Error(result.error || 'Không tìm thấy dữ liệu');
                }
            } catch (error) {
                console.error('Error loading birthday data:', error);
                showError(error.message);
            }
        }
        
        function displayBirthdayData() {
            // Cập nhật title
            document.getElementById('pageTitle').textContent = birthdayData.title;
            document.title = `${birthdayData.title} - ${birthdayData.name}`;
            
            // Hiển thị thông tin
            document.getElementById('title').textContent = birthdayData.title;
            document.getElementById('name').textContent = birthdayData.name;
            document.getElementById('ageInfo').textContent = `${birthdayData.age} tuổi • ${birthdayData.date}`;
            
            // Hiển thị lời chúc
            const wishesContainer = document.getElementById('wishesContainer');
            wishesContainer.innerHTML = '';
            
            birthdayData.wishes.forEach((wish, index) => {
                const wishElement = document.createElement('div');
                wishElement.className = 'wish-item';
                wishElement.textContent = wish;
                wishElement.style.animationDelay = `${index * 0.3}s`;
                wishesContainer.appendChild(wishElement);
            });
            
            // Ẩn loading và hiển thị card
            document.getElementById('loading').style.display = 'none';
            document.getElementById('birthdayCard').style.display = 'block';
            
            // Bắt đầu hiệu ứng pháo hoa
            startFireworks();
        }
        
        function setupMusic() {
            if (birthdayData.music) {
                audioElement = document.getElementById('backgroundMusic');
                audioElement.src = birthdayData.music.url;
                audioElement.volume = 0.7;
                
                // Hiển thị thông tin nhạc
                document.getElementById('musicInfo').textContent = birthdayData.music.name;
                
                // Ẩn instruction khi không có nhạc
                if (birthdayData.music) {
                    document.getElementById('tapInstruction').style.display = 'block';
                } else {
                    document.getElementById('tapInstruction').style.display = 'none';
                }
            } else {
                document.getElementById('tapInstruction').style.display = 'none';
            }
        }
        
        function showError(message) {
            document.getElementById('loading').style.display = 'none';
            document.getElementById('errorMessage').textContent = message;
            document.getElementById('error').style.display = 'block';
        }
        
        // Xử lý click để phát nhạc
        document.body.addEventListener('click', function() {
            if (!userInteracted && audioElement) {
                userInteracted = true;
                document.getElementById('tapInstruction').style.display = 'none';
                playMusic();
            }
        });
        
        function playMusic() {
            if (audioElement && !isPlaying) {
                audioElement.play().then(() => {
                    isPlaying = true;
                    document.getElementById('musicControls').style.display = 'flex';
                    document.getElementById('playPauseBtn').innerHTML = '<i class="fas fa-pause"></i>';
                }).catch(error => {
                    console.log('Cannot play audio:', error);
                });
            }
        }
        
        function toggleMusic() {
            if (!audioElement) return;
            
            if (isPlaying) {
                audioElement.pause();
                isPlaying = false;
                document.getElementById('playPauseBtn').innerHTML = '<i class="fas fa-play"></i>';
            } else {
                audioElement.play().then(() => {
                    isPlaying = true;
                    document.getElementById('playPauseBtn').innerHTML = '<i class="fas fa-pause"></i>';
                });
            }
        }
        
        function startFireworks() {
            const fireworksContainer = document.getElementById('fireworks');
            const colors = ['#ff6b6b', '#4ecdc4', '#45b7d1', '#96ceb4', '#feca57', '#ff9ff3'];
            
            function createFirework() {
                const firework = document.createElement('div');
                firework.className = 'firework';
                firework.style.left = Math.random() * 100 + '%';
                firework.style.top = Math.random() * 100 + '%';
                firework.style.backgroundColor = colors[Math.floor(Math.random() * colors.length)];
                
                fireworksContainer.appendChild(firework);
                
                setTimeout(() => {
                    firework.remove();
                }, 1000);
            }
            
            // Tạo pháo hoa định kỳ
            setInterval(createFirework, 800);
            
            // Tạo burst ban đầu
            for (let i = 0; i < 5; i++) {
                setTimeout(createFirework, i * 200);
            }
        }
    </script>
</body>
</html>
