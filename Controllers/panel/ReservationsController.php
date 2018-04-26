<?
namespace Controllers\Panel;
use Config\Validator\Validator;
use Config\Response\Response;
use Models\Panel\ReservationsModel;
class ReservationsController {
    private static $rules = array(
        "property" => "required|number",
        "customer" => "required",
        "init_date" => "required",
        "finish_date" => "required",
        "rate" => "required|number",
        "deposit_entry" => "required",
        "deposit_exit" => "required",
        "commissions" => "required",
        "rate_amount" => "required",
        "total" => "total"
    );

    private static $rulesUpdate = array(
        "id" => "required",
        "property" => "required|number",
        "customer" => "required",
        "init_date" => "required",
        "finish_date" => "required",
        "rate" => "required|number",
        "deposit_entry" => "required",
        "deposit_exit" => "required",
        "commissions" => "required",
        "rate_amount" => "required",
        "total" => "total"
    );

    private static $rulesDelete = array(
        "id" => "required"
    );

    private static $rulesFind = array(
        "first_date" => "required",
        "second_date" => "required",
        "property" => "required"
    );

    public function save() {
        $request = (object)$_REQUEST;
        $validator = Validator::make(self::$rules, $request);
        $response = json_decode($validator);
        if(isset($response->error)) {
            echo $validator;
        }else{
            $date = date("Y-m-d");
            $reservation = new \stdClass;
            self::setData($reservation, $request);
            $reservationM = new ReservationsModel;
            $response = $reservationM::save($reservation->property,
            $reservation->customer,
            $reservation->init_date,
            $reservation->finish_date,
            $reservation->rate,
            $reservation->rate_amount,
            $reservation->deposit_entry,
            $reservation->deposit_exit,
            $reservation->disccount,
            $reservation->commissions,
            $reservation->total,
            $date);
            if($response) {
                $reservation->id = $response;
                echo Response::response($reservation);
            }else{
                echo Response::error("No se pudo insertar el tipo de propiedad");
            }
        }
    }

    public function update() {
        parse_str(file_get_contents("php://input"),$post_vars);
        $request = (object)$post_vars;
        $validator = Validator::make(self::$rulesUpdate, $request);
        $response = json_decode($validator);
        if(isset($response->error)) {
            echo $validator;
        }else{
            $date = date("Y-m-d");
            $reservation = new \stdClass;
            self::setData($reservation, $request);
            $reservation->id = $request->id;
            $reservationM = new ReservationsModel;
            $response = $reservationM::update($reservation->id, $reservation->property,
            $reservation->customer,
            $reservation->init_date,
            $reservation->finish_date,
            $reservation->rate,
            $reservation->rate_amount,
            $reservation->deposit_entry,
            $reservation->deposit_exit,
            $reservation->disccount,
            $reservation->commissions,
            $reservation->total,
            $date);
            if($response) {
                echo Response::response($reservation);
            }else{
                echo Response::error("No se pudo actualizar la reservación");
            }
        }
    }

    public function delete() {
        parse_str(file_get_contents("php://input"),$post_vars);
        $request = (object)$post_vars;
        $validator = Validator::make(self::$rulesDelete, $request);
        $response = json_decode($validator);
        if(isset($response->error)) {
            echo $validator;
        }else{
            $reservationM = new ReservationsModel;
            $response = $reservationM::delete($request->id);
            if($response) {
                echo Response::success("Reservación eliminada correctamente");
            }else{
                echo Response::error("No se pudo eliminar la reservación");
            }
        }
    }

    public function get() {
        $reservationM = new ReservationsModel;
        $response = $reservationM::get();
        if(!$response) {
            echo Response::error("No se pudieron cargar los tipos de propiedades");
        }else{
            echo Response::response($response);
        }
    }

    public function getBetweenDates() {
        $request = (object)$_REQUEST;
        $validator = Validator::make(self::$rulesFind, $request);
        $response = json_decode($validator);
        if(isset($response->error)) {
            echo $validator;
        }else{
            $reservationM = new ReservationsModel;
            $response = $reservationM::getBetweenDates($request->first_date, $request->second_date, $request->property);
            if(!$response) {
                echo var_dump($response);
                echo Response::error("No se pudieron cargar los tipos de propiedades");
            }else{
                if($response === 2) {
                    echo Response::error("No hay propiedades disponibles con ese filtro");
                } else {
                    echo Response::response($response);
                }
            }
        }
    }

    private function setData(&$reservation, $request) {
        $reservation->property = $request->property;
        $reservation->customer = $request->customer;
        $reservation->init_date = $request->init_date;
        $reservation->finish_date = $request->finish_date;
        $reservation->rate = $request->rate;
        $reservation->rate_amount = $request->rate_amount;
        $reservation->deposit_entry = $request->deposit_entry;
        $reservation->deposit_exit = $request->deposit_exit;
        $reservation->disccount = $request->disccount;
        $reservation->total = $request->total;
        $reservation->commissions = $request->commissions;
    }
}
