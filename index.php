<?php
// Connect to MySQL (XAMPP defaults) and auto-create database + table
$db = new mysqli("localhost", "root", "");
$db->query("CREATE DATABASE IF NOT EXISTS school");
$db->select_db("school");
$db->query("CREATE TABLE IF NOT EXISTS students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    course VARCHAR(100) NOT NULL
)");

$message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $stmt = $db->prepare("INSERT INTO students (name, email, course) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $_POST["name"], $_POST["email"], $_POST["course"]);
    $stmt->execute();
    $message = "Student registered!";
}
$students = $db->query("SELECT * FROM students ORDER BY id DESC");
?>
<!DOCTYPE html>
<html>
<head><title>Student Registration</title></head>
<body>
    <h2>Student Registration</h2>
    <p style="color:green"><?= $message ?></p>
    <form method="post">
        Name: <input type="text" name="name" required><br><br>
        Email: <input type="email" name="email" required><br><br>
        Course: <input type="text" name="course" required><br><br>
        <button type="submit">Register</button>
    </form>

    <h3>Registered Students</h3>
    <table border="1" cellpadding="5">
        <tr><th>ID</th><th>Name</th><th>Email</th><th>Course</th></tr>
        <?php while ($row = $students->fetch_assoc()): ?>
        <tr>
            <td><?= $row["id"] ?></td>
            <td><?= htmlspecialchars($row["name"]) ?></td>
            <td><?= htmlspecialchars($row["email"]) ?></td>
            <td><?= htmlspecialchars($row["course"]) ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
