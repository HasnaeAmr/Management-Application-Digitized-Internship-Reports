<?php
    include_once 'include/database.php';
    $stmt = $database->prepare('SELECT * FROM internship_reports WHERE id_report = ?');
    $stmt->execute([$_GET['id']]);
    $report = $stmt->fetch(PDO::FETCH_OBJ);

    $head_stmt = $database->prepare('SELECT * FROM user WHERE id_user = ?');
    $head_stmt->execute([$report->poster]);
    $head = $head_stmt->fetch(PDO::FETCH_OBJ);
    $student_stmt = $database->prepare('SELECT * FROM user,students_report WHERE students_report.id_report = ? AND user.id_user = students_report.id_user ');
    $student_stmt->execute([$_GET['id']]);
    $student = $student_stmt->fetch(PDO::FETCH_OBJ);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Lepcha&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
    <title><?php echo $report->title?> | Details</title>
    <style>
        .details{
            width: 100%;
            height: 500px;
            margin: auto;
        }
        .container{
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: row;
            margin: 50px 80px;
            height: 100%;
        }
        .pdf{
            width:50%;
            height: 100%;
            margin: 30px;
        }
        .title{
            background-color: #eee;
        }
        .text{
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            margin: 30px;
            width:50%;
            height: 60%;

        }
        .description {
    max-width: 100%;
    overflow-wrap: break-word;
}
.doc{
    border-radius: 5px;
}

    </style>
</head>
<body>
    <div class="details">
        <div class="container">
        <div class="pdf">
            <embed src="uploads/<?php echo $report->file;?>" class="doc" type="application/pdf" width="100%" height="100%" />
        </div>
        <div class="text">
            <div class="title">
                <h2><?php echo $report->title;?></h2>
            </div>
            <div class="description">
                <h5><?php echo $report->description;?></h5>
            </div>
            <div class="date">
                Posted on : <?php echo $report->date."<br>By ". $head->fullName;?>
                 <?php echo "<br> Contact : ". $head->email;?>
            </div>
            <div class="from">
                <?php echo "From Student :  ". $student->fullName;?>
                <?php echo "Contact :  ". $student->email;?>
            </div>
            <br>
            
            </div>
        </div>
    </div>
</body>
</html>