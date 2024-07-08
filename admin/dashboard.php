
<?php
 include '../include/database.php';
 $logo="../Images/logo.png";
 $logout="../logOut.php";
    include '../Style/nav.php';


    // Check if user is logged in and has the appropriate role
    if(!isset($_SESSION['role']) || $_SESSION['role'] != 10) {
        header('Location: ../login.php');
        exit; // Stop further execution
    }
    
    // Include the database connection
   
    
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Style/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Lepcha&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Lepcha&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
<style>
        /* Reset default margin and padding */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Style for header */
        .header {/* Dark background color */
            color: white; /* Text color */
            padding: 20px; /* Padding for top and bottom */
            display: flex;
            justify-content: center; /* Align items to the edges */
            align-items: center; /* Center vertically */
            margin-top: -42px;
        }

        /* Style for the heading */
        .header h1 {
            font-size: 24px; /* Adjust font size */
            margin-right: auto; 
            color: #333;/* Pushes the button to the right */
        }

        /* Style for the inbox button */
        .inbox-button {
            margin: 0 85px;
            background-color: #007bff; /* Blue background color */
            color: white; /* Text color */
            text-decoration: none; /* Remove underline */
            padding: 10px 20px; /* Padding for top and bottom */
            border-radius: 5px; /* Rounded corners */
            transition: background-color 0.3s; /* Smooth transition on hover */
            font-size: 16px; /* Font size */
        }

        /* Change background color on hover */
        .inbox-button:hover {
            background-color: #0056b3; /* Darker shade of blue */
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="container">
            <h1>Hello <?php echo $_SESSION['fullName']." !";?></h1>
            <a href="inbox.php" class="inbox-button">Inbox</a>
        </div>
    </div>
    <div class="dash">
        <div class="container">
                <div class="card">
                    <div class="container">
                        <div class="icon">
                        <i class="fa-solid fa-file-lines"></i>
                        <h3>REPORTS</h3>
                        </div>
                        <div class="number">
                            <?php
                            $stmt = $database->prepare("SELECT COUNT(*) as total_rows FROM internship_reports");
                            $stmt->execute();
                            $result = $stmt->fetch(PDO::FETCH_ASSOC);
                            // Output the total number of rows
                            echo $result['total_rows'];
                            ?>
                        </div>
                        <div class="manage">
                            <a href="reports.php">Manage</a>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="container">
                        <div class="icon">
                        <div><i class="fa-solid fa-users"></i></div>
                        <h3>USERS</h3>
                        </div>
                        <div class="number">
                            <?php
                            $stmt = $database->prepare("SELECT COUNT(*) as total_rows FROM user");
                            $stmt->execute();
                            $result = $stmt->fetch(PDO::FETCH_ASSOC);
                            // Output the total number of rows
                            echo $result['total_rows'];
                            ?>
                        </div>
                        <div class="manage">
                            <a href="users.php">Manage</a>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="container">
                        <div class="icon">
                        <i class="fa-solid fa-list-check"></i>
                        <h3>Roles</h3>
                        </div>
                        <div class="number">
                            <?php
                            $stmt = $database->prepare("SELECT COUNT(*) as total_rows FROM roles");
                            $stmt->execute();
                            $result = $stmt->fetch(PDO::FETCH_ASSOC);
                            // Output the total number of rows
                            echo $result['total_rows'];
                            ?>
                        </div>
                        <div class="manage">
                            <a href="roles.php">Manage</a>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="container">
                        <div class="icon">
                        <i class="fa-solid fa-vector-square"></i>
                        <h3>Sectors</h3>
                        </div>
                        <div class="number">
                            <?php
                            $stmt = $database->prepare("SELECT COUNT(*) as total_rows FROM sectors");
                            $stmt->execute();
                            $result = $stmt->fetch(PDO::FETCH_ASSOC);
                            // Output the total number of rows
                            echo $result['total_rows'];
                            ?>
                        </div>
                        <div class="manage">
                            <a href="sectors.php">Manage</a>
                        </div>
                    </div>
                </div>
                
    </div>
</div>
        </div>
    </div>
           <div class="para">
            <p>Welcome to your dedicated space for internship reports ! Explore our database to discover valuable insights and opportunities for your professional growth.</p>
           </div> 
        
</body>
</html>