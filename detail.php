<?php 
session_start();
require('./dbconnect.php');

if (isset($_SESSION['id']) && $_SESSION['time'] + 3600 > time()) {
    $_SESSION['time'] = time();
    $_SESSION['content_id'] = $_REQUEST['id'];

    $posts = $db->prepare('SELECT * FROM wonder_posts WHERE id=?');
    $posts->execute(array(
        $_REQUEST['id']
    ));
    $post = $posts->fetch();

    $members = $db->prepare('SELECT * FROM wonder_members WHERE id=?');
    $members->execute(array(
        $post['member_id']
    ));
    $member = $members->fetch();

    // $sql = 'SELECT * FROM wonder_chats ORDER BY id DESC';
    // $messages = $db->query($sql);

    $messages = $db->prepare('SELECT * FROM wonder_chats WHERE content_id=? ORDER BY id DESC');
    $messages->execute(array(
      $post['id']
    ));
    $all = $messages->fetchAll();



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
    <title>Detail</title>
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
            <li class="nav-item">
              <a class="nav-link" href="./index2.php">Secreat for PC users</a>
            </li>
          </ul>
        </div>
      </nav>
    </header>
    <div class="container">
        <h1 class="text-center" style="font-family: 'Pacifico', cursive;">idea</h1>
        <p class="text-secondary text-center mt-1" style="font-family: 'Pacifico', cursive;">presented by　<?php print(htmlspecialchars($member['name'], ENT_QUOTES));?></p>
        <h2 class="text-info font-weight-bold"><?php echo htmlspecialchars($post['title'],ENT_QUOTES);?></h2>
        <hr>
        <p><?php echo htmlspecialchars($post['content'],ENT_QUOTES);?></p>
        <hr>
        <h2 class="text-warning font-weight-bold">comment</h2>
        <hr>
        <form action="./chat.php" method="post">
          <input type="text" name="message" required>
          <input type="submit" value="送信">
        </form>
        <br>
        
<?php foreach($all as $message):?>
    <div class="clerfix">
<img src="./member_picture/<?php $users = $db->prepare('SELECT * FROM wonder_members WHERE id=?');
$users->execute(array($message['member_id']));
$user = $users->fetch();
echo htmlspecialchars($user['picture'],ENT_QUOTES);
?>" style="width:70px; height:70px;" class="float-left mr-3">
<p><?php echo htmlspecialchars($message['message']);?>(<?php echo htmlspecialchars($user['name'],ENT_QUOTES);?>)</p>
<p><?php echo htmlspecialchars($message['created'],ENT_QUOTES);?></p>
<hr>
</div>
<?php endforeach;?>

        <hr>
<?php if($member[id] === $_SESSION['id']):?>
    <a href="./delete.php?id=<?php echo htmlspecialchars($post['id'],ENT_QUOTES);?>" class="btn btn-danger mt-3 mb-3" style="width:20%;">Delete This Idea</a>
<?php endif; ?>

    </div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>