<?php
    include '../include/database.php';
    $id=$_GET['id'];
    $stmt=$database->prepare('SELECT * FROM internship_reports WHERE id_report=?');
    $stmt->execute([$id]);
    $row=$stmt->fetch(PDO::FETCH_OBJ);
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Style/styleHead.css">
 <!-- Corrected the typo -->
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Lepcha&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Lepcha&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
<title>update</title>
</head>
<body>
    
    <div class="landing">
        <div class="container">
            </div>
        </div>
                <div class="formm">
                <form method="post" enctype="multipart/form-data">
                <?php
        $fileName='';
        if(isset($_POST['upRep'])){
            $title=$_POST['title'];
            $description=$_POST['description'];
            $email=$_POST['email'];
        }
        if(!empty($title) && !empty($description) && !empty($email)){
                $userq=$database->prepare('SELECT id_user,id_role FROM user WHERE email=?');
                $userq->execute([$email]);
                $user=$userq->fetch(PDO::FETCH_OBJ);

                if($user && $user->id_role==1){
                    if(!empty($_FILES['report']['name'])){
                        $report=$_FILES['report']['name'];
                        $fileName=uniqid().$report;
                        move_uploaded_file($_FILES['report']['tmp_name'],'../uploads/'.$fileName);
                        $stmt=$database->prepare('
                        UPDATE internship_reports
                        SET title = ?, email = ?, description = ?, file=?
                        WHERE id_report=?');
                        $stmt->execute([$title,$email,$description,$fileName,$id]);}
                    else{
                        $stmt=$database->prepare('
                        UPDATE internship_reports
                        SET title = ?, email = ?, description = ?
                        WHERE id_report=?');
                        $stmt->execute([$title,$email,$description,$id]);
                    }

            ?>
            <div class="alert alert-success" role="alert">
                <?php echo $title. " Document is Updated successfully !";
                header('Location: reports.php');?> 

            </div>
            <?php
            } else{
                ?>
                <div class="alert alert-danger" role="alert">
                <?php echo $title. " Undefiend Student !";?> 
            </div>
            <?php
            }
        }
        
    ?>
                    <div class="mb-3">
                        <label for="title"class="form-label">Title</label>
                        <input type="text" name="title" class="form-control" id="title" value="<?php echo $row->title;?>">
                    </div>
                    <div class="mb-3">
                        <label for="email"class="form-label">Student Email</label>
                        <input type="email" name="email" class="form-control" id="email" value="<?php echo $row->email;?>" >
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" name="description" id="description"><?php echo $row->description;?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="report" class="form-label">Your report</label>
                        <input type="file" name="report" class="form-control" id="report" >
                    </div><br>
                    <div class="pdf">
                        <embed src="../uploads/<?php echo $row->file;?>" class="doc" type="application/pdf" width="300px" height="120px"/>
                    </div><br>
                    <div class="submit">
                    <input type="submit" name="upRep" class="btn btn-primary" value="Update Report">
                    </div>
                    
                </form>
                </div>
    </body>
    </html>