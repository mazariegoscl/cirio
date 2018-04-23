<?
namespace Models\Panel;
use DB;
class PropertyInventoryModel extends DB\Database {

    public function save($name, $quantity, $property, $date) {
        $query = self::$_db->query("INSERT INTO property_inventory (name, quantity, property, date) VALUES ('$name', '$quantity', '$property', '$date')");
        $query2 = self::$_db->query("SELECT LAST_INSERT_ID() AS ID");
        if($query2) {
            $id = $query2->fetch_assoc();
            return $id["ID"];
        }else{
            return false;
        }
    }

    public function update($id, $name, $quantity, $property, $date) {
        $query = self::$_db->query("UPDATE property_inventory SET name='$name', quantity='$quantity', property='$property', date='$date' WHERE id='$id'");
        if($query) {
            return true;
        }else{
            return false;
        }
    }

    public function delete($id) {
        $query = self::$_db->query("DELETE FROM property_inventory WHERE id='$id'");
        if($query) {
            return true;
        }else{
            return false;
        }
    }

    public function get() {
        $query = self::$_db->query("SELECT * FROM property_inventory");
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

    public function getId($property) {
        $query = self::$_db->query("SELECT * FROM property_inventory WHERE property = '$property'");
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
