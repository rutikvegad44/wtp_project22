<?php
session_start();
require_once "db.php";
require_once "auth_check.php";

$user_id = $_SESSION['user_id'];

// Get user account details
$user_sql = "SELECT * FROM users WHERE id = '$user_id' LIMIT 1";
$user_result = mysqli_query($conn, $user_sql);
$user_data = mysqli_fetch_assoc($user_result);

// Get practical 7 profile details if exists
$profile_sql = "SELECT * FROM profile WHERE user_id = '$user_id' LIMIT 1";
$profile_result = mysqli_query($conn, $profile_sql);
$profile_data = mysqli_fetch_assoc($profile_result);
?>
<!DOCTYPE html>
<html>
<head>
    <title>My Profile - User Dashboard</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f7f6;
            margin: 0;
            padding: 40px 20px;
        }

        .profile-container {
            max-width: 550px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        }

        h2 {
            text-align: center;
            color: #1e293b;
            margin-bottom: 25px;
        }

        .profile-avatar {
            text-align: center;
            font-size: 55px;
            margin-bottom: 15px;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }

        .info-table th, .info-table td {
            padding: 12px 14px;
            border-bottom: 1px solid #e2e8f0;
            text-align: left;
            font-size: 15px;
        }

        .info-table th {
            background-color: #f8fafc;
            color: #475569;
            width: 35%;
        }

        .info-table td {
            color: #1e293b;
            font-weight: 500;
        }

        .actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 20px;
        }

        .btn {
            padding: 10px 18px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            display: inline-block;
        }

        .btn-home {
            background-color: #3b82f6;
            color: white;
        }

        .btn-home:hover {
            background-color: #2563eb;
        }

        .btn-logout {
            background-color: #ef4444;
            color: white;
        }

        .btn-logout:hover {
            background-color: #dc2626;
        }
    </style>
</head>

<body>

<div class="profile-container">
    <div class="profile-avatar">👤</div>
    <h2>My User Profile</h2>

    <table class="info-table">
        <tr>
            <th>Full Name</th>
            <td><?php echo htmlspecialchars($user_data['full_name'] ?? $_SESSION['full_name'] ?? 'N/A'); ?></td>
        </tr>
        <tr>
            <th>Username</th>
            <td><?php echo htmlspecialchars($user_data['username'] ?? $_SESSION['username'] ?? 'N/A'); ?></td>
        </tr>
        <tr>
            <th>Email</th>
            <td><?php echo htmlspecialchars($user_data['email'] ?? 'N/A'); ?></td>
        </tr>
        <tr>
            <th>Mobile</th>
            <td><?php echo htmlspecialchars($user_data['mobile'] ?? 'N/A'); ?></td>
        </tr>
        <?php if ($profile_data): ?>
            <tr>
                <th>Age</th>
                <td><?php echo htmlspecialchars($profile_data['age']); ?></td>
            </tr>
            <tr>
                <th>City</th>
                <td><?php echo htmlspecialchars($profile_data['city']); ?></td>
            </tr>
        <?php endif; ?>
    </table>

    <div class="actions">
        <a href="index.php" class="btn btn-home">← Back to Home Page</a>
        <a href="logout.php" class="btn btn-logout">Logout</a>
    </div>
</div>

</body>
</html>
