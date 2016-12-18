<?php
session_start();

$fullName = "";
if (isset($_SESSION['Id'])){
    require_once 'includes/user.php';

    $usr = new User();
    $usr->SetVariablesBySession();
    $fullName = $usr->getFirstName()." ".$usr->getLastName();
}
?>
<!doctype html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Yet another ToDo App</title>
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <link rel="icon" href="/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="css/dist/font-awesome.min.css">
    <link rel="stylesheet" href="css/dist/normalize.css">
    <link rel="stylesheet" href="css/dist/main.min.css">

</head>
<body>
<div class="wrapper">
    <nav class="hidden nav">
        <div class="title"><span>Yet another ToDo App</span></div>
        <div class="menu-toggle ripple"><i class="fa fa-bars" aria-hidden="true"></i></div>
        <ul>
            <?php
            if (!empty($fullName)){
                echo "<li><a href=\"app.php\"><i class=\"fa fa-sticky-note-o\" aria-hidden=\"true\"></i>Zarządzaj notatkami</a></li>";
                echo "<li><a href='logout.php'><i class=\"fa fa-sign-out\" aria-hidden=\"true\"></i>Wyloguj się!</a></li>";

            } else{
                echo "<li><a href=\"login.php\"><i class=\"fa fa-sign-in\" aria-hidden=\"true\"></i>Logowanie</a></li>";
            }
            ?>
        </ul>
    </nav>
    <header>
        <div class="invite">
            <span class="invite-text"></span>
        </div>
    </header>
    <footer>Wykonanie: <a href="mailto:lukasz.kozak.97@gmail.com">Łukasz Kozak</a>, na projekt zaliczeniowy PAI, Grudzień 2016</footer>
</div>

<script src="js/dist/jquery.min.js"></script>
<script src="js/dist/jquery.materialripple.js"></script>
<script src="js/dist/typed.js"></script>
<script src="js/dist/script.min.js"></script>
</body>
</html>
