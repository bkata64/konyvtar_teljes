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
    <main class="col-6 form-panel">
      <header>
        <h1>Könyvtár Program</h1>
        <span class="f-right"><a href="?userhandler/logout"><img src="Sources/img/logout.png" alt="kilépés" title="kilépés"></a></span>
      </header>
      <!--<?php debug($_SESSION); ?> -->
      <?= $object->msg->messages() ?>
      <?= $object->msg->getSessionMessage() ?>
    <!--  <?php debug($book); ?> -->
      <form id="form-inside" method="post" enctype="multipart/form-data">

        <input type="hidden" name="id" value="<?= empty($book['id']) ? null : $book['id'] ?>">

        <label class="col-3" for="title">Cím</label>
        <input class="col-6" type="text" name="title" invalid="false" value="<?= empty($book['title']) ? "" : $book['title'] ?>">
        <span class='validation' field='title'><?= $object->msg->getValidationMessage('title') ?></span>

        <label class="col-3" for="page_size">Oldalszám</label>
        <input class="col-6" type="number" name="page_size" value="<?= empty($book['page_size']) ? "" : $book['page_size'] ?>">

        <label class="col-3" for="lang">Nyelv</label>
        <input class="col-6" type="text" name="lang" value="<?= empty($book['lang']) ? "" : $book['lang'] ?>">

        <label class="col-3" for="author_id">Szerző</label>
        <select class="col-8" name="author_id">
          <?php foreach ($authors as $author) { ?>
            <option value="<?= $author['id'] ?>" <?= !empty($book['author_id']) && $book['author_id'] == $author['id'] ? 'selected' : '' ?>><?= $author['name'] ?></option>
      <?php } ?>
        </select>

        <span class="col-3 p-t-s-10">Kategória</span>
        <div class="checkbox-group col-8">
          <?php
            $catArray = !empty($book['category_ids']) ? explode(',', $book['category_ids']) : array();
            foreach ($categories as $category) { ?>
            <input type="checkbox" name="kategoria[<?= $category['id'] ?>]" <?= in_array($category['id'], $catArray) ? 'checked' : '' ?>>
            <label for="kategoria[<?= $category['id'] ?>]"><?= $category['name'] ?></label>
      <?php } ?>
        </div>
        <span class="col-3 p-t-s-10">Kép:</span>
        <?php
          $col = 'col-8';
          if(!empty($book['picture'])) {
            $col = 'col-9';
            ?>
            <img src='Sources/uploads/<?= $book['picture'] ?>' alt='<?= !empty($book['title']) ? $book['title'] : '' ?>' title='<?= !empty($book['title']) ? $book['title'] : '' ?>'>

        <?php } ?>

        <input class="<?= $col ?>" type="file" name="picture">

        <span class="col-3 p-t-s-10">Leírás:</span>
        <textarea class="col-8" name="description"><?= empty($book['description']) ? "Könyv leírása" : $book['description'] ?></textarea>
        <div class="col-12">
          <input type="submit" value="Ment">
          <button type="button" name="button" onclick="location.href='?library/backend'">Bezár</button>
        </div>
      </form>

    </main>




  </body>
</html>
