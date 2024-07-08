<?php
include '../include/database.php';

if (isset($_GET['operation'])) {
    $operation = $_GET['operation'];

    if ($operation == "delete") {
        // Ensure $id is properly defined here
        $id = $_GET['id'];
        $stmt = $database->prepare('DELETE FROM sectors WHERE id_sector = ?');
        $stmt->execute([$id]);
        header('Location: sectors.php');
        exit(); // It's good practice to exit after a redirect
    }

    if ($operation == "add" || $operation == "update") {
        // Check if the form is submitted and roleName is set
        if(isset($_POST['submit']) && isset($_POST['sectorName'])) {
            if ($operation == "add") {
                // Insert new role
                $sectorName = $_POST['sectorName'];
                $stmt = $database->prepare('INSERT INTO sectors (sector_name) VALUES (?)');
                $stmt->execute([$roleName]);
            } elseif ($operation == "update") {
                // Update existing role
                $id = $_GET['id'];
                $sectorName = $_POST['sectorName'];
                $stmt = $database->prepare('UPDATE sectors SET sector_name = ? WHERE id_sector = ?');
                $stmt->execute([$sectorName, $id]);
            }
            
            // Redirect to roles.php after performing the operation
            header('Location: sectors.php');
            exit();
        }

        // Fetch role data if in update mode
        if ($operation == "update" && isset($_GET['id'])) {
            $id = $_GET['id'];
            $stmt = $database->prepare('SELECT * FROM sectors WHERE id_sector = ?');
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
            <title>Sector Manage</title>
        </head>
        <body>
            <div class="header">
                <div class="container">
                    <h1>Sector Settings</h1>
                </div>
            </div>
            <div class="content">
                <div class="container">
                    <form method="POST">
                        <input type="text" placeholder="Sector Name" name="sectorName" value="<?php echo isset($row) ? $row->sector_name : ''; ?>"><br>
                        <input type="submit" name="submit" value="<?php echo $operation == 'add' ? 'Add Sector' : 'Update Sector'; ?>">
                    </form>
                </div>
            </div>
        </body>
        </html>
        <?php
    }
}
?>
