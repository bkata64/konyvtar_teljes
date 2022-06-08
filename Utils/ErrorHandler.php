<?php

/**
 *
 */
class ErrorHandler {
  private $debug = true;
  public function __construct() {}

  public function errorAndDie($msg) {
    //logolja a hibát -> házi feladat(logoló metódus Application.php-ból)
    $this->writeLog($msg);
    if(!$this->debug) {
      $msg = 'Szerver oldali hiba!';
    }

    die($msg);
  }

  private function writeLog($msg) {
    $log = fopen("log/log.txt", "a");
    fwrite($log, $msg);
    fclose($log);
  }

}



 ?>
