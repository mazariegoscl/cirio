<?
namespace Models\Panel;
use DB;
class ReservationsModel extends DB\Database {

    public function save($property, $customer, $init_date, $finish_date, $rate, $rate_amount, $deposit_entry, $deposit_exit, $disccount, $commissions, $total, $date) {
        $query = self::$_db->query("INSERT INTO reservations (property, customer, init_date, finish_date, rate, rate_amount, deposit_entry, deposit_exit, disccount, total, date) VALUES ('$property', '$customer', '$init_date', '$finish_date', '$rate', '$rate_amount', '$deposit_entry', '$deposit_exit', '$disccount', '$total', '$date')");
        $query2 = self::$_db->query("SELECT LAST_INSERT_ID() AS ID");
        if($query2) {
            $id = $query2->fetch_assoc();
            return $id["ID"];
        }else{
            return false;
        }
    }

    public function update($id, $property, $customer, $init_date, $finish_date, $rate, $rate_amount, $deposit_entry, $deposit_exit, $disccount, $commissions, $total, $date) {
        $count_commissions = count($commissions);
        $query = self::$_db->query("UPDATE reservations SET property='$property', customer='$customer', init_date='$init_date', finish_date='$finish_date', rate='$rate', rate_amount='$rate_amount', deposit_entry='$deposit_entry', deposit_exit='$deposit_exit', disccount='$disccount', total='$total', date='$date' WHERE id='$id'");
        if($query) {
            /*return $id["ID"];
            return true;*/


            if($count_commissions > 0) {
                $query3 = self::$_db->query("DELETE FROM commissions_reservations WHERE reservation='$id'");
                foreach($commissions as $commission) {
                    $id_commission = $commission["id"];
                    $status_commission = $commission["status"];


                    $query4 = self::$_db->query("INSERT INTO commissions_reservations (commission, reservation, status, date) VALUES ('$id_commission','$id','$status_commission','$date') ");

                    /*echo $id_commission;
                    echo $status_commission;
                    echo $id;*/
                    if(!$query4) {
                        return false;
                    }
                }
                return true;
            } else {
                return true;
            }
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
