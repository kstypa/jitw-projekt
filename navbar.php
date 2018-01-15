<?php
if(isset($_SESSION['loggedin'])) {
    if ($_SESSION['loggedin']) {
        $user_result = mysql_query("SELECT `id` from `users` WHERE `login` = '".$_SESSION['login']."' limit 1");
        $user_id = mysql_fetch_assoc($user_result);
        $uid = $user_id['id'];
    }
}
?>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="./">Gierki</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav">
            <li class="nav-item active">
                <a class="nav-link" href="./">Strona główna <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="./gameslist.php">Lista gier</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="./highscores.php">Najlepsi gracze</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="./userslist.php">Lista użytkowników</a>
            </li>

            <?php
            if(isset($_SESSION['loggedin'])) {
                if ($_SESSION['loggedin']) {
                    echo '
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            '.$login.'
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="./profile.php?id='.$uid.'">Zobacz profil</a>
                            <a class="dropdown-item" href="./profile.php?id='.$uid.'#friends">Znajomi</a>
                            <a class="dropdown-item" href="./index.php?logout=1">Wyloguj się</a>
                        </div>
                    </li>';
                }
            }
            ?>
        </ul>
    </div>
</nav>
