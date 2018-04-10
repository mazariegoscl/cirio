<?
error_reporting(E_ERROR | E_WARNING | E_PARSE);
session_start();
$config = parse_ini_file("Config/config.ini", true);
require_once "database/mysql.php";
require_once "Config/validator.php";
require_once "Config/routes.php";
$requestMode = $_GET["mode"];
$requestController = $_GET["controller"];
$requestAction = $_GET["action"];

if(!isset($requestMode) && !isset($requestController) && !isset($requestAction)) {
      call_user_func(array("Controllers\page\PageController", "home"));
}else{
      if(method_exists("Controllers"."\\".$requestMode."\\" . $requestController, $requestAction)) {
            call_user_func(array("Controllers"."\\".$requestMode."\\" . $requestController, $requestAction));
      }else{
            call_user_func(array("Controllers"."\\".$requestMode."\\" . $requestController, "error404"));
      }
}
