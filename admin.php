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
		<title>Panel administracyjny - Gierki</title>

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
								<a class="list-group-item list-group-item-action '.$listcolor.'" href="./profile.php?id='.$uid.'">Profil</a>
								<a class="list-group-item list-group-item-action '.$listcolor.'" href="./profile.php?id='.$uid.'#friends">Znajomi</a>
								<a class="list-group-item list-group-item-action '.$listcolor.'" href="./userslist.php">Lista użytkowników</a>';

							if($_SESSION['group_id'] == 1) {
								echo '<a class="list-group-item list-group-item-action '.$listcolor.' active" href="./admin.php">Panel administracyjny</a>';
							}

							echo '<a class="list-group-item list-group-item-action '.$listcolor.'" href="./?logout=1">Wyloguj się</a>
							</div></div>';
						}
					}
					?>
				<div class="col-md-9">
					<h1>Panel administracyjny</h1>

					<h2>Zarządzaj komentarzami:</h2>
					<div class="list-group">
						<a class="list-group-item list-group-item-action <?php echo $listcolor ?>" href="admin.php?game_id=1">Snake</a>
						<a class="list-group-item list-group-item-action <?php echo $listcolor ?>" href="admin.php?game_id=2">Outrun</a>
						<a class="list-group-item list-group-item-action <?php echo $listcolor ?>" href="admin.php?game_id=3">Delta</a>
						<a class="list-group-item list-group-item-action <?php echo $listcolor ?>" href="admin.php?game_id=4">Arkanoid</a>
						<a class="list-group-item list-group-item-action <?php echo $listcolor ?>" href="admin.php?game_id=5">Tetris</a>
					</div><br>

					<?php
					if(isset($_SESSION['loggedin'])) {
						if($_SESSION['loggedin']) {
							if(isset($_GET['game_id'])) {
								if(isset($_POST['comment_id'])) {
									// echo $_POST['comment_id'];
									$delete_comment_query = "DELETE FROM `comments` WHERE id=".$_POST['comment_id']." limit 1;";
									$delete_comment_result = mysql_query($delete_comment_query);
									if($delete_comment_result) {
										echo "Usunięto komentarz o id = ".$_POST['comment_id']."<br><br>";
									}
								}

								echo '
								<button class="btn '.$btncolor.'" type="button" data-toggle="collapse" data-target="#commentForm" aria-expanded="false" aria-controls="collapseExample">
								Dodaj komentarz
								</button><br><br>
								<div class="collapse" id="commentForm">
								<form class="col-md-12" action="admin.php?game_id='.$_GET['game_id'].'" method="post">
								<div class="form-group">
								<textarea class="form-control" name="comment_text" rows="5" cols="80" placeholder="Treść komentarza"></textarea>
								</div>
								<button type="submit" class="btn '.$btncolor.'" name="send_comment">Wyślij</button>
								</form><br>
								</div>';
								if(isset($_POST['send_comment'])) {
									$add_comment_query = "INSERT INTO `comments` (`game_id`, `user_id`, `text`)
									VALUES (".$_GET['game_id'].", ".$uid.", '".$_POST['comment_text']."');";
									$add_com_result = mysql_query($add_comment_query);
								}

								$comments_query = "SELECT A.id, A.timestamp, A.text, B.login as username
								FROM comments A
								Join users B
								on B.id = A.user_id
								WHERE A.game_id = ".$_GET['game_id']."
								ORDER BY A.timestamp DESC";
								$com_result = mysql_query($comments_query);
								while($row = mysql_fetch_assoc($com_result)) {
									echo '<div class="card '.$cardcolor.' m-2" style="">
										  	<div class="card-body">
												<h5 class="card-title">'.$row['username'].'</h5>
												<h6 class="card-subtitle mb-1 text-muted">'.$row['timestamp'].'</h6>
											  	<p class="card-text">'.$row['text'].'</p>
										  	</div>
											<div class="card-footer">
												<form action="admin.php?game_id='.$_GET['game_id'].'" method="post">
													<button type="submit" name="comment_id" value="'.$row['id'].'" class="btn btn-danger">Usuń</button>
												</form>
											</div>
										</div>';
								}
							}
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
