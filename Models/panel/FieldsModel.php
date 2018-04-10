<?
namespace Models\Panel;
use DB;
class FieldsModel extends DB\Database {

      public function save($name_es, $name_en, $status, $date) {
            $name_es = htmlentities($name_es, ENT_QUOTES, "UTF-8");
            $name_en = htmlentities($name_en, ENT_QUOTES, "UTF-8");

            $query = self::$_db->query("CALL sp_insert_field('$name_es','$name_en','$status','$date')");
            self::$_db->next_result();
            if($query) {
                  $id = $query->fetch_assoc();
                  return $id["ID"];
            }else{
                  return false;
            }
      }

      public function get() {
            $query = self::$_db->query("CALL sp_get_fields()");
            self::$_db->next_result();
            if($query) {
                  $rows = array();
                  while($row = $query->fetch_assoc()) {
                        $row["name_es"] = html_entity_decode($row["name_es"]);
                        $row["name_en"] = html_entity_decode($row["name_en"]);
                        $rows[] = $row;
                  }
                  return $rows;
            }else{
                  return false;
            }
      }

      public function update($id,$name_es, $name_en, $status, $date) {
            $query = self::$_db->query("CALL sp_update_field('$id','$name_es','$name_en','$status','$date')");
            self::$_db->next_result();
            if($query) {
                  return true;
            }else{
                  return false;
            }
      }

      public function delete($id) {
            $query = self::$_db->query("CALL sp_delete_field('$id')");
            if($query) {
                  return true;
            }else{
                  return false;
            }
      }
}
