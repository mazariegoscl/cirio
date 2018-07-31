<?
namespace Controllers\Panel;
namespace Controllers\Panel;
use Config\Validator\Validator;
use Config\Response\Response;
use Models\Panel\UsersModel;
class UsersController {
    private static $rules = array(
        "user" => "required",
        "pass" => "required"
    );

    private static $rulesRPassword = array(
        "oldPassword" => "required",
        "newPassword" => "required",
        "rNewPassword" => "required"
    );

    public function login() {
        $request = (object)$_REQUEST;
        $validator = Validator::make(self::$rules, $request);
        $response = json_decode($validator);
        if(isset($response->error)) {
            echo $validator;
        }else{
            $users = new \stdClass;
            self::setDataLogin($users, $request);
            $usersM = new UsersModel;
            $login = $usersM::login($users->user, $users->pass);
            if($login) {
                echo Response::success(array("response" => "ok"));
            } else {

                echo Response::error(array("usuario" => "Hubo un error al iniciar sesión"));
            }
        }
    }

    public function resetPassword() {
        $request = (object)$_REQUEST;
        $validator = Validator::make(self::$rulesRPassword, $request);
        $response = json_decode($validator);
        if(isset($response->error)) {
            echo $validator;
        }else{
            $users = new \stdClass;
            self::setData($users, $request);
            $usersM = new UsersModel;
            $save = $usersM::resetPassword($_SESSION["username"]["user"], $users->oldPassword, $users->newPassword, $users->rNewPassword);
            if($save) {
                echo Response::success(array("usuario" => "Usuario agregado correctamente"));
            } else {
                echo Response::error(array("usuario" => "Hubo un error al cambiar tu contraseña"));
            }
        }
    }

    public function logout() {
        session_start();
        session_destroy();
        header("Location: ../login");
    }

    private function setDataLogin(&$users, $request) {
        $users->user = $request->user;
        $users->pass = $request->pass;
    }

    private function setData(&$users, $request) {
        $users->oldPassword = $request->oldPassword;
        $users->newPassword = $request->newPassword;
        $users->rNewPassword = $request->rNewPassword;
    }
}
