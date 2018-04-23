<?
namespace Models\Panel;
use DB;
class ReservationsModel extends DB\Database {

    public function save($property, $customer, $init_date, $finish_date, $deposit_entry, $deposit_exit, $disccount, $commissions, $date) {
        $query = self::$_db->query("INSERT INTO reservations (property, customer, init_date, finish_date, deposit_entry, deposit_exit, disccount, date) VALUES ('$property', '$customer', '$init_date', '$finish_date', '$deposit_entry', '$deposit_exit', '$disccount','$date')");
        $query2 = self::$_db->query("SELECT LAST_INSERT_ID() AS ID");
        if($query2) {
            $id = $query2->fetch_assoc();
            return $id["ID"];
        }else{
            return false;
        }
    }

    public function update($id, $property, $customer, $init_date, $finish_date, $deposit_entry, $deposit_exit, $disccount, $commissions, $date) {
        $query = self::$_db->query("UPDATE reservations SET property='$property', customer='$customer', init_date='$init_date', finish_date='$finish_date', deposit_entry='$deposit_entry', deposit_exit='$deposit_exit', disccount='$disccount', date='$date' WHERE id='$id'");
        if($query) {
            return true;
        }else{
            return false;
        }
    }

    public function delete($id) {
        $query = self::$_db->query("DELETE FROM reservations WHERE id = '$id'");
        if($query) {
            return true;
        }else{
            return false;
        }
    }

    public function get() {
        $query = self::$_db->query("SELECT * FROM reservations");
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

    public function getBetweenDates($init_date, $finish_date, $property) {
        if($property == 0) {
            $query = self::$_db->query("SELECT * FROM reservations WHERE DATE(init_date) BETWEEN '$init_date' AND '$finish_date' OR DATE(finish_date) BETWEEN '$init_date' AND '$finish_date' ORDER BY init_date ASC");
        } else {
            $query = self::$_db->query("SELECT * FROM reservations WHERE (DATE(init_date) BETWEEN '$init_date' AND '$finish_date' OR DATE(finish_date) BETWEEN '$init_date' AND '$finish_date') AND property='$property' ORDER BY init_date ASC");
        }

        if($query) {
            if($query->num_rows > 0) {
                $rows = array();
                while($row = $query->fetch_assoc()) {
                    $rows[] = $row;
                }
                return $rows;
            } else {
                return 2;
            }
        }else{
            return false;
        }
    }
}
