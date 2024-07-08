<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Style/roles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Lepcha&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
    <title>Sectors</title>
</head>
<body>
    <?php
        include_once '../include/database.php';
    ?>
        <div class="header">
            <div class="container">
                <h1>Secotrs Table</h1>
            </div>
        </div>
        <div class="landing">
            <div class="container">
                
            </div>
        </div>
        <form method="POST" action="sectorControl.php">
            <div class="add">
                <div class="container">
                <a href="sectorControl.php?operation=add" class="btn btn-primary" name="addSector">Add Sector </a>
                               
                </div>
            </div>
        <div class="content">
            <div class="container">
                <table>
                    
                    <thead>
                        <td>Sector Name</td>
                        <td>Update</td>
                        <td>Delete</td>
                    </thead>
                    <tbody>
                        <?php
                            $stmt=$database->prepare('SELECT * FROM sectors');
                            $stmt->execute();
                            $sectors=$stmt->fetchAll(PDO::FETCH_OBJ);
                            foreach($sectors as $sector){
                               ?>
                               <tr>
                                <td><?php echo $sector->sector_name;?></td>
                                <td> 
                                    <a href="sectorControl.php?id=<?php echo $sector->id_sector;?>&operation=update" class="btn btn-primary" name="updateSector">Update </a>
                                </td>
                                <td> 
                                    <a href="sectorControl.php?id=<?php echo $sector->id_sector;?>&operation=delete" class="btn btn-primary" name="deleteSector">Delete </a>
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