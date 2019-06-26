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

    $posts = $db->query('SELECT m.name, m.picture, p.* FROM wonder_members m, wonder_posts p WHERE m.id=p.member_id ORDER BY p.id DESC');

    $stmt = $db->prepare('SELECT count(*) FROM wonder_goods WHERE content_id=?');

}else {
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
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Pacifico&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/23c9d2cac9.js"></script>
    <title>Home</title>
</head>
<body>
 <video id="bg-video" src="video/Milky Way Glowing At Night.mp4" poster="video/action-astronomy-constellation-1274260.jpg" autoplay loop></video>
  <div class="index-wrap">
  <h1 class="text-center mt-5 text-white" style="font-family: 'Pacifico', cursive;">Teams</h1>
  <p class="text-center font-weight-bold text-white">What comes to your mind?</p>
  <?php foreach($posts as $post) : ?>
        <div class="card float-left mt-3 ml-5 mr-5 mb-3" style="width: 20rem; height:50rem;">
          <!-- 画像 -->
          <img src="./member_picture/<?php print(htmlspecialchars($post['picture'], ENT_QUOTES));?>" class="card-img-top" style="height: 20rem">
          <div class="card-body">
            <!-- タイトル -->
            <h2 class="card-title"><?php print(htmlspecialchars($post['title'], ENT_QUOTES));?></h2>
            <P class="card-text"><?php print(htmlspecialchars($post['content'], ENT_QUOTES)); ?></P>
            <a href="check.php?id=<?php print(htmlspecialchars($post['id'], ENT_QUOTES));?>" class="btn btn btn-info mt-3" style="width: 40%;">join</a>
            <a href="member.php?id=<?php print(htmlspecialchars($post['id'], ENT_QUOTES));?>" class="btn btn-warning mt-3" style="width: 40%;">member</a>
            <div class="clear-fix">
            <a class="fas fa-heart text-danger float-left text-justify mt-1" href="./good.php?id=<?php print(htmlspecialchars($post['id'],ENT_QUOTES));?>"></a>
            <p class="float-left ml-1">
            <?php 
            $stmt->execute(array(
              $post['id']
            )); 
            $count = $stmt->fetchColumn();
            echo $count;
            ?>
            </p>
              <P class="card-text text-muted float-right mt-1">From　<?php print(htmlspecialchars($post['name'], ENT_QUOTES)); ?></P>
            </div>
          </div>
        </div>
<?php endforeach;?>
</div>
<embed src="./video/Grab_A_Star.mp3" class="clearfix border float-right" width="1" height="1">
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>