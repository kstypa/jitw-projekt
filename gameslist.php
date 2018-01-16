<?php
	require_once "session.php";

	if (!isset($_SESSION['loggedin'])) {
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
		<title>Lista gier - Gierki</title>

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
								<a class="list-group-item list-group-item-action '.$listcolor.'" href="./">Strona główna</a>
								<a class="list-group-item list-group-item-action '.$listcolor.' active" href="./gameslist.php">Lista gier</a>
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
						}
					}
					else {
						echo '
						<div class="list-group">
							<a class="list-group-item list-group-item-action" href="./">Strona główna</a>
							<a class="list-group-item list-group-item-action" href="./register.php">Rejestracja</a>
							<a class="list-group-item list-group-item-action active" href="./gameslist.php">Lista gier</a>
							<a class="list-group-item list-group-item-action" href="./highscores.php">Najlepsi gracze</a>
							<a class="list-group-item list-group-item-action" href="./gameslist.php#popularity">Ranking popularności gier</a>
							<a class="list-group-item list-group-item-action" href="./userslist.php">Lista użytkowników</a>
						</div>
					</div>';
					}

				function average($id) {
					$avg_result = mysql_query("SELECT AVG(`rating`) as `avg` FROM `ratings` WHERE `game_id` = ".$id.";");
					if($row = mysql_fetch_assoc($avg_result)) {
						return round($row['avg'], 1);
					}
					else return "0";
				}

				$games_select_result = mysql_query("SELECT * FROM games;");
				?>

				<div class="col-md-9">
					<h1>Lista gier</h1><br>
						<?php
						while($row = mysql_fetch_assoc($games_select_result)) {
							echo '
							<div class="card '.$cardcolor.' mb-3">
							  	<img class="card-img-top" src="'.$row['image1'].'" alt="Card image cap">
							  	<div class="card-body">
							    	<h5 class="card-title">'.$row['name'].'</h5>
							    	<p class="card-text">'.$row['description'].'</p>
							    	<p class="card-text"><small class="text-muted">ocena użytkowników: '.average($row['id']).'</small></p>
							  	</div>
							  	<div class="card-footer">
  									<a href="game.php?id='.$row['id'].'" class="btn '.$btncolor.'">Przejdź</a>
  								</div>
							</div>
							';
						}
						?>

					<br>
					<h2 id="popularity">Najpopularniejsze gry:</h2>
					<br>
					<?php
					$popularity_query = "SELECT name, play_count
											FROM games
											ORDER BY play_count DESC limit 3;";
					$popularity_result = mysql_query($popularity_query);
					echo '<ul class="list-group">';
					while($row = mysql_fetch_assoc($popularity_result)) {
						echo '
							<li class="list-group-item '.$listcolor.' d-flex justify-content-between align-items-center">
							    '.$row['name'].'
							    <span class="badge '.$badgecolor.' badge-pill">'.$row['play_count'].' odsłon</span>
						  	</li>';
					}
					echo '</ul>';

					?>
				</div>
			</div>
    	</div>

		<?php include './footer.html'; ?>

    	<?php mysql_close(); ?>
	</body>
</html>
