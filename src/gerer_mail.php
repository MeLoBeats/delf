<?php
require_once '../src/bootstrap.php';

if(!is_admin()) {
    header('location: ../public');
    die;
}

$sujet = $_POST['sujet'];
$message = $_POST['message'];
try {
    $query = "INSERT INTO mail (sujet, message) VALUES ('$sujet', '$message');";
    $res = db()->prepare($query);
    $res->execute();
    header('location: ../public/admin.php?success=1');
} catch (\Throwable $th) {
    header('location: ../public/admin.php?err=2');
    // echo $th;
}