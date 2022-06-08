<?php
  //include_once('php/Books.php');

  //debug('Itt vagyok')
  //$books->writeLog("első log bejegyzésünk!!");
 ?>
<!DOCTYPE html>
<html lang="hu">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Könyvtár program</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="Sources/css/responsive.css">
    <link rel="stylesheet" href="Sources/css/admin.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="Sources/js/admin_script.js"></script>
  </head>
  <body>
    <header>
      <h1>Könyvtár Program</h1>
      <span class="f-right"><a href="?userhandler/logout"><img src="Sources/img/logout.png" alt="kilépés" title="kilépés"></a></span>
    </header>
    <div class="col-12">
      <div class="col-6">
        <h2>Szerzők listája</h2>
        <button type="button" name="button" onclick="location.href='?library/author';">Új szerző</button>

        <table>
          <tr>
            <th>Név</th>
            <th>Funkciók</th>
          </tr>
          <?php foreach ($authors as $key => $author) { ?>
            <tr>
              <td><?= $author['name'] ?></td>
              <td class="functions">
                <a href="?library/author/<?= $author['id'] ?>"><img src="Sources/img/edit.png" alt="módosítás" title="módosítás"></a>
                <a href="#" class="delete_rec" table="Authors" rec_id="<?= $author['id'] ?>"><img src="Sources/img/delete.png" alt="törlés" title="törlés"></a>
              </td>
            </tr>
    <?php } ?>
        </table>
      </div>
      <div class="col-6">
        <h2>Kategóriák listája</h2>
        <button type="button" name="button" onclick="location.href='?library/category';">Új kategória</button>

        <table>
          <tr>
            <th>Név</th>
            <th>Funkciók</th>
          </tr>
        <?php foreach ($categories as $key => $category) { ?>
          <tr>
            <td><?= $category['name'] ?></td>
            <td class="functions">
              <a href="?library/category/<?= $category['id'] ?>"><img src="Sources/img/edit.png" alt="módosítás" title="módosítás"></a>
              <a href="#"  class="delete_rec" table="Categories" rec_id="<?= $category['id'] ?>"><img src="Sources/img/delete.png" alt="törlés" title="törlés"></a>
            </td>
          </tr>
        <?php } ?>
        </table>
      </div>
    </div>
    <div class="col-12">
      <h2>Könyvek listája</h2>
      <button type="button" name="button" onclick="location.href='?library/book';">Új könyv</button>

      <table>
        <tr>
          <th>Cím</th>
          <th>Oldalszám</th>
          <th>Nyelv</th>
          <th>Szerző</th>
          <th>Kategória</th>
          <th>Funkciók</th>
        </tr>
        <?php foreach ($books as $key => $book) { ?>
          <tr>
            <td><?= $book['title'] ?></td>
            <td><?= $book['page_size'] ?></td>
            <td><?= $book['lang'] ?></td>
            <td><?= $book['author'] ?></td>
            <td><?= $book['category'] ?></td>
            <td class="functions">
              <a href="?library/book/<?= $book['id'] ?>"><img src="Sources/img/edit.png" alt="módosítás" title="módosítás"></a>
              <a href="#" class="delete_rec" table="Books" rec_id="<?= $book['id'] ?>"><img src="Sources/img/delete.png" alt="törlés" title="törlés"></a>
            </td>
          </tr>
  <?php }
        ?>

      </table>

    </div>

  </body>
</html>
