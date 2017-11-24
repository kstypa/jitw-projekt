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
		<link rel="stylesheet" href="./style.css">
	</head>

	<body>

		<?php include "navbar.html"; ?>

		<div class="container-fluid col-md-8 main">

			<?php
			$rating = [0, 0, 0, 0];
			for ($i = 0; $i < 4; ++$i) {
				$rating_query = "SELECT rating FROM ratings WHERE game_id = $i+1";
	      $rating_result = mysql_query($rating_query);
				$sum = 0;
				$n = 0;
	      while($row = mysql_fetch_assoc($rating_result)) {
	        ++$n;
					$sum += $row['rating'];
	      }
				$rating[$i] = $sum / $n;
			}

			?>

      <h1>Lista gier</h1>
      <ul>
        <li><a href="snake.php">Snake</a> ocena użytkowników: <?php echo $rating[0] ?></li>
        <li><a href="">Wisielec</a> ocena użytkowników: <?php echo $rating[1] ?></li>
        <li><a href="">Space Invaders</a> ocena użytkowników: <?php echo $rating[2] ?></li>
        <li><a href="">Arkanoid</a> ocena użytkowników: <?php echo $rating[3] ?></li>
      </ul>


    </div>

    <?php mysql_close(); ?>
  </body>
</html>
