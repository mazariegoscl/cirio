<?
namespace Models\Panel;
use DB;
class HelperModel extends DB\Database {

	/*public function calcRatesReservation($fecha_inicial, $fecha_final, $tarifa) {
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

$query = self::$_db->query("SELECT $nombreTarifa FROM cirio_panel.properties WHERE id = '$propiedad'");

$tarifaNormal = $query->fetch_assoc()["rate"];

$query = self::$_db->query("SELECT id, property, rate, rate_weekly, rate_monthly, init_date, finish_date FROM cirio_panel.rates WHERE DATE(init_date) >= '$fecha_inicial' AND DATE(finish_date) <= '$fecha_final'");

$dia = date('Y-m-d', strtotime($fecha_inicial . ' - 1 days'));
$diasRestantes = intval(date_diff(date_create($fecha_inicial), date_create($fecha_final))->format("%a"));
$diasRestantes = $diasRestantes > 0 ? $diasRestantes : 1;
$total = 0;

while ($tarifas = $query->fetch_array()) {
$dia = date('Y-m-d', strtotime($dia . ' + 1 days'));

$inicioTarifa = date_create($tarifas["init_date"]);
$finTarifa = date_create($tarifas["finish_date"]);
$diasTarifa = intval(date_diff($inicioTarifa, $finTarifa)->format("%a"));

if ($dia >= $inicioTarifa->format('Y-m-d') && $dia <= $finTarifa->format('Y-m-d')) {
switch ($tarifa) {
case 1:
$total += ($diasTarifa * $tarifas["rate"]);
break;
case 2:
$total += ($diasTarifa * $tarifas["rate_weekly"]);
break;
case 3:
$total += ($diasTarifa * $tarifas["rate_monthly"]);
break;
}

$dia = date('Y-m-d', strtotime($dia . ' + ' . $diasTarifa . ' days'));
$diasRestantes -= $diasTarifa;
}
}

$total += ($diasRestantes * $tarifaNormal);

echo "Total: " . $total;
}*/

public function calcRatesRese2rvation($fecha_inicial, $fecha_final, $tarifa) {
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

	$total_tarifas = 0;
	$dias_tarifas = 0;
	$array_dias_restantes = array();
	while($tarifas = $tarifa_temporada->fetch_assoc()) {
		$fecha_inicial_tarifa = $tarifas["init_date"];
		$fecha_final_tarifa = $tarifas["finish_date"];
		$fecha_final_tarifa2 = date("Y-m-d", strtotime($fecha_final_tarifa . "- 1 days"));
		$crear_fecha_inicial_tarifa = date_create($fecha_inicial_tarifa);
		$crear_fecha_final_tarifa = date_create($fecha_final_tarifa);


		$intervalo = date_diff($crear_fecha_inicial_tarifa, $crear_fecha_final_tarifa);
		$intervalo = intval($intervalo->format('%R%a'));
		for($i = $fecha_final_tarifa; $i <= $fecha_final; $i++) {
			$dias_tarifas = $dias_tarifas += $intervalo;
		}

		for($i = $fecha_inicial_tarifa; $i <= $fecha_final_tarifa2; $i = date("Y-m-d", strtotime($i . "+ 1 days"))) {
			array_push($array_dias_restantes, $i);
		}


		echo "Tarifa: " . $nombre_tarifa . "<br />";
		echo "Precio: " . $tarifas[$nombre_tarifa] . "<br />";
		echo "Fecha de Entrada en Tarifa: " . $fecha_inicial_tarifa . "<br />";
		echo "Fecha de Salida en Tarifa: " . $fecha_final_tarifa . "<br />";
		echo "Intervalo: " . $intervalo . "<br />";
		echo "Total de Tarifa: " . ($tarifas[$nombre_tarifa] * $intervalo) . "<br /><br />";

		$total_tarifas += intval($tarifas[$nombre_tarifa]) * $intervalo;
	}

	echo "Total Tarifas: " . $total_tarifas . "<br />";
	echo "Días Tarifas: " . $dias_tarifas . "<br />";
	echo "<br />";
	echo "Precio Normal: " . $tarifa_normal . "<br />";

	$fecha_inicial = date('Y-m-d', strtotime($fecha_inicial));
	$fecha_final= date('Y-m-d', strtotime($fecha_final));
	$crear_fecha_inicial = date_create($fecha_inicial);
	$crear_fecha_final = date_create($fecha_final);

	$intervalo = date_diff($crear_fecha_inicial, $crear_fecha_final);
	$intervalo = intval($intervalo->format('%R%a'));

	$dias_restantes = ($intervalo - $dias_tarifas);
	$tarifa_normal_calculada = ($tarifa_normal * ($intervalo - $dias_tarifas));
	$total = $tarifa_normal_calculada + $total_tarifas;

	echo "<br /><br />";
	sort($array_dias_restantes);
	//foreach($array_dias_restantes as $dias) {
	//echo "Fecha: " . $dias . "<br />";
	for($i = $fecha_inicial; $i <= $fecha_final; $i = date("Y-m-d", strtotime($i . "+ 1 days"))) {
		if(!in_array($i, $array_dias_restantes)) {
			echo "Fecha con Tarifa Normal: " . $i . "<br />";
		} else {
			echo "Fecha con Tarifa de Temporada: " . $i  . "<br />";
		}

	}
	//}
	echo "<br /><br />";
	echo "Fecha de Entrada: " . $fecha_inicial . "<br />";
	echo "Fecha de Salida: " . $fecha_final . "<br />";
	echo "<br />";
	echo "Dias Totales: " . $intervalo . "<br />";
	echo "Días Calculados con Tarifa Normal: " . $dias_restantes . "<br />";
	echo "Días Calculados con Tarifa de Temporada: " . $dias_tarifas . "<br />";
	echo "<br />";
	echo "Tarifa Normal: " . $tarifa_normal_calculada . "<br />";
	echo "Total: " . $total;

	//echo $intervalo;
	/*try {
	if($intervalo > 0) {
	$intervalo = $intervalo;
} elseif($intervalo == 0) {
$intervalo = 1;
} elseif($intervalo < 0) {
throw new \Exception("Fecha no válida", 1);
} else {
throw new \Exception("Error Processing Request", 1);
}
//echo $intervalo;*/



}

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
			$fecha_final_tarifa2 = date('Y-m-d', strtotime($tarifas["finish_date"] . "-2 days"));
			$crear_fecha_inicial_tarifa = date_create($fecha_inicial_tarifa);
			$crear_fecha_final_tarifa = date_create($fecha_final_tarifa);
			$crear_fecha_final_tarifa2 = date_create($tarifas["finish_date"]);

			echo "<br />";
			echo "<br />";
			echo "<br />";
			$intervalo = 0;
			for($i = $fecha_inicial_tarifa; $i <= $fecha_final_tarifa; $i = date("Y-m-d", strtotime($i . "+ 1 days"))) {
				array_push($array_dias_restantes, $i);

				if($i <= $fecha_final) {
					echo $i . " SI ENTRA" . "<br />";
					$intervalo += count($i);

				} else {
					echo  $i . " NO ENTRA" . "<br />";
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
