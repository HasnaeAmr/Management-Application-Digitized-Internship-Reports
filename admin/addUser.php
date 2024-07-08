<?php 
    include_once 'include/database.php';
    $stmt=$database->query('SELECT * FROM sectors');
    $sectors=$stmt->fetchAll(PDO::FETCH_OBJ);
    $stmt=$database->query('SELECT * FROM level');
    $levels=$stmt->fetchAll(PDO::FETCH_OBJ);
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>| Sign Up</title>
    <link rel="stylesheet" href="../Style/signUp.css">
</head>
<body>
<div class="main">
        <div class="container">
            <div class="hello">
                <h4>Hello !</h4>
                <p>Sign Up to continue</p>
            </div>
            
            <form action="signupControl.php" method="POST">
                
            <div class="mb-3">
                <label for="name" class="form-label">Full Name</label>
                <input type="text" id="name" class="form-control" name="fullName" placeholder="Hasna AMARMACH" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" id="email" class="form-control" name="email" placeholder="hasna.amr@gmail.com" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" id="password" class="form-control" name="password" placeholder="hasna-amr:)" required>
            </div>
            
            <div class="sector-choice">
            <label for="sector">Choose your Sector </label>
           
            <select select class="form-select" aria-label="Default select example" id="sector" name="sector">
                <?php
                foreach($sectors as $sector){
                ?>
                <option value="<?php echo $sector->id_sector;?>"><?php echo $sector->sector_name;?></option><?php
                }?>
            </select>
            </div>
            <br>
            <div>
            Role : <br>
            
                <input type="radio" id="student" name="role" value=1 onchange="toggleLevel()">
                <label for="student"> Student</label>
                
                <input type="radio" id="HeadOfDepartment" name="role" value=2 onchange="toggleLevel()">
                <label for="HeadOfDepartment"> Head of Department</label>
                
                <input type="radio" id="departmentSecretary" name="role" value=3 onchange="toggleLevel()">
                <label for="departmentSecretary"> Department Secretary</label>
            </div>
            <br>
                <div id="level" name="level">
                    
                Level : <br>
                    <?php
                       
                        foreach($levels as $level){
                    ?>
                    <input type="radio" id="level" name="level" value="<?php echo $level->id_level;?>">
                    <label for="level"> <?php echo $level->level_name;?></label> <?php
                    }?>
                </div>
            <br>
            <div class="singup">
                <input type="submit" name="signup" class="btn btn-primary" value="Add User">
            </div>
            </form>
            
            
        </div>
    </div>
    
    <script src="main.js"></script>
</body>
</html>