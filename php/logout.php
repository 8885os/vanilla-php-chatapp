<?php
session_start();
if (isset($_SESSION['unique_id'])) {
    include_once "config.php";
    $logout_id = htmlspecialchars($_GET['logout_id']);
    if (isset($logout_id)) {
        $status = "Offline now";
        $sql = $pdo->prepare("UPDATE users SET status = :status WHERE unique_id = :unique_id");
        $sql->bindParam(':status', $status);
        $sql->bindParam(':unique_id', $logout_id);
        $sql->execute();
        session_destroy();
        session_unset();
        header('location: ../login.php');
    } else {
        header('location: ../users.php');
    }
} else {
    header('location: ../login.php');
}
