<?php

include_once('../php/Books.php');
include_once('../php/Authors.php');
include_once('../php/Categories.php');

switch ($_GET['t']) {
  case 'books':
    $books = new Books();
    $res = $books->delete(intval($_GET['id']));

    if(!$res) {
      echo "hiba a könyv törlése során, id: ".$_GET[id];
    }
    break;

  case 'authors':
    $authors = new Authors();
    $res = $authors->delete(intval($_GET['id']));

    if(!$res) {
      echo "hiba a szerző törlése során, id: ".$_GET[id];
    }
    break;

    case 'categories':
      $categories = new Categories();
      $res = $categories->delete(intval($_GET['id']));

      if(!$res) {
        echo "hiba a kategória törlése során, id: ".$_GET[id];
      }
      break;

  default:
    // code...
    break;
}

if ($res) {
  header("Location: ../admin/index.php");
}

?>
