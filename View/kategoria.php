<?php
  include_once('php/Books.php');
  $books = new Books();

  //echo $_GET['cat'];

  //debug('Itt vagyok')
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="Cache-control" content="no-cache">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Könyvtár Program</title>
    <link rel="stylesheet" href="css/responsive.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="js/script.js"></script>
  </head>
  <body>
    <main>
      <div class="col-9" id="tartalom">
        <header class="m-b-20">
          <h2>Könyvek kategorizált listája</h2>
        </header>
        <div>

          <table>
            <tr>
              <th>Cím</th>
              <th>Szerző</th>
              <th>Kategória</th>
            </tr>

            <?php foreach ($books->getBooksByCategory(intval($_GET['cat'])) as $key => $book) { ?>
              <tr>
                <td><?=  $book['title'] ?></td>
                <td><?=  $book['author'] ?></td>
                <td><?=  $book['category'] ?></td>
              </tr>
      <?php } ?>

          </table>
        </div>
        <br>
        <button type="button" onclick="location.href='index.php'">Vissza</button>

      </div>
    </main>

  </body>
</html>
