<?
namespace Models\Panel;
use DB;
class ReservationsModel extends DB\Database {

  public function save($property, $customer, $init_date, $finish_date, $rate, $rate_amount, $deposit_entry, $deposit_exit, $disccount, $commissions, $total, $date, $dates, $nights) {
    $query = self::$_db->query("INSERT INTO reservations (property, customer, init_date, finish_date, rate, rate_amount, deposit_entry, deposit_exit, disccount, total, date) VALUES ('$property', '$customer', '$init_date', '$finish_date', '$rate', '$rate_amount', '$deposit_entry', '$deposit_exit', '$disccount', '$total', '$date')");
    $query2 = self::$_db->query("SELECT LAST_INSERT_ID() AS ID");
    if($query2) {
      $id = $query2->fetch_assoc()["ID"];
      $howmuch_dates = count($dates);
      $disccount_peer_rate = ($disccount / $nights);
      /*echo var_dump($dates);
      echo "<br /><br />";
      echo "CUANTAS NOCHES: " . $howmuch_dates;
      echo "DESCUENTO POR TARIFA: " . $disccount_peer_rate;*/

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

      /*  $rows = array();
        $query5 = self::$_db->query("SELECT * FROM commissions_reservations WHERE reservation = '$id'");
        while($fetchr = $query5->fetch_assoc()) {
          $rows[] = $fetchr;
        } */
      }


      if($howmuch_dates > 0 || $howmuch_dates != "") {
        foreach($dates as $reservation_dates) {
          $date_reservation = $reservation_dates["fecha"];
          $rate_reservation = $reservation_dates["tarifa"];
          $total_rate = ($rate_reservation - $disccount_peer_rate);

          /*echo "FECHA RESERVACION: " . $date_reservation . "<br />";
          echo "TARIFA RESERVACION: " . $rate_reservation . "<br />";
          echo "TOTAL RESRVACION: " . $total_rate . "<br />";
          echo "ID RESERVACION: " . $id . "<br />";*/
          $query3 = self::$_db->query("INSERT INTO reservation_days (reservation, rate, disccount, total, date_reservation, date) VALUES ('$id', '$rate_reservation', '$disccount_peer_rate', '$total_rate', '$date_reservation', '$date')");
          if(!$query3) {
            return false;
          }
        }
      }
      return $id;
    }else{
      return false;
    }
  }

  public function update($id, $property, $customer, $init_date, $finish_date, $rate, $rate_amount, $deposit_entry, $deposit_exit, $disccount, $commissions, $total, $date, $dates, $nights) {
    $count_commissions = count($commissions);
    $query = self::$_db->query("UPDATE reservations SET property='$property', customer='$customer', init_date='$init_date', finish_date='$finish_date', rate='$rate', rate_amount='$rate_amount', deposit_entry='$deposit_entry', deposit_exit='$deposit_exit', disccount='$disccount', total='$total', date='$date' WHERE id='$id'");
    if($query) {

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

        $rows = array();
        $query5 = self::$_db->query("SELECT * FROM commissions_reservations WHERE reservation = '$id'");
        while($fetchr = $query5->fetch_assoc()) {
          $rows[] = $fetchr;
        }
      }
      /*return $id["ID"];
      return true;*/


      $howmuch_dates = count($dates);
      $disccount_peer_rate = ($disccount / $nights);
      /*echo var_dump($dates);
      echo "<br /><br />";
      echo "CUANTAS NOCHES: " . $howmuch_dates;
      echo "DESCUENTO POR TARIFA: " . $disccount_peer_rate;*/
      if($howmuch_dates > 0 || $howmuch_dates != "") {
        $query5 = self::$_db->query("DELETE FROM reservation_days WHERE reservation='$id'");
        foreach($dates as $reservation_dates) {
          $date_reservation = $reservation_dates["fecha"];
          $rate_reservation = $reservation_dates["tarifa"];
          $total_rate = ($rate_reservation - $disccount_peer_rate);

          /*echo "FECHA RESERVACION: " . $date_reservation . "<br />";
          echo "TARIFA RESERVACION: " . $rate_reservation . "<br />";
          echo "TOTAL RESRVACION: " . $total_rate . "<br />";
          echo "ID RESERVACION: " . $id . "<br />";*/
          $query6 = self::$_db->query("INSERT INTO reservation_days (reservation, rate, disccount, total, date_reservation, date) VALUES ('$id', '$rate_reservation', '$disccount_peer_rate', '$total_rate', '$date_reservation', '$date')");

          if(!$query6) {
            return false;
          }
        }
      }

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

        $rows = array();
        $query5 = self::$_db->query("SELECT * FROM commissions_reservations WHERE reservation = '$id'");
        while($fetchr = $query5->fetch_assoc()) {
          $rows[] = $fetchr;
        }
      }

      return $rows;
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
      $i = 0;
      while($row = $query->fetch_assoc()) {
        $rows[$i] = $row;
        $id_res = $row["id"];
        $query2 = self::$_db->query("SELECT * FROM commissions_reservations WHERE reservation = '$id_res'");
        $u = 0;
        while($fetch = $query2->fetch_assoc()) {
          $rows[$i]["commissions"][$u]["id"] = $fetch["id"];
          $rows[$i]["commissions"][$u]["status"] = $fetch["status"];
          $rows[$i]["commissions"][$u]["commission"] = $fetch["commission"];
          $u++;
        }
        $i++;
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
        $i = 0;
        while($row = $query->fetch_assoc()) {
          $rows[$i] = $row;
          $id_res = $row["id"];
          $query2 = self::$_db->query("SELECT * FROM commissions_reservations WHERE reservation = '$id_res'");
          $u = 0;
          while($fetch = $query2->fetch_assoc()) {
            $rows[$i]["commissions"][$u]["id"] = $fetch["id"];
            $rows[$i]["commissions"][$u]["status"] = $fetch["status"];
            $rows[$i]["commissions"][$u]["commission"] = $fetch["commission"];
            $u++;
          }
          $i++;
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
