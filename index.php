<?php
session_start();

//require $_SERVER['DOCUMENT_ROOT']."/core/Model.php";
//echo '<pre>'; print_r($_SESSION); echo '</pre>';
// Проверка авторизации и сохранение хеша юзера в сессию
if (isset($_POST['login']))
{
    $cfg = $_SERVER['DOCUMENT_ROOT']."/core/users.json";
    $users = json_decode(file_get_contents($cfg), true);

    foreach ($users as $oneUser){
        if ($oneUser['login'] == $_POST['login'] && $_POST['pass'] == $oneUser['password']){
            $user_hash = $oneUser['hash'];
            break;
        }
    }
    if (isset($user_hash) && !isset($_SESSION['user_hash'])){
        $_SESSION['user_hash'] = $user_hash;
        header("Location: http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
    }
    else{
        header("Location: http://".$_SERVER['HTTP_HOST']."?auth_error=y");
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Авторизация</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
    </style>
    <!-- Custom styles for this template -->
    <link href="/resources/signin.css" rel="stylesheet">
</head>
<body class="text-center">
<?php
if (!isset($_SESSION['user_hash'])) {
    ?>
    <form class="form-signin" method="POST">
        <img class="mb-4" src="/resources/bootstrap-solid.svg" alt="" width="72" height="72">
        <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>
        <?if ($_GET['auth_error'] == 'y'):?>
            <div class="alert alert-warning" role="alert">
                Логин или пароль не совпадают
            </div>
        <?endif;?>
        <label for="inputEmail" class="sr-only">Email address</label>
        <input name="login" type="text" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>
        <label for="inputPassword" class="sr-only">Password</label>
        <input name="pass" type="password" id="inputPassword" class="form-control" placeholder="Password" required>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
        <p class="mt-5 mb-3 text-muted">&copy; 2017-2019</p>
    </form>
    <?
    exit;
}
else{?>
    <form id="prize-form" class="form-signin" method="POST">
        <div id="formtext"></div>
        <input type="hidden" name="getprize" value="gp">
        <button id="prizebtn" class="btn btn-lg btn-primary btn-block" type="submit">Get a prize</button>
    </form>
<?}?>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
<script src="/resources/script.js"></script>
</body>
</html>