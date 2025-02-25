<?php
$host = 'database-1.cvkeq04gcavr.ap-south-1.rds.amazonaws.com';
$dbname = 'user_management';
$username = 'admin';
$password = 'your_password_here'; // Replace with your actual password

try {
    // Create database connection
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Get form data
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    // Prepare SQL statement
    $sql = "INSERT INTO users (first_name, last_name, email, phone) VALUES (:first_name, :last_name, :email, :phone)";
    $stmt = $conn->prepare($sql);

    // Bind parameters
    $stmt->bindParam(':first_name', $first_name);
    $stmt->bindParam(':last_name', $last_name);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':phone', $phone);

    // Execute the statement
    $stmt->execute();

    // Redirect to view users page after successful insertion
    header("Location: view_users.php");
    exit();
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$conn = null;
?> 