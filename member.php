<?php
session_start();
require('./dbconnect.php');

if (isset($_SESSION['id']) && $_SESSION['time'] + 3600 > time()) {
    $_SESSION['time'] = time();

    $teams = $db->prepare('SELECT m.year, m.school_num, m.name, m.picture, m.skill FROM wonder_members m, wonder_teams t WHERE t.content_id=? AND t.member_id=m.id');
    $teams->execute(array(
        $_REQUEST['id']
    ));
} else {
    header('Location: login.php');
    exit();
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

  <h1 class="text-center mt-5" style="font-family: 'Pacifico', cursive;">Team Members</h1>
  <p class="text-center font-weight-bold">What comes to your mind?</p>
<?php foreach($teams as $team) : ?>
        <div class="card mb-5 ml-3 float-left" style="width: 18rem;">
          <!-- 画像 -->
          <img src="./member_picture/<?php print(htmlspecialchars($team['picture'], ENT_QUOTES));?>" class="card-img-top" style="height: 18rem;">
          <div class="card-body">
            <!-- タイトル -->
            <p class="card-text"><?php print(htmlspecialchars($team['year'], ENT_QUOTES));?></p>
            <p class="card-text"><?php print(htmlspecialchars($team['school_num'], ENT_QUOTES));?></p>
            <P class="card-text"><?php print(htmlspecialchars($team['name'], ENT_QUOTES)); ?></P>
            <P class="card-text text-muted float-right"><?php print(htmlspecialchars($team['skill'], ENT_QUOTES)); ?></P>
          </div>
        </div>
<?php endforeach;?>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>