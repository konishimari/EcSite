<?php
session_start(); //サーバー側にデータを預けておく

//GETでidを取得
if(!isset($_GET["id"]) || $_GET["id"]==""){
  exit("ParamError!");
}else{
  $id = intval($_GET["id"]); //intval全てを数値変換する
}

//1.  DB接続します
try {
  $pdo = new 
  PDO('mysql:dbname=gs_db;charset=utf8;host=localhost','root','');
} catch (PDOException $e) {
  exit('データベースに接続できませんでした。'.$e->getMessage());
}

//２．データ登録SQL作成
$stmt = $pdo->prepare("SELECT * FROM ec_table WHERE id=:id");
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$status = $stmt->execute();



//３．データ表示
$view="";
if($status==false) {
  //execute（SQL実行時にエラーがある場合）
  $error = $stmt->errorInfo();
  exit("ErrorQuery:".$error[2]);

} else {
  //Selectデータの数だけ自動でループしてくれる
  $row = $stmt->fetch();  //１レコードだけ取得：$row["フィールド名"]で取得可能
}
?>


<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>Document</title>
  <link rel="stylesheet" href="css/reset.css">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/jquery.bxslider.css">
</head>
<body>
  <!--header-->
  <header class="header">
    <p class="site-title">Gallery of Air</a></p>
    <a href="cart.php" class="btn btn-cart">Gallery of Air</a>
    <a href="#" class="btn btn-menu">Gallery of Air</a>
  </header>
  <!-- end header-->
<form action="cartadd.php" method="POST">
  <div class="outer">
    <!--商品本情報-->
    <div class="wrapper wrapper-item flex-parent">

      <main class="wrapper-main">

        <!--商品情報-->
        <p class="item-thumb">
        <img src="./images/img/air_sculpture/<?=$row["fname"]?>" width="280">
        <div class="flex-parent item-label">
          <h3 class="item-name"><?=$row["category"]?></h3>
          <h1 class="item-name"><?=$row["item"]?></h1>
          <?php $display_amount = number_format($row["value"]);?>
          <p class="item-price">¥<?=$display_amount?></p>
          <p><input type="number" value="1" name="1" class="cartin-number"></p>
        </div>
        <!--商品詳細情報-->
        <div class="flex-parent item-label">
          <p class="item-text"><?=$row["description"]?></p>
        </div>
        <!--カートボタン-->
        <div class="flex-parent item-label">
          <input type="submit" class="btn-cartin" value="カートに入れる">
        </div>
        <input type="hidden" name="category" value="<?=$row["category"]?>">
        <input type="hidden" name="item" value="<?=$row["item"]?>">
        <input type="hidden" name="value" value="<?=$row["value"]?>">
        <input type="hidden" name="id" value="<?=$row["id"]?>">
        <input type="hidden" name="fname" value="<?=$row["fname"]?>">
      </main>
    </div>
  </div>
</form>

  <!--footer-->
  <footer class="footer">
    <div class="wrapper wrapper-footer">

      <div class="footer-widget__long">
        <p><a href="#">Gallery of Air</a></p>
      </div>

      <div class="footer-widget">
        <ul class="nav-footer">
          <li class="nav-footer__item"><a href="#">空気彫刻シリーズ</a></li>
          <li class="nav-footer__item"><a href="#">記憶装置シリーズ</a></li>
          <li class="nav-footer__item"><a href="#">コレクション１</a></li>
          <!-- <li class="nav-footer__item"><a href="#">コレクション２</a></li>
          <li class="nav-footer__item"><a href="#">コレクション３</a></li> -->
        </ul>
      </div>

      <div class="footer-widget">
        <ul class="nav-footer">
          <li class="nav-footer__item"><a href="#">Gallery of Air</a></li>
          <li class="nav-footer__item"><a href="#">Contact Us</a></li>
          <li class="nav-footer__item"><a href="#">Cart</a></li>
          <li class="nav-footer__item"><a href="#">Member Page</a></li>
        </ul>
      </div>

      <div class="footer-widget">
        <ul class="social-list">
          <li class="social-item"><a href="#"><img src="images/common/facebook.png" alt=""></a></li>
          <li class="social-item"><a href="#"><img src="images/common/instagram.png" alt=""></a></li>
          <li class="social-item"><a href="#"><img src="images/common/twitter.png" alt=""></a></li>
        </ul>
      </div>

    </div>
    <p class="copyrights"><small>Copyrights Gallery of Air All Rights Reserved.</small></p>
  </footer>
  <!--end footer-->

<script src="http://code.jquery.com/jquery-3.0.0.js"></script>
</body>
</html>
