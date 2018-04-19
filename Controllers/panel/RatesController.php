<?
namespace Controllers\Panel;
use Config\Validator\Validator;
use Config\Response\Response;
use Models\Panel\RatesModel;
class RatesController {
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
            $rateM = new RatesModel;
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
            $rateM = new RatesModel;
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
            $rateM = new RatesModel;
            $response = $rateM::delete($request->id);
            if($response) {
                echo Response::success("Propiedad eliminado correctamente");
            }else{
                echo Response::error("No se pudo eliminar la propiedad");
            }
        }
    }

    public function get() {
        $rateM = new RatesModel;
        $response = $rateM::get();
        if(!$response) {
            echo Response::error("No se pudieron cargar los tipos de propiedades");
        }else{
            echo Response::response($response);
        }
    }

    public function getProperty() {
        $request = (object)$_REQUEST;
        $rateM = new RatesModel;
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
