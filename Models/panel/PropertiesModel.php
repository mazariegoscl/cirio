<?
namespace Models\Panel;
use DB;
class PropertiesModel extends DB\Database {

    public function save($name, $rate, $rate_weekly, $rate_monthly, $date) {
        $query = self::$_db->query("INSERT INTO properties (name, rate, rate_weekly, rate_monthly, date) VALUES ('$name', '$rate', '$rate_weekly', '$rate_monthly', '$date')");
        $query2 = self::$_db->query("SELECT LAST_INSERT_ID() AS ID");
        if($query2) {
            $id = $query2->fetch_assoc();
            return $id["ID"];
        }else{
            return false;
        }
    }

    public function update($id, $name, $rate, $rate_weekly, $rate_monthly, $date) {
        $query = self::$_db->query("UPDATE properties SET name='$name', rate='$rate', rate_weekly='$rate_weekly', rate_monthly='$rate_monthly', date='$date' WHERE id='$id'");
        if($query) {
            return true;
        }else{
            return false;
        }
    }

    public function delete($id) {
        $query = self::$_db->query("DELETE FROM properties WHERE id='$id'");
        if($query) {
            return true;
        }else{
            return false;
        }
    }

    public function get() {
        $query = self::$_db->query("SELECT * FROM properties");
        if($query) {
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
