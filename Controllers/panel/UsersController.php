<?
namespace Controllers\Panel;
namespace Controllers\Panel;
use Config\Validator\Validator;
use Config\Response\Response;
use Models\Panel\UsersModel;
class UsersController {
    private static $rules = array(
        "name" => "required",
        "email" => "required",
        "pass" => "required",
        "role" => "required"
    );

    public function home() {
    }

    public function add() {
        $request = (object)$_REQUEST;
        $validator = Validator::make(self::$rules, $request);
        $response = json_decode($validator);
        if(isset($response->error)) {
            echo $validator;
        }else{
            $users = new \stdClass;
            self::setData($users, $request);
            $usersM = new UsersModel;
            $verify = $usersM::verify($users->email);
            if($verify) {
                Response::error(array("usuario" => "El usuario ya existe"));
                //Response::response($usersM::get(''));
                //Response::response($usersM::get(''));
            }else{
                $save = $usersM::save($users);
                if($save) {
                    Response::success(array("usuario" => "Usuario agregado correctamente"));
                }
            }
        }
    }
}
