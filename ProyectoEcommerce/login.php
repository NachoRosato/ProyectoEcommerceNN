<?php

  session_start();

  if (isset($_SESSION['user_id'])) {
    header('Location: /php-login');
  }
  require 'database.php';

  if (!empty($_POST['email']) && !empty($_POST['password'])) {
    $records = $conn->prepare('SELECT id, email, password FROM users WHERE email = :email');
    $records->bindParam(':email', $_POST['email']);
    $records->execute();
    $results = $records->fetch(PDO::FETCH_ASSOC);

    $message = '';

    if (count($results) > 0 && password_verify($_POST['password'], $results['password'])) {
      $_SESSION['user_id'] = $results['id'];
      header("Location: /php-login/ProyectoEcommerce/");
    } else {
      $message = 'Sorry, those credentials do not match';
    }
  }

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Login</title>
	<link href="https://fonts.googleapis.com/css2?family=Roboto:ital@0;1&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
	<?php require 'partials/header.php' ?>
	<h1>Login</h1>

	<?php if(!empty($message)): ?>
      <p> <?= $message ?></p>
    <?php endif; ?>

	<span>or <a href="signup.php">SignUp</a></span>
	<form action="login.php" method="post">
		<input type="text" name="email" placeholder="Ingrese su Email">
		<input type="password" name="password" placeholder="Ingrese su Contraseña">
		<input type="submit" value="Ingresar">
	</form>

</body>
</html>