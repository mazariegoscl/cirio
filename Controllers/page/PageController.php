<?php
namespace Controllers\Page;
use Config\Validator\Validator;
use Config\Response\Response;
use Models\Panel\ProjectsModel;
use Lang\lang;
class PageController {

      static $config;
      static $base;
      public function setConfig() {
            self::$config = $config = parse_ini_file("Config/config.ini", true);
      }
      public function error404() {
            require_once "404.php";
      }

      public function login() {
          if($_SESSION["username"]) {
              header("Location: home");
          }else{
              self::setConfig();
              self::$base = self::$config["server"]["directory"];
              require_once "Views/page/header.php";
              require_once "Views/page/index.php";
              require_once "Views/page/footer.php";
          }
      }


      public function home() {
          //if(!$_SESSION["username"]) {
            //  header("Location: login");
          //}else{
            self::setConfig();
            self::$base = self::$config["server"]["directory"];
            require_once "Views/page/header.php";
            require_once "Views/page/home.php";
            require_once "Views/page/footer.php";
        //}
      }

      public function reservations() {
          //if(!$_SESSION["username"]) {
            //  header("Location: login");
          //}else{
            self::setConfig();
            self::$base = self::$config["server"]["directory"];
            require_once "Views/page/header.php";
            require_once "Views/page/reservations.php";
            require_once "Views/page/footer.php";
        //}
      }

      public function sales() {
          //if(!$_SESSION["username"]) {
            //  header("Location: login");
          //}else{
            self::setConfig();
            self::$base = self::$config["server"]["directory"];
            require_once "Views/page/header.php";
            require_once "Views/page/sales.php";
            require_once "Views/page/footer.php";
        //}
      }

      public function expenses() {
          //if(!$_SESSION["username"]) {
            //  header("Location: login");
          //}else{
            self::setConfig();
            self::$base = self::$config["server"]["directory"];
            require_once "Views/page/header.php";
            require_once "Views/page/expenses.php";
            require_once "Views/page/footer.php";
        //}
      }

      public function commissions() {
          //if(!$_SESSION["username"]) {
            //  header("Location: login");
          //}else{
            self::setConfig();
            self::$base = self::$config["server"]["directory"];
            require_once "Views/page/header.php";
            require_once "Views/page/commissions.php";
            require_once "Views/page/footer.php";
        //}
      }

      public function propertyInventory() {
          //if(!$_SESSION["username"]) {
            //  header("Location: login");
          //}else{
            self::setConfig();
            self::$base = self::$config["server"]["directory"];
            require_once "Views/page/header.php";
            require_once "Views/page/propertyInventory.php";
            require_once "Views/page/footer.php";
        //}
      }

      public function inventory() {
          //if(!$_SESSION["username"]) {
            //  header("Location: login");
          //}else{
            self::setConfig();
            self::$base = self::$config["server"]["directory"];
            require_once "Views/page/header.php";
            require_once "Views/page/inventory.php";
            require_once "Views/page/footer.php";
        //}
      }

      public function properties() {
          //if(!$_SESSION["username"]) {
            //  header("Location: login");
          //}else{
            self::setConfig();
            self::$base = self::$config["server"]["directory"];
            require_once "Views/page/header.php";
            require_once "Views/page/properties.php";
            require_once "Views/page/footer.php";
        //}
      }

      public function expensesType() {
          //if(!$_SESSION["username"]) {
            //  header("Location: login");
          //}else{
            self::setConfig();
            self::$base = self::$config["server"]["directory"];
            require_once "Views/page/header.php";
            require_once "Views/page/expensesType.php";
            require_once "Views/page/footer.php";
        //}
      }

      public function categoryExpenses() {
          //if(!$_SESSION["username"]) {
            //  header("Location: login");
          //}else{
            self::setConfig();
            self::$base = self::$config["server"]["directory"];
            require_once "Views/page/header.php";
            require_once "Views/page/categoryExpenses.php";
            require_once "Views/page/footer.php";
        //}
      }

      public function configuration() {
          //if(!$_SESSION["username"]) {
            //  header("Location: login");
          //}else{
            self::setConfig();
            self::$base = self::$config["server"]["directory"];
            require_once "Views/page/header.php";
            require_once "Views/page/configuration.php";
            require_once "Views/page/footer.php";
        //}
      }
}
