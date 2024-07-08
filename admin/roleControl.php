<?php
include '../include/database.php';

if (isset($_GET['operation'])) {
    $operation = $_GET['operation'];


    if ($operation == "add" || $operation == "update") {
        // Check if the form is submitted and roleName is set
        if(isset($_POST['submit']) && isset($_POST['roleName'])) {
            if ($operation == "update") {
                // Update existing role
                $id = $_GET['id'];
                $roleName = $_POST['roleName'];
                $stmt = $database->prepare('UPDATE roles SET role_name = ? WHERE id_role = ?');
                $stmt->execute([$roleName, $id]);
            }
            
            // Redirect to roles.php after performing the operation
            header('Location: roles.php');
            exit();
        }

        // Fetch role data if in update mode
        if ($operation == "update" && isset($_GET['id'])) {
            $id = $_GET['id'];
            $stmt = $database->prepare('SELECT * FROM roles WHERE id_role = ?');
            $stmt->execute([$id]);
            $row = $stmt->fetch(PDO::FETCH_OBJ);
        }

        // Common HTML for both add and update operations
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Role Manage</title>
            <style>
    .content {
        margin: 20px auto;
        width: 50%;
        border: 1px solid #ccc;
        padding: 20px;
        border-radius: 5px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .container {
        text-align: center;
    }

    input[type="text"] {
        width: 100%;
        padding: 10px;
        margin-bottom: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        box-sizing: border-box;
    }

    input[type="submit"] {
        background-color: #4CAF50;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    input[type="submit"]:hover {
        background-color: #45a049;
    }
</style>

        </head>
        <body>
            <div class="header">
                <div class="container">
                    <h1>Role Settings</h1>
                </div>
            </div>
            <div class="content">
                <div class="container">
                    <form method="POST">
                        <input type="text" placeholder="Role Name" name="roleName" value="<?php echo isset($row) ? $row->role_name : ''; ?>"><br>
                        <input type="submit" name="submit" value="<?php echo 'Update Role'; ?>">
                    </form>
                </div>
            </div>
        </body>
        </html>
        <?php
    }
}
?>
