<?php
session_start();
require('./dbconnect.php');
if (isset($_SESSION['id']) && $_SESSION['time'] + 3600 > time()) {
    $_SESSION['time'] = time();

    $members = $db->prepare('SELECT * FROM wonder_members WHERE id=?');
    $members->execute(array(
        $_SESSION['id']
    ));
    $member = $members->fetch();
} else {
    header('Location: login.php');
    exit();
}

$id = uniqid(rand());

if (!empty($_POST)) {
    if($_POST['message']!==''){
        $message = $db->prepare('INSERT INTO wonder_posts VALUES(?,?,?,?)');
        $message->execute(array(
            $id,
            $member['id'],
            $_POST['title'],
            $_POST['content']
        ));
        
        $num = uniqid(rand());
        $teams = $db->prepare('INSERT INTO wonder_teams VALUES(?,?,?)');
          $teams->execute(array(
          $num,
          $member['id'],
          $id
          ));

        header('Location: index.php');
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Pacifico&display=swap" rel="stylesheet">
    <title>Team Build</title>
</head>
<body>
<!-- header -->
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

<h2 class="text-center mt-5" style="font-family: 'Pacifico', cursive;">Team Up</h2>
<p class="text-center mt-1 mb-2 font-weight-bold">What comes to your mind?</p>

<div class="container">
<!-- フォーム -->
    <div class="text-center">
      <form action="" method="post">
        <div class="form-group row mr-1">
          <label for="colFormLabelLg" class="col-sm-2 col-form-label col-form-label-lg font-weight-bold">Title</label>
          <div class="col-sm-10">
          <input class="form-control form-control-lg ml-2" id="colFormLabelLg" placeholder="" name="title" value="<?php print(htmlspecialchars($_POST['title'],ENT_QUOTES));?>" type="text" required>
          </div>
        </div><br>

        <div class="form-group row mr-1">
          <label for="colFormLabelLg" class="col-sm-2 col-form-label col-form-label-lg font-weight-bold">Expalin</label>
          <div class="col-sm-10">
          <textarea class="form-control form-control-lg ml-2" id="colFormLabelLg" placeholder="" name="content" type="text" required><?php print(htmlspecialchars($_POST['content'],ENT_QUOTES));?></textarea>
          </div>
        </div><br>
        
        <input class="btn btn-success btn-lg mb-4" type="submit" value="Register" id="btn_submit">  
      </form>
    </div>
</div>

    


<!-- bootstrap -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>