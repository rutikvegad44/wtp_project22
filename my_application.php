<?php
require_once "auth_check.php";
require_once "db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php?msg=auth_required");
    exit();
}

$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['full_name'] ?? 'User';

// Fetch ALL applications for this user
$sql = "SELECT * FROM applications WHERE user_id = ? ORDER BY created_at DESC";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$applications = [];
while ($row = mysqli_fetch_assoc($result)) {
    $applications[] = $row;
}
$total = count($applications);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Applications - Job Portal</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #334155 100%);
            min-height: 100vh;
            color: #e2e8f0;
        }

        /* Top Navigation */
        .top-nav {
            background: rgba(15, 23, 42, 0.95);
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #3b82f6;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
        }

        .top-nav h2 {
            color: #60a5fa;
            font-size: 22px;
        }

        .nav-links {
            display: flex;
            gap: 15px;
        }

        .nav-links a {
            color: #94a3b8;
            text-decoration: none;
            padding: 8px 16px;
            border-radius: 6px;
            font-size: 14px;
            transition: all 0.3s;
        }

        .nav-links a:hover {
            background: #1e40af;
            color: white;
        }

        .nav-links .logout-btn {
            background: #dc2626;
            color: white;
        }

        .nav-links .logout-btn:hover {
            background: #b91c1c;
        }

        /* Main Container */
        .container {
            max-width: 1200px;
            margin: 30px auto;
            padding: 0 20px;
        }

        /* Stats Bar */
        .stats-bar {
            display: flex;
            gap: 20px;
            margin-bottom: 25px;
            flex-wrap: wrap;
        }

        .stat-card {
            background: rgba(30, 41, 59, 0.8);
            border: 1px solid #334155;
            border-radius: 12px;
            padding: 20px 25px;
            flex: 1;
            min-width: 200px;
            backdrop-filter: blur(10px);
        }

        .stat-card h3 {
            color: #94a3b8;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 8px;
        }

        .stat-card .value {
            font-size: 28px;
            font-weight: 700;
            color: #60a5fa;
        }

        .stat-card .sub {
            font-size: 12px;
            color: #64748b;
            margin-top: 4px;
        }

        /* Action Bar */
        .action-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .action-bar h1 {
            font-size: 24px;
            color: #f1f5f9;
        }

        .btn-new {
            background: linear-gradient(135deg, #2563eb, #3b82f6);
            color: white;
            padding: 12px 24px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(37, 99, 235, 0.3);
        }

        .btn-new:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(37, 99, 235, 0.5);
        }

        /* Table Container */
        .table-container {
            background: rgba(30, 41, 59, 0.8);
            border: 1px solid #334155;
            border-radius: 12px;
            overflow: hidden;
            backdrop-filter: blur(10px);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
        }

        .table-scroll {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 900px;
        }

        thead th {
            background: rgba(15, 23, 42, 0.9);
            color: #93c5fd;
            padding: 14px 16px;
            text-align: left;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 1px;
            border-bottom: 2px solid #3b82f6;
            white-space: nowrap;
        }

        tbody td {
            padding: 12px 16px;
            border-bottom: 1px solid #1e293b;
            font-size: 14px;
            color: #cbd5e1;
        }

        tbody tr {
            transition: background 0.2s;
        }

        tbody tr:hover {
            background: rgba(59, 130, 246, 0.08);
        }

        tbody tr:nth-child(even) {
            background: rgba(15, 23, 42, 0.3);
        }

        tbody tr:nth-child(even):hover {
            background: rgba(59, 130, 246, 0.12);
        }

        /* Action Buttons */
        .action-btns {
            display: flex;
            gap: 6px;
        }

        .btn-action {
            padding: 6px 14px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 12px;
            font-weight: 600;
            display: inline-block;
            transition: all 0.2s;
            border: none;
            cursor: pointer;
        }

        .btn-view {
            background: #0ea5e9;
            color: white;
        }

        .btn-view:hover {
            background: #0284c7;
        }

        .btn-edit {
            background: #f59e0b;
            color: #1e293b;
        }

        .btn-edit:hover {
            background: #d97706;
        }

        .btn-delete {
            background: #ef4444;
            color: white;
        }

        .btn-delete:hover {
            background: #dc2626;
        }

        /* Badge */
        .badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: 600;
        }

        .badge-success {
            background: rgba(34, 197, 94, 0.2);
            color: #4ade80;
        }

        /* No Data */
        .no-data {
            text-align: center;
            padding: 60px 20px;
        }

        .no-data h2 {
            color: #64748b;
            margin-bottom: 10px;
            font-size: 20px;
        }

        .no-data p {
            color: #475569;
            margin-bottom: 25px;
        }

        /* Detail Modal */
        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            z-index: 1000;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .modal-overlay.active {
            display: flex;
        }

        .modal-content {
            background: #1e293b;
            border: 1px solid #334155;
            border-radius: 16px;
            max-width: 700px;
            width: 100%;
            max-height: 85vh;
            overflow-y: auto;
            padding: 30px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.5);
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 1px solid #334155;
        }

        .modal-header h2 {
            color: #60a5fa;
            font-size: 20px;
        }

        .modal-close {
            background: #475569;
            border: none;
            color: white;
            width: 35px;
            height: 35px;
            border-radius: 50%;
            cursor: pointer;
            font-size: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.2s;
        }

        .modal-close:hover {
            background: #ef4444;
        }

        .detail-table {
            width: 100%;
            border-collapse: collapse;
        }

        .detail-table th,
        .detail-table td {
            padding: 10px 14px;
            border-bottom: 1px solid #1e293b;
            text-align: left;
            font-size: 14px;
        }

        .detail-table th {
            color: #94a3b8;
            width: 35%;
            background: rgba(15, 23, 42, 0.5);
            font-weight: 600;
        }

        .detail-table td {
            color: #e2e8f0;
        }

        /* Serial Number */
        .sr-no {
            font-weight: 700;
            color: #60a5fa;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .stats-bar {
                flex-direction: column;
            }

            .action-bar {
                flex-direction: column;
                gap: 15px;
                text-align: center;
            }

            .top-nav {
                flex-direction: column;
                gap: 10px;
            }
        }
    </style>
</head>

<body>

    <!-- Top Navigation -->
    <nav class="top-nav">
        <h2>📋 My Applications</h2>
        <div class="nav-links">
            <a href="index.php">🏠 Home</a>
            <a href="practical 3/form.php">📝 New Application</a>
            <a href="profile.php">👤 Profile</a>
            <a href="logout.php" class="logout-btn">🚪 Logout</a>
        </div>
    </nav>

    <div class="container">

        <!-- Welcome & Stats -->
        <div class="stats-bar">
            <div class="stat-card">
                <h3>Welcome</h3>
                <div class="value" style="font-size: 20px;"><?php echo htmlspecialchars($user_name); ?></div>
                <div class="sub">Logged in User</div>
            </div>
            <div class="stat-card">
                <h3>Total Applications</h3>
                <div class="value"><?php echo $total; ?></div>
                <div class="sub">Jobs Applied</div>
            </div>
            <div class="stat-card">
                <h3>Last Applied</h3>
                <div class="value" style="font-size: 16px;">
                    <?php 
                    if ($total > 0) {
                        echo date('d M Y', strtotime($applications[0]['created_at']));
                    } else {
                        echo 'N/A';
                    }
                    ?>
                </div>
                <div class="sub">Most Recent Application</div>
            </div>
        </div>

        <!-- Action Bar -->
        <div class="action-bar">
            <h1>📄 All Applications</h1>
            <a href="practical 3/form.php" class="btn-new">➕ Apply for New Job</a>
        </div>

        <!-- Applications Table -->
        <div class="table-container">
            <?php if ($total > 0): ?>
                <div class="table-scroll">
                    <table>
                        <thead>
                            <tr>
                                <th>Sr.</th>
                                <th>Full Name</th>
                                <th>Position</th>
                                <th>Qualification</th>
                                <th>Experience</th>
                                <th>Salary</th>
                                <th>City</th>
                                <th>Applied On</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($applications as $index => $app): ?>
                                <tr>
                                    <td class="sr-no"><?php echo $index + 1; ?></td>
                                    <td><?php echo htmlspecialchars($app['fullName']); ?></td>
                                    <td><strong><?php echo htmlspecialchars($app['position']); ?></strong></td>
                                    <td><?php echo htmlspecialchars($app['qualification']); ?></td>
                                    <td><?php echo htmlspecialchars($app['experience']); ?> yrs</td>
                                    <td>₹<?php echo htmlspecialchars(number_format($app['expectedSalary'])); ?></td>
                                    <td><?php echo htmlspecialchars($app['city']); ?></td>
                                    <td><?php echo date('d/m/Y', strtotime($app['created_at'])); ?></td>
                                    <td><span class="badge badge-success">Submitted</span></td>
                                    <td>
                                        <div class="action-btns">
                                            <button class="btn-action btn-view" onclick="viewDetails(<?php echo $app['id']; ?>)">👁 View</button>
                                            <a href="edit_application.php?id=<?php echo $app['id']; ?>" class="btn-action btn-edit">✏ Edit</a>
                                            <a href="delete_application.php?id=<?php echo $app['id']; ?>" class="btn-action btn-delete" onclick="return confirm('Kya aap sure hain? Application delete ho jayegi!');">🗑 Delete</a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="no-data">
                    <h2>📭 Koi Application Nahi Mili</h2>
                    <p>Aapne abhi tak koi job application submit nahi ki hai.</p>
                    <a href="practical 3/form.php" class="btn-new">📝 Pehli Application Submit Karein</a>
                </div>
            <?php endif; ?>
        </div>

    </div>

    <!-- View Detail Modal -->
    <div class="modal-overlay" id="detailModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>📋 Application Details</h2>
                <button class="modal-close" onclick="closeModal()">✕</button>
            </div>
            <div id="detailBody">Loading...</div>
        </div>
    </div>

    <script>
        // Application data from PHP
        const allApps = <?php echo json_encode($applications); ?>;

        function viewDetails(id) {
            const app = allApps.find(a => a.id == id);
            if (!app) return;

            const html = `
                <table class="detail-table">
                    <tr><th>Full Name</th><td>${escHtml(app.fullName)}</td></tr>
                    <tr><th>Date of Birth</th><td>${escHtml(app.dob)}</td></tr>
                    <tr><th>Gender</th><td>${escHtml(app.gender)}</td></tr>
                    <tr><th>Email</th><td>${escHtml(app.email)}</td></tr>
                    <tr><th>Mobile</th><td>${escHtml(app.mobile)}</td></tr>
                    <tr><th>City</th><td>${escHtml(app.city)}</td></tr>
                    <tr><th>Address</th><td>${escHtml(app.address)}</td></tr>
                    <tr><th>Qualification</th><td>${escHtml(app.qualification)}</td></tr>
                    <tr><th>Passing Year</th><td>${escHtml(app.passingYear)}</td></tr>
                    <tr><th>College</th><td>${escHtml(app.college)}</td></tr>
                    <tr><th>Percentage/CGPA</th><td>${escHtml(app.percentage)}</td></tr>
                    <tr><th>Position</th><td>${escHtml(app.position)}</td></tr>
                    <tr><th>Experience</th><td>${escHtml(app.experience)} years</td></tr>
                    <tr><th>Expected Salary</th><td>₹${Number(app.expectedSalary).toLocaleString()}</td></tr>
                    <tr><th>Skills</th><td>${escHtml(app.skills)}</td></tr>
                    <tr><th>Cover Letter</th><td>${escHtml(app.coverLetter)}</td></tr>
                    <tr><th>Applied On</th><td>${escHtml(app.created_at)}</td></tr>
                </table>
            `;

            document.getElementById('detailBody').innerHTML = html;
            document.getElementById('detailModal').classList.add('active');
        }

        function closeModal() {
            document.getElementById('detailModal').classList.remove('active');
        }

        // Close modal on background click
        document.getElementById('detailModal').addEventListener('click', function(e) {
            if (e.target === this) closeModal();
        });

        // Escape HTML helper
        function escHtml(str) {
            if (str === null || str === undefined) return '';
            const div = document.createElement('div');
            div.textContent = String(str);
            return div.innerHTML;
        }
    </script>

</body>

</html>