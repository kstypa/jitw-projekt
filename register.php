<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Rejestracja - Gierki</title>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./style.css">
  </head>

  <body>
    <?php include "navbar.php"; ?>

    <div class="container-fluid col-md-8 main">

      <form class="col-md-4" action="register.php" method="POST">
        <h2>Rejestracja</h2><br>
        <div class="form-group">
          <label for="login">Nazwa użytkownika</label>
          <input type="text" class="form-control" name="login" placeholder="Podaj swój login">
        </div>
        <div class="form-group">
          <label for="password1">Hasło</label>
          <input type="password" class="form-control" name="password1" placeholder="Hasło">
        </div>
        <div class="form-group">
          <label for="password2">Potwierdź hasło</label>
          <input type="password" class="form-control" name="password2" placeholder="Potwierdź hasło">
        </div>
        <div class="form-group">
          <label for="email">Adres e-mail</label>
          <input type="email" class="form-control" name="email" placeholder="Podaj swój adres e-mail">
        </div>
        <button type="submit" class="btn btn-primary" name="signup">Zarejestruj się</button>
      </form>

      <?php
      mysql_connect("localhost","root","");
      mysql_select_db("testlog");

      function filter($var)
      {
          if(get_magic_quotes_gpc())
              $var = stripslashes($var);
          return mysql_real_escape_string(htmlspecialchars(trim($var)));
      }

      if (isset($_POST['signup']))
      {
      	$login = filter($_POST['login']);
      	$password1 = filter($_POST['password1']);
      	$password2 = filter($_POST['password2']);
      	$email = filter($_POST['email']);
      	$ip = filter($_SERVER['REMOTE_ADDR']);

      	if (mysql_num_rows(mysql_query("SELECT login FROM users WHERE login = '".$login."';")) == 0)
      	{
      		if ($password1 == $password2)
      		{
      			mysql_query("INSERT INTO `users` (`login`, `password`, `email`, `registered`, `last_login`, `ip`)
      				VALUES ('".$login."', '".md5($password1)."', '".$email."', '".time()."', '".time()."', '".$ip."');");

      			echo "Konto zostało utworzone!";
      		}
      		else echo "Hasła muszą być takie same!";
      	}
      	else echo "Podany login jest już zajęty.";
      }
      ?>

      <br><a href="index.php">Wróć do strony głównej</a>

    </div>

    <?php include './footer.html'; ?>

    <?php mysql_close(); ?>
  </body>
</html>
