<?php include_once "config.php";
session_start();
$outgoing_id = $_SESSION['unique_id'];
$searchTerm = htmlspecialchars($_POST['searchTerm']);
$searchTerm = "%" . $searchTerm . "%";
$output = "";
$sql = $pdo->prepare("SELECT * FROM users WHERE NOT unique_id = :outgoing_id AND (fname LIKE :searchTerm OR lname LIKE :searchTerm)");
$sql->bindParam(':searchTerm', $searchTerm, PDO::PARAM_STR);
$sql->bindParam(':outgoing_id', $outgoing_id);
$sql->execute();
if ($sql->rowCount() > 0) {
    include "data.inc.php";
} else {
    $output .= "No user found related to your search term";
}
echo $output;
