<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$is_logged_in = isset($_SESSION['user_id']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parmar Kashyap Webpage</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f7f6;
        }
        table {
            border-collapse: collapse;
        }
        .nav-bar a {
            color: #003366;
            text-decoration: none;
            font-weight: bold;
            padding: 5px 10px;
        }
        .nav-bar a:hover {
            text-decoration: underline;
            color: #000;
        }
        .btn-home {
            display: inline-block;
            background: #ff5722;
            color: white !important;
            padding: 6px 14px;
            border-radius: 4px;
            text-decoration: none !important;
        }
        .btn-home:hover {
            background: #e64a19;
        }
    </style>
</head>
<body>

    <table width="100%" cellpadding="8">
        <tr bgcolor="orange">
            <th colspan="3" align="center" style="padding: 20px;">
                <font size="6" color="white">Welcome to Parmar Kashyap Webpage</font><br>
                <font size="3" color="white">Student ID: 26GMCA39 | Government MCA College, Maninagar</font>
            </th>
        </tr>
        <tr bgcolor="lightblue">
            <td colspan="3" align="center" class="nav-bar" style="padding: 12px;">
                <a href="index.php" class="btn-home">🏠 Main Portal</a> | 
                <a href="practical 2/index.php"><u>About Us (Group 22)</u></a> |
                <a href="practical 3/form.php">Application Form</a> |
                <a href="practical 4/cal.php">Calculator</a> | 
                <a href="profile.php">My Profile</a>
                <?php if ($is_logged_in): ?>
                    | <a href="logout.php" style="color: red;">Logout</a>
                <?php else: ?>
                    | <a href="login.php">Login</a> | <a href="register.php">Register</a>
                <?php endif; ?>
            </td>
        </tr>
        <tr valign="top">
            <td width="22%" style="padding: 20px; background: #fafafa;">
                <b>📢 Latest News:</b>
                <ol style="padding-left: 20px; line-height: 1.8; margin-top: 10px;">
                    <li>New Admissions 2026</li>
                    <li>Annual Cultural Event from <b>30 Sept to 5 Oct 2026</b></li>
                    <li>Seminar on AI - <b>15th Oct</b></li>
                </ol>
                <br>
                <b>📂 Quick Practical Links:</b>
                <ul style="padding-left: 20px; line-height: 1.8; margin-top: 10px;">
                    <li><a href="max.php">9.1 Max of 3</a></li>
                    <li><a href="numbers.php">9.2 Print 1 to N</a></li>
                    <li><a href="pyramid.php">9.3 Pyramid Patterns</a></li>
                    <li><a href="array.php">10.1 Array Operations</a></li>
                    <li><a href="string.php">10.2 String Program</a></li>
                    <li><a href="max_min.php">11.1 Max & Min</a></li>
                    <li><a href="date_time.php">11.2 Date & Time</a></li>
                    <li><a href="string_function.php">11.4 String Functions</a></li>
                </ul>
            </td>
            <td width="56%" style="padding: 20px; background: #fff;">
                <h2>About Our Institute</h2>
                <p>
                    At Government MCA College, Maninagar, we provide high-quality education in the field 
                    of Computer Applications. Our experienced faculties, and Principal Dr. Chetan B. Bhatt, 
                    are dedicated to imparting practical and theoretical knowledge.
                </p>

                <h2>Our Mission</h2>
                <p>
                    We aim to produce skilled professionals who excel in their respective fields. With state-of-the-art 
                    infrastructure and innovative teaching methods, we strive for academic excellence.
                </p>
                <ul>
                    <li>To equip our students with good knowledge, skills and attitude to solve real-life problems in the domain of computer application.</li>
                    <li>To establish industry-academia interaction to facilitate the students to work proficiently in the industrial environment.</li>
                    <li>To imbibe high moral values and professional ethics.</li>
                    <li>To provide a conducive environment so as to achieve excellence in teaching learning, and research and development activities.</li>
                </ul>

                <h2>Contact Us</h2>
                <form action="#" method="post">
                    <table border="0" cellspacing="5" cellpadding="4">
                        <tr>
                            <td>Name:</td>
                            <td><input type="text" name="name" size="30" style="padding: 6px;"></td>
                        </tr>
                        <tr>
                            <td>Email:</td>
                            <td><input type="email" name="email" size="30" style="padding: 6px;"></td>
                        </tr>
                        <tr>
                            <td valign="top">Message:</td>
                            <td><textarea name="message" rows="4" cols="30" style="padding: 6px;"></textarea></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><input type="submit" value="Submit" style="padding: 8px 20px; background: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer;"></td>
                        </tr>
                    </table>
                </form>
            </td>
            <td width="22%" style="padding: 20px; background: #fafafa;">
                <b>🔗 Important Links:</b>
                <ul style="padding-left: 20px; line-height: 1.8; margin-top: 10px;">
                    <li><a href="https://nptel.ac.in/" target="_blank">NPTEL</a></li>
                    <li><a href="https://www.gtu.ac.in/" target="_blank">GTU</a></li>
                    <li><a href="https://www.aicte-india.org/" target="_blank">AICTE</a></li>
                </ul>
                <br>
                <div style="text-align: center; margin-top: 20px;">
                    <a href="index.php" style="display: block; padding: 10px; background: #333; color: white; text-decoration: none; border-radius: 6px;">← Return to Main Portal</a>
                </div>
            </td>
        </tr>
        <tr bgcolor="green">
            <td colspan="3" align="center" style="padding: 12px;">
                <font size="3" color="white">
                    &copy; 2026 Government MCA College, Maninagar. All Rights Reserved.
                </font>
            </td>
        </tr>
    </table>

</body>
</html>
