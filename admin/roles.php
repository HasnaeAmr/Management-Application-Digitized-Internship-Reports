<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Style/roles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Lepcha&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
    <title>Roles</title>
    <style>
        .content .container{
            width: 50%;
            margin: auto;
        }
    </style>
</head>
<body>
    <?php
        include_once '../include/database.php';
    ?>
        <div class="header">
            <div class="container">
                <h1>Roles Table</h1>
            </div>
        </div>
        <div class="landing">
            <div class="container">
                <div class="card">
                    <div class="number">
                         <?php $stmt = $database->prepare("SELECT COUNT(*) as total_rows FROM students");
                            $stmt->execute();
                            $result = $stmt->fetch(PDO::FETCH_ASSOC);
                            echo $result['total_rows'];?></div><h3> Students</h3>
                    
                </div>
                <div class="card">
                    <div class="number">
                        <?php $stmt = $database->prepare("SELECT COUNT(*) as total_rows FROM head_of_department");
                            $stmt->execute();
                            $result = $stmt->fetch(PDO::FETCH_ASSOC);
                            echo $result['total_rows'];?> </div><h3> Head of Department</h3>
                    
                </div>
                <div class="card">
                    <div class="number">
                         <?php $stmt = $database->prepare("SELECT COUNT(*) as total_rows FROM department_secretary");
                            $stmt->execute();
                            $result = $stmt->fetch(PDO::FETCH_ASSOC);
                            echo $result['total_rows'];?></div><h3> Department Secretary</h3>
                    
                </div>
            </div>
        </div>
        <form method="POST" action="roleControl.php">
            <div class="add">
                <div class="container">
                               
                </div>
            </div>
        <div class="content">
            <div class="container">
                <table>
                    
                    <thead>
                        <td>Role Name</td>
                        <td>Update</td>
                    </thead>
                    <tbody>
                        <?php
                            $stmt=$database->prepare('SELECT * FROM roles');
                            $stmt->execute();
                            $roles=$stmt->fetchAll(PDO::FETCH_OBJ);
                            foreach($roles as $role){
                               ?>
                               <tr>
                                <td><?php echo $role->role_name;?></td>
                                <td> 
                                    <a href="roleControl.php?id=<?php echo $role->id_role;?>&operation=update" class="btn btn-primary" name="updateRole">Update </a>
                                </td>
                                
                                <tr>
                                <?php
                            }
                        ?>
                    </tbody>
                    </form>
                </table>
            </div>
        </div>
</body>
</html>