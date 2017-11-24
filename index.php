<?php
	require_once "session.php";
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Logowanie - Gierki</title>

		<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
		<link rel="stylesheet" href="./style.css">
	</head>

	<body>

		<?php include "navbar.html"; ?>

		<div class="container-fluid col-md-8 main">
			<?php

			$loginmessage = "";

			if (isset($_GET['logout']))
			{
				unset($_SESSION['loggedin']);
				session_destroy();
			}

			function filter($var)
			{
			    if(get_magic_quotes_gpc())
			        $var = stripslashes($var);
			    return mysql_real_escape_string(htmlspecialchars(trim($var)));
			}

			if (isset($_POST['signin']))
			{
				$login = filter($_POST['login']);
				$password = filter($_POST['password']);
				$ip = filter($_SERVER['REMOTE_ADDR']);

				if (mysql_num_rows(mysql_query("SELECT login, password FROM users WHERE login = '".$login."' AND password = '".md5($password)."';")) > 0)
				{
					mysql_query("UPDATE `users` SET (`last_login` = '".time().", `ip` = '".$ip."'') WHERE login = '".$login."';");

					$group_id_query = "SELECT group_id FROM users WHERE login = '".$login."' limit 1;";
					$gid_result = mysql_query($group_id_query);
					$row = mysql_fetch_assoc($gid_result);

					$_SESSION['loggedin'] = true;
					$_SESSION['login'] = $login;
					$_SESSION['group_id'] = $row['group_id'];

				}
				// else echo "Wpisany login i/lub hasło są niepoprawne.";
				else $loginmessage = "<br>Wpisany login i/lub hasło są niepoprawne.";
			}

			if(isset($_SESSION['loggedin'])) {
				if ($_SESSION['loggedin'])
				{
					echo '
					<h1>Witaj, '.$_SESSION['login'].'!</h1>
					<br>

					<ul><li><a href="./gameslist.php">Lista gier</a></li>
					<li><a href="./highscores.php">Najlepsi gracze</a></li>
					<li><a href="">Ranking popularności gier</a></li>
					<li><a href="">Profil</a></li>
					<li><a href="">Znajomi</a></li></ul><br>';

					if($_SESSION['group_id'] == 1) {
						echo '<a href="./admin.php">Panel administracyjny</a><br>';
					}

					echo '<a class="btn btn-primary" href="?logout=1">Wyloguj się</a><br>';
				}
			}

			if (!isset($_SESSION['loggedin'])){
					echo '
					<h1>Witaj, gościu!</h1>
					<p>W tej chwili jako niezalogowany użytkownik możesz:</p>
					<ul>
						<li><a href="./gameslist.php">Przeglądać listę gier wraz z ich opisami</a></li>
						<li><a href="">Sprawdzić, które gry są najpopularniejsze</a></li>
						<li><a href="./highscores.php">Zobaczyć ranking najlepszych graczy</a></li>
					</ul>

					<form class="col-md-4" action="index.php" method="POST">
						<h2>Logowanie</h2>
					  <div class="form-group">
					    <label for="login">Nazwa użytkownika</label>
					    <input type="text" class="form-control" name="login" placeholder="Podaj swój login">
					  </div>
					  <div class="form-group">
					    <label for="password">Hasło</label>
					    <input type="password" class="form-control" name="password" placeholder="Hasło">
					  </div>
					  <button type="submit" class="btn btn-primary" name="signin">Zaloguj się</button>
					</form>'.$loginmessage.'

					<br><a href="./register.php">Nie masz konta? Zarejestruj się!</a>
					';
			}
			?>
		</div>

		<?php mysql_close(); ?>
	</body>
</html>
