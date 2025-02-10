<?php while ($user = $sql->fetch(PDO::FETCH_ASSOC)) {
	$sql2 = $pdo->prepare("SELECT * FROM messages WHERE (incoming_msg_id = ? OR outgoing_msg_id = ?) 
	AND (incoming_msg_id = ? OR outgoing_msg_id = ?) ORDER BY msg_id DESC LIMIT 1");
	$sql2->bindParam(1, $user['unique_id']);
	$sql2->bindParam(2, $user['unique_id']);
	$sql2->bindParam(3, $outgoing_id);
	$sql2->bindParam(4, $outgoing_id);
	$sql2->execute();
	$you = '';
	if ($sql2->rowCount() > 0) {

		$row2 = $sql2->fetch(PDO::FETCH_ASSOC);
		$last_message = $row2['message'];
		($outgoing_id == $row2['outgoing_msg_id']) ? $you = "You: " : $you = "";
	} else {
		$last_message = "No message available";
	}
	//check user is online or offline
	($user['status'] == 'Offline now') ? $offline = "offline" : $offline = "";

	//trimming message if word more than 28 characters.
	(strlen($last_message) > 28) ? $msg = substr($last_message, 0, 28) . ' .....' : $msg = $last_message;
	//who sent last message
	$output .= ' <a href="chat.php?user_id=' . $user["unique_id"] . '">
		<div class="content">
			<img src="images/users/' . $user["image"] . '" alt="user profile picture" />
							<div class="details">
								<span>' . $user['fname'] . " " . $user['lname'] . '</span>
								<p>' . $you . $msg . '</p>
							</div>
						</div>
						<div class="status-dot ' . $offline . '">
							<i class="fas fa-circle"></i>
						</div>
					</a>';
}
