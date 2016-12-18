<?php
session_start();

$feedback="";
if(isset($_POST['login-btn'])){
    require_once 'includes/user.php';
    $usr = new User();
    $login = $_POST['login'];
    $password = $_POST['password'];
    if($usr->AuthenticateUser($login,$password)){
        header("Location: index.php?log-success");
    }else{
        $feedback = "Niepoprawne dane logowania!";
    }
}
require_once 'includes/user.php';
if(isset($_POST['register-btn'],$_POST['first-name'],$_POST['login'],$_POST['last-name'],$_POST['pass'])){
    $usr = new User();
    $usr->setFirstName( $_POST['first-name']);
    $usr->setLastName(  $_POST['last-name']);
    $usr->setLogin(     $_POST['login']);
    $usr->setPassword(  $_POST['pass']);
    $response = $usr->InsertUser();
    if($response['status'] == 'success'){
        $feedback = $response['messege'];
        $usr->SetSessionVariables();
        header("Location: index.php?add-success");
    }else{
        $feedback = $response['messege'];
    }
}

if(isset($_SESSION['Id'])){
    header("Location: app.php");
}
?>
<!doctype html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Logowanie - Yet another ToDo App</title>
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
            <li><a href='/'><i class="fa fa-home" aria-hidden="true"></i>Strona Główna</a></li>
        </ul>
    </nav>
    <section>

        <form action="login.php" method="post" id="login-form">
            <?php
            if(!empty($feedback)){
                echo "<div class=\"feedback\">".$feedback."</div>";
                $feedback="";
            }?>
            <div class="group">
                <input type="text" name="login" required="required"><span class="highlight"></span><span class="bar"></span>
                <label>Login</label>
            </div>
            <div class="group">
                <input type="password" name="password" required="required"><span class="highlight"></span><span class="bar"></span>
                <label>Hasło</label>
            </div>
            <button type="submit" name="login-btn" value="login-btn" form="login-form" class="btn ripple">Zaloguj się!</button>
            <button type="button" class="btn login-toggle ripple register-toggle" >Rejestracja</button>
            <a href="#" class="reset-pass">Nie pamiętam hasła</a>
        </form>


        <form action="login.php" method="post" id="register-form" class="hidden">
            <div class="group">
                <input type="text" name="first-name" required="required"><span class="highlight"></span><span class="bar"></span>
                <label>Imię</label>
            </div>
            <div class="group">
                <input type="text" name="last-name" required="required"><span class="highlight"></span><span class="bar"></span>
                <label>Nazwisko</label>
            </div>
            <div class="group">
                <input type="text" name="login" required="required"><span class="highlight"></span><span class="bar"></span>
                <label>Login</label>
            </div>
            <div class="group">
                <input type="password" name="pass" required="required"><span class="highlight"></span><span class="bar"></span>
                <label>Hasło</label>
            </div>
            <button type="submit" name="register-btn" value="register-btn" form="register-form" class="btn ripple">Zarejestruj się!</button>
            <button type="button" class="btn login-toggle ripple register-toggle" >Logowanie</button>
        </form>

    </section>
    <footer>Wykonanie: <a href="mailto:lukasz.kozak.97@gmail.com">Łukasz Kozak</a>, na projekt zaliczeniowy PAI, Grudzień 2016</footer>
</div>
<script src="js/dist/jquery.min.js"></script>
<script src="js/dist/jquery.materialripple.js"></script>
<script src="js/dist/typed.js"></script>
<script src="js/dist/script.min.js"></script>
</body>
</html>



