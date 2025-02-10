<?php
session_start();
include_once 'config.php';

$email = htmlspecialchars($_POST['email']);
$password = htmlspecialchars($_POST['password']);

if (!empty($email) && !empty($password)) {
    //Check users entered email & password matched to database
    $pdo->beginTransaction();
    $sql = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $sql->bindParam(':email', $email);
    $sql->execute();
    if ($sql->rowCount() > 0) {
        $user = $sql->fetch(PDO::FETCH_ASSOC);
        if (password_verify($password, $user['password'])) {
            $_SESSION['unique_id'] = $user['unique_id'];
            $status = "Active now";
            $update = $pdo->prepare("UPDATE users SET status = :status WHERE unique_id = :unique_id");
            $update->bindParam(':unique_id', $user['unique_id']);
            $update->bindParam(':status', $status);
            $update->execute();
            $pdo->commit();
            if ($update) {
                echo 'success';
            }
        } else {
            echo 'Username or Password is incorrect.';
        }
    } else {
        echo 'Username or Password is incorrect..';
    }
} else {
    echo "All input fields are required!";
}
