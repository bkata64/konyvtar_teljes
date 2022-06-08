<?php
include_once('AppController.php');

/**
 *
 */
class Userhandler extends AppController
{

  function __construct() {
    parent::__construct();

      $this->allowedMethods(array('login', 'logout'));
  }

  public function login() {
    $this->useModels(array('Users'));
    $this->template = 'admin/login';

    if (isset($_POST['loginname']) && isset($_POST['password'])) {
      //TODO: Loginname validálása, users tábla és model létrehozása, a user adatok lekérése
      $user = $this->Users->getUserByName($_POST['loginname']);
    /*  $user = array(
        'loginname' => 'Kata',
        'password' => md5('babesoft'),
      ); */

      if (strtolower($_POST['loginname']) == strtolower($user['loginname'])
        && md5($_POST['password']) == $user['password']) {
        $_SESSION['user'] = $user;
        debug($_SESSION['user']);
        $this->Users->save($user, true);
        header('Location: ?library/backend');
        exit;
      } else {
        $this->msg->setSessionMessage('Helytelen felhasználónév vagy jelszó!');
      }
    }
  }

  public function logout() {
    $this->useModels(array('Users'));
    $this->template = 'admin/login';
    debug($_SESSION['user']);
    $user = $_SESSION['user'];
    $_SESSION['user'] = null;
    $this->Users->save($user, false);
    header('Location: ?library/index');
    exit;
  }


}
?>
