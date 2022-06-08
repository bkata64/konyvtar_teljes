<?php

/**
 *
 */
class Messages {
  private $message = array();
  private $type = '';
  private $validationMessages = array();

  function __construct() {
    if(!isset($_SESSION['messages'])) {
      $_SESSION['messages'] = array();
      $_SESSION['message_flag'] = false;
    }

    if(!isset($_SESSION['validation'])) {
      $_SESSION['validation'] = array();
      $_SESSION['validationMessageFlag'] = false;
    }
  }

  public function setValidationMsg($field, $message) {
    $this->validatonMessages[$field] = $message;
    $_SESSION['validation'] = $this->validatonMessages;
    $_SESSION['validationMessageFlag'] = false;
  }

  public function getValidationMessage($field) {
    if (!$_SESSION['validationMessageFlag']) {
      $js = ''; //"<script> $('input[name=\$field\"]').css('border-color','red') </script>";

      echo $_SESSION['validation'][$field] . $js;
      $_SESSION['validationMessageFlag'] = true;
      $_SESSION['validation'] = array();
    }
  }

  public function setErrorMsg($str) {
    $this->message[] = $str;
    $this->type = 'error_msg';
  }

  public function messages() {
    if (!empty($this->message)) {
      echo "<div class='{$this->type} msg'>". implode("<br>", $this->message) ."</div>";
    }
  }

  public function setSessionMessage($str) {
    $_SESSION['messages'][] = $str;
    $_SESSION['message_flag'] = false;
  }

  public function getSessionMessage() {
    if(!$_SESSION['message_flag']) {
      echo implode(', ', $_SESSION['messages']);
      $_SESSION['message_flag'] = true;
      $_SESSION['messages'] = array();
    }
  }

}



?>
