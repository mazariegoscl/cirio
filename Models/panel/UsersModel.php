<?
namespace Models\Panel;
use DB;
class UsersModel extends DB\Database {

    public function resetPassword($user, $oldPassword, $newPassword, $rNewPassword) {
        $query0 = self::$_db->query("SELECT * FROM users WHERE password='$oldPassword' AND user='$user'");
        if($query0) {
            $num_rows = $query0->num_rows;
            if($num_rows > 0) {
                if($newPassword == $rNewPassword) {
                    $query = self::$_db->query("UPDATE users SET password='$newPassword' WHERE user='$user'");
                    if($query) {
                        return true;
                    }else{
                        return false;
                    }
                } else{
                    return false;
                }
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    public function login($user, $password) {
        $query = self::$_db->query("SELECT * FROM users WHERE user='$user' AND password='$password'");
        if($query) {
            $num_rows = $query->num_rows;
            if($num_rows > 0) {
                while($info = $query->fetch_array()) {
                    session_start();
                    $_SESSION["username"]["user"] = $info["user"];
                    return true;
                }
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

}
