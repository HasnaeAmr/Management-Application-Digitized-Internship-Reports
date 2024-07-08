<?php 
 include 'include/database.php';
 $logo="Images/logo.png";
 $logout="logOut.php";
include_once 'Style/nav.php';


// Check if user is logged in and has the appropriate role
if(!isset($_SESSION['role']) || $_SESSION['role'] != 3) {
    header('Location: login.php');
    exit; // Stop further execution
}
    
    // Include the database connection
   


$reports=[];
if(isset($_POST['search']))
$search = $_POST['search'];
// Check if a search is performed
if(isset($search) && !isset($_POST['showAll']) && !empty($search)){
    // Prepare SQL statement based on selected search criteria
    if(isset($_POST['byTitle'])){
        $stmt = $database->prepare("SELECT * FROM internship_reports, department_secretary, head_of_department 
        WHERE poster = head_of_department.id_user 
        AND head_of_department.id_sector = department_secretary.id_sector
        AND department_secretary.id_user = ? AND title LIKE ?");
        $stmt->execute([$_SESSION['id_user'],"%$search%"]);
    }
    
        elseif(isset($_POST['byYear'])){
        $stmt = $database->prepare("SELECT * FROM internship_reports, department_secretary, head_of_department 
        WHERE poster = head_of_department.id_user 
        AND head_of_department.id_sector = department_secretary.id_sector
        AND department_secretary.id_user = ? AND YEAR(date) = ?");
        $stmt->execute([$_SESSION['id_user'],$search]);
    }

    // Fetch reports
    if(isset($stmt)) {
        $reports = $stmt->fetchAll(PDO::FETCH_OBJ);
    }
} 
else if(isset($_POST['filter'])) {
    $level = $_POST['level'];
    $date=$_POST['date'];
    if(!empty($level)){
        if(!empty($date)){
            $stmt = $database->prepare('SELECT DISTINCT internship_reports.* 
            FROM internship_reports, students, department_secretary, students_report, head_of_department
            WHERE poster = head_of_department.id_user 
            AND date=?
            AND head_of_department.id_sector = department_secretary.id_sector
            AND department_secretary.id_user = ?
            AND students_report.id_report=internship_reports.id_report
            AND students.id_level = ?
            AND students_report.id_user = students.id_user');
            $stmt->execute([$date,$_SESSION['id_user'],$level]);
            $reports = $stmt->fetchAll(PDO::FETCH_OBJ);
        }else{
            $stmt = $database->prepare('SELECT DISTINCT internship_reports.* 
            FROM internship_reports, students, department_secretary, students_report, head_of_department
            WHERE poster = head_of_department.id_user 
            AND head_of_department.id_sector = department_secretary.id_sector
            AND department_secretary.id_user = ?
            AND students_report.id_report=internship_reports.id_report
            AND students.id_level = ?
            AND students_report.id_user = students.id_user');
            $stmt->execute([$_SESSION['id_user'],$level]);
            $reports = $stmt->fetchAll(PDO::FETCH_OBJ);
        }
    
}else{
    if(!empty($date)){
        $stmt = $database->prepare('SELECT * FROM internship_reports, department_secretary, head_of_department 
        WHERE poster = head_of_department.id_user 
        AND head_of_department.id_sector = department_secretary.id_sector
        AND department_secretary.id_user = ?
        AND date = ?');
        $stmt->execute([$_SESSION['id_user'],$date]);
        $reports = $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}
}else{
    if(isset($_POST['showAll']) || !isset($search) || (isset($filter) && empty($date) && empty($level))){
        $stmt = $database->prepare('SELECT * FROM internship_reports, department_secretary, head_of_department 
        WHERE poster = head_of_department.id_user 
        AND head_of_department.id_sector = department_secretary.id_sector
        AND department_secretary.id_user = ?');
        $stmt->execute([$_SESSION['id_user']]);
        $reports = $stmt->fetchAll(PDO::FETCH_OBJ);
    }        

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
                            <form class="form-inline" method="POST">
                                <input class="form-control mr-sm-2" type="search" name="search" placeholder="Search" aria-label="Search">
                                <div class="search-by">
                                    <input class="btn btn-outline-success my-2 my-sm-0" type="submit" name="byTitle" value="Search By Title">
                                    <input class="btn btn-outline-success my-2 my-sm-0" type="submit" name="byYear" value="Search By Year">
                                    <input class="btn btn-outline-success my-2 my-sm-0" type="submit" name="showAll" value="Show All">
                                </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="filter">
                <div class="container">
                <div class="sector-choice">
            <label for="sector">Filters</label>
            <select select class="form-select" aria-label="Default select example" id="sector" name="level">
            <option value="">Select</option>
            <?php
            $stmt=$database->query('SELECT * FROM level');
            $levels=$stmt->fetchAll(PDO::FETCH_OBJ);
            if($levels){
                foreach($levels as $level){
                    ?>
                        <option value="<?php echo $level->id_level;?>"><?php echo $level->level_name;?></option>
                    <?php
                }
            }
            ?>
            </select>
            <input name="date" type="date">
        </div>
        <input class="btn btn-outline-success my-2 my-sm-0" type="submit" name="filter" value="Filter">
        
        </form>
                </div>
            </div>
        </div>
    </div>

  
    <div class="cont">
        
                <?php 
                if(!$reports && isset($search) && $search){
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
                        <div class="view"> <div class="file"> </div> </div>
                       <div class="infos">
                           <div class="title">
                       <h5><?php echo $report->title ?></h5>
                       <span class="daty"><?php echo $report->date ?></span>
                      </div>
                      <a href="uploads/<?php echo $report->file ?>" class="down" class="btn btn-outline-primary my-2 my-sm-0" download>
    <i class="fa-solid fa-download"></i>
</a>
                       </div></a>
                       </div>
                       
                       <?php }  } ?>
    </div>

</body>
</html>
