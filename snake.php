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
		<script src="./js/snake.js" type="text/javascript"></script>
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
					echo '
						<div class="snake-canvas">
							<canvas id="stage" height="400" width="520"></canvas>
						</div>';
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
					$user_result = mysql_query("SELECT `id` from `users` WHERE `login` = '".$_SESSION['login']."' limit 1");
					$user_id = mysql_fetch_assoc($user_result);

					echo '<h3>Oceń grę</h3>
								<form action="snake.php" method="post">
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
						// echo $_POST['rating'];

						$rating_select_query = "SELECT * FROM `ratings` WHERE `game_id` = 1 AND `user_id` = ".$user_id['id']." limit 1;";
						$rating_select_result = mysql_query($rating_select_query);
						if($row = mysql_fetch_assoc($rating_select_result)) {
			        // echo '<br>rating: '.$row['game_id'].' '.$row['user_id'].' '.$row['rating'].', update';
							$rating_update_query = "UPDATE `ratings`
																			SET `rating` = ".$_POST['rating']."
																			WHERE `game_id` = 1 AND `user_id` = ".$user_id['id'].";";
							$rating_update_result = mysql_query($rating_update_query);
			      }
						else {
							// echo '<br>nie znaleziono ratingu, insert';
							$rating_insert_query = "INSERT INTO `ratings` (`game_id`, `user_id`, `rating`)
																			VALUES (1, ".$user_id['id'].", '".$_POST['rating']."');";
							$rating_insert_result = mysql_query($rating_insert_query);
						}
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
					<form class="col-md-12" action="snake.php" method="post">
							<div class="form-group">
								<textarea class="form-control" name="comment_text" rows="5" cols="80" placeholder="Treść komentarza"></textarea>
							</div>
							<button type="submit" class="btn btn-primary" name="send_comment">Wyślij</button>
					</form><br>
					</div>';
					if(isset($_POST['send_comment'])) {
						// echo $_POST['comment_text'].'<br>';
						// echo $_SESSION['login'].'<br>';
						// $user_result = mysql_query("SELECT `id` from `users` WHERE `login` = '".$_SESSION['login']."' limit 1");
						// $user_id = mysql_fetch_assoc($user_result);
						// echo $user_id['id'];
						$add_comment_query = "INSERT INTO `comments` (`game_id`, `user_id`, `text`)
																		VALUES (1, ".$user_id['id'].", '".$_POST['comment_text']."');";
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
