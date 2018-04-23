<?
namespace Models\Panel;
use DB;
class ProjectFieldsModel extends DB\Database {

      public function save($id_field, $id_project, $value) {
            $query = self::$_db->query("CALL sp_insert_project_field('$id_field','$id_project','$value')");
            if($query) {
                  return true;
            }else{
                  return false;
            }
      }

      public function update($id,$id_project, $id_field, $value, $date) {
            $query = self::$_db->query("CALL sp_update_project_field('$id','$id_project','$id_field','$value','$date')");
            self::$_db->next_result();
            if($query) {
                  return true;
            }else{
                  return false;
            }
      }

      public function delete($id) {
            $query = self::$_db->query("CALL sp_delete_project_field('$id')");
            if($query) {
                  return true;
            }else{
                  return false;
            }
      }

      public function get($id, $param) {
            $query = self::$_db->query("CALL sp_get_project_fields('$id','$param')");
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
}
