<?php
session_start();
if (isset($_SESSION['unique_id'])) {
    include_once "config.php";
    $outgoing_id = htmlspecialchars($_POST['outgoing_id']);
    $incoming_id = htmlspecialchars($_POST['incoming_id']);
    $message = htmlspecialchars($_POST['message']);
    $output = "";
    $query = $pdo->prepare("SELECT * FROM messages 
    LEFT JOIN users ON users.unique_id = messages.incoming_msg_id
    WHERE (outgoing_msg_id = :outgoing_id AND incoming_msg_id = :incoming_id)
    OR (outgoing_msg_id = :incoming_id AND incoming_msg_id = :outgoing_id) ORDER BY msg_id");
    $query->bindParam(':outgoing_id', $outgoing_id);
    $query->bindParam(':incoming_id', $incoming_id);
    $query->execute();




    if ($query->rowCount() > 0) {
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            if ($row['outgoing_msg_id'] === $outgoing_id) { // if its equal then they are a sender
                $output .= '<div class="chat outgoing">
                <img src="images/users/' . $row['image'] . '" alt="user profile picture" />
                <div class="details">
                <p> ' . $row['message'] . '</p>
                </div>
                </div>';
            } else { // recieving message
                $user_query = $pdo->prepare("SELECT * FROM users WHERE unique_id = ?");
                $user_query->bindParam(1, $incoming_id);
                $user_query->execute();
                if ($user_query->rowCount() > 0) {
                    $user_query = $user_query->fetch(PDO::FETCH_ASSOC);
                    $incoming_image = $user_query['image'];
                }
                $output .= '<div class="chat incoming">
                                <div class="details">
                                <p>
                                ' . $row['message'] . '
                                </p>
                                </div>
                                <img src="images/users/' . $row['image'] . '" alt="user profile picture" />
                            </div>';
            }
        }
        echo $output;
    }
} else {
    header("../login.php");
}
