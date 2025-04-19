<?php
include 'db_connect.php';

// Handle new record insertion
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['insert'])) {
    $stmt = $mysqli->prepare("INSERT INTO students (name, email, age, enrollment_date) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssis", $_POST['name'], $_POST['email'], $_POST['age'], $_POST['enrollment_date']);
    $stmt->execute();
    $stmt->close();
}

// Handle search functionality
$search = $_GET['search'] ?? '';
$sql = "SELECT * FROM students WHERE name LIKE ? OR enrollment_date LIKE ?";
$stmt = $mysqli->prepare($sql);
$searchParam = "%$search%";
$stmt->bind_param("ss", $searchParam, $searchParam);
$stmt->execute();
$result = $stmt->get_result();

// Handle record deletion
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
    $deleteId = intval($_POST['delete_id']);
    $stmt = $mysqli->prepare("DELETE FROM students WHERE id = ?");
    $stmt->bind_param("i", $deleteId);
    if ($stmt->execute()) {
        echo "<script>alert('Record deleted successfully.'); window.location.href='index.php';</script>";
    } else {
        echo "<script>alert('Error deleting record.');</script>";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Records</title>
    <style>
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
<h2>Student Records</h2>

<form method="get">
    <input type="text" name="search" placeholder="Search by name or date">
    <button type="submit">Search</button>
</form>

<table>
    <tr>
        <th>ID</th><th>Name</th><th>Email</th><th>Age</th><th>Enrollment Date</th>
    </tr>
    <?php while($row = $result->fetch_assoc()): ?>
    <tr>
        <td><?= htmlspecialchars($row['id']) ?></td>
        <td><?= htmlspecialchars($row['name']) ?></td>
        <td><?= htmlspecialchars($row['email']) ?></td>
        <td><?= htmlspecialchars($row['age']) ?></td>
        <td><?= htmlspecialchars($row['enrollment_date']) ?></td>
        <td>
        <form method="post" onsubmit="return confirm('Are you sure you want to delete this record?');">
            <input type="hidden" name="delete_id" value="<?= $row['id'] ?>">
            <button type="submit" name="delete">Delete</button>
        </form>
    </td>
    </tr>
    <?php endwhile; ?>
</table>

<h3>Add New Student</h3>
<form method="post">
    <input type="text" name="name" required placeholder="Name">
    <input type="email" name="email" required placeholder="Email">
    <input type="number" name="age" placeholder="Age">
    <input type="date" name="enrollment_date" placeholder="Enrollment Date">
    <button type="submit" name="insert">Insert</button>
</form>

</body>
</html>