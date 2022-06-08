<?php
include_once('Application.php');

class Users extends Application {

  private $sql = array(  
    'userByName' => "select u.id, u.name, u.loginname, u.password from users u where u.loginname = '{loginname}'
                      limit 1",
    'updateBySid' => "update users SET sid = {sid} WHERE id = {id}"
  );

  private $messages = array();

  protected $table = 'users';
  protected $fields = array('id', 'name', 'loginname', 'password');

  public function __construct()  {
    parent::__construct();

  }

  public function getUserByName($loginname) {
    if(!is_string($loginname) || strlen($loginname) > 50) {
      return array();
    }
    $loginname = htmlspecialchars($loginname, ENT_QUOTES);
    $params = array(
      '{loginname}' => $loginname
     );
     $user = $this->getSingleResult(strtr($this->sql['userByName'], $params));
     return $user;
  }


  public function save($user, $exists) {
    if ($exists) {
      $params = array(
        '{sid}' => $_SESSION['user']['id'],
        '{id}' => $_SESSION['user']['id']
       );
       $user = $this->execute(strtr($this->sql['updateBySid'], $params));
     } else {
       $params = array(
         '{sid}' => 'null',
         '{id}' => $user['id']
        );
        debug(strtr($this->sql['updateBySid'], $params));
        $user = $this->execute(strtr($this->sql['updateBySid'], $params));
       return false;
     }
       return true;
    }



}
?>
