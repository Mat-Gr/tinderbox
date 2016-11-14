<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Tinderbox volunteer app</title>
</head>
<body>
	<form method="post" action="">
	<?php echo validation_errors(); ?>
		<div>
			<label>Email</label>
			<input type="text" name="email">
		</div>
		<div>
			<label>Password</label>
			<input type="password" name="password">
		</div>
		<input type="submit">
	</form>
</body>
</html>