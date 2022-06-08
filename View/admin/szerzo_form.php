<!DOCTYPE html>
<html lang="hu">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Könyvtár program</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="Sources/css/responsive.css">
    <link rel="stylesheet" href="Sources/css/admin.css">
  </head>
  <body>
    <main class="col-6 form-panel">
      <header>
        <h1>Könyvtár Program</h1>
        <span class="f-right"><a href="?userhandler/logout"><img src="Sources/img/logout.png" alt="kilépés" title="kilépés"></a></span>
      </header>
      <?= $object->msg->messages() ?>
      <?= $object->msg->getSessionMessage() ?>
      <form id="form-inside" method="post">

        <input type="hidden" name="id" value="<?= empty($author['id']) ? null : $author['id'] ?>">

        <label class="col-3" class="col-3" for="name">Név</label>
        <input class="col-6" type="text" name="name" value="<?= empty($author['name']) ? "" : $author['name'] ?>">

        <div class="col-12">
          <input type="submit" value="Ment">
          <button type="button" name="button" onclick="location.href='?library/backend'">Bezár</button>
        </div>
      </form>

    </main>




  </body>
</html>
