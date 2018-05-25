<?
namespace Controllers\Panel;
use Config\Validator\Validator;
use Config\Response\Response;
use Models\Panel\HelperModel;
class HelperController {
    private static $rules = array(
        "property" => "required",
        "rate" => "required",
        "rate_weekly" => "required",
        "rate_monthly" => "required",
        "init_date" => "required",
        "finish_date" => "required"
    );

    private static $rulesUpdate = array(
        "id" => "required",
        "property" => "required",
        "rate" => "required",
        "rate_weekly" => "required",
        "rate_monthly" => "required",
        "init_date" => "required",
        "finish_date" => "required"
    );

    private static $rulesDelete = array(
        "id" => "required"
    );

    public function calcRatesReservation() {
        $request = (object)$_REQUEST;
        $rateM = new HelperModel;
        $response = $rateM::calcRatesReservation($request->property,
        $request->init_date,
        $request->finish_date,
        $request->rate);
        if($response){
            echo Response::response($response);
        }
    }

    public function calcDisccount() {
        $request = (object)$_REQUEST;
        if($request->rate != "" && $request->disccount != "") {
            if($request->rate > 0 && $request->rate > 0) {
                echo ($request->rate - $request->disccount);
            }
        }
    }

    public function calcReports() {
        $rateM = new HelperModel;
        $response = $rateM::calcReports();
    }

    public function listaVentas() {
        $rateM = new HelperModel;
        $response = $rateM::listaVentas();
    }

    public function listaVentasFechas() {
    	$request = (object)$_REQUEST;
        $rateM = new HelperModel;
        $response = $rateM::listaVentasFechas($request->fechaInicial, $request->fechaFinal);
    }

    public function dashBoard() {
        $rateM = new HelperModel;
        $response = $rateM::dashBoard();
    }

    public function dashBoardFechas() {
    	$request = (object)$_REQUEST;
        $rateM = new HelperModel;
        $response = $rateM::dashBoardFechas($request->fechaInicial, $request->fechaFinal);
    }

    public function dashBoardDates() {
      $request = (object)$_REQUEST;

        $rateM = new HelperModel;
        $response = $rateM::dashBoardDates($request->init_date, $request->finish_date);
    }

    public function porcentajeOcupacion() {
        $rateM = new HelperModel;
        $response = $rateM::porcentajeOcupacion();
    }

    public function listaComisiones() {
      $rateM = new HelperModel;
      $response = $rateM::listaComisiones();
    }

    public function listaComisionesFechas() {
      $request = (object)$_REQUEST;

        $rateM = new HelperModel;
        $response = $rateM::listaComisionesFechas($request->fechaInicial, $request->fechaFinal);
    }

    public function save() {
        $request = (object)$_REQUEST;
        $validator = Validator::make(self::$rules, $request);
        $response = json_decode($validator);
        if(isset($response->error)) {
            echo $validator;
        }else{
            $date = date("Y-m-d");
            $rate = new \stdClass;
            self::setData($rate, $request);
            $rateM = new HelperModel;
            $response = $rateM::save($rate->property,
            $rate->rate,
            $rate->rate_weekly,
            $rate->rate_monthly,
            $rate->init_date,
            $rate->finish_date,
            $date);
            if($response) {
                $rate->id = $response;
                echo Response::response($rate);
            }else{
                echo Response::error("No se pudo insertar el tipo de propiedad");
            }
        }
    }

    public function update() {
        parse_str(file_get_contents("php://input"),$post_vars);
        $request = (object)$post_vars;
        $validator = Validator::make(self::$rulesUpdate, $request);
        $response = json_decode($validator);
        if(isset($response->error)) {
            echo $validator;
        }else{
            $date = date("Y-m-d");
            $rate = new \stdClass;
            self::setData($rate, $request);
            $rate->id = $request->id;
            $rateM = new HelperModel;
            $response = $rateM::update($rate->id,
            $rate->property,
            $rate->rate,
            $rate->rate_weekly,
            $rate->rate_monthly,
            $rate->init_date,
            $rate->finish_date,
            $date);
            if($response) {
                echo Response::response($rate);
            }else{
                echo Response::error("No se pudo actualizar la propiedad");
            }
        }
    }

    public function delete() {
        parse_str(file_get_contents("php://input"),$post_vars);
        $request = (object)$post_vars;
        $validator = Validator::make(self::$rulesDelete, $request);
        $response = json_decode($validator);
        if(isset($response->error)) {
            echo $validator;
        }else{
            $rateM = new HelperModel;
            $response = $rateM::delete($request->id);
            if($response) {
                echo Response::success("Propiedad eliminado correctamente");
            }else{
                echo Response::error("No se pudo eliminar la propiedad");
            }
        }
    }

    public function get() {
        $rateM = new HelperModel;
        $response = $rateM::get();
        if(!$response) {
            echo Response::error("No se pudieron cargar los tipos de propiedades");
        }else{
            echo Response::response($response);
        }
    }

    public function getProperty() {
        $request = (object)$_REQUEST;
        $rateM = new HelperModel;
        $response = $rateM::getProperty($request->property);
        if(!$response) {
            echo Response::error("No se pudieron cargar los tipos de propiedades");
        }else{
            echo Response::response($response);
        }
    }

    private function setData(&$rate, $request) {
        $rate->property = $request->property;
        $rate->rate = $request->rate;
        $rate->rate_weekly = $request->rate_weekly;
        $rate->rate_monthly = $request->rate_monthly;
        $rate->init_date = $request->init_date;
        $rate->finish_date = $request->finish_date;
    }
}
