<?php
	require_once "session.php";
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Gierki</title>

		<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
		<link rel="stylesheet" href="./css/style.css">
	</head>

	<body>

		<?php

		$signinmessage = "";

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
			$logininput = filter($_POST['login']);
			$password = filter($_POST['password']);
			$ip = filter($_SERVER['REMOTE_ADDR']);

			if (mysql_num_rows(mysql_query("SELECT login, password FROM users WHERE login = '".$logininput."' AND password = '".md5($password)."';")) > 0)
			{
				mysql_query("UPDATE `users` SET (`last_login` = '".time().", `ip` = '".$ip."'') WHERE login = '".$logininput."';");

				$group_id_query = "SELECT group_id FROM users WHERE login = '".$logininput."' limit 1;";
				$gid_result = mysql_query($group_id_query);
				$row = mysql_fetch_assoc($gid_result);

				$_SESSION['loggedin'] = true;
				$_SESSION['login'] = $logininput;
				$_SESSION['group_id'] = $row['group_id'];

			}
			// else echo "Wpisany login i/lub hasło są niepoprawne.";
			else $signinmessage = "<br>Wpisany login i/lub hasło są niepoprawne.";
		}

		include "navbar.php";
		?>

		<div class="container-fluid col-md-8 main">
			<?php



			if(isset($_SESSION['loggedin'])) {
				if ($_SESSION['loggedin'])
				{
					$user_result = mysql_query("SELECT `id` from `users` WHERE `login` = '".$_SESSION['login']."' limit 1");
			        $user_id = mysql_fetch_assoc($user_result);
					$uid = $user_id['id'];
					$login = $_SESSION['login'];

					echo '
					<h1>Witaj, '.$_SESSION['login'].'!</h1>
					<br>';

					echo '
					<h3>Zagraj w swoje ulubione gry:</h3>';
					$fav_select_query = "SELECT A.game_id, B.thumbnail, B.description, B.name as game
                                                FROM favorites A
                                                JOIN games B
                                                ON B.id = A.game_id
                                                WHERE A.user_id = ".$uid."
                                                ORDER BY B.id ASC";
                    $fav_select_result = mysql_query($fav_select_query);
					$favcounter = 0;
					echo '<br><div class="card-deck" style="height:18rem">';
                    while($row = mysql_fetch_assoc($fav_select_result)) {
						echo '
						<div class="card">
							<img class="card-img-top" src="'.$row['thumbnail'].'" alt="Game thumbnail">
							<div class="card-body">
								<h4 class="card-title">'.$row['game'].'</h4>
								<p class="card-text">'.$row['description'].'</p>

							</div>
							<div class="card-footer">
								<a href="game.php?id='.$row['game_id'].'" class="btn btn-primary">Przejdź</a>
							</div>
						</div>';
						$favcounter++;
                    }
					echo '</div>';
					if($favcounter == 0) {
						echo 'Nie masz żadnych ulubionych gier! Dodaj jakieś klikając przycisk na stronie gry!';
					}
					echo '<br><br>';

					echo '
					<ul>
						<li><a href="./gameslist.php">Lista gier</a></li>
						<li><a href="./highscores.php">Najlepsi gracze</a></li>
						<li><a href="./gameslist.php#popularity">Ranking popularności gier</a></li>
						<li><a href="./profile.php?id='.$uid.'">Profil</a></li>
						<li><a href="./profile.php?id='.$uid.'#friends">Znajomi</a></li>
						<li><a href="./userslist.php">Lista użytkowników</a></li>
					</ul><br>';

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
						<li><a href="./gameslist.php#popularity">Sprawdzić, które gry są najpopularniejsze</a></li>
						<li><a href="./highscores.php">Zobaczyć ranking najlepszych graczy</a></li>
						<li><a href="./userslist.php">Spojrzeć na listę użytkowników i ich profile</a></li>
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
					</form>'.$signinmessage.'

					<br><a href="./register.php">Nie masz konta? Zarejestruj się!</a>
					';
			}
			?>
		</div>

		<?php include './footer.html'; ?>

		<?php mysql_close(); ?>
	</body>
</html>
