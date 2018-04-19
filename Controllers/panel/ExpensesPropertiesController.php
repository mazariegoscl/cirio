<?
namespace Controllers\Panel;
use Config\Validator\Validator;
use Config\Response\Response;
use Models\Panel\ExpensesPropertiesModel;
class ExpensesPropertiesController {
    private static $rules = array(
        "id_property" => "required",
        "expense_property" => "required",
        "quantity" => "required"
    );

    private static $rulesUpdate = array(
        "id" => "required",
        "id_property" => "required",
        "expense_property" => "required",
        "quantity" => "required"
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
            $expense = new \stdClass;
            self::setData($expense, $request);
            $expenseM = new ExpensesPropertiesModel;
            $response = $expenseM::save($expense->id_property, $expense->expense_property,
            $expense->quantity,
            $date);
            if($response) {
                $expense->id = $response["id_enviado"];
                $response["expense"] = $expense;
                $expense->date = $date;
                echo Response::response($response);
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
            $expense = new \stdClass;
            self::setData($expense, $request);
            $expense->id = $request->id;
            $expenseM = new ExpensesPropertiesModel;
            $response = $expenseM::update($expense->id,
            $expense->id_property,
            $expense->expense_property,
            $expense->quantity,
            $date);
            if($response) {
                $expense->date = $date;
                $response["expense"] = $expense;
                echo Response::response($response);
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
            $expenseM = new ExpensesPropertiesModel;
            $response = $expenseM::delete($request->id_property, $request->id);
            if($response) {
                echo Response::response($response);
            }else{
                echo Response::error("No se pudo actualizar la propiedad");
            }
        }
    }

    public function get() {
        $expenseM = new ExpensesPropertiesModel;
        $response = $expenseM::get();
        if(!$response) {
            echo Response::error("No se pudieron cargar los tipos de propiedades");
        }else{
            echo Response::response($response);
        }
    }

    public function getProperty() {
        $request = (object)$_REQUEST;
        $expenseM = new ExpensesPropertiesModel;
        $response = $expenseM::getProperty($request->property);
        if(!$response) {
            echo Response::error("No se pudieron cargar los tipos de propiedades");
        }else{
            echo Response::response($response);
        }
    }

    public function getId() {
        $request = (object)$_REQUEST;
        $expenseM = new ExpensesPropertiesModel;
        $response = $expenseM::getExpense($request->property);
        if(!$response) {
            echo Response::error("No se pudieron cargar los tipos de propiedades");
        }else{
            echo Response::response($response);
        }
    }

    private function setData(&$expense, $request) {
        $expense->id_property = $request->id_property;
        $expense->expense_property = $request->expense_property;
        $expense->quantity = $request->quantity;
    }
}
