<?
namespace Controllers\Panel;
use Config\Validator\Validator;
use Config\Response\Response;
use Models\Panel\FieldsModel;
class FieldsController {
      private static $rules = array(
            "name_es" => "required",
            "name_en" => "required",
            "status" => "required"
      );

      private static $rulesUpdate = array(
            "id" => "required",
            "name_es" => "required",
            "name_en" => "required",
            "status" => "required"
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
                  $field = new \stdClass;
                  self::setData($field, $request);
                  $fieldM = new FieldsModel;
                  $response = $fieldM::save($field->name_es,
                  $field->name_en,
                  $field->status,
                  $date);
                  if($response) {
                        echo Response::response($response);
                  }else{
                        echo Response::error("No se pudo insertar el campo");
                  }
            }
      }

      public function update() {
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
                  $fieldM = new FieldsModel;
                  $response = $fieldM::update($field->id,
                  $field->name_es,
                  $field->name_en,
                  $field->status,
                  $date);
                  if($response) {
                        echo Response::success("Campo editado correctamente");
                  }else{
                        echo Response::error("No se pudo actualizar el campo");
                  }
            }
      }

      public function delete() {
            $request = (object)$_REQUEST;
            $validator = Validator::make(self::$rulesDelete, $request);
            $response = json_decode($validator);
            if(isset($response->error)) {
                  echo $validator;
            }else{
                  $fieldM = new FieldsModel;
                  $response = $fieldM::delete($request->id);
                  if($response) {
                        echo Response::success("Campo eliminado correctamente");
                  }else{
                        echo Response::error("No se pudo eliminar el campo");
                  }
            }
      }

      public function get() {
		$fieldM = new FieldsModel;
		$response = $fieldM::get();
		if(!$response) {
			echo Response::error("No se pudieron cargar los campos");
		}else{
			echo Response::response($response);
		}
	}

      private function setData(&$field, $request) {
            $field->name_es = $request->name_es;
            $field->name_en = $request->name_en;
            $field->status = $request->status;
      }
}
