<?php
 session_start();
?>
<style>
.head{
    width: 100%;
    box-shadow: 0 -20px 28px 2px rgb(103, 103, 103);
    backdrop-filter: blur(15px);
}
.head .container{
    display: flex;
    justify-content: space-between;
    align-items: center;
    width: 100%;
    margin: auto;
    padding: 0 40px;
}
.head img{
    width: 60px;
}
.head .container .profile{
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.head i{
    font-size: 20px;
    color: rgb(16, 113, 239);
    cursor: pointer;
    padding: 2px 0 2px 15px;
}
.head .user-image{
    border-left: 3px solid rgb(16, 113, 239);
}
.head h5{
    padding-right: 15px;
    margin-bottom: 0;
}
.head h3{
    margin-bottom: 0;
}
</style>
<div class="head">
        <div class="container">
            <?php  
            
            ?>
            <div class="logo"><img src=<?php echo $logo ;?>></div>
            <?php 
            $q=$database->query('SELECT role_name FROM roles WHERE id_role='.$_SESSION['role'])->fetch(PDO::FETCH_OBJ);
            ?>
            <div class="username"><h3><?php echo $q->role_name?></h3></div>
            <div class="profile">
                <div class="username"><?php echo "<h5>".$_SESSION['fullName']."</h5>";?></div>
                <div class="user-image"><i class="fa-solid fa-user"></i>
                <a href=<?php echo $logout ;?>><i class="fa-solid fa-right-from-bracket"></i></a></div>
            </div>
        </div>
    </div>