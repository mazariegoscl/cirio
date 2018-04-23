<?
namespace Controllers\Panel;
use Config\Validator\Validator;
use Config\Response\Response;
use Models\Panel\PropertyInventoryModel;
class PropertyInventoryController {
    private static $rules = array(
        "name" => "required",
        "quantity" => "required",
        "property" => "required"
    );

    private static $rulesUpdate = array(
        "id" => "required",
        "name" => "required",
        "quantity" => "required",
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
            $inventory = new \stdClass;
            self::setData($inventory, $request);
            $inventoryM = new PropertyInventoryModel;
            $response = $inventoryM::save($inventory->name,
            $inventory->quantity,
            $inventory->property,
            $date);
            if($response) {
                $inventory->id = $response;
                echo Response::response($inventory);
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
            $inventory = new \stdClass;
            self::setData($inventory, $request);
            $inventory->id = $request->id;
            $inventoryM = new PropertyInventoryModel;
            $response = $inventoryM::update($inventory->id,
            $inventory->name,
            $inventory->quantity,
            $inventory->property,
            $date);
            if($response) {
                echo Response::response($inventory);
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
            $inventoryM = new PropertyInventoryModel;
            $response = $inventoryM::delete($request->id);
            if($response) {
                echo Response::success("Propiedad eliminado correctamente");
            }else{
                echo Response::error("No se pudo eliminar la propiedad");
            }
        }
    }

    public function get() {
        $inventoryM = new PropertyInventoryModel;
        $response = $inventoryM::get();
        if(!$response) {
            echo Response::error("No se pudieron cargar los tipos de propiedades");
        }else{
            echo Response::response($response);
        }
    }

    public function getId() {
        $request = (object)$_REQUEST;
        $inventoryM = new PropertyInventoryModel;
        $validator = Validator::make(self::$rulesFind, $request);
        $response = $inventoryM::getId($request->property);
        if(!$response) {
            echo Response::error("No se pudieron cargar los tipos de propiedades");
        }else{
            echo Response::response($response);
        }
    }

    private function setData(&$inventory, $request) {
        $inventory->name = $request->name;
        $inventory->quantity = $request->quantity;
        $inventory->property = $request->property;
    }
}
