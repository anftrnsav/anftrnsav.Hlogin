<?php
session_start();

// SECURITY CHECK
if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}

// DATA CITIZENS LENGKAP
$citizens = [
    [
        'id' => 1,
        'name' => 'Judy Hopps',
        'avatar' => 'judy.png',
        'species' => 'Rabbit 🐰',
        'status' => 'active',
        'email' => 'judy.hopps@zpd.zootopia',
        'phone' => '+555-0123',
        'address' => 'Zootopia Central District',
        'job' => 'Police Officer',
        'last_login' => '2024-12-05 14:30'
    ],
    [
        'id' => 2,
        'name' => 'Nick Wilde',
        'avatar' => 'nick1.png',
        'species' => 'Fox 🦊',
        'status' => 'active',
        'email' => 'nick.wilde@zootopia.com',
        'phone' => '+555-0456',
        'address' => 'Savanna Central',
        'job' => 'Consultant',
        'last_login' => '2024-12-05 09:15'
    ],
    [
        'id' => 3,
        'name' => 'Chief Bogo',
        'avatar' => 'bogo.png',
        'species' => 'Buffalo 🦬',
        'status' => 'active',
        'email' => 'chief.bogo@zpd.zootopia',
        'phone' => '+555-0789',
        'address' => 'ZPD Headquarters',
        'job' => 'Police Chief',
        'last_login' => '2024-12-04 16:45'
    ],
    [
        'id' => 4,
        'name' => 'Flash Slothmore',
        'avatar' => 'flash.png',
        'species' => 'Sloth 🦥',
        'status' => 'inactive',
        'email' => 'flash@dmv.zootopia',
        'phone' => '+555-9999',
        'address' => 'DMV District',
        'job' => 'DMV Officer',
        'last_login' => '2024-11-28 11:22'
    ],
    [
        'id' => 5,
        'name' => 'Gazelle',
        'avatar' => 'gazelle.png',
        'species' => 'Gazelle 🦌',
        'status' => 'active',
        'email' => 'gazelle@star.zootopia',
        'phone' => '+555-1111',
        'address' => 'Little Rodentia',
        'job' => 'Singer',
        'last_login' => '2024-12-05 19:20'
    ]
];

$adminProfiles = [
    'Judith.L.H' => ['img' => 'judy.png', 'name' => 'Judith Laverne Hopps', 'title' => '🐰 Chief Administrator'],
    'Nicholas.P.W' => ['img' => 'nick1.png', 'name' => 'Nicholas Piberius Wilde', 'title' => '🦊 Senior Supervisor'],
    'Chief.B' => ['img' => 'bogo.png', 'name' => 'Chief Bogo', 'title' => '🦬 Head of Security'],
    'Flash.S' => ['img' => 'flash.png', 'name' => 'Flash Slothmore', 'title' => '🦥 Operations Manager'],
    'Gazelle' => ['img' => 'gazelle.png', 'name' => 'Gazelle', 'title' => '🦌 Public Relations']
];

$profile = $adminProfiles[$_SESSION['username']] ?? $adminProfiles['Judith.L.H'];

if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🌸 Zootopia Admin Dashboard 🌸</title>
    <link href="https://fonts.cdnfonts.com/css/waltograph" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    
    <style>
        
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            overflow-x: hidden;
            background: url('bg.png') center/cover no-repeat fixed;
            position: relative;
        }

        body::before {
            content: "";
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, 
                rgba(255, 182, 193, 0.6) 0%, 
                rgba(255, 105, 180, 0.4) 25%, 
                rgba(255, 20, 147, 0.3) 50%, 
                rgba(255, 182, 193, 0.5) 100%);
            backdrop-filter: blur(8px);
            z-index: -1;
        }

        /* TABLE CONTAINER */
        .table-container {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(25px);
            border-radius: 25px;
            padding: 40px;
            border: 1px solid rgba(255,255,255,0.2);
            box-shadow: 0 25px 60px rgba(0,0,0,0.3);
            margin-bottom: 40px;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: rgba(255,255,255,0.05);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 50px rgba(0,0,0,0.3);
        }

        th {
            background: linear-gradient(45deg, rgba(255,105,180,0.3), rgba(255,20,147,0.2));
            color: white;
            padding: 20px 15px;
            text-align: left;
            font-weight: 700;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            border-bottom: 2px solid rgba(255,255,255,0.2);
        }

        td {
            padding: 20px 15px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            vertical-align: middle;
            color: white;
        }

        tr:hover {
            background: rgba(255,255,255,0.1);
            transform: scale(1.01);
        }

        tr:last-child td {
            border-bottom: none;
        }

        .header {
            background: rgba(255, 125, 227, 0.15);
            backdrop-filter: blur(25px);
            padding: 20px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid rgba(229, 143, 204, 0.3);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .logo {
            font-family: 'Waltograph', cursive;
            font-size: 28px;
            color: white;
            text-shadow: 0 0 20px #ff69b4, 0 0 30px #ff1493;
            letter-spacing: 2px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .logo:hover {
            transform: scale(1.05);
            text-shadow: 0 0 30px #ff69b4, 0 0 40px #ff1493;
        }

        .admin-profile {
            display: flex;
            align-items: center;
            gap: 15px;
            background: rgba(255,255,255,0.15);
            padding: 15px 25px;
            border-radius: 30px;
            backdrop-filter: blur(20px);
            border: 2px solid rgba(255,255,255,0.4);
            cursor: pointer;
            transition: all 0.4s ease;
        }

        .admin-profile:hover {
            background: rgba(255,255,255,0.25);
            transform: scale(1.05) translateY(-3px);
            box-shadow: 0 15px 40px rgba(255,105,180,0.5);
        }

        .profile-img-small {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid rgba(255,255,255,0.6);
            box-shadow: 0 8px 25px rgba(0,0,0,0.3);
        }

        .profile-info h3 {
            margin: 0;
            font-size: 16px;
            color: white;
            font-weight: 600;
        }

        .profile-info p {
            margin: 0;
            font-size: 13px;
            color: #ffe6f0;
        }

        .main-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 40px 20px;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 30px;
            margin-bottom: 50px;
        }

        .stat-card {
            background: rgba(255, 255, 255, 0.12);
            backdrop-filter: blur(25px);
            border-radius: 25px;
            padding: 40px 30px;
            text-align: center;
            border: 1px solid rgba(255,255,255,0.25);
            cursor: pointer;
            transition: all 0.4s ease;
        }

        .stat-card:hover {
            transform: translateY(-15px);
            box-shadow: 0 40px 80px rgba(255,105,180,0.6);
        }

        .stat-icon { 
            font-size: 60px;
            margin-bottom: 25px; 
            display: block;
        }

        .stat-number { 
            font-size: 48px; 
            font-weight: 800; 
            color: white; 
            margin-bottom: 12px;
        }

        .stat-label { 
            font-size: 16px; 
            color: #ffe6f0;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .avatar-small {
            width: 55px;
            height: 55px;
            border-radius: 15px;
            object-fit: cover;
            border: 4px solid rgba(255,255,255,0.5);
        }

        .status-badge {
            padding: 8px 20px;
            border-radius: 25px;
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
        }

        .status-active {
            background: linear-gradient(45deg, #4CAF50, #45a049);
            color: white;
        }

        .status-inactive {
            background: linear-gradient(45deg, #f44336, #d32f2f);
            color: white;
        }

        .action-btn {
            padding: 8px 12px;
            border: none;
            border-radius: 8px;
            font-size: 11px;
            font-weight: 700;
            cursor: pointer;
            text-transform: uppercase;
            transition: all 0.3s ease;
            min-width: 60px;
            height: 36px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn-view { 
            background: linear-gradient(45deg, #9C27B0, #7B1FA2); 
            color: white; 
        }

        .btn-edit { 
            background: linear-gradient(45deg, #2196F3, #1976D2); 
            color: white; 
        }

        .btn-delete { 
            background: linear-gradient(45deg, #f44336, #d32f2f); 
            color: white; 
        }

        .action-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.4);
        }

        .logout-btn {
            position: fixed;
            bottom: 40px;
            right: 40px;
            padding: 20px 35px;
            font-size: 16px;
            font-weight: 700;
            color: white;
            text-decoration: none;
            border-radius: 35px;
            background: linear-gradient(45deg, #ff69b4, #ff1493);
            border: 2px solid rgba(255,255,255,0.5);
            transition: all 0.4s ease;
            text-transform: uppercase;
            box-shadow: 0 15px 45px rgba(255,105,180,0.6);
            z-index: 1000;
        }

        .logout-btn:hover {
            transform: translateY(-8px) scale(1.1);
            box-shadow: 0 25px 60px rgba(255,20,147,0.8);
        }

        .profile-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.7);
            backdrop-filter: blur(15px);
            z-index: 2000;
        }

        .modal-content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: rgba(255,255,255,0.15);
            backdrop-filter: blur(30px);
            border-radius: 30px;
            padding: 50px;
            max-width: 450px;
            width: 90%;
            text-align: center;
            border: 2px solid rgba(255,255,255,0.4);
        }

        .profile-large {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            border: 6px solid rgba(255,255,255,0.8);
            margin-bottom: 30px;
        }

        .close-modal {
            position: absolute;
            top: 20px;
            right: 25px;
            font-size: 30px;
            color: #ffe6f0;
            cursor: pointer;
        }

        @media (max-width: 768px) {
            .main-container { padding: 20px 15px; }
            .stats-grid { grid-template-columns: 1fr; }
            .table-container { padding: 20px; }
        }
    </style>
</head>

<body>
    <!-- HEADER -->
    <div class="header">
        <div class="logo" onclick="toggleModal()">🦊 Zootopia Admin Panel</div>
        <div class="admin-profile" onclick="toggleModal()">
            <img src="<?php echo htmlspecialchars($profile['img']); ?>" alt="<?php echo htmlspecialchars($profile['name']); ?>" class="profile-img-small">
            <div class="profile-info">
                <h3><?php echo htmlspecialchars($profile['name']); ?></h3>
                <p><?php echo htmlspecialchars($profile['title']); ?></p>
            </div>
        </div>
    </div>

    <!-- MAIN CONTENT -->
    <div class="main-container">
        <!-- Stats Cards -->
        <div class="stats-grid">
            <div class="stat-card">
                <span class="stat-icon">🦊</span>
                <div class="stat-number"><?php echo count($citizens); ?></div>
                <div class="stat-label">Total Citizens</div>
            </div>
            <div class="stat-card">
                <span class="stat-icon">✅</span>
                <div class="stat-number"><?php 
                    echo count(array_filter($citizens, function($c) { 
                        return $c['status'] === 'active'; 
                    })); 
                ?></div>
                <div class="stat-label">Active Users</div>
            </div>
            <div class="stat-card">
                <span class="stat-icon">⏰</span>
                <div class="stat-number"><?php 
                    echo count(array_filter($citizens, function($c) { 
                        return $c['status'] === 'inactive'; 
                    })); 
                ?></div>
                <div class="stat-label">Inactive</div>
            </div>
            <div class="stat-card">
                <span class="stat-icon">💼</span>
                <div class="stat-number"><?php echo count(array_unique(array_column($citizens, 'job'))); ?></div>
                <div class="stat-label">Job Types</div>
            </div>
        </div>

        <!-- CITIZENS TABLE -->
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Avatar</th>
                        <th>Name & Species</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Job</th>
                        <th>Status</th>
                        <th>Last Login</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($citizens as $citizen): ?>
                    <tr>
                        <td>
                                                        <img src="<?php echo htmlspecialchars($citizen['avatar']); ?>" 
                                 alt="<?php echo htmlspecialchars($citizen['name']); ?>" 
                                 class="avatar-small"
                                 onerror="this.src='https://via.placeholder.com/55x55/666/fff?text=?';">
                        </td>
                        
                        <td>
                            <div style="font-weight: 700; font-size: 16px; margin-bottom: 4px; color: white;">
                                <?php echo htmlspecialchars($citizen['name']); ?>
                            </div>
                            <div style="color: #ffe6f0; font-size: 13px; opacity: 0.9;">
                                <?php echo htmlspecialchars($citizen['species']); ?>
                            </div>
                        </td>
                        
                        <td style="font-size: 14px;">
                            <div style="word-break: break-all;"><?php echo htmlspecialchars($citizen['email']); ?></div>
                        </td>
                        
                        <td style="font-size: 14px;">
                            <?php echo htmlspecialchars($citizen['phone']); ?>
                        </td>
                        
                        <td>
                            <span style="background: rgba(255,105,180,0.2); padding: 6px 12px; border-radius: 20px; 
                                         color: #ff69b4; font-weight: 600; font-size: 13px; display: inline-block;">
                                <?php echo htmlspecialchars($citizen['job']); ?>
                            </span>
                        </td>
                        
                        <td>
                            <span class="status-badge status-<?php echo $citizen['status']; ?>">
                                <?php echo ucfirst($citizen['status']); ?>
                            </span>
                        </td>
                        
                        <td style="font-size: 13px; color: #ccc;">
                            <?php echo htmlspecialchars($citizen['last_login']); ?>
                        </td>
                        
                        <td>
                            <div style="display: flex; gap: 6px; white-space: nowrap;">
                                <button class="action-btn btn-view" onclick="viewCitizen(<?php echo $citizen['id']; ?>)" title="View Profile">
                                    👁️
                                </button>
                                <button class="action-btn btn-edit" onclick="editCitizen(<?php echo $citizen['id']; ?>)" title="Edit Data">
                                    ✏️
                                </button>
                                <button class="action-btn btn-delete" onclick="deleteCitizen(<?php echo $citizen['id']; ?>)" title="Delete User">
                                    🗑️
                                </button>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- LOGOUT BUTTON -->
    <a href="?logout=true" class="logout-btn">🚪 Logout</a>

    <!-- PROFILE MODAL -->
    <div id="profileModal" class="profile-modal">
        <div class="modal-content">
            <span class="close-modal" onclick="toggleModal()">&times;</span>
            <img src="<?php echo htmlspecialchars($profile['img']); ?>" alt="<?php echo htmlspecialchars($profile['name']); ?>" class="profile-large">
            <h2 class="modal-title"><?php echo htmlspecialchars($profile['name']); ?></h2>
            <p class="modal-subtitle"><?php echo htmlspecialchars($profile['title']); ?></p>
            <p style="color: #ffe6f0; font-size: 16px;">Admin Access Granted ✨</p>
        </div>
    </div>

    <!-- JAVASCRIPT -->
    <script>
        function toggleModal() {
            const modal = document.getElementById('profileModal');
            if (modal) {
                modal.style.display = modal.style.display === 'block' ? 'none' : 'block';
            }
        }

        // Close modal on outside click
        window.onclick = function(event) {
            const modal = document.getElementById('profileModal');
            if (event.target === modal) {
                modal.style.display = 'none';
            }
        }

        // Citizen Actions
        function viewCitizen(id) {
            alert(`🔍 Viewing Citizen ID: ${id}\nFull profile details would open here!`);
        }

        function editCitizen(id) {
            alert(`✏️ Editing Citizen ID: ${id}\nEdit form would open here!`);
        }

        function deleteCitizen(id) {
            if (confirm(`🗑️ Are you sure you want to delete Citizen ID: ${id}?\nThis action cannot be undone!`)) {
                alert(`✅ Citizen ID: ${id} has been DELETED successfully!`);
                location.reload(); // Refresh to simulate deletion
            }
        }
    </script>
</body>
</html>