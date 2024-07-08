<?php
    include '../include/database.php';
    $id=$_GET['id'];
    $stmt=$database->prepare('DELETE FROM internship_reports
    WHERE id_report=?');
    $stmt->execute([$id]);
    header('Location: reports.php');
?>