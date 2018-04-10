<?
namespace Models\Panel;
use DB;
class ServicesModel extends DB\Database {

      public function save($name_es, $name_en, $status, $date) {
            $query = self::$_db->query("CALL sp_insert_service('$name_es','$name_en','$status','$date')");
            self::$_db->next_result();
            if($query) {
                  $id = $query->fetch_array();
                  return $id["ID"];
            }else{
                  return false;
            }
      }

      public function update($id,$name_es, $name_en, $status, $date) {
            $query = self::$_db->query("CALL sp_update_service('$id','$name_es','$name_en','$status','$date')");
            self::$_db->next_result();
            if($query) {
                  return true;
            }else{
                  return false;
            }
      }

      public function delete($id) {
            $query = self::$_db->query("CALL sp_delete_service('$id')");
            if($query) {
                  return true;
            }else{
                  return false;
            }
      }

      public function get() {
            $query = self::$_db->query("CALL sp_get_services()");
            self::$_db->next_result();
            if($query) {
                  $rows = array();
                  while($row = $query->fetch_assoc()) {
                        $rows[] = $row;
                  }
                  return $rows;
            }else{
                  return false;
            }
      }
}
