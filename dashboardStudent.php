<?php 
include 'include/database.php';
$logo="Images/logo.png";
$logout="logOut.php";
include 'Style/nav.php';


// Check if user is logged in and has the appropriate role
if(!isset($_SESSION['role']) || $_SESSION['role'] != 1) {
    header('Location: login.php');
    exit; // Stop further execution
}

// Include the database connection



$reports=[];

if(isset($_POST['search'])){
$search = $_POST['search'];}
// Check if a search is performed
if(isset($search) && !isset($_POST['showAll']) && !empty($search)){
    

    // Prepare SQL statement based on selected search criteria
    if(isset($_POST['byTitle'])){
        $stmt = $database->prepare("SELECT * FROM internship_reports WHERE title LIKE ?");
        $stmt->execute(["%$search%"]);
    }
    elseif(isset($_POST['bySector'])){
        $stmt = $database->prepare("SELECT * FROM internship_reports, head_of_department, sectors WHERE sector_name LIKE ? 
        AND poster=id_user
        AND head_of_department.id_sector=sectors.id_sector");
        $stmt->execute(["%$search%"]);
        
    }
        elseif(isset($_POST['byYear'])){
        $stmt = $database->prepare("SELECT * FROM internship_reports WHERE YEAR(date) = ?");
        $stmt->execute([$search]);
    }

    // Fetch reports
    if(isset($stmt)) {
        $reports = $stmt->fetchAll(PDO::FETCH_OBJ);
    }
} else{
    if(isset($_POST['showAll']) || !isset($search))
    $reports = $database->query('SELECT * FROM internship_reports')->fetchAll(PDO::FETCH_OBJ);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | <?php echo $_SESSION['fullName'];?></title>
    <link rel="stylesheet" href="Style/student.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .rq{
            font-weight: 200;
            font-size: 12px;
            color: #333;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Lepcha&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="landing">
        <div class="container">
            <h1>Welcome <span class="name"><?php echo $_SESSION['fullName']; ?></span> to Your Space !</h1>
                <div class="search">
                <div class="container mt-5">
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <div class="rq">Search by sector try to write : GINFO GIND FID BTP GEE GE GM</div>
                            <style>
        
    </style>
                            <form class="form-inline" method="POST" action="">
                                <input class="form-control mr-sm-2" type="search" name="search" placeholder="Search" aria-label="Search">
                                <div class="search-by">
                                    <input class="btn btn-outline-secondary my-2 my-sm-0" type="submit" name="byTitle" value="Search By Title">
                                    <input class="btn btn-outline-secondary my-2 my-sm-0" type="submit" name="bySector" value="Search By Sector">
                                    <input class="btn btn-outline-secondary my-2 my-sm-0" type="submit" name="byYear" value="Search By Year">
                                    <input class="btn btn-outline-secondary my-2 my-sm-0" type="submit" name="showAll" value="Show All">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="cont">
                <?php 
                if(!$reports && $search){
                    ?>
                        <div class="alert alert-secondary" role="alert">
                            No result found !
                        </div>
                        <?php
                }else{
                    foreach ($reports as $report) {
                         ?>
                        
                         <div class="cardy">
                         <a href="details.php?id=<?php echo $report->id_report;?>">
                         <div class="view"><div class="file"></div> </div>
                        <div class="infos">
                            <div class="title">
                        <h5><?php echo $report->title ?></h5>
                        <span class="daty"><?php echo $report->date ?></span>
                       </div>
                       <a href="uploads/<?php echo $report->file ?>" class="down" class="btn btn-outline-primary my-2 my-sm-0" download>
    <i class="fa-solid fa-download"></i>
</a>                        </div></a>
                        </div>
                        
                        <?php }  } ?>
           
    </div>
                               

</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>PDF Card Design</title>
<style>
   
    .card {
        width: 300px;
        height: 200px;
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        padding: 20px;
        margin: 50px auto;
        text-align: center;
    }
    .card h1 {
        color: #333;
    }
    .card p {
        color: #666;
    }

