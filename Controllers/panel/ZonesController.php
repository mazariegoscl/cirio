<?
namespace Controllers\Panel;
use Config\Validator\Validator;
use Config\Response\Response;
use Models\Panel\ZonesModel;
class ZonesController {
      private static $rules = array(
            "name" => "required",
            "status" => "required"
      );

      private static $rulesUpdate = array(
            "id" => "required",
            "name" => "required",
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
                  $zone = new \stdClass;
                  self::setData($zone, $request);
                  $zoneM = new ZonesModel;
                  $response = $zoneM::save($zone->name,
                  $zone->status, $date);
                  if($response) {
                        echo Response::response($response);
                  }else{
                        echo Response::error("No se pudo insertar la zona");
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
                  $zone = new \stdClass;
                  self::setData($zone, $request);
                  $zone->id = $request->id;
                  $zoneM = new ZonesModel;
                  $response = $zoneM::update($zone->id, $zone->name,
                  $zone->status, $date);
                  if($response) {
                        echo Response::success("Zona editada correctamente");
                  }else{
                        echo Response::error("No se pudo actualizar la zona");
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
                  $zoneM = new ZonesModel;
                  $response = $zoneM::delete($request->id);
                  if($response) {
                        echo Response::success("Zona eliminada correctamente");
                  }else{
                        echo Response::error("No se pudo eliminar la zona");
                  }
            }
      }

      public function get() {
            $zoneM = new ZonesModel;
            $response = $zoneM::get();
            if(!$response) {
                  echo Response::error("No se pudieron cargar las zonas");
            }else{
                  echo Response::response($response);
            }
      }

      private function setData(&$zone, $request) {
            $zone->name = $request->name;
            $zone->status = $request->status;
      }
}
