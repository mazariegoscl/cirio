<?
namespace Models\Panel;
use DB;
class ZonesModel extends DB\Database {

      public function save($name, $status, $date) {
            $query = self::$_db->query("CALL sp_insert_zone('$name','$status','$date')");
            self::$_db->next_result();
            if($query) {
                  $id = $query->fetch_array();
                  return $id["ID"];
            }else{
                  return false;
            }
      }

      public function update($id,$name, $status, $date) {
            $query = self::$_db->query("CALL sp_update_zone('$id','$name','$status','$date')");
            self::$_db->next_result();
            if($query) {
                  return true;
            }else{
                  return false;
            }
      }

      public function delete($id) {
            $query = self::$_db->query("CALL sp_delete_zone('$id')");
            if($query) {
                  return true;
            }else{
                  return false;
            }
      }

      public function get() {
            $query = self::$_db->query("CALL sp_get_zones()");
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
