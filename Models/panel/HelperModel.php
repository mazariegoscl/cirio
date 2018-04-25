<?
namespace Models\Panel;
use DB;
class HelperModel extends DB\Database {

public function calcRatesReservation($fecha_inicial, $fecha_final, $tarifa) {
	$fecha_inicial = date('Y-m-d', strtotime($fecha_inicial));
	$fecha_final = date('Y-m-d', strtotime($fecha_final));
	$crear_fecha_final = date_create($fecha_final);
	$fecha_final = date('Y-m-d', strtotime($fecha_final . "-1 days"));
	$crear_fecha_inicial = date_create($fecha_inicial);

	$intervalo0 = date_diff($crear_fecha_inicial, $crear_fecha_final);
	$intervalo0 = intval($intervalo0->format('%R%a'));

	$total_tarifas = 0;
	$dias_tarifas = 0;

	$array_dias_restantes = array();

	try {
		if($intervalo0 > 0) {
			$intervalo = $intervalo;
		} elseif($intervalo0 == 0) {
			$intervalo0 = 1;
		} elseif($intervalo0 < 0) {
			throw new \Exception("Fecha no válida", 1);
		} else {
			throw new \Exception("Error Processing Request", 1);
		}
		echo "NOCHES: " . $intervalo0 . "<br /><br /><br />";

		$propiedad = 1;
		switch($tarifa) {
			case 1:
			$nombre_tarifa = "rate";
			break;
			case 2:
			$nombre_tarifa = "rate_weekly";
			break;
			case 3:
			$nombre_tarifa = "rate_monthly";
			break;
		}

		$tarifa_propiedad = self::$_db->query("SELECT $nombre_tarifa FROM properties WHERE id = '$propiedad'");

		$tarifa_normal = $tarifa_propiedad->fetch_assoc()[$nombre_tarifa];

		$tarifa_temporada = self::$_db->query("SELECT * FROM rates WHERE property = '$propiedad' AND DATE(init_date) >= '$fecha_inicial' AND DATE(finish_date) <= '$fecha_final' || DATE(init_date) BETWEEN '$fecha_inicial' AND '$fecha_final' ");


		while($tarifas = $tarifa_temporada->fetch_assoc()) {
			$fecha_inicial_tarifa = $tarifas["init_date"];
			$fecha_final_tarifa = date('Y-m-d', strtotime($tarifas["finish_date"] . "-1 days"));
			$crear_fecha_inicial_tarifa = date_create($fecha_inicial_tarifa);
			$crear_fecha_final_tarifa = date_create($fecha_final_tarifa);
			$crear_fecha_final_tarifa2 = date_create($tarifas["finish_date"]);

			echo "<br />";
			echo "<br />";
			echo "<br />";
			$intervalo = 0;
			for($i = $fecha_inicial_tarifa; $i <= $tarifas["finish_date"]; $i = date("Y-m-d", strtotime($i . "+ 1 days"))) {
				array_push($array_dias_restantes, $i);

				if($i <= $fecha_final) {
					echo "Tarifa con fecha <span style='color: rgb(129, 109, 195); font-weight: bold;'>" . $i . "</span> <span style='color: green; font-weight: bold;'>SI ENTRA</span>" . "<br />";
					$intervalo += count($i);

				} else {
					echo "Tarifa con fecha <span style='color: rgb(129, 109, 195); font-weight: bold;'>" . $i . "</span> <span style='color: red; font-weight: bold;'>NO ENTRA</span>" . "<br />";
				}
			}

			$total_tarifas += intval($tarifas[$nombre_tarifa]) * $intervalo;

			$dias_tarifas = $dias_tarifas += $intervalo;

			echo "<br />";
			echo "<br />";
			echo "<br />";


			echo "Tarifa: " . $nombre_tarifa;
			echo "<br />";
			echo "Precio: " . $tarifas[$nombre_tarifa];
			echo "<br />";
			echo "Fecha Inicial: " . $tarifas["init_date"];
			echo "<br />";
			echo "Fecha Final: " . $tarifas["finish_date"];
			echo "<br />";
			echo "Calcular Hasta: " . $fecha_final_tarifa;
			echo "<br />";
			echo "Intervalo: " . $intervalo;
			echo "<br />";

			echo "<br />";
			echo "<br />";
			echo "<br />";
		}

		echo "Precio Normal: " . $tarifa_normal;
		echo "<br />";
		echo "Total Precio Normal: " . $tarifa_normal * ($intervalo0 - $dias_tarifas);
		echo "<br />";
		echo "Precio Total Tarifas: " . $total_tarifas;
		echo "<br />";
		echo "Días Tarifas: " . $dias_tarifas;
		echo "<br />";
		echo "Días Normales: " . ($intervalo0 - $dias_tarifas);
		echo "<br />";
		echo "Total: " . ($tarifa_normal * ($intervalo0 - $dias_tarifas) + $total_tarifas);


	} catch (\Exception $e) {
		echo 'Excepción capturada: ',  $e->getMessage();
	}
}


private function pinta($var, $texto) {
	echo "$" . $var . " = " . $texto . "<br>-----------<br>";
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
