<?php
require_once 'config/database.php';

try {
    $conn = getDBConnection();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Handle form submission
        $sql = "UPDATE users SET first_name = :first_name, last_name = :last_name, 
                email = :email, phone = :phone WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':id' => $_POST['id'],
            ':first_name' => $_POST['first_name'],
            ':last_name' => $_POST['last_name'],
            ':email' => $_POST['email'],
            ':phone' => $_POST['phone']
        ]);
        
        header("Location: view_users.php");
        exit();
    }

    // Fetch user data
    $id = $_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM users WHERE id = :id");
    $stmt->execute([':id' => $id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
        }
        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
        .cancel-btn {
            background-color: #f44336;
            margin-left: 10px;
        }
    </style>
</head>
<body>
    <h2>Edit User</h2>
    <form action="edit_user.php" method="POST">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($user['id']); ?>">
        
        <div class="form-group">
            <label for="first_name">First Name:</label>
            <input type="text" id="first_name" name="first_name" 
                   value="<?php echo htmlspecialchars($user['first_name']); ?>" required>
        </div>
        
        <div class="form-group">
            <label for="last_name">Last Name:</label>
            <input type="text" id="last_name" name="last_name" 
                   value="<?php echo htmlspecialchars($user['last_name']); ?>" required>
        </div>
        
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" 
                   value="<?php echo htmlspecialchars($user['email']); ?>" required>
        </div>
        
        <div class="form-group">
            <label for="phone">Phone:</label>
            <input type="tel" id="phone" name="phone" 
                   value="<?php echo htmlspecialchars($user['phone']); ?>">
        </div>
        
        <button type="submit">Update User</button>
        <a href="view_users.php"><button type="button" class="cancel-btn">Cancel</button></a>
    </form>
</body>
</html> 