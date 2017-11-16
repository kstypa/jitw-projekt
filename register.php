<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Rejestracja - Gierki</title>

    <style>
      body {
        font-size:14px;
        font-family:Tahoma;
        line-height:1.6;
      }
    </style>
  </head>

  <body>
    <h1>Gierki</h1>

    <form action="register.php" method="POST">
      <h2>Rejestracja</h2>
      <p>Dołącz do naszej społeczności już dziś i graj we wspaniałe gry!</p>
      <b>Login:</b> <input type="text" name="login"><br>
      <b>Hasło:</b> <input type="password" name="haslo1"><br>
      <b>Powtórz hasło:</b> <input type="password" name="haslo2"><br>
      <b>Email:</b> <input type="text" name="email"><br><br>
      <input type="submit" value="Zarejestruj" name="loguj">
    </form>

    <?php
    mysql_connect("localhost","root","");
    mysql_select_db("testlog");

    function filtruj($zmienna)
    {
        if(get_magic_quotes_gpc())
            $zmienna = stripslashes($zmienna);
        return mysql_real_escape_string(htmlspecialchars(trim($zmienna)));
    }

    if (isset($_POST['loguj']))
    {
    	$login = filtruj($_POST['login']);
    	$haslo1 = filtruj($_POST['haslo1']);
    	$haslo2 = filtruj($_POST['haslo2']);
    	$email = filtruj($_POST['email']);
    	$ip = filtruj($_SERVER['REMOTE_ADDR']);

    	if (mysql_num_rows(mysql_query("SELECT login FROM uzytkownicy WHERE login = '".$login."';")) == 0)
    	{
    		if ($haslo1 == $haslo2)
    		{
    			mysql_query("INSERT INTO `uzytkownicy` (`login`, `haslo`, `email`, `rejestracja`, `logowanie`, `ip`)
    				VALUES ('".$login."', '".md5($haslo1)."', '".$email."', '".time()."', '".time()."', '".$ip."');");

    			echo "Konto zostało utworzone!";
    		}
    		else echo "Hasła muszą być takie same!";
    	}
    	else echo "Podany login jest już zajęty.";
    }
    ?>

    <?php mysql_close(); ?>
  </body>
</html>
