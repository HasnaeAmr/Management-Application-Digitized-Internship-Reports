<?php
include '../include/database.php';

// Fetch roles, sectors, and levels from the database
$stmt = $database->query('SELECT * FROM roles');
$roles = $stmt->fetchAll(PDO::FETCH_OBJ);

$stmt = $database->query('SELECT * FROM sectors');
$sectors = $stmt->fetchAll(PDO::FETCH_OBJ);

$stmt = $database->query('SELECT * FROM level');
$levels = $stmt->fetchAll(PDO::FETCH_OBJ);

// Check the operation
if (!isset($_GET['operation'])) {
    header('Location: users.php');
    exit();
}

$operation = $_GET['operation'];

// Delete operation
if ($operation == "delete" && isset($_GET['id'])) {
    $stmt = $database->prepare('DELETE FROM user WHERE id_user = ?');
    $stmt->execute([$_GET['id']]);
    header('Location: users.php');
    exit();
}

// Add or update operation
if ($operation == "add" || $operation == "update") {
    if (
        isset($_POST['submit']) &&
        isset($_POST['fullName']) &&
        isset($_POST['email']) &&
        isset($_POST['password']) &&
        isset($_POST['sector']) &&
        isset($_POST['role'])
    ) {
        $fullName = filter_var($_POST['fullName'], FILTER_SANITIZE_STRING);
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $password = $_POST['password'];
        $sector = $_POST['sector'];
        $role = $_POST['role'];
        $level = isset($_POST['level']) ? $_POST['level'] : null;

        if ($operation == "add") {
            // Insert user data
            $stmt = $database->prepare("INSERT INTO user (fullName, email, `password`, id_role) VALUES (?,?,?,?)");
            $stmt->execute([$fullName, $email, $password, $role]);

            // Get the user's ID
            $userId = $database->lastInsertId();

            // Insert additional data based on role
            if ($role == 1 && isset($level)) {
                // Insert into students table
                $stmt = $database->prepare("INSERT INTO students (id_user, id_sector, id_level) VALUES (?,?,?)");
                $stmt->execute([$userId, $sector, $level]);
            } elseif ($role == 2 || $role == 3) {
                // Insert into head_of_department or department_secretary table
                $table = ($role == 2) ? 'head_of_department' : 'department_secretary';
                $stmt = $database->prepare("INSERT INTO $table (id_user, id_sector) VALUES (?, ?)");
                $stmt->execute([$userId, $sector]);
            } else {
                // Insert into admin table
                $stmt = $database->prepare("INSERT INTO admin (id_user) VALUES (?)");
                $stmt->execute([$userId]);
            }

            header('Location: users.php');
            exit();
        } elseif ($operation == "update" && isset($_GET['id'])) {
            $id = $_GET['id'];

            // Update user data
            $stmt = $database->prepare('UPDATE user SET fullName = ?, email = ?, password = ?, id_role = ? WHERE id_user = ?');
            $stmt->execute([$_POST['fullName'], $_POST['email'], $_POST['password'], $_POST['role'], $id]);

            // Handle role change
            if ($_POST['role'] != $row->id_role) {
                $stmt = $database->prepare('DELETE FROM students WHERE id_user = ?');
                $stmt->execute([$id]);

                $stmt = $database->prepare('DELETE FROM head_of_department WHERE id_user = ?');
                $stmt->execute([$id]);

                $stmt = $database->prepare('DELETE FROM department_secretary WHERE id_user = ?');
                $stmt->execute([$id]);

                if ($role == 1 && isset($level)) {
                    $stmt = $database->prepare("INSERT INTO students (id_user, id_sector, id_level) VALUES (?,?,?)");
                    $stmt->execute([$id, $sector, $level]);
                } elseif ($role == 2 || $role == 3) {
                    $table = ($role == 2) ? 'head_of_department' : 'department_secretary';
                    $stmt = $database->prepare("INSERT INTO $table (id_user, id_sector) VALUES (?, ?)");
                    $stmt->execute([$id, $sector]);
                } else {
                    $stmt = $database->prepare("INSERT INTO admin (id_user) VALUES (?)");
                    $stmt->execute([$id]);
                }
            }

            // Update level and sector
            if (isset($level)) {
                $stmt = $database->prepare('UPDATE students SET id_level = ? WHERE id_user = ?');
                $stmt->execute([$level, $id]);
            }

            if ($_POST['sector'] != $user->id_sector) {
                $stmt = $database->prepare('UPDATE students SET id_sector = ? WHERE id_user = ?');
                $stmt->execute([$sector, $id]);

                $stmt = $database->prepare('UPDATE head_of_department SET id_sector = ? WHERE id_user = ?');
                $stmt->execute([$sector, $id]);

                $stmt = $database->prepare('UPDATE department_secretary SET id_sector = ? WHERE id_user = ?');
                $stmt->execute([$sector, $id]);
            }

            header('Location: users.php');
            exit();
        }
    }
}

// Common HTML for both add and update operations
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">    <link rel="preconnect" href="https://fonts.googleapis.com">
    <title>User Manage</title>
    <style>
        #level, .op{
            margin: 20px 125px;
        }
        .signup{
            width: 60%;
            margin: auto;
        }
        .signup input{
            width: 100%;
            margin-bottom: 30px;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="container">
            <h1>User Settings</h1>
        </div>
    </div>
    <div class="content">
        <div class="container">
            <form method="POST">
                <div class="mb-3">
                    <label for="name" class="form-label">Full Name</label>
                    <input type="text" id="name" class="form-control" name="fullName" value="<?php echo isset($row) ? $row->fullName : ''; ?>" placeholder="Hasna AMARMACH" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" id="email" class="form-control" name="email" value="<?php echo isset($row) ? $row->email : ''; ?>" placeholder="hasna.amr@gmail.com" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" id="password" class="form-control" name="password" value="<?php echo isset($row) ? $row->password : ''; ?>" placeholder="hasna-amr:)" required>
                </div>
                <br>
                <div class="op">
                    Role : <br>
                    <?php foreach ($roles as $role) { ?>
                        <input type="radio" name="role" value="<?php echo $role->id_role; ?>" <?php echo (isset($row) && $row->id_role == $role->id_role) ? 'checked' : ''; ?> onchange="toggleLevel()">
                        <label><?php echo $role->role_name; ?></label>
                    <?php } 
                     
                    ?>
                </div>
                <br>
                <div id="level" name="level">
                    Level : <br>
                    <?php foreach ($levels as $level) { ?>
                        <input type="radio" name="level" value="<?php echo $level->id_level; ?>">
                        <label><?php echo $level->level_name; ?></label>
                    <?php } if((isset($role) && $role->id_role!=10)|| $operation=='add'){ ?>
                </div>
                <br>
                <div class="sector-choice">
                    <label for="sector">Choose your Sector (Vous pouvez ignorez ce champ dans le cas d'admine)</label>
                    <select class="form-select" aria-label="Default select example" id="sector" name="sector">
                        <?php foreach ($sectors as $sector) { ?>
                            <option value="<?php echo $sector->id_sector; ?>" <?php echo (isset($row) && isset($user) && $user->id_sector == $sector->id_sector) ? 'selected' : ''; ?>><?php echo $sector->sector_name; ?></option>
                        <?php } }?>
                    </select>
                </div>
                <div class="signup">
                    <input type="submit" name="submit" class="btn btn-primary" value="<?php echo $operation == 'update' ? 'Update' : 'Add'; ?>">
                </div>
            </form>
        </div>
    </div>
    <script src="../main.js"></script>
</body>
</html>
