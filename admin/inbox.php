<?php
// Include database connection file
include "../include/database.php";

// Fetch messages from the database
$stmt = $database->query("SELECT * FROM contactus");
$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - View Messages</title>
    <style>
        *{
    padding: 0;
    margin: 0;
    box-sizing: border-box;
    font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
}

/* Body styles */
.container {
    width: 90%;
    margin: auto; 
    margin-top: 40px;

        }
        h1{
            margin: 50px 0 40px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            overflow-x: auto;/* Show overflow content */
        }
        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <div class="container">
    <h1>Admin - View Messages</h1>
    <table>
        <tr>
            <th>Full Name</th>
            <th>Email</th>
            <th>Subject</th>
            <th>Message</th>
        </tr>
        <?php foreach ($messages as $message): ?>
        <tr>
            <td><?php echo $message['fullName']; ?></td>
            <td><?php echo $message['email']; ?></td>
            <td><?php echo $message['subject']; ?></td>
            <td><?php echo $message['message']; ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
    </div>
</body>
</html>
