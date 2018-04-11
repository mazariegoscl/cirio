<?
require_once "database/mysql.php";
require_once "Config/validator.php";
require_once "Config/response.php";
require_once "Config/lang.php";

// MODELS
require_once "Models/panel/UsersModel.php";
require_once "Models/panel/HomeModel.php";
require_once "Models/panel/ProjectsModel.php";
require_once "Models/panel/PropertiesModel.php";
require_once "Models/panel/ServicesModel.php";
require_once "Models/panel/ZonesModel.php";
require_once "Models/panel/FieldsModel.php";
require_once "Models/panel/ProjectFieldsModel.php";
require_once "Models/panel/ReservationsModel.php";
require_once "Models/panel/TExpensesModel.php";
require_once "Models/panel/InventoryModel.php";
require_once "Models/panel/PropertyInventoryModel.php";
require_once "Models/panel/CategoryExpensesPropertyModel.php";

// CONTROLLERS
// require_once "Controllers/page/PageController.php";
require_once "Controllers/panel/HomeController.php";
require_once "Controllers/panel/UsersController.php";
require_once "Controllers/panel/ProjectsController.php";
require_once "Controllers/panel/PropertiesController.php";
require_once "Controllers/panel/ServicesController.php";
require_once "Controllers/panel/ZonesController.php";
require_once "Controllers/panel/FieldsController.php";
require_once "Controllers/panel/ProjectFieldsController.php";
require_once "Controllers/panel/ReservationsController.php";
require_once "Controllers/panel/TExpensesController.php";
require_once "Controllers/panel/InventoryController.php";
require_once "Controllers/panel/PropertyInventoryController.php";
require_once "Controllers/panel/CategoryExpensesPropertyController.php";
