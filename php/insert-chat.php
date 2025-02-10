<?php
session_start();
if (isset($_SESSION['unique_id'])) {
    include_once "config.php";
    $incoming_id = htmlspecialchars($_POST['incoming_id']);
    $outgoing_id = htmlspecialchars($_POST['outgoing_id']);
    $message = htmlspecialchars($_POST['message']);

    if (!empty($message)) {
        $sql = $pdo->prepare("INSERT INTO messages (incoming_msg_id,outgoing_msg_id,message) VALUES (?,?,?)") or die();
        $sql->bindParam(1, $incoming_id);
        $sql->bindParam(2, $outgoing_id);
        $sql->bindParam(3, $message);
        $sql->execute();
    }
} else {
    header("../login.php");
}
