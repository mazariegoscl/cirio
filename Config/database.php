<?
namespace DB;
class Database {
    protected static $_db;
    public static $_dbserver;
    private static $_dbuser;
    private static $_dbpass;
    private static $_dbdb;

    public function __construct() {
        $config = parse_ini_file("Config/config.ini", true);
        self::$_dbserver = $config["database_config"]["server"];
        self::$_dbuser = $config["database_config"]["user"];
        self::$_dbpass = $config["database_config"]["pass"];
        self::$_dbdb = $config["database_config"]["db"];

        self::$_db = new \mysqli(self::$_dbserver, self::$_dbuser, self::$_dbpass, self::$_dbdb);
        if (self::$_db->connect_errno) {
            echo "Fallo al conectar a MySQL: " . $mysqli->connect_error;
        }
    }
}
