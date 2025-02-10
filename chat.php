<?php
session_start();
if (!isset($_SESSION['unique_id'])) {
	header("location: login.php");
}

?>
<?php include_once "header.inc.php" ?>

<body>
	<div class="wrapper">
		<section class="chat-area">
			<header>
				<?php
				include_once "php/config.php";
				$user_id = htmlspecialchars($_GET['user_id']);
				$sql = $pdo->prepare("SELECT * FROM users WHERE unique_id = ?");
				$sql->execute([$user_id]);
				if ($sql->rowCount() > 0) {
					$user = $sql->fetch(PDO::FETCH_ASSOC);
				}
				?>
				<a href="users.php" class="back-icon"><i class="fas fa-arrow-left"></i></a>
				<img src="<?= "images/users/" . $user['image'] ?>" alt="user profile picture" />
				<div class="details">
					<span><?= $user['fname'] . " " . $user['lname'] ?></span>
					<p><?= $user['status'] ?></p>
				</div>
			</header>
			<div class="chat-box">

			</div>
			<form action="#" class="typing-area" autocomplete="off">
				<input type="text" value="<?= $_SESSION['unique_id'] ?>" hidden name="outgoing_id">
				<input type="text" value="<?= $user_id ?>" hidden name="incoming_id">
				<input type="text" name="message" class="input-field" placeholder="Type a message here..." />
				<button><i class="fab fa-telegram-plane"></i></button>
			</form>
		</section>
	</div>
	<script src="javascript/chat.js"></script>
</body>

</html>