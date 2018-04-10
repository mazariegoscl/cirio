<?
namespace Config\Validator;
class Validator {
      static $params;
      static $error;
      static $success;

      public function __construct() {
            self::$params = array();
            self::$error = array();
            self::$success = array();
      }

      public static function make($rules, $request) {
            foreach($rules as $rule => $val) {
                  $explode = explode("|", $val);
                  foreach(explode("|", $val) as $rul) {
                        switch($rul) {
                              case "required" :
                              if(isset($request->$rule)) {
                                    self::required($rul, $rule, $request->$rule);
                              }else{
                                    self::$params["error"][$rule][$rul] = "No está seteado";
                              }
                              break;
                              case "number" :
                              if(isset($request->$rule)) {
                                    self::number($rul, $rule, $request->$rule);
                              }else{
                                    self::$params["error"][$rule][$rul] = "No está seteado";
                              }
                              break;
                              case "file" :
                              if(isset($request->$rule)) {
                                    self::file($rul, $rule, $request->$rule);
                              }else{
                                    self::$params["error"][$rule][$rul] = "No está seteado";
                              }
                              break;
                        }
                  }
            }
            return self::$params = json_encode(self::$params);
      }

      public function file($rul, $rule, $request) {
            if($request["name"] == "") {
                  //self::$params["error"][$rule][$rul] = "No hay archivo";
            }
      }

      public function required($rul, $rule, $request) {
            if($request == "") {
                  self::$params["error"][$rule][$rul] = "No puede estar vacía";
            }
      }

      public function number($rul, $rule, $request) {
            if(!is_numeric($request)) {
                  self::$params["error"][$rule][$rul] = "No es un número";
            }
      }

      public function error($message) {
            self::$error["error"] = $message;
            return self::$error = json_encode(self::$error);
      }

      public function success($message) {
            self::$success["success"] = $message;
            return self::$success = json_encode(self::$success);
      }
}
