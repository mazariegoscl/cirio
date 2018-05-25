<?
namespace Controllers\Panel;
use Config\Validator\Validator;
use Config\Response\Response;
use Models\Panel\PropertiesModel;
class PropertiesController {
    private static $rules = array(
        "name" => "required",
        "rate" => "required|number",
        "rate_weekly" => 'required|number',
        "rate_monthly" => 'required|number'
    );

    private static $rulesUpdate = array(
        "id" => "required",
        "name" => "required",
        "rate" => "required",
        "rate_weekly" => 'required|number',
        "rate_monthly" => 'required|number'
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
            $property = new \stdClass;
            self::setData($property, $request);
            $propertyM = new PropertiesModel;
            $response = $propertyM::save($property->name,
            $property->rate,
            $property->rate_weekly,
            $property->rate_monthly,
            $date);
            if($response) {
                $property->id = $response;
                echo Response::response($property);
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
            $property = new \stdClass;
            self::setData($property, $request);
            $property->id = $request->id;
            $propertyM = new PropertiesModel;
            $response = $propertyM::update($property->id,
            $property->name,
            $property->rate,
            $property->rate_weekly,
            $property->rate_monthly,
            $date);
            if($response) {
                echo Response::response($property);
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
            $propertyM = new PropertiesModel;
            $response = $propertyM::delete($request->id);
            if($response) {
                echo Response::success("Propiedad eliminado correctamente");
            }else{
                echo Response::error("No se pudo eliminar la propiedad");
            }
        }
    }

    public function get() {
        $propertyM = new PropertiesModel;
        $response = $propertyM::get();
        if(!$response) {
            echo Response::error("No se pudieron cargar los tipos de propiedades");
        }else{
            echo Response::response($response);
        }
    }

    private function setData(&$property, $request) {
        $property->name = $request->name;
        $property->rate = $request->rate;
        $property->rate_weekly = $request->rate_weekly;
        $property->rate_monthly = $request->rate_monthly;
    }
    //
}
