<?
namespace Controllers\Panel;
use Config\Validator\Validator;
use Config\Response\Response;
use Models\Panel\ProjectsModel;
class ProjectsController {
	private static $rules = array(
		"name" => "required",
		"price" => "required|number",
		"description_es" => "required",
		"description_en" => "required",
		"property_type" => "required|number",
		"service_type" => "required|number",
		"zone" => "required|number",
		"photo" => "file",
		"status" => "required"
	);

	private static $rulesUpdate = array(
		"id" => "required",
		"name" => "required",
		"price" => "required|number",
		"description_es" => "required",
		"description_en" => "required",
		"property_type" => "required|number",
		"service_type" => "required|number",
		"zone" => "required|number",
		"key" => "key",
		"status" => "required"
	);

	private static $rulesVideos = array(
		"id_project" => "required"
	);

	public function save() {
		if(isset($_SESSION["username"])) {
			$request = $_REQUEST;
			$request += $_FILES;
			$request = (object)$request;
			$photo = (object)$request->photo;
			$validator = Validator::make(self::$rules, $request);
			$response = json_decode($validator);
			if(isset($response->error)) {
				echo $validator;
			}else{
				$date = date("Y-m-d");
				$project = new \stdClass;
				self::setData($project, $request);
				$projectM = new ProjectsModel;
				$key = rand(1111111111,9999999999);
				$date_dir = date("YmdHis");
				$generate_dir = "images/projects/" . $date_dir . "_" . $key;
				if(!mkdir($generate_dir, 0777, true)) {
					Response::error("Error al generar la carpeta");
				}else{
					if($photo->name == "") {
						//$photo_default = "default.png";
						$key = $date_dir . "_" . $key;
						$id = $projectM::save($project->name,
						$project->price,
						$project->description_es,
						$project->description_en,
						$photo->name,
						$project->property_type,
						$project->service_type,
						$project->zone,
						$key,
						$date,
						$project->status);
						$project->directory = $key;
						$project->id = $id;
						$project->notPhoto = true;
						echo Response::response($project);
					}else{
						$photoGenerate = basename(md5($key));
						$file_upload = $generate_dir . "/" . $photoGenerate;
						if (move_uploaded_file($photo->tmp_name, $file_upload)) {
							$key = $date_dir . "_" . $key;
							$id = $projectM::save($project->name,
							$project->price,
							$project->description_es,
							$project->description_en,
							$photoGenerate,
							$project->property_type,
							$project->service_type,
							$project->zone,
							$key,
							$date,
							$project->status);
							$project->directory = $key;
							$project->id = $id;
							$project->photoGenerate = $photoGenerate;
							echo Response::response($project);
						} else {
							Response::error("No se pudo guardar la imagen");
						}
					}
				}
			}
		}
	}

	public function update() {
		if(isset($_SESSION["username"])) {
			$request = $_REQUEST;
			$request += $_FILES;
			$request = (object)$request;
			$photo = (object)$request->photo;
			$validator = Validator::make(self::$rulesUpdate, $request);
			$response = json_decode($validator);
			if(isset($response->error)) {
				echo $validator;
			}else{
				$date = date("Y-m-d");
				$project = new \stdClass;
				self::setData($project, $request);
				$projectM = new ProjectsModel;
				$directory = $request->key;
				$key = rand(1111111111,9999999999);
				$date_dir = date("YmdHis");
				$generate_dir = "images/projects/" . $directory;
				//
				if(isset($request->photo_status) && $request->photo_status == "same") {
					$projectM::update($request->id,
					$project->name,
					$project->price,
					$project->description_es,
					$project->description_en,
					$request->photo,
					$project->property_type,
					$project->service_type,
					$project->zone,
					$request->key,
					$date,
					$project->status);
					$project->photoGenerate = $request->photo;
					$project->directory = $request->key;
					$project->id = $request->id;
					echo Response::response($project);
				}else{
					if(isset($photo->name) && $photo->name == "") {
						$photo = "";
					}else{
						$photo = $photo;
					}
					if($photo == "") {
						$key = $request->key;
						$id = $projectM::update($request->id,
						$project->name,
						$project->price,
						$project->description_es,
						$project->description_en,
						$photo,
						$project->property_type,
						$project->service_type,
						$project->zone,
						$key,
						$date,
						$project->status);
						$project->id = $request->id;
						$project->notPhoto = true;
						echo Response::response($project);
					}else{
						$photoGenerate = basename(md5($key));
						$file_upload = $generate_dir . "/" . $photoGenerate;
						if (move_uploaded_file($photo->tmp_name, $file_upload)) {
							$key = $request->key;
							$id = $projectM::update($request->id,
							$project->name,
							$project->price,
							$project->description_es,
							$project->description_en,
							$photoGenerate,
							$project->property_type,
							$project->service_type,
							$project->zone,
							$key,
							$date,
							$project->status);
							$project->directory = $key;
							$project->id = $request->id;
							$project->photoGenerate = $photoGenerate;
							echo Response::response($project);
						} else {
							echo Response::error("No se pudo guardar la imagen");
						}
					}
				}
			}
		}
	}

	public function saveVideos() {
		if(isset($_SESSION["username"])) {
			$request = $_REQUEST;
			$files = (object)$_FILES;
			$request = (object)$request;
			$validator = Validator::make(self::$rulesVideos, $request);
			$response = json_decode($validator);
			$date = date("Y-m-d");
			$projectM = new ProjectsModel;
			if(isset($response->error)) {
				echo $validator;
			}else{
				$image = array();
				foreach($files as $file) {
					$file = (object)$file;
					$count = count($file->name);
					for($i = 0; $i < $count; $i++) {
						$key = rand(1111111111,9999999999);
						$videoGenerate = basename(md5($key));
						$getExtension = explode(".", $file->name[$i]);
						$finishVideo = $videoGenerate . "."  . end($getExtension);
						$file_upload = "images/projects/" . $request->key_project . "/" . $finishVideo;
						if (move_uploaded_file($file->tmp_name[$i], $file_upload)) {
							$image[$i] = $projectM::saveVideo($finishVideo,
							$request->id_project, $date, 'active');
						} else {
							echo Response::error("No se pudo guardar el video");
						}
					}
				}
				echo Response::response($image);
			}
		}
	}

	public function saveImages() {
		if(isset($_SESSION["username"])) {
			$request = $_REQUEST;
			$files = (object)$_FILES;
			$request = (object)$request;
			$validator = Validator::make(self::$rulesVideos, $request);
			$response = json_decode($validator);
			$date = date("Y-m-d");
			$projectM = new ProjectsModel;
			if(isset($response->error)) {
				echo $validator;
			}else{
				$image = array();
				foreach($files as $file) {
					$file = (object)$file;
					$count = count($file->name);
					for($i = 0; $i < $count; $i++) {
						$key = rand(1111111111,9999999999);
						$videoGenerate = basename(md5($key));
						$file_upload = "images/projects/" . $request->key_project . "/" . $videoGenerate;
						if (move_uploaded_file($file->tmp_name[$i], $file_upload)) {
							$image[$i] = $projectM::saveImage($videoGenerate,
							$request->id_project, $date, 'active');
						} else {
							echo Response::error("No se pudo guardar la imagen");
						}
					}
				}
				echo Response::response($image);
			}
		}
	}

	public function deleteVideo() {
		if(isset($_SESSION["username"])) {
			$request = $_REQUEST;
			$request = (object)$request;
			$projectM = new ProjectsModel;
			$response = $projectM::deleteVideo($request->id);
			if(!$response) {
				echo Response::error("No se pudo eliminar el video");
			}else{
				echo Response::success("OK");
			}
		}
	}

	public function deleteImage() {
		if(isset($_SESSION["username"])) {
			$request = $_REQUEST;
			$request = (object)$request;
			$projectM = new ProjectsModel;
			$response = $projectM::deleteImage($request->id);
			if(!$response) {
				echo Response::error("No se pudo eliminar la imagen");
			}else{
				echo Response::success("OK");
			}
		}
	}

	public function get() {
		$projectM = new ProjectsModel;
		$response = $projectM::get();
		if(!$response) {
			echo Response::error("No se pudieron cargar los proyectos");
		}else{
			echo Response::response($response);
		}
	}

	public function getVideos() {
		if(isset($_SESSION["username"])) {
			$request = $_REQUEST;
			$request = (object)$request;
			$projectM = new ProjectsModel;
			$response = $projectM::getVideos($request->id);
			if(!$response) {
				echo Response::error("No se pudieron cargar los videos");
			}else{
				echo Response::response($response);
			}
		}
	}

	public function getGallery() {
		if(isset($_SESSION["username"])) {
			$request = $_REQUEST;
			$request = (object)$request;
			$projectM = new ProjectsModel;
			$response = $projectM::getGallery($request->id);
			if(!$response) {
				echo Response::error("No se pudieron cargar los proyectos");
			}else{
				echo Response::response($response);
			}
		}
	}

	public function delete() {
		if(isset($_SESSION["username"])) {
			$request = $_REQUEST;
			$request = (object)$request;
			$projectM = new ProjectsModel;
			$response = $projectM::delete($request->id);
			if(!$response) {
				echo Response::error("No se pudo eliminar el proyecto");
			}else{
				echo Response::success("OK");
			}
		}
	}

	private function setData(&$project, $request) {
		$project->name = $request->name;
		$project->price = $request->price;
		$project->description_es = $request->description_es;
		$project->description_en = $request->description_en;
		$project->photo = $request->photo;
		$project->property_type = $request->property_type;
		$project->service_type = $request->service_type;
		$project->zone = $request->zone;
		$project->status = $request->status;
	}
}
