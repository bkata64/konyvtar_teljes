<?php
include_once('Application.php');

class Books extends Application {

  private $sql = array(
    'allBooks' => "select b.id, title, page_size, lang, a.name AS author, group_concat(c.name separator ', ') as category, description, picture from books b
                    left join authors a on a.id = b.author_id
                    left join books_categories bc on bc.book_id = b.id
                    left join categories c on c.id = bc.category_id
                    WHERE b.active = 1
                    group by b.title",
    'booksByCategory' => "select b.id, title, a.name AS author, group_concat(c.name separator ', ') as category from books b
                    left join authors a on a.id = b.author_id
                    left join books_categories bc on bc.book_id = b.id
                    left join categories c on c.id = bc.category_id
                    where c.id = {id} and b.active = 1
                    group by b.title",
    'bookById' => "select b.id, title, page_size, lang, a.name AS author, author_id, group_concat(c.name separator ', ') as category,
                      group_concat(c.id separator ', ') as category_ids, description, picture
                      from books b
                      left join authors a on a.id = b.author_id
                      left join books_categories bc on bc.book_id = b.id
                      left join categories c on c.id = bc.category_id
                      where b.id = {id} and b.active = 1
                      group by b.title
                      limit 1",
    'booksByFilter' => "select b.id, title, page_size, lang, a.name AS author, group_concat(c.name separator ', ') as category, description, picture from books b
                    left join authors a on a.id = b.author_id
                    left join books_categories bc on bc.book_id = b.id
                    left join categories c on c.id = bc.category_id
                    WHERE b.active = 1 and lower(b.title) like '%{title}%'
                    group by b.title",
    'booksByCategories' => "select b.id, title, a.name AS author, group_concat(c.name separator ', ') as category from books b
                    left join authors a on a.id = b.author_id
                    left join books_categories bc on bc.book_id = b.id
                    left join categories c on c.id = bc.category_id
                    where c.id in {ids} and b.active = 1
                    group by b.title",
    'booksSearchAndFilter' => "select b.id, title, a.name AS author, group_concat(c.name separator ', ') as category from books b
                    left join authors a on a.id = b.author_id
                    left join books_categories bc on bc.book_id = b.id
                    left join categories c on c.id = bc.category_id
                    where c.id in {ids} and lower(b.title) like '%{title}%' and b.active = 1
                    group by b.title"
  );

  private $messages = array();

  protected $table = 'books';
  protected $fields = array('id', 'title', 'page_size', 'lang', 'author_id', 'description', 'picture');

  public function __construct()  {
    parent::__construct();

    //db ellenőrzés
    /*if($this->isDbConnectionLive()) {
      echo "db kapcsolat él";
    } else {
      echo "db kapcsolat nincs meg";
    }*/

    //próba kiíratás
    /*debug($this->getResultList("select * from books"));*/
  }

  public function getBooks()  {
    $books = $this->getResultList($this->sql['allBooks']);
    return $books;
  }

  public function getBooksFilter($title) {
    if (strlen($title) > 255) {
      return false;
    }

    $params = array('{title}' => strtolower($title));
    $books = $this->getResultList(strtr($this->sql['booksByFilter'], $params));
    return $books;
  }

  public function getBooksByCategory($category_id)  {
    if(!$this->isValidId($category_id)) {
      return array();
    }

    $params = array(
      '{id}' => $category_id
     );

    $books = $this->getResultList(strtr($this->sql['booksByCategory'], $params));

    return $books;
  }

  public function getBooksByCategories($category_ids)  {
    $text = '( ';
    $text .= implode(', ', $category_ids)." )";
    $params = array(
      '{ids}' => $text
     );
    $books = $this->getResultList(strtr($this->sql['booksByCategories'], $params));
    return $books;
  }

  public function getBooksSearchAndFilter($category_ids, $title) {
    $text = '( ';
    $text .= implode(', ', $category_ids)." )";
    if (strlen($title) > 255) {
      return false;
    }

    $params = array(
      '{ids}' => $text,
      '{title}' => strtolower($title)
     );
    $books = $this->getResultList(strtr($this->sql['booksSearchAndFilter'], $params));
    return $books;
  }

  public function getBookById($id) {
    if(!$this->isValidId($id)) {
      return array();
    }

    $params = array(
      '{id}' => $id
     );

     $book = $this->getSingleResult(strtr($this->sql['bookById'], $params));
     return $book;
  }

  public function delete($id) {
    if(!$this->isValidId($id)) {
      return false;
    }
    $res = $this->deleteRekordById('books', $id);
    return $res;
  }

  public function save($book) {
    if(!$this->validation($book)) {
      $this->writeLog('A kapott adatsor invalid! <br>'.implode('<br>',$this->messages));
      $this->msg->setSessionMessage('A form kitöltése nem megfelelő! <br>'.implode('<br>',$this->messages));
      return null;
    };

    if(isset($book['id']) && !empty($book['id'])) {
      if($this->isValidId(intval($book['id']))) {
        $this->id = intval($book['id']);
        $filename = $this->fileUpload();
        if($filename) {
          $book['picture'] = $filename;
        }
        $res = $this->modify($book);
        $this->saveCategory($book);
      } else {
        $this->writeLog('A kapott id invalid: '.$book['id']);
        $this->msg->setSessionMessage('A kapott id invalid: '.$book['id']);
      }


    } else {
      $filename = $this->fileUpload();
      $book['picture'] = $filename ? $filename : '';
      $res = $this->create($book);
      $this->id = $this->getLastInsertedId();
      $this->saveCategory($book);
    }

    return $this->id;
  }

  private function fileUpload() {
    if(isset($_FILES) && !empty($_FILES['picture']['tmp_name'])) {
      $targetDir = 'Sources/uploads/';
      //debug($_FILES);
      $targetFile = $targetDir . basename($_FILES['picture']['name']);

      $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

      $check = getimagesize($_FILES['picture']['tmp_name']);
      if ($check !== false) {
        if (file_exists($targetFile)) {
          $this->msg->setSessionMessage('A fájl már létezik!');
          return false;
        }
        if ($_FILES['picture']['size'] > 500000) {
          $this->msg->setSessionMessage('A fájl mérete túl nagy!');
          return false;
        }
        if ($imageFileType != 'jpg' && $imageFileType != 'png' && $imageFileType != 'jpeg' && $imageFileType != 'gif') {
          $this->msg->setSessionMessage('A megengedett képformátumok: JPG, JPEG, PNG vagy GIF!');
          return false;
        }
      } else {
        $this->msg->setSessionMessage('A feltöltött fájl nem kép!');
        return false;
      }

      if(move_uploaded_file($_FILES['picture']['tmp_name'], $targetFile)) {
        $filename = basename($_FILES['picture']['name']);
        return $filename;
      } else {
        $this->msg->setSessionMessage('A fájl áthelyezése sikertelen!');
        return false;
      }
    }
    return false;
  }

  private function saveCategory($book) {
    $sql = "delete from books_categories where book_id = {$this->id}";
    $this->execute($sql);

    $categories = array();
    foreach ($book as $key => $value) {
      if($key == "kategoria") {
        $keys = array_keys($value);

        foreach ($keys as $catId) {
          $categories[] = "($catId, {$this->id})";
        }
      }
    }

    $sql = "INSERT INTO books_categories(category_id, book_id) VALUES ". implode(', ', $categories);
    $this->execute($sql);
  }

  /** override */
  protected function validation($data) {
    if(!isset($data['title']) || empty($data['title']) || $data['title'] == null) {
      //$this->messages[] = 'A cím mező kitöltése kötelező.';
      $this->msg->setValidationMsg('title', 'A cím mező kitöltése kötelező');
      return false;
    }
    if(!is_string($data['title'])) {
      $this->messages[] = 'A cím csak szöveg lehet.';
      return false;
    }
    if (strlen($data['title']) > 255) {
      $this->messages[] = 'A cím hossza nem haladhatja meg a 255 karaktert.';
      return false;
    }

    $pageSize = intval($data['page_size']);
    if($pageSize < 0 || $pageSize > 10000) {
      $this->messages[] = 'Az oldalszám értéke 0 10000 közé kell, hogy essen.';
      return false;
    }

    if(!is_string($data['lang'])) {
      $this->messages[] = 'A nyelv értéke csak szöveg lehet.';
      return false;
    }
    if (strlen($data['lang']) > 255) {
      $this->messages[] = 'A nyelv értéke nem lehet hosszabb 255 karakternél.';
      return false;
    }

   // author_id és a category_id validálása az adatbázis alapján.
    if(!$this->isValidId(intval($data['author_id'])) || !$this->exist($data['author_id'], 'authors')) {
      $this->messages[] = 'Létező szerző megadása szükséges.';
      return false;
    }

    if(!$this->checkCategory($data)) {
      $this->messages[] = 'Létező kategória megadása szükséges.';
      return false;
    }

    return true;
  }

  public function checkCategory($data) {
    $categories = array();
    foreach ($data as $key => $value) {
      if($key == "kategoria") {
        $keys = array_keys($value);

        foreach ($keys as $catId) {
          $categories[] = $catId;
        }
      }
    }
    foreach ($categories as $category) {
      if(!$this->isValidId(intval($category)) || !$this->exist($category, 'categories')) {
        return false;
      }
    }
    return true;
  }

}

?>
