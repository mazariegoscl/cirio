<?
namespace Models\Panel;
use DB;
class HomeModel extends DB\Database {

    public function login($email, $pass) {
        $query = self::$_db->query("SELECT * FROM users WHERE email = '$email' AND pass = '$pass'");
        if($query->num_rows > 0) {
            $rows = array();
            while($row = $query->fetch_assoc()) {
                  $rows[] = $row;
            }
            return $rows;
        }else{
            return false;
        }
    }
}
