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
			<h1>Gierki</h1>

			<?php
			if (isset($_GET['wyloguj']))
			{
				unset($_SESSION['zalogowany']);
				session_destroy();
			}

			function filtruj($zmienna)
			{
			    if(get_magic_quotes_gpc())
			        $zmienna = stripslashes($zmienna);
			    return mysql_real_escape_string(htmlspecialchars(trim($zmienna)));
			}

			if (isset($_POST['loguj']))
			{
				$login = filtruj($_POST['login']);
				$haslo = filtruj($_POST['haslo']);
				$ip = filtruj($_SERVER['REMOTE_ADDR']);

				if (mysql_num_rows(mysql_query("SELECT login, haslo FROM uzytkownicy WHERE login = '".$login."' AND haslo = '".md5($haslo)."';")) > 0)
				{
					mysql_query("UPDATE `uzytkownicy` SET (`logowanie` = '".time().", `ip` = '".$ip."'') WHERE login = '".$login."';");

					$_SESSION['zalogowany'] = true;
					$_SESSION['login'] = $login;

				}
				else echo "Wpisany login i/lub hasło są niepoprawne.";
			}

			if(isset($_SESSION['zalogowany'])) {
				if ($_SESSION['zalogowany'])
				{
					echo '
					Witaj <b>'.$_SESSION['login'].'</b><br>

					<ul><li><a href="">Lista gier</a></li>
					<li><a href="">Ranking popularności gier</a></li>
					<li><a href="">Najlepsi gracze</a></li>
					<li><a href="">Znajomi</a></li></ul><br>';

					if($_SESSION['login'] == "admin") {
						echo '<a href="./admin.php">Panel administracyjny</a><br>';
					}

					echo '<a href="?wyloguj=1">[Wyloguj]</a>';
				}
			}

			if (!isset($_SESSION['zalogowany'])){
					echo '
					<p>W tej chwili jako niezalogowany użytkownik możesz:</p>
					<ul>
						<li><a href="#1">Przeglądać listę gier wraz z ich opisami</a></li>
						<li><a href="#2">Sprawdzić, które gry są najpopularniejsze</a></li>
						<li><a href="#3">Zobaczyć ranking najlepszych graczy</a></li>
					</ul>

					<form action="index.php" method="POST">
						<h2>Logowanie</h2>
						<b>Login:</b> <input type="text" name="login"><br>
						<b>Hasło:</b> <input type="password" name="haslo"><br><br>
						<input type="submit" value="Zaloguj" name="loguj">
					</form>

					</br><a href="./register.php">Nie masz konta? Zarejestruj się!</a>
					';
			}
			?>
		</div>


		<?php mysql_close(); ?>
	</body>
</html>
