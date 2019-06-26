<?php
session_start();
require('./dbconnect.php');

date_default_timezone_set('Asia/Tokyo');
$date = date('Y-m-d H:i:s');

if (isset($_SESSION['id']) && $_SESSION['time'] + 3600 > time()) {
    $_SESSION['time'] = time();

    $members = $db->prepare('SELECT * FROM wonder_members WHERE id=?');
    $members->execute(array(
        $_SESSION['id']
    ));
    $member = $members->fetch();
}

if (!empty($_POST)) {
  $questions = $db->prepare('INSERT INTO wonder_questions (title, message, member_id, created) VALUES(?,?,?,?)');
    $questions->execute(array(
        $_POST['title'],
        $_POST['message'],
        $member['id'],
        $date
    ));
    header('Location:answer.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Pacifico&display=swap" rel="stylesheet">
    <title>Document</title>
</head>
<body>
    <header>
      <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <h1 class="navbar-brand">wonder</h1>
        <button
          class="navbar-toggler"
          type="button"
          data-toggle="collapse"
          data-target="#navbarNav"
          aria-controls="navbarNav"
          aria-expanded="false"
          aria-label="Toggle navigation"
        >
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav">
            <li class="nav-item active">
              <a class="nav-link" href="./index.php"
                >Home <span class="sr-only">(current)</span></a
              >
            </li>
            <li class="nav-item">
              <a class="nav-link" href="./build.php">Team Up</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="./friends.php">Participants</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="./lesson/php_lesson1.html">PHP</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="./lesson/sql_lesson1.html">SQL</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="./lesson/advanced_lesson1.html">Advanced PHP</a>
            </li><li class="nav-item">
              <a class="nav-link" href="./wonder.html">How To Make App?</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="./lesson/wonder_lesson1.html">How To Make wonder?</a>
            </li>
          </ul>
        </div>
      </nav>
    </header>
    <div class="container">
      <h1 class="text-center mt-3" style="font-family: 'Pacifico', cursive;">Please Ask now</h1>
      <p class="text-center font-weight-bold">わからないことはみんなで解決しよう！！</p>
      <!-- フォーム -->
      <div class="text-center">
        <form action="" method="post">
          <div class="form-group row mr-1">
            <label for="colFormLabelLg" class="col-sm-2 col-form-label col-form-label-lg font-weight-bold">Title</label>
            <div class="col-sm-10">
            <input class="form-control form-control-lg ml-2" id="colFormLabelLg" placeholder="<img>タグで画像を指定しているのに、動かない" name="title" value="<?php print(htmlspecialchars($_POST['title'],ENT_QUOTES));?>" type="text" required>
            </div>
          </div><br>

          <div class="form-group row mr-1">
            <label for="colFormLabelLg" class="col-sm-2 col-form-label col-form-label-lg font-weight-bold">Message</label>
            <div class="col-sm-10">
            <textarea class="form-control form-control-lg ml-2" id="colFormLabelLg" placeholder="<img>タグの使い方がわかりません。<img href= ./aaa.jpg> のように指定しているのですが・・・・" name="message" type="text" required><?php print(htmlspecialchars($_POST['message'],ENT_QUOTES));?></textarea>
            </div>
          </div><br>
          
          <input class="btn btn-success btn-lg mb-4" type="submit" value="Register" id="btn_submit">  
        </form>
      </div>
    </div>
</body>
</html>