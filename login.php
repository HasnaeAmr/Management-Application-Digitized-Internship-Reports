<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="Style/logIn.css" rel="stylesheet">
    <link rel="stylesheet" href="Style/student.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Lepcha&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
    <title>Log In</title>
</head>
<body>
    <div class="main">
        <div class="container">
            <div class="hello">
                <h1>Hello!</h1>
                <p>Log in to continue</p>
            </div>
            <?php
            session_start();
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                if(isset($_POST['email']) && isset($_POST['password'])){
                    $email = $_POST['email'];
                    $password = $_POST['password'];

                    include_once 'include/database.php';

                    $query = $database->prepare("SELECT id_user, fullName, id_role, password FROM user WHERE email = :email");
                    $query->bindParam(':email', $email);
                    $query->execute();
                    $row = $query->fetch();

                    if($row){
                        if($password == $row['password']){
                            $_SESSION['id_user'] = $row['id_user'];
                            $_SESSION['fullName'] = $row['fullName'];
                            $_SESSION['role'] = $row['id_role'];
                            if($row['id_role'] == 1)
                                header("Location: dashboardStudent.php");
                            elseif($row['id_role'] == 2)
                                header("Location: dashboardHead.php");
                            elseif($row['id_role'] == 3)
                                header("Location: dashboardSec.php");
                            elseif($row['id_role']==10){
                                header("Location: admin/dashboard.php");
                            }
                            exit();
                        } else {
                            echo '<div class="alert alert-secondary" role="alert">Invalid password!</div>';
                        }
                    }else {
                            echo '<div class="alert alert-secondary" role="alert">User not found!</div>';
                        }
                    }
                }
            
            ?>
            <div class="inputs">
                <form method="POST">
                    <div class="email">
                        <input type="email" id="email" class="emaill" name="email" placeholder="Email" required>
                    </div>
                    <div class="password">
                        <input type="password" id="password" class="passwordd" name="password" placeholder="Password" required>
                    </div>
                    <br>
                    <div class="logIn">
                        <input type="submit" name="logIn" class="logInn" value="Log In">
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
