<?
namespace Models\Panel;
use DB;
class HelperModel extends DB\Database {

	public function calcRatesReservation($fecha_inicial, $fecha_final, $tarifa) {
		$nombreTarifa = "rate";
		$propiedad = 1;

		switch ($tarifa) {
			case 2:
			$nombreTarifa = "rate_weekly";
			break;
			case 3:
			$nombreTarifa = "rate_monthly";
			break;
		}

		$query = self::$_db->query("SELECT id, property, (SELECT $nombreTarifa FROM cirio_panel.properties WHERE id = '$propiedad') 'normal', rate, rate_weekly, rate_monthly, init_date, finish_date FROM cirio_panel.rates WHERE DATE(init_date) >= '$fecha_inicial' AND DATE(finish_date) <= '$fecha_final'");

		$dia = date('Y-m-d', strtotime($fecha_inicial. ' - 1 days'));
		$totalTarifas = 0;
		$totalNormal = 0;

		while($tarifas = $query->fetch_array()) {
			$inicioTarifa = date_create($tarifas["init_date"]);
			$finTarifa = date_create($tarifas["finish_date"]);
			$diasTarifa = intval(date_diff($inicioTarifa, $finTarifa)->format("%a"));

			if ($inicioTarifa >= $inicioTarifa && $finTarifa <= $finTarifa) {
				switch ($tarifa) {
					case 1:
					$totalTarifas += ($diasTarifa * $tarifas["rate"]);
					break;
					case 2:
					$totalTarifas += ($diasTarifa * $tarifas["rate_weekly"]);
					break;
					case 3:
					$totalTarifas += ($diasTarifa * $tarifas["rate_monthly"]);
					break;
				}
			}
			else {
				$totalNormal += $tarifas["normal"];
			}
		}

		echo "Total: " . ($totalTarifas + $totalNormal);
	}

	public function save($property, $rate, $rate_weekly, $rate_monthly, $init_date, $finish_date, $date) {
		$query = self::$_db->query("INSERT INTO rates (property, rate, rate_weekly, rate_monthly, init_date, finish_date, date) VALUES ('$property', '$rate', '$rate_weekly', '$rate_monthly', '$init_date', '$finish_date', '$date')");
		$query2 = self::$_db->query("SELECT LAST_INSERT_ID() AS ID");
		if($query2) {
			$id = $query2->fetch_assoc();
			return $id["ID"];
		}else{
			return false;
		}
	}

	public function calcReports() {
		$query = self::$_db->query("SELECT SUM(total - descuento) FROM reservations");
		$rows = array();
		while($row = $query->fetch_array()) {
			$rows[] = $row;
		}
		return $rows;
	}

	public function update($id, $property, $rate, $rate_weekly, $rate_monthly, $init_date, $finish_date, $date) {
		$query = self::$_db->query("UPDATE rates SET property='$property', rate='$rate', rate_weekly='$rate_weekly', rate_monthly='$rate_monthly', init_date='$init_date', finish_date='$finish_date', date='$date' WHERE id='$id'");
		if($query) {
			return true;
		}else{
			return false;
		}
	}

	public function delete($id) {
		$query = self::$_db->query("DELETE FROM rates WHERE id='$id'");
		if($query) {
			return true;
		}else{
			return false;
		}
	}

	public function get() {
		$query = self::$_db->query("SELECT * FROM rates");
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

	public function getProperty($property) {
		$query = self::$_db->query("SELECT * FROM rates WHERE property='$property'");
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
