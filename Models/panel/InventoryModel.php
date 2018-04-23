<?
namespace Models\Panel;
use DB;
class InventoryModel extends DB\Database {

    public function save($name, $quantity, $date) {
        $query = self::$_db->query("INSERT INTO inventory (name, quantity, date) VALUES ('$name', '$quantity', '$date')");
        $query2 = self::$_db->query("SELECT LAST_INSERT_ID() AS ID");
        if($query2) {
            $id = $query2->fetch_assoc();
            return $id["ID"];
        }else{
            return false;
        }
    }

    public function update($id, $name, $quantity, $date) {
        $query = self::$_db->query("UPDATE inventory SET name='$name', quantity='$quantity', date='$date' WHERE id='$id'");
        if($query) {
            return true;
        }else{
            return false;
        }
    }

    public function delete($id) {
        $query = self::$_db->query("DELETE FROM inventory WHERE id='$id'");
        if($query) {
            return true;
        }else{
            return false;
        }
    }

    public function get() {
        $query = self::$_db->query("SELECT * FROM inventory");
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
