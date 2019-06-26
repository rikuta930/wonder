<?php
session_start();
require('./dbconnect.php');

if (isset($_SESSION['id']) && $_SESSION['time'] + 3600 > time()) {
    $_SESSION['time']  = time();

    $members = $db->prepare('SELECT * FROM wonder_members WHERE id=?');
    $members->execute(array(
        $_SESSION['id']
    ));
    $member = $members->fetch();

    $accounts = $db->prepare('SELECT * FROM wonder_teams WHERE member_id=? AND content_id=?');
    $accounts->execute(array(
      $member['id'],
      $_REQUEST['id']
    ));
    $account = $accounts->fetch();

    $stmt = $db->prepare('SELECT count(*) FROM wonder_teams WHERE content_id=?');
    $stmt->execute(array(
      $_REQUEST['id']
    ));
    $count = $stmt->fetchColumn();
}else {
    header('Location: login.php');
}






if (!empty($_REQUEST['id'])) {
    if (empty($account)) {
        if ($count <= 6) {
          $id = uniqid(rand());
          $teams = $db->prepare('INSERT INTO wonder_teams VALUES(?,?,?)');
          $teams->execute(array(
          $id,
          $member['id'],
          $_REQUEST['id']
          ));
        } else {
          $error['count'] = "restriction";
        }
    }else {
      $error['account'] = "double";
    }
} else {
  header('Location: index.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Document</title>
</head>
<body>
<header>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
<h1 class="navbar-brand">wonder</h1>
<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
<span class="navbar-toggler-icon"></span>
</button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
      <li class="nav-item active">
        <a class="nav-link" href="./index.php">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="./build.php">Team Up</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="./wonder.html">How To Make App?</a>
      </li>
    </ul>
  </div>
</nav>
</header>

<div class="container mt-5 text-center font-weight-bold">
<?php if ($error['count'] === "restriction"):?>
  <p>このチームはすでに定員に達していますので、違うチームに登録するか、新しいチームの作成をお願いします。</p>
<?php else: ?>
<?php if ($error['account'] === "double"): ?>
  <p>このアカウントは既に登録されています。</p>
<?php else: ?>
<p>チームに登録されました！</p>
<?php endif; ?>
<?php endif; ?>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>