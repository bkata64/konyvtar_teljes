<!DOCTYPE html>
<html lang="hu">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="Cache-control" content="no-cache">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Könyvtár Program</title>
    <link rel="stylesheet" href="Sources/css/responsive.css">
    <link rel="stylesheet" href="Sources/css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="Sources/js/script.js"></script>
  </head>
  <body>
    <!--<p onclick=<?php phpinfo()?>>PHP info</p>-->
    <header>
      <span><img id="panel-nyito" src="Sources/img/menu.png" alt="menü" title="menü"></span>
      <h1>Könyvtár Program</h1>
    </header>
    <main>
      <div class="col-3" id="kategoria">
        <header class="m-b-10">
          <h2>Kategóriák</h2>
          <span class="f-right"><img id="panel-zaro" src="Sources/img/arrow_left.png" alt="összecsuk" title="összecsuk"></span>
        </header>
        <div>
          <?php foreach ($categories as $key => $category) { ?>
            <!--<input type="checkbox" name="<?= $category['name'] ?>" id="<?= $category['name'] ?>"><label for="<?= $category['name'] ?>" id="<?= $category['name'] ?>" class="cat" szamlalo=0 onClick="location.href='kategoria.php?cat=<?= $category['id'] ?>'"><?= $category['name'] ?> (0)</label><br>-->
            <input type="checkbox" name="kategoria[<?= $category['id'] ?>]" id="kategoria[<?= $category['id'] ?>]" class="cat" cat="<?= $category['id'] ?>"><label for="kategoria[<?= $category['id'] ?>]" szamlalo=0> <?= $category['name'] ?> </label><br>
          <?php } ?>
          <hr>
          <a href="?userhandler/login"><span><img src="Sources/img/login.png" alt="belépés" title="belépés"></span>Belépés</a>
        </div>
      </div>
      <div class="col-9" id="tartalom">
        <header class="m-b-20">
          <h2>Könyvek listája</h2>
        </header>
        <div>
          <?php $msg->messages(); ?>
          <input type="search" name="search" class="m-b-20">
          <button type="button" id="search">Keresés</button>
          <button type="button" id="cancel">Mégse</button>

          <div id="table-content">

            <?php include_once('table_view.php'); ?>
          </div>
          <div id="detail-view">
            <?php
              $book = $books[0];
              include_once('detail.php');   ?>
          </div>
        </div>
      </div>

    </main>
  </body>
</html>
