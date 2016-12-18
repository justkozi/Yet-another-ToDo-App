<?php
session_start();
$name;

if (isset($_SESSION['Id'])){
    require_once 'includes/user.php';
    $usr = new User();
    $usr->SetVariablesBySession();
    $name = $usr->getFirstName()." ".$usr->getLastName();

}else{
    header("Location: login.php");
}

?>
<!doctype html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Yet Another ToDo App</title>
    <link rel="stylesheet" href="css/dist/font-awesome.min.css">
    <link rel="stylesheet" href="css/dist/normalize.css">
    <link rel="stylesheet" href="css/dist/main.min.css">

</head>
<body class="app">
<div class="wrapper">
    <nav class="hidden nav">
        <div class="title"><span>Yet Another ToDo App</span></div>
        <div class="menu-toggle ripple"><i class="fa fa-bars" aria-hidden="true"></i></div>
        <ul>
            <li><a style="cursor: pointer" id="refresh"><i class="fa fa-refresh" aria-hidden="true"></i>Synchronizuj</a></li>
            <li><a href='logout.php'><i class="fa fa-sign-out" aria-hidden="true"></i>Wyloguj się</a></li>
        </ul>
    </nav>
    <section>
        <article>
            <div class="intro">
                <div class="greeting">Witaj <?php echo $name?></div>
                <p>Twoje notatki:</p>
            </div>
            <div id="todos">

                <div class="todo-wrapper">

                </div>
                <div class="add-todo cat_1">
                    <input type="text" placeholder="Dodaj nową grupę notatek...">
                    <label for="category">Kolor: </label>
                    <select name="category" id="category">
                        <option value="cat_1" selected="selected" >Niebieski</option>
                        <option value="cat_2">Pomarańczowy</option>
                        <option value="cat_3">Złoty</option>
                        <option value="cat_4">Fioletowy</option>
                        <option value="cat_5">Zielony</option>
                    </select>
                    <i class="fa fa-plus" aria-hidden="true"></i>
                </div>
            </div>
        </article>
    </section>
    <footer>Wykonanie: <a href="mailto:lukasz.kozak.97@gmail.com">Łukasz Kozak</a>, na projekt zaliczeniowy PAI, grudzień 2016</footer>
</div>
<script src="js/dist/jquery.min.js"></script>
<script src="js/dist/jquery.materialripple.js"></script>
<script src="js/dist/typed.js"></script>
<script src="js/dist/script.min.js"></script>
<script src="js/dist/app.min.js"></script>
</body>
</html>