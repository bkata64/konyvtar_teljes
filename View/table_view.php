<table>
  <tr>
    <th>Cím</th>
    <th>Szerző</th>
    <th>Kategória</th>
  </tr>

  <?php foreach ($books as $key => $book) { ?>
    <tr>
      <td class="book-row" book="<?=  $book['id'] ?>"><?= $book['title'] ?></td>
      <td><?=  $book['author'] ?></td>
      <td><?=  $book['category'] ?></td>
    </tr>
<?php } ?>

</table>
