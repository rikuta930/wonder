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

    $questions = $db->query('SELECT m.name, m.picture, q.* FROM wonder_members m, wonder_questions q WHERE m.id=q.member_id ORDER BY q.id DESC');
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
    <title>Answer</title>
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
        <h1 class="text-center mt-3" style="font-family: 'Pacifico', cursive;">Answer</h1>
        <p class="text-center font-weight-bold">We can do it as a team!</p>
<?php foreach($questions as $question): ?>
    <div class="card float-left mb-4 mt-4 ml-5 mr-5 " style="width: 263px; height:45rem;">
          <!-- 画像 -->
          <img src="./member_picture/<?php print(htmlspecialchars($question['picture'], ENT_QUOTES));?>" class="card-img-top" style="height: 263px">
          <div class="card-body">
            <!-- タイトル -->
            <h2 class="card-title"><?php print(htmlspecialchars($question['title'], ENT_QUOTES));?></h2>
            <a href="answer_chat.php?id=<?php print(htmlspecialchars($question['id'], ENT_QUOTES));?>" class="btn btn-success mt-3" style="width: 80%;">answer</a>
            <div class="clear-fix">
              <P class="card-text text-muted float-right mt-1">From　<?php print(htmlspecialchars($question['name'], ENT_QUOTES)); ?></P>
            </div>
          </div>
        </div>
<?php endforeach;?>
    </div>
</body>
</html>