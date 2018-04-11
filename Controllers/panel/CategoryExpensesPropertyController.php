<?
namespace Controllers\Panel;
use Config\Validator\Validator;
use Config\Response\Response;
use Models\Panel\CategoryExpensesPropertyModel;
class CategoryExpensesPropertyController {
    private static $rules = array(
        "expense" => "required",
        "property" => "required"
    );

    private static $rulesUpdate = array(
        "id" => "required",
        "expense" => "required",
        "property" => "required"
    );

    private static $rulesDelete = array(
        "id" => "required"
    );

    private static $rulesFind = array(
        "property" => "required"
    );

    public function save() {
        $request = (object)$_REQUEST;
        $validator = Validator::make(self::$rules, $request);
        $response = json_decode($validator);
        if(isset($response->error)) {
            echo $validator;
        }else{
            $date = date("Y-m-d");
            $category = new \stdClass;
            self::setData($category, $request);
            $categoryM = new CategoryExpensesPropertyModel;
            $response = $categoryM::save($category->expense,
            $category->property,
            $date);
            if($response) {
                $category->id = $response;
                echo Response::response($category);
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
            $category = new \stdClass;
            self::setData($category, $request);
            $category->id = $request->id;
            $categoryM = new CategoryExpensesPropertyModel;
            $response = $categoryM::update($category->id,
            $category->expense,
            $category->property,
            $date);
            if($response) {
                echo Response::response($category);
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
            $categoryM = new CategoryExpensesPropertyModel;
            $response = $categoryM::delete($request->id);
            if($response) {
                echo Response::success("Propiedad eliminado correctamente");
            }else{
                echo Response::error("No se pudo eliminar la propiedad");
            }
        }
    }

    public function get() {
        $categoryM = new CategoryExpensesPropertyModel;
        $response = $categoryM::get();
        if(!$response) {
            echo Response::error("No se pudieron cargar los tipos de propiedades");
        }else{
            echo Response::response($response);
        }
    }

    public function getId() {
        $request = (object)$_REQUEST;
        $categoryM = new CategoryExpensesPropertyModel;
        $validator = Validator::make(self::$rulesFind, $request);
        $response = $categoryM::getId($request->property);
        if(!$response) {
            echo Response::error("No se pudieron cargar los tipos de propiedades");
        }else{
            echo Response::response($response);
        }
    }

    public function getEP() {
        $request = (object)$_REQUEST;
        $categoryM = new CategoryExpensesPropertyModel;
        $validator = Validator::make(self::$rulesFind, $request);
        $response = $categoryM::getEP($request->property);
        if(!$response) {
            echo Response::error("EPO");
        }else{
            echo Response::response($response);
        }
    }

    private function setData(&$category, $request) {
        $category->expense = $request->expense;
        $category->property = $request->property;
    }
}
