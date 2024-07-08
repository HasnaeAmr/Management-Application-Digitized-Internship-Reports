<?php
    include '../include/database.php';
    $stmt=$database->prepare('SELECT * FROM admin WHERE email=? AND password=?');
    $stmt->prepare([$email,$password]);
    if(!$stmt)
        echo "You havn't access to this page !";    
        header(location: )

?>