<header>
  <h2>Részletes nézet</h2>
</header>
<div>
  <h3 class="col-12"><?= $book['title'] ?></h3>
  <div class="kep col-3">
    <img class="book_img" src="Sources/uploads/<?= $book['picture'] ?>" alt="<?= $book['title'] ?>" title="<?= $book['title'] ?>">
  </div>
  <div class="data col-6">
    <table class="detail_table">
      <tr>
        <th>Szerző:</th>
        <td><?= $book['author'] ?></td>
      </tr>
      <tr>
        <th>Oldalszám:</th>
        <td><?= $book['page_size'] ?></td>
      </tr>
      <tr>
        <th>Nyelv:</th>
        <td><?= $book['lang'] ?></td>
      </tr>
      <tr>
        <th>Kategóriák:</th>
        <td><?= $book['category'] ?></td>
      </tr>
    </table>

  </div>
  <div class="col-12">
    <h4 class="col-12 leiras">Leírás:</h4>
    <p class="col-12"><?= $book['description'] ?></p>
  </div>
</div>
