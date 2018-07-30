<?
namespace Models\Panel;
use DB;
class UsersModel extends DB\Database {

    public function resetPassword($email, $password) {
        $query = self::$_db->query("UPDATE FROM users SET password='$password' WHERE email = '$email'");
        $query2 = self::$_db->query("SELECT LAST_INSERT_ID() AS ID");
        if($query2) {
            $id = $query2->fetch_assoc();
            return $id["ID"];
        }else{
            return false;
        }
    }

    public function save($users) {
        $sql = self::$_db->prepare("INSERT INTO users (name,email,pass,role) VALUES (:name, :email, :pass, :role)");
        $sql->execute(array(
            "name" => $users->name,
            "email" => $users->email,
            "pass" => $users->pass,
            "role" => $users->role
        ));
        if($sql) {
            return true;
        }else{
            return false;
        }
    }

    public function get($user) {
        $rows = array();
        if(empty($user)) {
            $sql = self::$_db->prepare("SELECT * FROM users");
        }else{
            $sql = self::$_db->prepare("SELECT * FROM users WHERE email = '$user'");
        }
        $sql->execute();
        while($result = $sql->fetch(\PDO::FETCH_ASSOC)) {
            $rows[] = $result;
        }
        return $rows;
    }

    public function find($id) {
        $rows = array();
        if(empty($id)) {
            $sql = self::$_db->prepare("SELECT * FROM users");
        }else{
            $sql = self::$_db->prepare("SELECT * FROM users WHERE id = '$id'");
        }
        $sql->execute();
        while($result = $sql->fetch(\PDO::FETCH_ASSOC)) {
            $rows[] = $result;
        }
        return $rows;
    }

    public function verify($email) {
        $sql = self::$_db->prepare("SELECT email FROM users WHERE email = '$email'");
        $sql->execute();
        $result = $sql->rowCount();
        if($result > 0) {
            return true;
        }else{
            return false;
        }
    }
}
