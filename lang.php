<?
if(isset($_GET['lang'])) {
      $lang = $_GET['lang'];
      $_SESSION['lang'] = $lang;
}elseif(isset($_SESSION['lang'])) {
      $lang = $_SESSION['lang'];
      header("Location: $lang/home");
}else{
      header("Location: en/home");
      $lang = 'en';
}

switch ($lang) {
      case 'en':
      $lang_file = 'en.php';
      break;
      case 'es':
      $lang_file = 'es.php';
      break;
      default:
      $lang_file = 'en.php';
      break;
}

include_once "lang/$lang_file";
