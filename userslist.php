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

		<?php
        include "navbar.php";

        $searchphrase = "";
        if(isset($_GET['action'])) {
            if($_GET['action'] == "search") {
                if(isset($_GET['username'])) {
                    $searchphrase = $_GET['username'];
                }
            }
        }

        ?>

		<div class="container-fluid col-md-8 main">

			<h1>Lista użytkowników</h1><br>

            <form class="col-md-10 offset-md-1" action="userslist.php" method="GET">
                <label class="sr-only" for="username">Nazwa użytkownika</label>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" name="username" placeholder="Szukaj użytkowników">
                    <div class="input-group-btn">
                        <button type="submit" class="btn btn-primary" name="action" value="search">Szukaj</button>
                    </div>
                </div>
            </form>

            <?php

            $userslist_select_query = "SELECT * FROM users WHERE login LIKE '%".$searchphrase."%';";
            $userslist_select_result = mysql_query($userslist_select_query);

            echo '<ul>';
            while($row = mysql_fetch_assoc($userslist_select_result)) {
                echo '<li><a href="profile.php?id='.$row['id'].'">'.$row['login'].'</a></li>';
            }
            echo '</ul>';

            ?>

    	</div>

		<?php include './footer.html'; ?>

    	<?php mysql_close(); ?>
	</body>
</html>
