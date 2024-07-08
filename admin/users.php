<?php
    include_once '../include/database.php';
    $users = [];
    $search = "";
    
    // Check if the search form is submitted
    
    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../Style/user.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Lepcha&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
    <title>Users</title>
    <style>
        .header h1{
            color: #666;
        }
    </style>
</head>
<body>
    
    <?php
        include_once '../include/database.php';
    ?>
        <div class="header">
            <div class="container">
                <h1>User Settings</h1>
        </div>
        </div>
        
        <div class="dash">
        <form method="POST">
    <div class="cont">
       
            <?php 
            $stmt_roles = $database->query('SELECT * FROM roles');
            $roles = $stmt_roles->fetchAll(PDO::FETCH_ASSOC);

            // Loop through each role
            foreach($roles as $role) {
                // Prepare statement to count users for this role
                $stmt_users = $database->prepare("SELECT COUNT(*) as total_users FROM user WHERE id_role=? ORDER BY fullName");
                $stmt_users->execute([$role['id_role']]);
                $users_count = $stmt_users->fetchColumn(); // Fetching the count directly

                // Display role information
            ?>
            <div class="cardy">
                <div class="number">
                    <?php echo "<h3>". $users_count."</h3>"
                    ; ?>
                </div>
                <h3 class="title"><?php echo $role['role_name']; ?></h3>
                <button value="<?php echo $role['id_role'];?>" name="role">Select</button>
            </div>
            <?php
            }
            ?>
       
    </div>
</div>

            <div class="search">
            <?php
            $stmt = $database->prepare('SELECT * FROM user ORDER BY fullName');
            $stmt->execute();
            $users = $stmt->fetchAll(PDO::FETCH_OBJ);
            if(isset($_POST['role'])){ 
                $stmt= $database->prepare('SELECT * FROM user WHERE id_role=?');
                $stmt->execute([$_POST['role']]);
                $users = $stmt->fetchAll(PDO::FETCH_OBJ);}
                if(isset($_POST['search'])){
                    $search = $_POST['search'];
                    // Check if a search is performed
                    if(isset($search) && !empty($search)){
                        // Prepare SQL statement based on selected search criteria
                        if(isset($_POST['byName'])){
                            $stmt = $database->prepare("SELECT * FROM user WHERE fullName LIKE ?");
                            $stmt->execute(["%$search%"]);
                        } elseif(isset($_POST['byemail'])){
                            $stmt = $database->prepare("SELECT * FROM user WHERE email LIKE ?");
                            $stmt->execute(["%$search%"]);
                        }
                        if(isset($stmt)){
                            $users = $stmt->fetchAll(PDO::FETCH_OBJ);
                        }
                    }
                }
                if(isset($_POST['showAll'])|| !isset($search) || !isset($role)){
                    $stmt = $database->prepare('SELECT * FROM user ORDER BY fullName');
                    $stmt->execute();
                    $users = $stmt->fetchAll(PDO::FETCH_OBJ);
                }  
    ?> 

</form>
<form method="POST">
    <div class="search">
                <div class="container mt-5">
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            
                                <input class="form-control mr-sm-2" type="search" name="search" placeholder="Search" aria-label="Search">
                                <div class="search-by">
                                    <input class="btn btn-outline-info my-2 my-sm-0" type="submit" name="byName" value="Search By Name">
                                    <input class="btn btn-outline-info my-2 my-sm-0" type="submit" name="byemail" value="Search By Email">
                                    <input class="btn btn-outline-primary my-2 my-sm-0" type="submit" name="showAll" value="Show All">
                                </div>
                        </div>
                    </div>
                </div>
    </div>
            </div>
            
    <div class="infos"> 
        <div class="cont">
            <div class="add">
            <a href="userControl.php?operation=add" class="btn btn-primary" name="add">Add <i class="fa-solid fa-plus"></i></a>
            </div>
            <div class="tabcont">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Full Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Password</th>
                    <th scope="col">Role</th>
                    <th scope="col">Sector</th>
                    <th scope="col">Level</th>
                    <th scope="col">Update</th>
                    <th scope="col">Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                if(!$users && $search){
                    ?>
                        <div class="alert alert-secondary" role="alert">
                            No result found !
                        </div>
                        <?php
                }else{
                    foreach ($users as $user) {
                        $stmt= $database->prepare('SELECT * FROM roles Where id_role=?');
                        $stmt->execute([$user->id_role]);
                        $role = $stmt->fetch(PDO::FETCH_OBJ);
                        if($user->id_role==1){
                            $stmt= $database->prepare('SELECT * FROM sectors,students WHERE students.id_sector=sectors.id_sector AND students.id_user=?');
                            $stmt->execute([$user->id_user]);
                            $sector = $stmt->fetch(PDO::FETCH_OBJ);
                            $stmt= $database->prepare('SELECT * FROM level,students WHERE students.id_level=level.id_level AND students.id_user=?');
                            $stmt->execute([$user->id_user]);
                            $level = $stmt->fetch(PDO::FETCH_OBJ);
                        }
                        if($user->id_role==2){
                            $stmt= $database->prepare('SELECT * FROM sectors,head_of_department WHERE head_of_department.id_sector=sectors.id_sector AND head_of_department.id_user=?');
                            $stmt->execute([$user->id_user]);
                            $sector = $stmt->fetch(PDO::FETCH_OBJ);
                        }
                        if($user->id_role==3){
                            $stmt= $database->prepare('SELECT * FROM sectors,department_secretary WHERE department_secretary.id_sector=sectors.id_sector AND department_secretary.id_user=?');
                            $stmt->execute([$user->id_user]);
                            $sector = $stmt->fetch(PDO::FETCH_OBJ);
                        }
                        
                         ?>
                    <tr>
                        <td><h5><?php echo $user->fullName ?></h5></td>
                        <td><?php echo $user->email ?></td>
                        <td><?php echo $user->password ?></td>
                        <td><?php echo $role->role_name ?></td>
                        <?php
                            if ($user->id_role == 10) {
                                echo "<td>All</td>";
                            } else {
                                echo "<td>" . $sector->sector_name . "</td>";
                            }
                            ?>

                        <?php
                            if($user->id_role == 1) {
                                ?><td><?php echo $level->level_name; ?></td><?php
                            } else {
                                ?><td>All</td><?php
                            }
                            ?>

                        <td><a href="userControl.php?id=<?php echo $user->id_user;?>&operation=update" class="btn btn-success" name="details">Update <i class="fa-solid fa-pen-to-square"></i></a></td>
                        <td><a href="userControl.php?id=<?php echo $user->id_user;?>&operation=delete" class="btn btn-danger" name="details">Delete <i class="fa-solid fa-trash"></i></a></td>
                <?php }  } ?>
            </tbody>
            </form>
        </table>
    </div>
    </div>
</body>
</html>