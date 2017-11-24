<?php
	require_once "session.php";
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Snake - Gierki</title>

		<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
		<link rel="stylesheet" href="./style.css">
	</head>

	<body>

		<?php include "navbar.html"; ?>

		<div class="container-fluid col-md-8 main">
      <h1>Snake</h1>
      <?php
      if(isset($_SESSION['loggedin'])) {
				if ($_SESSION['loggedin'])
				{
					echo '<h2>Możesz grać!</h2>';
				}
			}

			if (!isset($_SESSION['loggedin'])){
					echo '<a href="index.php">Zaloguj się by grać</a>
					</br><a href="./register.php">Nie masz konta? Zarejestruj się!</a>
					';
			}
			?>

      <br>
      <h3>Komentarze</h3><br>
      <?php

      $comments_query = "SELECT A.timestamp, A.text, B.login as username
                          FROM comments A
                          Join users B
                          on B.id = A.user_id
                          WHERE A.game_id = 1
                          ORDER BY A.timestamp DESC";
      $com_result = mysql_query($comments_query);
      while($row = mysql_fetch_assoc($com_result)) {
        echo $row['username'].'<br>'.$row['timestamp'].'<br>'.$row['text'].'<br><br>';
      }

      ?>


    </div>

    <?php mysql_close(); ?>
  </body>
</html>
