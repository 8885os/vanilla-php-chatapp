<?php
session_start();
if (!isset($_SESSION['unique_id'])) {
	header("location: login.php");
}

?>

<?php include_once "header.inc.php" ?>

<body>
	<div class="wrapper">
		<section class="users">
			<header>
				<?php
				include_once "php/config.php";
				$sql = $pdo->prepare("SELECT * FROM users WHERE unique_id = ?");
				$sql->execute([$_SESSION['unique_id']]);
				if ($sql->rowCount() > 0) {
					$user = $sql->fetch(PDO::FETCH_ASSOC);
				}
				?>
				<div class="content">
					<img src="<?= "images/users/" . $user['image'] ?>" alt="user profile picture" />
					<div class="details">
						<span><?= $user['fname'] . " " . $user['lname'] ?></span>
						<p><?= $user['status'] ?></p>
					</div>
				</div>
				<a href="php/logout.php?logout_id=<?= $user['unique_id'] ?>" class="logout">Logout</a>
			</header>
			<div class="search">
				<span class="text">Select a user to start chat</span>
				<input type="text" placeholder="Enter name to search..." />
				<button><i class="fas fa-search"></i></button>
			</div>
			<div class="users-list">

			</div>
		</section>
	</div>
	<script src="javascript/users.js"></script>
</body>

</html>