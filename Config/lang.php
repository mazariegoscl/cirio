<?
namespace Lang;
class lang {
      public $lang;
      public function __construct() {
            require_once "lang.php";
            $this->lang = $lang;
      }

      public function setLang() {
            return $this->lang;
      }
}
