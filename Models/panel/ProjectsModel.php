<?
namespace Models\Panel;
use DB;
class ProjectsModel extends DB\Database {

      public function clean_url($text) {
            $text = html_entity_decode($text, ENT_QUOTES, 'UTF-8');
            $patron = array (
                  // Espacios, puntos y comas por guion
                  '/[., ()%]+/' => '-',

                  // Vocales
                  '/à/' => 'a',
                  '/è/' => 'e',
                  '/ì/' => 'i',
                  '/ò/' => 'o',
                  '/ù/' => 'u',

                  '/á/' => 'a',
                  '/é/' => 'e',
                  '/í/' => 'i',
                  '/ó/' => 'o',
                  '/ú/' => 'u',

                  '/Á/' => 'A',
                  '/É/' => 'E',
                  '/Í/' => 'I',
                  '/Ó/' => 'O',
                  '/Ú/' => 'U',

                  '/â/' => 'a',
                  '/ê/' => 'e',
                  '/î/' => 'i',
                  '/ô/' => 'o',
                  '/û/' => 'u',

                  '/ã/' => 'a',
                  '/&etilde;/' => 'e',
                  '/&itilde;/' => 'i',
                  '/õ/' => 'o',
                  '/&utilde;/' => 'u',

                  '/ä/' => 'a',
                  '/ë/' => 'e',
                  '/ï/' => 'i',
                  '/ö/' => 'o',
                  '/ü/' => 'u',

                  '/ä/' => 'a',
                  '/ë/' => 'e',
                  '/ï/' => 'i',
                  '/ö/' => 'o',
                  '/ü/' => 'u',

                  // Otras letras y caracteres especiales
                  '/å/' => 'a',
                  '/ñ/' => 'n',
                  '/Ñ/' => 'N',
            );

            $text = preg_replace(array_keys($patron),array_values($patron),$text);
            $text = strtolower($text);
            return $text;
      }

      public function save($name, $price, $description_es, $description_en, $photo, $property_type, $service_type, $zone, $key, $date, $status) {
            $query = self::$_db->query("CALL sp_insert_project('$name','$price','$description_es','$description_en','$photo','$property_type','$service_type','$zone','$key','$date','$status')");
            self::$_db->next_result();
            if($query) {
                  $id = $query->fetch_array();
                  return $id["ID"];
            }else{
                  return false;
            }
      }

      public function update($id, $name, $price, $description_es, $description_en, $photo, $property_type, $service_type, $zone, $key, $date, $status) {
            $query = self::$_db->query("CALL sp_update_project('$id','$name','$price','$description_es','$description_en','$photo','$property_type','$service_type','$zone','$key','$date','$status')");
            self::$_db->next_result();
            if($query) {
                  return true;
            }else{
                  return false;
            }
      }

      public function get() {
            $query = self::$_db->query("CALL sp_get_projects()");
            self::$_db->next_result();
            if($query) {
                  $rows = array();
                  while($row = $query->fetch_assoc()) {
                        $row["url"] = self::clean_url($row["id"] . "/" . $row["name"]);
                        $rows[] = $row;
                  }
                  return $rows;
            }else{
                  return false;
            }
      }

      public function getProjectsLimit() {
            $query = self::$_db->query("CALL sp_get_projectsLimit()");
            self::$_db->next_result();
            if($query) {
                  $rows = array();
                  while($row = $query->fetch_assoc()) {
                        $row["url"] = self::clean_url($row["id"] . "/" . $row["name"]);
                        $rows[] = $row;
                  }
                  return $rows;
            }else{
                  return false;
            }
      }

      public function getProject($id) {
            $query = "CALL sp_get_project('$id')";
            if (self::$_db->multi_query($query)) {
                  $data = array();
                  $images_number = 0;
                  $videos_number = 0;
                  $fields_number = 0;
                  do {
                        if ($result = self::$_db->store_result()) {
                              while ($row = $result->fetch_assoc()) {
                                    $keys = array_keys($row);

                                    if(in_array("isProject", $keys)) {
                                          $data["project"] = $row;
                                          $data["project"]["project_name"] = html_entity_decode($row["project_name"]);
                                          $data["project"]["project_d_es"] = html_entity_decode($row["project_d_es"]);
                                          $data["project"]["project_d_en"] = html_entity_decode($row["project_d_en"]);
                                          $data["project"]["pt_name_es"] = html_entity_decode($row["pt_name_es"]);
                                          $data["project"]["pt_name_en"] = html_entity_decode($row["pt_name_en"]);
                                          $data["project"]["st_name_es"] = html_entity_decode($row["st_name_es"]);
                                          $data["project"]["st_name_en"] = html_entity_decode($row["st_name_en"]);
                                          $data["project"]["project_price"] = number_format($row["project_price"], 2);
                                    }

                                    if(in_array("isImages", $keys)) {
                                          $data["images"][$images_number] = $row;
                                          $images_number++;
                                    }

                                    if(in_array("isVideos", $keys)) {
                                          $data["videos"][$videos_number] = $row;
                                          $videos_number++;
                                    }

                                    if(in_array("isFields", $keys)) {
                                          $data["fields"][$fields_number] = $row;
                                          $data["fields"][$fields_number]["fields_name_es"] = html_entity_decode($row["fields_name_es"]);
                                          $data["fields"][$fields_number]["fields_name_en"] = html_entity_decode($row["fields_name_en"]);
                                          $fields_number++;
                                    }
                              }
                              $result->free();
                        }
                  } while (self::$_db->next_result());
            }
            return $data;
      }

      public function saveVideo($video, $project, $date, $status) {
            $query = self::$_db->query("CALL sp_insert_video('$video','$project','$date','$status')");
            self::$_db->next_result();
            if($query) {
                  $rows;
                  while($row = $query->fetch_assoc()) {
                        $rows = $row;
                  }
                  return $rows;
            }else{
                  return false;
            }
      }

      public function saveImage($image, $project, $date, $status) {
            $query = self::$_db->query("CALL sp_insert_image('$image','$project','$date','$status')");
            self::$_db->next_result();
            if($query) {
                  $rows;
                  while($row = $query->fetch_assoc()) {
                        $rows = $row;
                  }
                  return $rows;
            }else{
                  return false;
            }
      }

      public function getVideos($id) {
            $query = self::$_db->query("CALL sp_get_videos('$id')");
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

      public function getGallery($id) {
            $query = self::$_db->query("CALL sp_get_galleries('$id')");
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

      public function deleteImage($id) {
            $query = self::$_db->query("CALL sp_delete_image('$id')");
            if($query) {
                  return true;
            }else{
                  return false;
            }
      }

      public function deleteVideo($id) {
            $query = self::$_db->query("CALL sp_delete_video('$id')");
            if($query) {
                  return true;
            }else{
                  return false;
            }
      }

      public function delete($id) {
            $query = self::$_db->query("CALL sp_delete_project('$id')");
            if($query) {
                  return true;
            }else{
                  return false;
            }
      }
}
