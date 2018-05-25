<?
namespace Models\Panel;
use DB;
class HelperModel extends DB\Database {

	public function calcRatesReservation($propiedad, $fecha_inicial, $fecha_final, $tarifa) {
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
			if($propiedad == "") {
				throw new \Exception("Seleccione una propiedad", 1);
			}

			if($tarifa == "") {
				throw new \Exception("Seleccione una tarifa", 1);
			}

			if($intervalo0 > 0) {
				$intervalo = $intervalo;
			} elseif($intervalo0 == 0) {
				//$intervalo0 = 1;
				throw new \Exception("Fecha no válida", 1);
			} elseif($intervalo0 < 0) {
				throw new \Exception("Fecha no válida", 1);
			} else {
				throw new \Exception("Error Processing Request", 1);
			}

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
			if(!$tarifa_propiedad) {
				throw new \Exception("Imposible obtener la tarifa de la propiedad", 1);
			}

			if($tarifa_propiedad->num_rows <= 0) {
				throw new \Exception("No existe tal propiedad", 1);
			}

			//echo "NOCHES: " . $intervalo0 . "<br /><br /><br />";

			$tarifa_normal = $tarifa_propiedad->fetch_assoc()[$nombre_tarifa];

			$tarifa_temporada = self::$_db->query("SELECT * FROM rates WHERE property = '$propiedad' AND DATE(finish_date) >= '$fecha_inicial'");

			if(!$tarifa_temporada) {
				throw new \Exception("Imposible obtener la tarifa de temporada", 1);
			}

			/* $fechas_con_tarifa = array();
			$info_tarifa = array(); */
			$fechas_reservacion = array();
			$fechas_con_tarifa = array();
			while($tarifas = $tarifa_temporada->fetch_assoc()) {
				$fecha_inicial_tarifa = $tarifas["init_date"];
				$fecha_final_tarifa = date('Y-m-d', strtotime($tarifas["finish_date"] . "-1 days"));
				$crear_fecha_inicial_tarifa = date_create($fecha_inicial_tarifa);
				$crear_fecha_final_tarifa = date_create($fecha_final_tarifa);
				$crear_fecha_final_tarifa2 = date_create($tarifas["finish_date"]);

				/*echo "<br />";
				echo "<br />";
				echo "<br />";*/
				$intervalo = 0;
				for($i = $fecha_inicial_tarifa; $i <= $tarifas["finish_date"]; $i = date("Y-m-d", strtotime($i . "+ 1 days"))) {
					array_push($array_dias_restantes, $i);

					if($i >= $fecha_inicial && $i <= $fecha_final) {
						/* $info_tarifa["fecha"] = $i;
						$info_tarifa["precio"] = $tarifas[$nombre_tarifa];
						echo "ESTO ES: " . $mas;
						array_push($fechas_con_tarifa, $info_tarifa);
						*///echo "Tarifa con fecha <span style='color: rgb(129, 109, 195); font-weight: bold;'>" . $i . "</span> <span style='color: green; font-weight: bold;'>SI ENTRA</span>" . "<br />";
						array_push($fechas_con_tarifa, $i);
						array_push($fechas_reservacion, array("fecha" => $i, "tarifa" => $tarifas[$nombre_tarifa]));
						$intervalo += count($i);

					} else {
						//echo "Tarifa con fecha <span style='color: rgb(129, 109, 195); font-weight: bold;'>" . $i . "</span> <span style='color: red; font-weight: bold;'>NO ENTRA</span>" . "<br />";
					}
				}

				//echo json_encode($fechas_con_tarifa);

				$total_tarifas += intval($tarifas[$nombre_tarifa]) * $intervalo;

				$dias_tarifas = $dias_tarifas += $intervalo;

				/*echo "<br />";
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
				echo "<br />";*/
				$mas++;
			}

			/*echo "Precio Normal: " . $tarifa_normal;
			echo "<br />";
			echo "Total Precio Normal: " . $tarifa_normal * ($intervalo0 - $dias_tarifas);
			echo "<br />";
			echo "Precio Total Tarifas: " . $total_tarifas;
			echo "<br />";
			echo "Días Tarifas: " . $dias_tarifas;
			echo "<br />";
			echo "Días Normales: " . ($intervalo0 - $dias_tarifas);
			echo "<br />";
			echo "Total: " . ($tarifa_normal * ($intervalo0 - $dias_tarifas) + $total_tarifas);*/
			$resultado = array();
			$total = ($tarifa_normal * ($intervalo0 - $dias_tarifas) + $total_tarifas);

			$resultado["total"] = $total;
			for($i = $fecha_inicial; $i <= $fecha_final; $i = date("Y-m-d", strtotime($i . "+ 1 days"))) {


				if(!in_array($i, $fechas_con_tarifa)) {
					array_push($fechas_reservacion, array("fecha" => $i, "tarifa" => $tarifa_normal));
				}
				//array_push($fechas_reservacion, $i);
				//array_push($fechas_reservacion, array("fecha" => $i));
			}


			$resultado["fechas"] = $fechas_reservacion;
			$resultado["noches"] = $intervalo0;



			return $resultado;

			//return ($tarifa_normal * ($intervalo0 - $dias_tarifas) + $total_tarifas);

		} catch (\Exception $e) {
			echo 'Excepción capturada: ',  $e->getMessage();

			//return json_encode("{mamad:ABASTECED}");
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

	public function listaVentas() {
		$query = self::$_db->query("SELECT 0 'IdPropiedad', 'Resumen' as 'NombrePropiedad', Ventas, Tarifas, Depositos, Gastos, Descuentos, Utilidad, DiasOcupacion FROM
			( SELECT IFNULL(SUM(Ventas), 0) 'Ventas', IFNULL(SUM(Tarifas), 0) 'Tarifas', IFNULL(SUM(Depositos), 0) 'Depositos', IFNULL(SUM(Gastos), 0) 'Gastos', IFNULL(SUM(Descuentos), 0) 'Descuentos', IFNULL(SUM((Ventas - Gastos + Depositos)), 0) 'Utilidad', IFNULL(SUM(DiasOcupacion), 0) 'DiasOcupacion' FROM
			( SELECT p.id, p.name,
				(SELECT IFNULL(SUM(total),0) FROM reservations WHERE property = p.id) 'Ventas' ,
				(SELECT IFNULL(SUM(rate_amount),0) FROM reservations WHERE property = p.id) 'Tarifas' ,
				(SELECT IFNULL(SUM(deposit_entry),0) - IFNULL(SUM(deposit_exit),0) FROM reservations WHERE property = p.id) 'Depositos' ,
				(SELECT IFNULL(SUM(ep.quantity),0) FROM expenses_properties ep INNER JOIN expenses_type_properties etp ON etp.id = ep.expense_property WHERE etp.property = p.id) 'Gastos' ,
				(SELECT IFNULL(SUM(disccount),0) FROM reservations WHERE property = p.id) 'Descuentos' ,
				(SELECT IFNULL(SUM(DATEDIFF(finish_date, init_date)),0) FROM reservations WHERE property = p.id) 'DiasOcupacion' FROM properties p ) X) X2
				UNION SELECT id 'IdPropiedad', name 'Nombre', IFNULL(Ventas, 0),  IFNULL(Tarifas,0), IFNULL(Depositos,0), IFNULL(Gastos, 0), IFNULL(Descuentos, 0), IFNULL((Ventas - Gastos + Depositos), 0) 'Utilidad', IFNULL(DiasOcupacion, 0) FROM
				( SELECT p.id, p.name, (SELECT IFNULL(SUM(total),0) FROM reservations WHERE property = p.id) 'Ventas' ,
				(SELECT IFNULL(SUM(rate_amount),0) FROM reservations WHERE property = p.id) 'Tarifas' ,
				(SELECT IFNULL(SUM(deposit_entry),0) - IFNULL(SUM(deposit_exit),0) FROM reservations WHERE property = p.id) 'Depositos' ,
				(SELECT IFNULL(SUM(ep.quantity),0) FROM expenses_properties ep INNER JOIN expenses_type_properties etp ON etp.id = ep.expense_property WHERE etp.property = p.id) 'Gastos' ,
				(SELECT IFNULL(SUM(disccount),0) FROM reservations WHERE property = p.id) 'Descuentos' ,
				(SELECT IFNULL(SUM(DATEDIFF(finish_date, init_date)),0) FROM reservations WHERE property = p.id) 'DiasOcupacion' FROM properties p ) X");
				$rows = array();
				while($row = $query->fetch_array()) {
					$rows[] = $row;
				}
				echo json_encode($rows);
			}

			public function listaComisiones() {
				$query = self::$_db->query("SELECT * FROM properties");
				$rows = array();
				$u = 0;
				$i = 0;

				$query0 = self::$_db->query("SELECT IFNULL(SUM(r.total * c.percent / 100),0) AS cantidad_porcentaje, IFNULL(r.id,0) as reservacion, IFNULL(c.name,0) AS comision, IFNULL(c.id,0) AS comision_id, IFNULL(p.name,0) as propiedad, IFNULL(p.id,0) AS propiedad_id FROM commissions_reservations cr INNER JOIN commissions c ON c.id = cr.commission INNER JOIN reservations r ON r.id = cr.reservation RIGHT JOIN properties p ON p.id = r.property WHERE cr.status='true' GROUP BY c.id;");

				$rows[$u]["name_property"] = "Resumen";
				$rows[$u]["id_propiedad"] = "NONE";
				while($row0 = $query0->fetch_array()) {
					$rows[$u]["commissions"][$i]["id"] = $row0["comision_id"];
					$rows[$u]["commissions"][$i]["name"] = $row0["comision"];
					$rows[$u]["commissions"][$i]["quantity"] = $row0["cantidad_porcentaje"];
					$i++;
				}

				$u = $u + 1;
				while($row = $query->fetch_array()) {
					//$rows[] = $row;
					$query2 = self::$_db->query("SELECT * FROM commissions");
					$rows[$u]["name_property"] = $row["name"];
					$rows[$u]["id_propiedad"] = $row["id"];

					$i = 0;

					while($row2 = $query2->fetch_array()) {
						$rows[$u]["commissions"][$i]["id"] = $row2["id"];
						$rows[$u]["commissions"][$i]["name"] = $row2["name"];
						$rows[$u]["commissions"][$i]["quantity"] = 0;
						$i++;
					}
					$u++;
				}

				$query3 = self::$_db->query("SELECT IFNULL(SUM(r.total * c.percent / 100),0) AS cantidad_porcentaje, IFNULL(r.id,0) as reservacion, IFNULL(c.name,0) AS comision, IFNULL(c.id,0) AS comision_id, IFNULL(p.name,0) as propiedad, IFNULL(p.id,0) AS propiedad_id FROM commissions_reservations cr INNER JOIN commissions c ON c.id = cr.commission INNER JOIN reservations r ON r.id = cr.reservation RIGHT JOIN properties p ON p.id = r.property WHERE cr.status='true' GROUP BY p.id, c.id");

				while($row3 = $query3->fetch_array()) {
					foreach($rows as $prop => $val) {
						foreach($val["commissions"] as $com => $val2) {
							if($row3["propiedad_id"] == $val["id_propiedad"] && $row3["comision_id"] == $val2["id"]) {
								//echo "ESTE SI: " . $prop . " " . $com . " " . $row3["cantidad_porcentaje"] . "<br />";
								$rows[$prop]["commissions"][$com]["quantity"] = $row3["cantidad_porcentaje"];
							}
						}
					}

				}

				echo json_encode($rows);
			}

			public function dashBoard() {
				$query = self::$_db->query("SELECT Ventas, Gastos, TarifaPromedioDiaria
					FROM (SELECT
						(SELECT IFNULL(SUM(total), 0) FROM reservations) 'Ventas',
						(SELECT IFNULL(SUM(quantity), 0) FROM expenses_properties) 'Gastos',
						(SELECT CAST(IFNULL(AVG(rate_amount), 0) AS DECIMAL(9, 2)) FROM reservations) 'TarifaPromedioDiaria') X");
						echo json_encode($query->fetch_assoc());
					}

					public function dashBoardDates($init_date, $finish_date) {
						$query = self::$_db->query("SELECT Ventas, Gastos, TarifaPromedioDiaria FROM (SELECT
							(SELECT IFNULL(SUM(total), 0) FROM reservation_days WHERE DATE(date_reservation) BETWEEN '$init_date' AND '$finish_date') 'Ventas',
							(SELECT IFNULL(SUM(quantity), 0) FROM expenses_properties WHERE DATE(date) BETWEEN '$init_date' AND '$finish_date') 'Gastos',
							(SELECT CAST(IFNULL(AVG(rate), 0) AS DECIMAL(9, 2)) FROM reservation_days WHERE DATE(date_reservation) BETWEEN '$init_date' AND '$finish_date') 'TarifaPromedioDiaria') X;");
							echo json_encode($query->fetch_assoc());
						}



						public function porcentajeOcupacion() {
							$query = self::$_db->query("SELECT id 'Propidad', name 'NombrePropiedad', CAST(IFNULL(((Ocupacion / Total) * 100), 0) AS DECIMAL(9, 2)) 'Porcentaje'
							FROM (
								SELECT p.id, p.name, SUM(DATEDIFF(finish_date, init_date)) 'Ocupacion', (SELECT SUM(DATEDIFF(finish_date, init_date)) FROM reservations) 'Total'
								FROM reservations r
								INNER JOIN properties p ON
								p.id = r.property
								GROUP BY p.id
								ORDER BY p.id
							) X");
							$rows = array();
							while($row = $query->fetch_assoc()) {
								$rows[] = $row;
							}
							echo json_encode($rows);
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
					//
