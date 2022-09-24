<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">   
    <title>404 Not Found</title>
</head>

<style>
body {
    background-image: url("/engine/images/404.png");
    height: 80vh;
    background-position-x: right;
    background-position-y: bottom;
    background-repeat: no-repeat;
}

section {
    text-align: center;
    width: 400px;
    margin: auto;
    top: 10%;
    position: relative;
}
</style>

<body>
    <section>
        <h2>404 Not Found</h2>
        <p>The requested URL <?=$_SERVER['REDIRECT_URL']?> was not found on this server.</p>
        <p><?=$_SERVER["SERVER_SIGNATURE"]?></p>
        <a href="/">На главную</a>
    </section>
</body>
</html>