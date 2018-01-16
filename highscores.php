<?php
	require_once "session.php";
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Najlepsi gracze - Gierki</title>

		<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
		<link rel="stylesheet" href="./css/style.css">
	</head>

	<body>

		<?php include "navbar.php"; ?>

		<div class="container col-md-8 px-4 main">
			<div class="row">
				<div class="col-md-3">
					<div class="logo"></div>

					<?php

					if(isset($_SESSION['loggedin'])) {
						if ($_SESSION['loggedin']) {
							echo '
							<div class="list-group">
								<a class="list-group-item list-group-item-action" href="./">Strona główna</a>
								<a class="list-group-item list-group-item-action" href="./gameslist.php">Lista gier</a>
								<a class="list-group-item list-group-item-action active" href="./highscores.php">Najlepsi gracze</a>
								<a class="list-group-item list-group-item-action" href="./gameslist.php#popularity">Ranking popularności gier</a>
								<a class="list-group-item list-group-item-action" href="./profile.php?id='.$uid.'">Profil</a>
								<a class="list-group-item list-group-item-action" href="./profile.php?id='.$uid.'#friends">Znajomi</a>
								<a class="list-group-item list-group-item-action" href="./userslist.php">Lista użytkowników</a>';

							if($_SESSION['group_id'] == 1) {
								echo '<a class="list-group-item list-group-item-action" href="./admin.php">Panel administracyjny</a>';
							}

							echo '<a class="list-group-item list-group-item-action" href="./?logout=1">Wyloguj się</a>
							</div></div>';
						}
					}
					else {
						echo '
						<div class="list-group">
							<a class="list-group-item list-group-item-action" href="./">Strona główna</a>
							<a class="list-group-item list-group-item-action" href="./register.php">Rejestracja</a>
							<a class="list-group-item list-group-item-action" href="./gameslist.php">Lista gier</a>
							<a class="list-group-item list-group-item-action active" href="./highscores.php">Najlepsi gracze</a>
							<a class="list-group-item list-group-item-action" href="./gameslist.php#popularity">Ranking popularności gier</a>
							<a class="list-group-item list-group-item-action" href="./userslist.php">Lista użytkowników</a>
						</div>
					</div>';
					}
					?>
					<div class="col-md-9">

						<h1>Najlepsi gracze</h1>

						<h2>Snake</h2>
						<?php
						$i = 1;
						$score_query = "SELECT A.score, B.login as username
						FROM scores A
						Join users B
						on B.id = A.user_id
						WHERE A.game_id = 1
						ORDER BY A.score DESC";
						$score_result = mysql_query($score_query);
						while($row = mysql_fetch_assoc($score_result)) {
							echo $i.'. '.$row['username'].' -- '.$row['score'].'<br>';
							++$i;
						}
						?>

						<br>
						<h2>Outrun</h2>
						<?php
						$i = 1;
						$score_query = "SELECT A.score, B.login as username
						FROM scores A
						Join users B
						on B.id = A.user_id
						WHERE A.game_id = 2
						ORDER BY A.score DESC";
						$score_result = mysql_query($score_query);
						while($row = mysql_fetch_assoc($score_result)) {
							echo $i.'. '.$row['username'].' -- '.$row['score'].'<br>';
							++$i;
						}
						?>

						<br>
						<h2>Delta</h2>
						<?php
						$i = 1;
						$score_query = "SELECT A.score, B.login as username
						FROM scores A
						Join users B
						on B.id = A.user_id
						WHERE A.game_id = 3
						ORDER BY A.score DESC";
						$score_result = mysql_query($score_query);
						while($row = mysql_fetch_assoc($score_result)) {
							echo $i.'. '.$row['username'].' -- '.$row['score'].'<br>';
							++$i;
						}
						?>

						<br>
						<h2>Arkanoid</h2>
						<?php
						$i = 1;
						$score_query = "SELECT A.score, B.login as username
						FROM scores A
						Join users B
						on B.id = A.user_id
						WHERE A.game_id = 4
						ORDER BY A.score DESC";
						$score_result = mysql_query($score_query);
						while($row = mysql_fetch_assoc($score_result)) {
							echo $i.'. '.$row['username'].' -- '.$row['score'].'<br>';
							++$i;
						}
						?>

						<br>
						<h2>Tetris</h2>
						<?php
						$i = 1;
						$score_query = "SELECT A.score, B.login as username
						FROM scores A
						Join users B
						on B.id = A.user_id
						WHERE A.game_id = 5
						ORDER BY A.score DESC";
						$score_result = mysql_query($score_query);
						while($row = mysql_fetch_assoc($score_result)) {
							echo $i.'. '.$row['username'].' -- '.$row['score'].'<br>';
							++$i;
						}
						?>

						<br>
					</div>
				</div>
    </div>

	<?php include './footer.html'; ?>

    <?php mysql_close(); ?>
  </body>
</html>
