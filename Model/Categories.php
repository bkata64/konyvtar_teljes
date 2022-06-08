<?php
include_once('Application.php');

class Categories extends Application {

  private $sql = array(
    'allCategories' => "select c.id, c.name from categories c WHERE c.active = 1",
    'categoryById' => "select c.id, c.name from categories c where c.id = {id} and c.active = 1
                      limit 1"
  );

  private $messages = array();

  protected $table = 'categories';
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

  public function getCategories()  {
    $categories = $this->getResultList($this->sql['allCategories']);
    return $categories;
  }

  public function getCategoryById($id) {
    if(!$this->isValidId($id)) {
      return array();
    }

    $params = array(
      '{id}' => $id
     );
     debug(strtr($this->sql['categoryById'], $params));
     $category = $this->getSingleResult(strtr($this->sql['categoryById'], $params));
     return $category;
  }

  public function delete($id) {
    if(!$this->isValidId($id)) {
      return false;
    }
    $res = $this->deleteRekordById('categories', $id);
    return $res;
  }

  public function save($category) {
    if(!$this->validation($category)) {
      $this->writeLog('A kapott adatsor invalid! <br>'.implode('<br>',$this->messages));
      $this->msg->setSessionMessage('A form kitöltése nem megfelelő! <br>'.implode('<br>',$this->messages));
      return null;
    };

    if(isset($category['id']) && !empty($category['id'])) {
      if($this->isValidId(intval($category['id']))) {
        $this->id = intval($category['id']);
        $res = $this->modify($category);
      } else {
        $this->writeLog('A kapott id invalid: '.$category['id']);
        $this->msg->setSessionMessage('A kapott id invalid: '.$category['id']);
      }


    } else {
      $res = $this->create($category);
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
