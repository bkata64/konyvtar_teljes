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
      </header>      
      <?= $object->msg->getSessionMessage() ?>
    <!--  php debug($book); ?> -->
      <form id="form-inside" method="post" enctype="multipart/form-data">

        <label class="col-3" for="loginname">Felhasználónév</label>
        <input class="col-6" type="text" name="loginname" >

        <label class="col-3" for="password">Jelszó</label>
        <input class="col-6" type="password" name="password" >
        <div class="col-12" id="form-buttons">
          <input type="submit" value="Belép">
          <button type="button" name="button" onclick="location.href='?library/index'">Mégse</button>
        </div>
      </form>
    </main>
  </body>
</html>
