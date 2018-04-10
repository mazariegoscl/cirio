<?
namespace Config\Response;
class Response {
    static $params;

    public function __construct() {
        self::$params = array();
    }

    public static function success($message) {
        self::$params["success"] = $message;
        return self::$params = json_encode(self::$params);
    }

    public static function error($message) {
        self::$params["error"] = $message;
        return self::$params = json_encode(self::$params);
    }

    public static function response($message) {
        return json_encode($message);
    }
}
