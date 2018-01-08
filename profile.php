<?php
	require_once "session.php";
	if(isset($_GET['id'])) {
		if($_GET['id']) {
			$profile_id = $_GET['id'];
		}
		else {
			$profile_id = $user_id['id'];
		}
	}
	else {
		$profile_id = $user_id['id'];
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Profil - Gierki</title>

		<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
		<link rel="stylesheet" href="./style.css">
		<script src="./js/snake.js" type="text/javascript"></script>
	</head>

	<body>

		<?php include "navbar.php"; ?>

		<div class="container-fluid col-md-8 main">
    		<?php

			$username_query = "SELECT login FROM users WHERE id = ".$profile_id." limit 1;";
			$username_result = mysql_query($username_query);
			$username = mysql_fetch_assoc($username_result);
			echo '<h1>Profil użytkownika '.$username['login'].'</h1><br>';

    		if (isset($_SESSION['loggedin'])) {
    			if ($_SESSION['loggedin']) {
					if($profile_id != $user_id['id']) {
						if(isset($_POST['delete_friend'])) {
							$delete_friend_query1 = "DELETE FROM `friends`
													WHERE `user1_id` = ".$user_id['id']." AND `user2_id` = ".$profile_id." limit 1;";
							$delete_friend_result1 = mysql_query($delete_friend_query1);
							$delete_friend_query2 = "DELETE FROM `friends`
													WHERE `user2_id` = ".$user_id['id']." AND `user1_id` = ".$profile_id." limit 1;";
							$delete_friend_result2 = mysql_query($delete_friend_query2);
						}

						if(isset($_POST['add_friend'])) {
							$add_friend_query1 = "INSERT INTO `friends` (`user1_id`, `user2_id`)
													VALUES (".$user_id['id'].", ".$profile_id.");";
							$add_friend_result1 = mysql_query($add_friend_query1);
							$add_friend_query2 = "INSERT INTO `friends` (`user1_id`, `user2_id`)
													VALUES (".$profile_id.", ".$user_id['id'].");";
							$add_friend_result2 = mysql_query($add_friend_query2);
						}

						$friends_select_query = "SELECT * FROM `friends` WHERE `user1_id` = ".$user_id['id']." AND `user2_id` = ".$profile_id." limit 1;";
						$friends_select_result = mysql_query($friends_select_query);
						if($row = mysql_fetch_assoc($friends_select_result)) {
							echo '
								<form action="profile.php?id='.$profile_id.'" method="post">
									<button class="btn btn-primary" type="submit" name="delete_friend">Usuń ze znajomych</button>
								</form>';
						}
						else {
							echo '
								<form action="profile.php?id='.$profile_id.'" method="post">
									<button class="btn btn-primary" type="submit" name="add_friend">Dodaj do znajomych</button>
								</form>';
						}
					}
				}
			}

			?>

			<br>
            <h3>Ulubione gry</h3>
            <?php
            $fav_select_query = "SELECT A.game_id, B.name as game
                                        FROM favorites A
                                        JOIN games B
                                        ON B.id = A.game_id
                                        WHERE A.user_id = ".$profile_id."
                                        ORDER BY B.id ASC";
            $fav_select_result = mysql_query($fav_select_query);
            while($row = mysql_fetch_assoc($fav_select_result)) {
                echo $row['game'].'<br>';
            }
            ?><br>
            <h3>Najlepsze wyniki</h3>
            <?php
            $scores_select_query = "SELECT A.score, B.name as game
                                        FROM scores A
                                        JOIN games B
                                        ON B.id = A.game_id
                                        WHERE A.user_id = ".$profile_id."
                                        ORDER BY B.id ASC";
            $scores_select_result = mysql_query($scores_select_query);
            while($row = mysql_fetch_assoc($scores_select_result)) {
                echo $row['game'].' -- '.$row['score'].'<br>';
            }
            ?>
            <br>
			<?php
			if (isset($_SESSION['loggedin'])) {
    			if ($_SESSION['loggedin']) {
					if($profile_id == $user_id['id']) {

						$friends_list_query = "SELECT A.user2_id as fid, B.login as name
												FROM friends A
												JOIN users B
												ON B.id = A.user2_id
												WHERE user1_id = ".$user_id['id'].";";
						$friends_list_result = mysql_query($friends_list_query);
						$friendscounter = 0;

						echo '
						<h3 id="friends">Znajomi</h3>
						<ul>';
						while($row = mysql_fetch_assoc($friends_list_result)) {
							$friendscounter++;
							echo '<li><a href="profile.php?id='.$row['fid'].'">'.$row['name'].'</a></li>';
						}
						echo '</ul>';
						if($friendscounter == 0) {
							echo 'Nie masz jeszcze żadnych znajomych! Znajdź ich na <a href="./userslist.php">liście użytkowników</a>!';
						}
					}
					?>
					<br>
                    <?php
                }
            }
            ?>

        </div>

        <?php include './footer.html'; ?>

        <?php mysql_close(); ?>
    </body>
</html>
