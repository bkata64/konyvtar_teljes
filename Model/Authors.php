<?php
include_once('Application.php');

class Authors extends Application {

  private $sql = array(
    'allAuthors' => "select a.id, a.name from authors a WHERE a.active = 1",
    'authorById' => "select a.id, a.name from authors a where a.id = {id} and a.active = 1
                      limit 1"
  );

  private $messages = array();

  protected $table = 'authors';
  protected $fields = array('id', 'name');

  public function __construct()  {
    parent::__construct();

    //db ellenőrzés
    /*if($this->isDbConnectionLive()) {
      echo "db kapcsolat él";
    } else {
      echo "db kapcsolat nincs meg";
    }*/

    //próba kiíratás
    //debug($this->getResultList("select * from authors"));
  }

  public function getAuthors()  {
    $authors = $this->getResultList($this->sql['allAuthors']);
    return $authors;
  }

  public function getAuthorById($id) {
    if(!$this->isValidId($id)) {
      return array();
    }

    $params = array(
      '{id}' => $id
     );
     debug(strtr($this->sql['authorById'], $params));
     $author = $this->getSingleResult(strtr($this->sql['authorById'], $params));
     return $author;
  }

  public function delete($id) {
    if(!$this->isValidId($id)) {
      return false;
    }
    $res = $this->deleteRekordById('authors', $id);
    return $res;
  }

  public function save($author) {
    if(!$this->validation($author)) {
      $this->writeLog('A kapott adatsor invalid! <br>'.implode('<br>',$this->messages));
      $this->msg->setSessionMessage('A form kitöltése nem megfelelő! <br>'.implode('<br>',$this->messages));
      return null;
    };

    if(isset($author['id']) && !empty($author['id'])) {
      if($this->isValidId(intval($author['id']))) {
        $this->id = intval($author['id']);
        $res = $this->modify($author);
      } else {
        $this->writeLog('A kapott id invalid: '.$author['id']);
        $this->msg->setSessionMessage('A kapott id invalid: '.$author['id']);
      }


    } else {
      $res = $this->create($author);
      $this->id = $this->getLastInsertedId();
    }

    return $this->id;
  }

  /** override */
  protected function validation($data) {
    if(!isset($data['name']) || empty($data['name']) || $data['name'] == null) {
      $this->messages[] = 'A név mező kitöltése kötelező.';
      return false;
    }
    if(!is_string($data['name'])) {
      $this->messages[] = 'A név csak szöveg lehet.';
      return false;
    }
    if (strlen($data['name']) > 255) {
      $this->messages[] = 'A név hossza nem haladhatja meg a 255 karaktert.';
      return false;
    }

    return true;
  }


}
?>
