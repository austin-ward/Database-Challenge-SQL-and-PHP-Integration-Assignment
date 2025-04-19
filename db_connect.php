<?php
// Database connection
$mysqli = new mysqli("localhost", "root", "", "student_records");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}
?>