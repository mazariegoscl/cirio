<?
namespace Controllers\Panel;
use Config\Validator\Validator;
use Config\Response\Response;
use Models\Panel\ServicesModel;
class ServicesController {
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
                  $service = new \stdClass;
                  self::setData($service, $request);
                  $serviceM = new ServicesModel;
                  $response = $serviceM::save($service->name_es,
                  $service->name_en,
                  $service->status,
                  $date);
                  if($response) {
                        echo Response::response($response);
                  }else{
                        echo Response::error("No se pudo insertar el tipo de servicio");
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
                  $service = new \stdClass;
                  self::setData($service, $request);
                  $service->id = $request->id;
                  $serviceM = new ServicesModel;
                  $response = $serviceM::update($service->id,
                  $service->name_es,
                  $service->name_en,
                  $service->status,
                  $date);
                  if($response) {
                        echo Response::success("Servicio editado correctamente");
                  }else{
                        echo Response::error("No se pudo actualizar el servicio");
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
                  $serviceM = new ServicesModel;
                  $response = $serviceM::delete($request->id);
                  if($response) {
                        echo Response::success("Servicio eliminado correctamente");
                  }else{
                        echo Response::error("No se pudo eliminar el servicio");
                  }
            }
      }

      public function get() {
            $servicesM = new ServicesModel;
            $response = $servicesM::get();
            if(!$response) {
                  echo Response::error("No se pudieron cargar los tipos de servicios");
            }else{
                  echo Response::response($response);
            }
      }

      private function setData(&$service, $request) {
            $service->name_es = $request->name_es;
            $service->name_en = $request->name_en;
            $service->status = $request->status;
      }
}
