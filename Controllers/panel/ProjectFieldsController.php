<?
namespace Controllers\Panel;
use Config\Validator\Validator;
use Config\Response\Response;
use Models\Panel\ProjectFieldsModel;
class ProjectFieldsController {
      private static $rules = array(
            "id_project" => "required",
            "id_field" => "required",
            "value" => "required"
      );

      private static $rulesUpdate = array(
            "id" => "required",
            "id_project" => "required",
            "id_field" => "required",
            "value" => "required"
      );

      private static $rulesDelete = array(
            "id" => "required"
      );

      public function save() {
            if(isset($_SESSION["username"])) {
            $request = (object)$_REQUEST;
            $date = date("Y-m-d");
            $field = new \stdClass;
            $fieldM = new ProjectFieldsModel;
            $fields = (object)$request->fields;
            foreach($fields as $field) {
                  $field = (object)$field;
                  $response = $fieldM::save($field->id,
                        $request->id_project,
                        $field->value
                  );
            }

            echo Response::success("OK");
      }
      }

      public function update() {
            if(isset($_SESSION["username"])) {
            $request = (object)$_REQUEST;
            $validator = Validator::make(self::$rulesUpdate, $request);
            $response = json_decode($validator);
            if(isset($response->error)) {
                  echo $validator;
            }else{
                  $date = date("Y-m-d");
                  $field = new \stdClass;
                  self::setData($field, $request);
                  $field->id = $request->id;
                  $fieldM = new ProjectFieldsModel;
                  $response = $fieldM::update($field->id,
                  $field->id_project,
                  $field->id_field,
                  $field->value,
                  $date);
                  if($response) {
                        echo Response::success("Campo editado correctamente");
                  }else{
                        echo Response::error("No se pudo actualizar el campo");
                  }
            }
      }
      }

      public function delete() {
            if(isset($_SESSION["username"])) {
            $request = (object)$_REQUEST;
            $validator = Validator::make(self::$rulesDelete, $request);
            $response = json_decode($validator);
            if(isset($response->error)) {
                  echo $validator;
            }else{
                  $fieldM = new ProjectFieldsModel;
                  $response = $fieldM::delete($request->id);
                  if($response) {
                        echo Response::success("Campo eliminado correctamente");
                  }else{
                        echo Response::error("No se pudo eliminar el campo");
                  }
            }
      }
      }

      public function get() {
            if(isset($_SESSION["username"])) {
            $request = (object)$_REQUEST;
            $fieldM = new ProjectFieldsModel;
            $response = $fieldM::get($request->id, $request->param);
            if(!$response) {
                  echo Response::error("No se pudieron cargar los campos");
            }else{
                  echo Response::response($response);
            }
      }
      }

      private function setData(&$field, $request) {
            $field->id_project = $request->id_project;
            $field->id_field = $request->id_field;
            $field->value = $request->value;
      }
}
