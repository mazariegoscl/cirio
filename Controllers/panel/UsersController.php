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

    private static $rulesRPassword = array(
        "oldPassword" => "required",
        "newPassword" => "required",
        "rNewPassword" => "required"
    );

    public function home() {
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
            $save = $usersM::resetPassword($_SESSION["username"]["email"], $users->newPassword);
            if($save) {
                Response::success(array("usuario" => "Usuario agregado correctamente"));
            } else {
                Response::error(array("usuario" => "Hubo un error al cambiar tu contraseña"));
            }
        }
    }

    private function setData(&$users, $request) {
        $users->oldPassword = $request->oldPassword;
        $users->newPassword = $request->newPassword;
        $users->rNewPassword = $request->rNewPassword;
    }
}
