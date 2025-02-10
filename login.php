<?php
session_start();
if (isset($_SESSION['unique_id'])) {
	header("location: users.php");
}
?>
<?php include_once "header.inc.php" ?>

<body>
	<div class="wrapper">
		<section class="form login">
			<header>Realtime Chat App</header>
			<form action="#">
				<div class="error-txt">This is an error message!</div>
				<div class="field input">
					<label>Email Address</label>
					<input type="text" name="email" placeholder="Email Address" />
				</div>
				<div class="field input">
					<label>Password</label>
					<input type="password" name="password" placeholder="Enter your Password" />
					<i class="fas fa-eye"></i>
				</div>
				<div class="field button">
					<input type="submit" value="Continue to Chat" />
				</div>
			</form>
			<div class="link">Not yet Signed up? <a href="index.php">Signup Now</a></div>
		</section>
	</div>
	<script src="javascript/pass-show-hide.js"></script>
	<script src="javascript/login.js"></script>
</body>

</html>