<?
namespace Controllers\Panel;
use Config\Validator\Validator;
use Config\Response\Response;
use Models\Panel\HomeModel;
use Models\Panel\UsersModel;
use Models\Panel\ZonesModel;
use Models\Panel\PropertiesModel;
use Models\Panel\ServicesModel;
use Models\Panel\ProjectsModel;
class HomeController {
	static $config;
	static $base;

	public function setConfig() {
		self::$config = $config = parse_ini_file("Config/config.ini", true);
	}

	public function home() {
		if(isset($_SESSION["username"])) {
			self::setConfig();
			self::$base = self::$config["server"]["directory"];
			require_once("Views/panel/home.php");
		}else{
			require_once("Views/panel/index.php");
		}
	}

	public function settings() {
		if(isset($_SESSION["username"])) {
			self::setConfig();
			self::$base = self::$config["server"]["directory"];
			require_once("Views/panel/settings.php");
		}else{
			require_once("Views/panel/index.php");
		}
	}

	public function fields() {
		if(isset($_SESSION["username"])) {
			self::setConfig();
			self::$base = self::$config["server"]["directory"];
			require_once("Views/panel/fields.php");
		}else{
			require_once("Views/panel/index.php");
		}
	}

	public function customFields() {
		if(isset($_SESSION["username"])) {
			self::setConfig();
			self::$base = self::$config["server"]["directory"];
			require_once("Views/panel/customFields.php");
		}else{
			require_once("Views/panel/index.php");
		}
	}

	public function login() {
		$rules = array(
			"email" => "required",
			"pass" => "required"
		);
		$request = (object)$_REQUEST;
		$validator = Validator::make($rules, $request);
		$response = json_decode($validator);
		if(isset($response->error)) {
			echo $validator;
		}else{
			$users = new \stdClass;
			self::setData($users, $request);
			$usersM = new HomeModel;
			$response = $usersM::login($users->email, $users->pass);

			if(!$response) {
				echo Response::error(["data" => ["attention" => "Tus datos de acceso son incorrectos"]]);

			}else{
				foreach($response as $data) {
					$_SESSION["username"]["name"] = $data["name"];
					$_SESSION["username"]["email"] = $data["email"];
					echo Response::success("OK");
				}
			}
		}
	}

	public function logout() {
		if(isset($_SESSION["username"])) {
			session_destroy();
			header("Location: ../panel");
		}
	}

	private function setData(&$users, $request) {
		$users->email = $request->email;
		$users->pass = $request->pass;
	}
}
