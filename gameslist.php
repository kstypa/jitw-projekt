<?php
	require_once "session.php";
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
		<link rel="stylesheet" href="./css/style.css">
	</head>

	<body>

		<?php include "navbar.php"; ?>

		<div class="container-fluid col-md-8 main">

			<?php

			function average($id) {
				$avg_result = mysql_query("SELECT AVG(`rating`) as `avg` FROM `ratings` WHERE `game_id` = ".$id.";");
				if($row = mysql_fetch_assoc($avg_result)) {
					return round($row['avg'], 1);
				}
				else return "0";
			}

			?>

			<h1>Lista gier</h1>
			<ul>
				<li><a href="snake.php">Snake</a> ocena użytkowników: <?php echo average(1); ?></li>
				<li><a href="">Wisielec</a> ocena użytkowników: <?php echo average(2); ?></li>
				<li><a href="">Space Invaders</a> ocena użytkowników: <?php echo average(3); ?></li>
				<li><a href="">Arkanoid</a> ocena użytkowników: <?php echo average(4); ?></li>
				<li><a href="game.php?id=5">Tetris</a> ocena użytkowników: <?php echo average(5); ?></li>
			</ul>


			<h2 id="popularity">Najpopularniejsze gry:</h2>
			<?php
			$popularity_query = "SELECT name, play_count
									FROM games
									ORDER BY play_count DESC limit 3;";
			$popularity_result = mysql_query($popularity_query);
			echo '<ol type="1">';
			while($row = mysql_fetch_assoc($popularity_result)) {
				echo '<li>'.$row['name'].' -- grana '.$row['play_count'].' razy</li>';
			}
			echo '</ol>'

			?>

    	</div>

		<?php include './footer.html'; ?>

    	<?php mysql_close(); ?>
	</body>
</html>
