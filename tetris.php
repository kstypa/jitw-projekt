<?php
	require_once "session.php";
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Tetris - Gierki</title>

		<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
		<link rel="stylesheet" href="./css/style.css">
	</head>

	<body>

		<?php include "navbar.php";

		mysql_query("UPDATE games SET play_count = play_count + 1 WHERE id = 5;")

		?>

		<div class="container-fluid col-md-8 main">
      <h1>Tetris</h1>
      <?php
      if(isset($_SESSION['loggedin'])) {
				if ($_SESSION['loggedin'])
				{
					echo '<h2>Możesz grać!</h2>';
					echo '
                        <div class="embed-responsive embed-responsive-4by3">
                            <iframe class="embed-responsive-item gameframe" src="./tetris/index.html" ></iframe>
                        </div>
						';
				}
			}

			if (!isset($_SESSION['loggedin'])){
					echo '<a href="index.php">Zaloguj się by grać</a>
					</br><a href="./register.php">Nie masz konta? Zarejestruj się!</a>
					';
			}
			?>

			<?php
			if (isset($_SESSION['loggedin'])) {
				if ($_SESSION['loggedin']) {
					echo '<h3>Oceń grę</h3>
								<form action="tetris.php" method="post">
									<div class="btn-group" role="group">
											<button type="submit" name="rating" value=1 class="btn btn-primary">1</button>
											<button type="submit" name="rating" value=2 class="btn btn-primary">2</button>
											<button type="submit" name="rating" value=3 class="btn btn-primary">3</button>
											<button type="submit" name="rating" value=4 class="btn btn-primary">4</button>
											<button type="submit" name="rating" value=5 class="btn btn-primary">5</button>
									</div>
								</form>
								<br>';

					if (isset($_POST['rating'])) {
						$rating_select_query = "SELECT * FROM `ratings` WHERE `game_id` = 5 AND `user_id` = ".$uid." limit 1;";
						$rating_select_result = mysql_query($rating_select_query);

						if($row = mysql_fetch_assoc($rating_select_result)) {
							$rating_update_query = "UPDATE `ratings`
																			SET `rating` = ".$_POST['rating']."
																			WHERE `game_id` = 5 AND `user_id` = ".$uid.";";
							$rating_update_result = mysql_query($rating_update_query);
			        	}
						else {
							$rating_insert_query = "INSERT INTO `ratings` (`game_id`, `user_id`, `rating`)
																			VALUES (5, ".$uid.", '".$_POST['rating']."');";
							$rating_insert_result = mysql_query($rating_insert_query);
						}
					}

					$rating_select_query = "SELECT * FROM `ratings` WHERE `game_id` = 5 AND `user_id` = ".$uid." limit 1;";
					$rating_select_result = mysql_query($rating_select_query);
					if ($row = mysql_fetch_assoc($rating_select_result)) {
						echo 'Twoja obecna ocena: '.$row['rating'];
					}
					else {
						echo 'Nie oceniłeś jeszcze tej gry';
					}

					if(isset($_POST['delete_favorite'])) {
						$delete_favorite_query = "DELETE FROM `favorites`
												WHERE `game_id` = 5 AND `user_id` = ".$uid." limit 1;";
						$delete_favorite_result = mysql_query($delete_favorite_query);
					}

					if(isset($_POST['add_favorite'])) {
						$add_favorite_query = "INSERT INTO `favorites` (`user_id`, `game_id`)
												VALUES (".$uid.", 5);";
						$add_favorite_result = mysql_query($add_favorite_query);
					}

					$fav_select_query = "SELECT * FROM `favorites` WHERE `game_id` = 5 AND `user_id` = ".$uid." limit 1;";
					$fav_select_result = mysql_query($fav_select_query);
					if($row = mysql_fetch_assoc($fav_select_result)) {
						echo '
							<form action="tetris.php" method="post">
								<button class="btn btn-primary" type="submit" name="delete_favorite">Usuń z ulubionych</button>
							</form>';
					}
					else {
						echo '
							<form action="tetris.php" method="post">
								<button class="btn btn-primary" type="submit" name="add_favorite">Dodaj do ulubionych</button>
							</form>';
					}
				}
			}
			?>

      <br>


      <?php

			if(isset($_SESSION['loggedin'])) {
				if ($_SESSION['loggedin'])
				{
					echo '
					<h3>Komentarze<span class="badge">
						<button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#commentForm" aria-expanded="false" aria-controls="collapseExample">
							Dodaj komentarz
						</button>
					</span></h3>
					<div class="collapse" id="commentForm">
					<form class="col-md-12" action="tetris.php" method="post">
							<div class="form-group">
								<textarea class="form-control" name="comment_text" rows="5" cols="80" placeholder="Treść komentarza"></textarea>
							</div>
							<button type="submit" class="btn btn-primary" name="send_comment">Wyślij</button>
					</form><br>
					</div>';
					if(isset($_POST['send_comment'])) {
						$add_comment_query = "INSERT INTO `comments` (`game_id`, `user_id`, `text`)
																		VALUES (5, ".$uid.", '".$_POST['comment_text']."');";
						$add_com_result = mysql_query($add_comment_query);
					}
				}
			}

			if (!isset($_SESSION['loggedin'])){
					echo '<h3>Komentarze</h3>
					<a href="index.php">Zaloguj się by dodać komentarz</a>
					</br><a href="./register.php">Nie masz konta? Zarejestruj się!</a><br>';
			}

      $comments_query = "SELECT A.timestamp, A.text, B.login as username
                          FROM comments A
                          Join users B
                          on B.id = A.user_id
                          WHERE A.game_id = 5
                          ORDER BY A.timestamp DESC";
      $com_result = mysql_query($comments_query);
      while($row = mysql_fetch_assoc($com_result)) {
        echo $row['username'].'<br>'.$row['timestamp'].'<br>'.$row['text'].'<br><br>';
      }

      ?>


    </div>

	<?php include './footer.html'; ?>

    <?php mysql_close(); ?>
  </body>
</html>
