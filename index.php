<?php
session_start();

$users = [
    ["username" => "Nicholas.P.W", "password" => "N1cholas.12345", "role" => "user"],
    ["username" => "Judith.L.H", "password" => "Judith7.4", "role" => "admin"]
];

$error = ""; 
$loginSuccess = false; 

// Cek login
if (isset($_POST['login'])) {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    foreach ($users as $u) {
        if ($username === $u['username'] && $password === $u['password']) {
            $_SESSION['login'] = true;
            $_SESSION['username'] = $username; 
            $_SESSION['role'] = $u['role'];
            $loginSuccess = true;
            break;
        }
    }

    if (!$loginSuccess) {
        $error = "Username atau password salah!";
    }
}

if ($loginSuccess && isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
    header("Location: admin.php");
    exit();
}

// Logout
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Welcome to Zootopia🌸</title>

<!-- FONT DISNEY ZOOTOPIA ORIGINAL -->
<link href="https://fonts.cdnfonts.com/css/waltograph" rel="stylesheet">

<!-- FONT SERIF ELEGANT untuk card content -->
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

<style>
/* BODY */
body {
    margin: 0;
    font-family: 'Poppins', sans-serif;
    height: 100vh;
    overflow: hidden;
    display: flex;
    justify-content: center;
    align-items: center;
    background: url('bg.png') center/cover no-repeat;
    position: relative;
}

/* SPARKLE */
body::before {
    content: "";
    position: absolute;
    width: 100%;
    height: 100%;
    background: radial-gradient(circle, rgba(255,255,255,0.4) 2px, transparent 2px);
    background-size: 80px 80px;
    animation: sparkleMove 20s linear infinite;
}

@keyframes sparkleMove {
    from { transform: translateY(0); }
    to { transform: translateY(-200px); }
}

/* CONTAINER */
.container {
    width: 650px;
}

/* LOGIN CARD */
.card {
    display: flex;
    border-radius: 25px;
    backdrop-filter: blur(15px);
    background: rgba(255, 192, 203, 0.2);
    box-shadow: 0 25px 60px rgba(255,105,180,0.4);
    overflow: visible;
}

.left {
    width: 50%;
    position: relative;
}

/* CHARACTER */
.character {
    position: absolute;
    width: 150%;
    bottom: -5px;
    left: -55px;
    z-index: 2;
    filter: drop-shadow(0 20px 20px rgba(0,0,0,0.4));
}

/* FLOWER */
.flower {
    position: absolute;
    bottom: -75px;
    left: 185px;
    transform: translateX(-50%) rotate(10deg);
    width: 220%;
    max-width: 350px;
    z-index: 3;
    pointer-events: none;
    filter: drop-shadow(0 8px 8px rgba(0,0,0,0.2));
    opacity: 0.95;
}

.right {
    width: 50%;
    padding: 50px;
    color: white;
}

/* JUDUL */
h2 {
    margin-bottom: 20px;
    font-family: 'Waltograph', cursive;
    font-size: 28px;
    letter-spacing: 2px;
    color: white;
    text-shadow:
        0 0 10px #fff,
        0 0 20px #ff7eb3,
        0 0 30px #ff4d6d;
    text-align: center;
}

input {
    width: 100%;
    padding: 12px;
    margin: 10px 0;
    border-radius: 10px;
    border: none;
    outline: none;
    background: rgba(255,255,255,0.3);
    color: white;
    backdrop-filter: blur(5px);
    font-size: 15px;
}

input::placeholder {
    color: #fff;
}

button {
    width: 100%;
    padding: 12px;
    background: linear-gradient(45deg, #ff7eb3, #ff4d6d);
    color: white;
    border: none;
    border-radius: 10px;
    cursor: pointer;
    font-weight: bold;
    font-size: 16px;
    transition: 0.3s;
}

button:hover {
    transform: scale(1.05);
    box-shadow: 0 0 20px #ff7eb3;
}

button {
    width: 100%;
    padding: 18px;
    background: linear-gradient(45deg, #ff69b4, #ff1493, #ff69b4);
    color: white;
    border: none;
    border-radius: 18px;
    cursor: pointer;
    font-family: 'Poppins', sans-serif;
    font-size: 16px;
    font-weight: 600;
    letter-spacing: 1px;
    transition: all 0.4s ease;
}

button:hover {
    transform: scale(1.03) translateY(-2px);
   box-shadow: 
        0 12px 30px rgba(255,105,180,0.6),
        0 0 30px rgba(255,20,147,0.7);
}

/* CITIZEN CARD */
.citizen-card {
    width: 600px;
    height: 350px;
    border-radius: 25px;
    background: rgba(255, 192, 203, 0.25);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255,255,255,0.3);
    box-shadow: 0 30px 70px rgba(255,105,180,0.5);
    color: white;
    position: relative;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    padding: 40px;
    gap: 25px;
}

/* TITLE - DISNEY FONT */
.card-title {
    font-family: 'Waltograph', cursive;
    font-size: 28px;
    font-weight: normal;
    margin: 0;
    letter-spacing: 2px;
    color: white;
    text-align: center;
    text-shadow:
        0 0 10px #fff,
        0 0 20px #ff7eb3;
}

/* CONTENT */
.card-content {
    display: flex;
    align-items: flex-start;
    gap: 40px;
    flex: 1;
}

/* LEFT - PROFILE */
.profile-section {
    position: relative;
    flex-shrink: 0;
}

.profile-img {
    width: 180px;
    height: 260px;
    border-radius: 20px;
    object-fit: cover;
    border: 4px solid rgba(255,255,255,0.5);
    box-shadow: 0 20px 50px rgba(0,0,0,0.4);
}

/* APPROVED STAMP */
.approved-stamp {
    position: absolute;
    bottom: -15px;
    left: 50%;
    transform: translateX(-50%);
    
    background: linear-gradient(45deg, #ffd700, #ff8c00);
    color: #8b0000;
    padding: 6px 16px;
    border-radius: 20px;
    font-family: 'Poppins', sans-serif;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    box-shadow: 0 5px 15px rgba(255,215,0,0.6);
    animation: stampPulse 2s ease-in-out infinite;
}

@keyframes stampPulse {
    0%, 100% { transform: translateX(-50%) scale(1); }
    50% { transform: translateX(-50%) scale(1.1); }
}

/* RIGHT - INFO - BLINK EFFECT! */
.card-right {
    flex: 1;
    padding-top: 10px;
}

/* LABELS - BOLD SERIF */
.card-right b {
    font-family: 'Playfair Display', serif;
    font-size: 16px;
    font-weight: 700;
    color: #4c9c7e;
    letter-spacing: 1px;
    text-transform: uppercase;
    display: block;
    margin-bottom: 4px;
}

/* VALUES - BLINK + GLOW EFFECT! */
.card-right span {
    font-family: 'Playfair Display', serif;
    font-size: 16px;
    font-weight: 400;
    color: white;
    letter-spacing: 0.5px;
    display: block;
    margin-bottom: 18px;
    line-height: 1.4;
    
    /* BLINK & GLOW ANIMATION */
    animation: blinkGlow 3s ease-in-out infinite;
    text-shadow:
        0 0 5px rgba(255,255,255,0.8),
        0 0 10px rgba(255,105,180,0.6);
}

@keyframes blinkGlow {
    0%, 100% {
        opacity: 1;
        text-shadow:
            0 0 5px rgba(255,255,255,0.8),
            0 0 10px rgba(255,105,180,0.6),
            0 0 15px rgba(255,20,147,0.4);
    }
    50% {
        opacity: 0.85;
        text-shadow:
            0 0 15px rgba(255,255,255,1),
            0 0 25px rgba(255,105,180,0.9),
            0 0 35px rgba(255,20,147,0.7);
    }
}

/* LOGOUT */
.logout-btn {
    position: absolute;
    bottom: 25px;
    right: 25px;
    
    padding: 12px 24px;
    font-family: 'Poppins', sans-serif;
    font-size: 14px;
    font-weight: 600;
    color: white;
    text-decoration: none;
    border-radius: 22px;
    background: linear-gradient(45deg, #ff69b4, #ff1493);
    backdrop-filter: blur(15px);
    border: 2px solid rgba(255,255,255,0.4);
    transition: all 0.4s ease;
    text-transform: uppercase;
    letter-spacing: 1.5px;
    box-shadow: 0 8px 25px rgba(255,105,180,0.4);
}

.logout-btn:hover {
    background: linear-gradient(45deg, #ff1493, #c71585);
    box-shadow: 0 12px 35px rgba(255,20,147,0.7);
    transform: translateY(-3px) scale(1.05);
}

/* PETALS */
@keyframes fall {
    0% { transform: translateY(-50px) rotate(0deg); }
    100% { transform: translateY(110vh) rotate(360deg); }
}

.petal {
    position: absolute;
    top: -50px;
    width: 25px;
    opacity: 0.85;
    animation: fall linear infinite;
}

.p1 { left: 10%; animation-duration: 8s; }
.p2 { left: 30%; animation-duration: 10s; }
.p3 { left: 50%; animation-duration: 7s; }
.p4 { left: 70%; animation-duration: 9s; }
.p5 { left: 90%; animation-duration: 11s; }
</style>
</head>

<body>

<!-- PETALS -->
<img src="petal1.png" class="petal p1">
<img src="petal1.png" class="petal p2">
<img src="petal2.png" class="petal p3">
<img src="petal2.png" class="petal p4">
<img src="petal2.png" class="petal p5">

<?php if (!isset($_SESSION['login'])): ?>

<div class="container">
    <div class="card">
        <div class="left">
            <img src="juddy.png" class="character">
            <img src="bunga.png" class="flower">
        </div>
        <div class="right">
            <h2>🌸 Zootopia Login 🌸</h2>
            <?php if (isset($error)): ?>
                <div style="color: #ff69b4; font-weight: 600; margin-bottom: 20px; text-align: center; font-size: 16px;">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>
            <form method="POST">
                <input type="text" name="username" placeholder="👤 Username" required>
                <input type="password" name="password" placeholder="🔒 Password" required>
                <button name="login">🚀 Sign in to Zootopia!</button>
            </form>
        </div>
    </div>
</div>

<?php else: ?>

<div class="container">
    <div class="citizen-card">
        
        <div class="card-title">🦊 Zootopia Citizen ID</div>
        
        <div class="card-content">
            <!-- LEFT - PROFILE -->
            <div class="profile-section">
                <img src="nick1.png" class="profile-img">
                <div class="approved-stamp">APPROVED!</div>
            </div>
            
            <!-- RIGHT - INFO -->
            <div class="card-right">
                <b>Name</b>
                <span>Nicholas Piberius Wilde</span>
                
                <b>ID</b>
                <span>ZTP-82A91F</span>
                
                <b>Status</b>
                <span>Active</span>
                
                <b>City</b>
                <span>Zootopia Central</span>
            </div>
        </div>
        
        <a href="?logout=true" class="logout-btn">🚪 Logout</a>
        
    </div>
</div>

<?php endif; ?>

</body>
</html>