<?php
	require_once "session.php";
	$profile_id = $_GET['id'];
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
            <h1>Profil</h1>

    		<?php
    		if (isset($_SESSION['loggedin'])) {
    			if ($_SESSION['loggedin']) {
                    echo $_SESSION['login'];

                    ?><br><br>
                    <h3>Ulubione gry</h3>
                    <?php
                    $fav_select_query = "SELECT A.game_id, B.name as game
                                                FROM favorites A
                                                JOIN games B
                                                ON B.id = A.game_id
                                                WHERE A.user_id = ".$user_id['id']."
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
                                                WHERE A.user_id = ".$user_id['id']."
                                                ORDER BY B.id ASC";
                    $scores_select_result = mysql_query($scores_select_query);
                    while($row = mysql_fetch_assoc($scores_select_result)) {
                        echo $row['game'].' -- '.$row['score'].'<br>';
                    }
                    ?>
                    <br>
                    <h3>Znajomi</h3><br>
                    <?php
                }
            }
            ?>

        </div>

        <?php include './footer.html'; ?>

        <?php mysql_close(); ?>
    </body>
</html>
