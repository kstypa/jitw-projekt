<?php
	require_once "session.php";

	if(isset($_SESSION['loggedin'])) {
		if ($_SESSION['loggedin']) {
			if(isset($_GET['changestyle'])) {
				if($_GET['changestyle'] == "1") {
					$user_result = mysql_query("SELECT * from `users` WHERE `login` = '".$_SESSION['login']."' limit 1");
			        $user_id = mysql_fetch_assoc($user_result);
			        $style = $user_id['style'];
					if($style == 1) {
						mysql_query("UPDATE users SET style = 0 WHERE id = ".$uid.";");
					}
					else {
						mysql_query("UPDATE users SET style = 1 WHERE id = ".$uid.";");
					}
					$user_result = mysql_query("SELECT * from `users` WHERE `login` = '".$_SESSION['login']."' limit 1");
			        $user_id = mysql_fetch_assoc($user_result);
			        $style = $user_id['style'];
					if($style == 1) {
			            $btncolor = "btn-danger";
			            $cardcolor = "card-dark bg-dark";
			            $listcolor = "list-group-item-dark";
			            $badgecolor = "badge-danger";
			        }
			        else {
			            $btncolor = "btn-primary";
			            $cardcolor = "";
			            $listcolor = "";
			            $badgecolor = "badge-primary";
			        }
				}
			}
		}
	}
	if (!isset($_SESSION['loggedin'])) {
		$style = 0;
		$btncolor = "btn-primary";
		$cardcolor = "";
		$listcolor = "";
		$badgecolor = "badge-primary";
	}
	if (isset($_GET['logout'])) {
		$style = 0;
		$btncolor = "btn-primary";
		$cardcolor = "";
		$listcolor = "";
		$badgecolor = "badge-primary";
	}
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
		<?php
		if($style == 1) {
			echo '<link rel="stylesheet" href="./css/style-dark.css">';
		}
		else {
			echo '<link rel="stylesheet" href="./css/style.css">';
		}
		?>
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

		<div class="container col-md-8 px-4 main">
			<div class="row">
				<div class="col-md-3">
					<div class="logo"></div>


			<?php
			if(isset($_SESSION['loggedin'])) {
				if ($_SESSION['loggedin'])
				{
					$user_result = mysql_query("SELECT * from `users` WHERE `login` = '".$_SESSION['login']."' limit 1");
			        $user_id = mysql_fetch_assoc($user_result);
					$uid = $user_id['id'];
					$login = $_SESSION['login'];
					$style = $user_id['style'];

					echo '
					<div class="list-group">
						<a class="list-group-item list-group-item-action '.$listcolor.' active" href="./">Strona główna</a>
						<a class="list-group-item list-group-item-action '.$listcolor.'" href="./gameslist.php">Lista gier</a>
						<a class="list-group-item list-group-item-action '.$listcolor.'" href="./highscores.php">Najlepsi gracze</a>
						<a class="list-group-item list-group-item-action '.$listcolor.'" href="./gameslist.php#popularity">Ranking popularności gier</a>
						<a class="list-group-item list-group-item-action '.$listcolor.'" href="./profile.php?id='.$uid.'">Profil</a>
						<a class="list-group-item list-group-item-action '.$listcolor.'" href="./profile.php?id='.$uid.'#friends">Znajomi</a>
						<a class="list-group-item list-group-item-action '.$listcolor.'" href="./userslist.php">Lista użytkowników</a>';

					if($_SESSION['group_id'] == 1) {
						echo '<a class="list-group-item list-group-item-action '.$listcolor.'" href="./admin.php">Panel administracyjny</a>';
					}

					echo '<a class="list-group-item list-group-item-action '.$listcolor.'" href="./?logout=1">Wyloguj się</a>
					</div></div>';

					echo '
					<div class="col-md-9">

					<h1>Witaj, '.$_SESSION['login'].'!</h1>
					<br>
					<h4>Zagraj w swoje ulubione gry:</h4>';
					$fav_select_query = "SELECT A.game_id, B.thumbnail, B.description, B.name as game
                                                FROM favorites A
                                                JOIN games B
                                                ON B.id = A.game_id
                                                WHERE A.user_id = ".$uid."
                                                ORDER BY B.id ASC";
                    $fav_select_result = mysql_query($fav_select_query);
					$favcounter = 0;
					echo '<br><div class="row">';
                    while($row = mysql_fetch_assoc($fav_select_result)) {
						echo '
						<div class="card mx-1 '.$cardcolor.'" style="width:15rem">
							<img class="card-img-top" src="'.$row['thumbnail'].'" alt="Game thumbnail">
							<div class="card-body">
								<h4 class="card-title">'.$row['game'].'</h4>
								<p class="card-text">'.$row['description'].'</p>

							</div>
							<div class="card-footer">
								<a href="game.php?id='.$row['game_id'].'" class="btn '.$btncolor.'">Przejdź</a>
							</div>
						</div>';
						$favcounter++;
                    }
					echo '</div>';
					if($favcounter == 0) {
						echo 'Nie masz żadnych ulubionych gier! Dodaj jakieś klikając przycisk na stronie gry!';
					}
					?>
					<br>
					<h3>Zapraszamy do zabawy!</h3>
					<p class="text-justify">Nasza strona oferuje rozrywkę, jakiej szukałeś! Zagraj za darmo w świetne gry online takie, jak Snake, Tetris czy Arkanoid!
						Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam ut quam et tellus gravida maximus. Sed vitae vulputate eros, non rutrum ex.
						Phasellus iaculis vehicula turpis quis posuere. Quisque non cursus enim. Aenean lobortis ornare pellentesque.
						Proin ullamcorper purus id est efficitur convallis. Proin interdum laoreet augue, ut placerat est pharetra a.
						In eleifend nulla sit amet urna maximus pharetra. Curabitur iaculis augue nec gravida scelerisque.
						Integer mattis augue ut justo gravida fermentum. Phasellus in dolor nibh.</p>
					<p class="text-justify">
						Donec sed magna turpis. Etiam finibus congue tortor ut rhoncus. Aenean egestas felis purus, eget mollis ex sodales ac.
						Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos.
						Nullam a erat sagittis, scelerisque tellus eu, cursus orci. Fusce non sollicitudin diam, eget rhoncus est.
						Donec mollis vulputate ligula vitae congue. Sed rhoncus magna eget condimentum pharetra. Fusce dapibus massa quam,
						nec congue ipsum efficitur et. Mauris porta eros non nisl iaculis vulputate. Ut mi arcu, finibus vel mollis eu,
						placerat a metus. Suspendisse potenti. Proin tincidunt nisi et ex sollicitudin, ac tempus diam eleifend.
						Praesent viverra malesuada ornare. Pellentesque et velit lectus.</p>


					</div>
					<?php
				}
			}

			if (!isset($_SESSION['loggedin'])){

				echo '
				<div class="list-group">
					<a class="list-group-item list-group-item-action active" href="./">Strona główna</a>
					<a class="list-group-item list-group-item-action" href="./register.php">Rejestracja</a>
					<a class="list-group-item list-group-item-action" href="./gameslist.php">Lista gier</a>
					<a class="list-group-item list-group-item-action" href="./highscores.php">Najlepsi gracze</a>
					<a class="list-group-item list-group-item-action" href="./gameslist.php#popularity">Ranking popularności gier</a>
					<a class="list-group-item list-group-item-action" href="./userslist.php">Lista użytkowników</a>
				</div>
			</div>
			<div class="col-md-9">
				<h1>Witaj, gościu!</h1><br>


				<form action="index.php" method="POST" style="width:18rem">
					<h3>Zaloguj się</h3>
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

				<br><a href="./register.php">Nie masz konta? Zarejestruj się!</a><br><br>

				<h3>Zapraszamy do zabawy!</h3>
				<p class="text-justify">Nasza strona oferuje rozrywkę, jakiej szukałeś! Zagraj za darmo w świetne gry online takie, jak Snake, Tetris czy Arkanoid!
					Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam ut quam et tellus gravida maximus. Sed vitae vulputate eros, non rutrum ex.
					Phasellus iaculis vehicula turpis quis posuere. Quisque non cursus enim. Aenean lobortis ornare pellentesque.
					Proin ullamcorper purus id est efficitur convallis. Proin interdum laoreet augue, ut placerat est pharetra a.
					In eleifend nulla sit amet urna maximus pharetra. Curabitur iaculis augue nec gravida scelerisque.
					Integer mattis augue ut justo gravida fermentum. Phasellus in dolor nibh.</p>
				<p class="text-justify">
					Donec sed magna turpis. Etiam finibus congue tortor ut rhoncus. Aenean egestas felis purus, eget mollis ex sodales ac.
					Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos.
					Nullam a erat sagittis, scelerisque tellus eu, cursus orci. Fusce non sollicitudin diam, eget rhoncus est.
					Donec mollis vulputate ligula vitae congue. Sed rhoncus magna eget condimentum pharetra. Fusce dapibus massa quam,
					nec congue ipsum efficitur et. Mauris porta eros non nisl iaculis vulputate. Ut mi arcu, finibus vel mollis eu,
					placerat a metus. Suspendisse potenti. Proin tincidunt nisi et ex sollicitudin, ac tempus diam eleifend.
					Praesent viverra malesuada ornare. Pellentesque et velit lectus.</p>

				</div>
				';
			}
			?>
			</div>
		</div>

		<?php include './footer.html'; ?>

		<?php mysql_close(); ?>
	</body>
</html>
