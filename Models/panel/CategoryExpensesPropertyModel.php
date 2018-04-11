<?
namespace Models\Panel;
use DB;
class CategoryExpensesPropertyModel extends DB\Database {

    public function save($expense, $property, $date) {
        $query = self::$_db->query("INSERT INTO expenses_type_properties (expense, property, date) VALUES ('$expense', '$property', '$date')");
        $query2 = self::$_db->query("SELECT LAST_INSERT_ID() AS ID");
        if($query2) {
            $id = $query2->fetch_assoc();
            return $id["ID"];
        }else{
            return false;
        }
    }

    public function update($id, $expense, $property, $date) {
        $query = self::$_db->query("UPDATE expenses_type_properties SET name='$expense', property='$property', date='$date' WHERE id='$id'");
        if($query) {
            return true;
        }else{
            return false;
        }
    }

    public function delete($id) {
        $query = self::$_db->query("DELETE FROM expenses_type_properties WHERE id='$id'");
        if($query) {
            return true;
        }else{
            return false;
        }
    }





    public function getEP($property) {
        $query = self::$_db->query("SELECT * FROM expenses_type et WHERE NOT EXISTS(SELECT * FROM expenses_type_properties  etp WHERE  etp.property = '$property' AND etp.expense=et.id);");
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
        $query = self::$_db->query("SELECT etp.id as id, et.name as name FROM expenses_type_properties etp INNER JOIN expenses_type et ON et.id = etp.expense WHERE property = '$property'");
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
