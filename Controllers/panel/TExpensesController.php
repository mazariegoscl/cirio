<?
namespace Controllers\Panel;
use Config\Validator\Validator;
use Config\Response\Response;
use Models\Panel\TExpensesModel;
class TExpensesController {
    private static $rules = array(
        "name" => "required",
    );

    private static $rulesUpdate = array(
        "id" => "required",
        "name" => "required",
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
            $tExpenses = new \stdClass;
            self::setData($tExpenses, $request);
            $tExpensesM = new TExpensesModel;
            $response = $tExpensesM::save($tExpenses->name,
            $date);
            if($response) {
                $tExpenses->id = $response;
                echo Response::response($tExpenses);
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
            $tExpenses = new \stdClass;
            self::setData($tExpenses, $request);
            $tExpenses->id = $request->id;
            $tExpensesM = new TExpensesModel;
            $response = $tExpensesM::update($tExpenses->id,
            $tExpenses->name,
            $date);
            if($response) {
                echo Response::response($tExpenses);
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
            $tExpensesM = new TExpensesModel;
            $response = $tExpensesM::delete($request->id);
            if($response) {
                echo Response::success("Propiedad eliminado correctamente");
            }else{
                echo Response::error("No se pudo eliminar la propiedad");
            }
        }
    }

    public function get() {
        $tExpensesM = new TExpensesModel;
        $response = $tExpensesM::get();
        if(!$response) {
            echo Response::error("No se pudieron cargar los tipos de propiedades");
        }else{
            echo Response::response($response);
        }
    }

    private function setData(&$tExpenses, $request) {
        $tExpenses->name = $request->name;
    }
}
