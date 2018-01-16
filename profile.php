<?php
	require_once "session.php";

	if(!isset($_SESSION['loggedin']) and !isset($_GET['id'])) {
		redirect('./');
	}

	if(isset($_GET['id'])) {
		if($_GET['id']) {
			$profile_id = $_GET['id'];
		}
		else {
			$profile_id = $uid;
		}
	}
	else {
		$profile_id = $uid;
	}

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
		<title>Profil - Gierki</title>

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
								<a class="list-group-item list-group-item-action '.$listcolor.'" href="./gameslist.php">Lista gier</a>
								<a class="list-group-item list-group-item-action '.$listcolor.'" href="./highscores.php">Najlepsi gracze</a>
								<a class="list-group-item list-group-item-action '.$listcolor.'" href="./gameslist.php#popularity">Ranking popularności gier</a>
								<a class="list-group-item list-group-item-action '.$listcolor.' active" href="./profile.php?id='.$uid.'">Profil</a>
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
							<a class="list-group-item list-group-item-action" href="./gameslist.php">Lista gier</a>
							<a class="list-group-item list-group-item-action" href="./highscores.php">Najlepsi gracze</a>
							<a class="list-group-item list-group-item-action" href="./gameslist.php#popularity">Ranking popularności gier</a>
							<a class="list-group-item list-group-item-action active" href="./userslist.php">Lista użytkowników</a>
						</div>
					</div>';
					}
					?>
					<div class="col-md-9">

						<?php

						$username_query = "SELECT login FROM users WHERE id = ".$profile_id." limit 1;";
						$username_result = mysql_query($username_query);
						$username = mysql_fetch_assoc($username_result);
						echo '<h1>Profil użytkownika '.$username['login'].'</h1><br>';

						if (isset($_SESSION['loggedin'])) {
							if ($_SESSION['loggedin']) {
								if($profile_id != $uid) {
									if(isset($_POST['delete_friend'])) {
										$delete_friend_query1 = "DELETE FROM `friends`
										WHERE `user1_id` = ".$uid." AND `user2_id` = ".$profile_id." limit 1;";
										$delete_friend_result1 = mysql_query($delete_friend_query1);
										$delete_friend_query2 = "DELETE FROM `friends`
										WHERE `user2_id` = ".$uid." AND `user1_id` = ".$profile_id." limit 1;";
										$delete_friend_result2 = mysql_query($delete_friend_query2);
									}

									if(isset($_POST['add_friend'])) {
										$add_friend_query1 = "INSERT INTO `friends` (`user1_id`, `user2_id`)
										VALUES (".$uid.", ".$profile_id.");";
										$add_friend_result1 = mysql_query($add_friend_query1);
										$add_friend_query2 = "INSERT INTO `friends` (`user1_id`, `user2_id`)
										VALUES (".$profile_id.", ".$uid.");";
										$add_friend_result2 = mysql_query($add_friend_query2);
									}

									$friends_select_query = "SELECT * FROM `friends` WHERE `user1_id` = ".$uid." AND `user2_id` = ".$profile_id." limit 1;";
									$friends_select_result = mysql_query($friends_select_query);
									if($row = mysql_fetch_assoc($friends_select_result)) {
										echo '
										<form action="profile.php?id='.$profile_id.'" method="post">
										<button class="btn '.$btncolor.'" type="submit" name="delete_friend">Usuń ze znajomych</button>
										</form>';
									}
									else {
										echo '
										<form action="profile.php?id='.$profile_id.'" method="post">
										<button class="btn '.$btncolor.'" type="submit" name="add_friend">Dodaj do znajomych</button>
										</form>';
									}
								}
							}
						}

						?>

						<br>
						<h3>Ulubione gry</h3>
						<?php
						$fav_select_query = "SELECT A.game_id, B.thumbnail, B.description, B.name as game
	                                                FROM favorites A
	                                                JOIN games B
	                                                ON B.id = A.game_id
	                                                WHERE A.user_id = ".$profile_id."
	                                                ORDER BY B.id ASC";
	                    $fav_select_result = mysql_query($fav_select_query);
						$favcounter = 0;
						echo '<br><div class="row">';
	                    while($row = mysql_fetch_assoc($fav_select_result)) {
							echo '
							<div class="card '.$cardcolor.' mx-1" style="width:15rem">
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
							echo 'Nie ma żadnych ulubionych gier!';
						}
						?><br>
						<h3>Najlepsze wyniki</h3><br>
						<?php
						$scores_select_query = "SELECT A.score, B.name as game
						FROM scores A
						JOIN games B
						ON B.id = A.game_id
						WHERE A.user_id = ".$profile_id."
						ORDER BY B.id ASC";
						$scores_select_result = mysql_query($scores_select_query);
						echo '<ul class="list-group">';
						while($row = mysql_fetch_assoc($scores_select_result)) {
							echo '
								<li class="list-group-item '.$listcolor.' d-flex justify-content-between align-items-center">
								    '.$row['game'].'
								    <span class="badge '.$badgecolor.' badge-pill">wynik: '.$row['score'].'</span>
							  	</li>';
						}
						echo '</ul>';
						?>
						<br>
						<?php
						if (isset($_SESSION['loggedin'])) {
							if ($_SESSION['loggedin']) {
								if($profile_id == $uid) {

									$friends_list_query = "SELECT A.user2_id as fid, B.login as name
									FROM friends A
									JOIN users B
									ON B.id = A.user2_id
									WHERE user1_id = ".$uid.";";
									$friends_list_result = mysql_query($friends_list_query);
									$friendscounter = 0;

									echo '
									<h3 id="friends">Znajomi</h3><br>
									<div class="list-group">';
										while($row = mysql_fetch_assoc($friends_list_result)) {
											$friendscounter++;
											echo '<a class="list-group-item list-group-item-action '.$listcolor.'" href="profile.php?id='.$row['fid'].'">'.$row['name'].'</a>';
										}
										echo '</div>';
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
				</div>
        </div>

        <?php include './footer.html'; ?>

        <?php mysql_close(); ?>
    </body>
</html>
