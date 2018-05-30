<?
namespace Models\Panel;
use DB;
class ExpensesPropertiesModel extends DB\Database {

    public function save($id_property, $expense_property, $quantity, $date) {
        $rows = array();
        $query = self::$_db->query("INSERT INTO expenses_properties (expense_property, quantity, date) VALUES ('$expense_property', '$quantity', '$date')");
        $query2 = self::$_db->query("SELECT LAST_INSERT_ID() AS ID");
        /*if($query2) {
            $id = $query2->fetch_assoc();
            return $id["ID"];
        }else{
            return false;
        }*/

         $iid = $query2->fetch_assoc();
         $rows["id_enviado"] = $iid["ID"];
        $query0 = self::$_db->query("SELECT * FROM properties WHERE id = '$id_property'");
        $fetch = $query0->fetch_assoc();
            $property = $fetch["id"];
            $rows["property"]["name"] = $fetch["name"];
            $rows["property"]["id"] = $fetch["id"];


        $u = 0;
        $query = self::$_db->query("SELECT SUM(IFNULL(ep.quantity, 0)) AS quantity,
        etp.id,
        et.name as name_expense,
        p.name,
        p.id AS id_property
        FROM expenses_type_properties etp
        LEFT JOIN expenses_properties ep ON ep.expense_property = etp.id
        INNER JOIN expenses_type et ON et.id = etp.expense
        INNER JOIN properties p ON p.id = etp.property
        WHERE etp.property = '$id_property'
        GROUP BY et.id");
        while($row = $query->fetch_assoc()) {
            $rows["expenses"][$u] = $row;
            $u++;
        }
        return $rows;
    }

    public function update($id, $id_property, $expense_property, $quantity, $date) {
        $rows = array();
        $query = self::$_db->query("UPDATE expenses_properties SET expense_property='$expense_property', quantity='$quantity', date='$date' WHERE id='$id'");

        $query0 = self::$_db->query("SELECT * FROM properties WHERE id = '$id_property'");
        $fetch = $query0->fetch_assoc();
            $property = $fetch["id"];
            $rows["property"]["name"] = $fetch["name"];
            $rows["property"]["id"] = $fetch["id"];


        $u = 0;
        $query = self::$_db->query("SELECT SUM(IFNULL(ep.quantity, 0)) AS quantity,
        etp.id,
        et.name as name_expense,
        p.name,
        p.id AS id_property
        FROM expenses_type_properties etp
        LEFT JOIN expenses_properties ep ON ep.expense_property = etp.id
        INNER JOIN expenses_type et ON et.id = etp.expense
        INNER JOIN properties p ON p.id = etp.property
        WHERE etp.property = '$id_property'
        GROUP BY et.id");
        while($row = $query->fetch_assoc()) {
            $rows["expenses"][$u] = $row;
            $u++;
        }
        return $rows;

    }

    public function delete($id_property, $id) {
        $query = self::$_db->query("DELETE FROM expenses_properties WHERE id='$id'");
        /*if($query) {
            return true;
        }else{
            return false;
        }*/

        $rows = array();


        $query0 = self::$_db->query("SELECT * FROM properties WHERE id = '$id_property'");
        $fetch = $query0->fetch_assoc();
            $property = $fetch["id"];
            $rows["property"]["name"] = $fetch["name"];
            $rows["property"]["id"] = $fetch["id"];


        $u = 0;
        $query = self::$_db->query("SELECT SUM(IFNULL(ep.quantity, 0)) AS quantity,
        etp.id,
        et.name as name_expense,
        p.name,
        p.id AS id_property
        FROM expenses_type_properties etp
        LEFT JOIN expenses_properties ep ON ep.expense_property = etp.id
        INNER JOIN expenses_type et ON et.id = etp.expense
        INNER JOIN properties p ON p.id = etp.property
        WHERE etp.property = '$id_property'
        GROUP BY et.id");
        while($row = $query->fetch_assoc()) {
            $rows["expenses"][$u] = $row;
            $u++;
        }
        return $rows;
    }

    public function get() {
        $query = self::$_db->query("SELECT * FROM expenses_properties");
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

    public function getExpense($property) {
        $query = self::$_db->query("SELECT * FROM expenses_properties WHERE expense_property = '$property'");
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

    public function getExpenseDates($property, $init_date, $finish_date) {
        $query = self::$_db->query("SELECT * FROM expenses_properties WHERE expense_property = '$property' AND DATE(date) BETWEEN '$init_date' AND '$finish_date'");
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

    public function getProperty($property) {
        $rows = array();
        $query0 = self::$_db->query("SELECT * FROM properties");
        $i = 0;
        while($fetch = $query0->fetch_assoc()) {
            $u = 0;
            $property = $fetch["id"];
            $rows[$i]["property"]["name"] = $fetch["name"];
            $rows[$i]["property"]["id"] = $fetch["id"];
            $query = self::$_db->query("SELECT p.id 'id_property', p.name, et.name 'name_expense', IFNULL(SUM(ep.quantity), 0) 'quantity'
FROM properties p
LEFT JOIN expenses_type et ON
    1 = 1
LEFT JOIN expenses_type_properties etp ON
    etp.property = p.id
    AND etp.expense = et.id
LEFT JOIN expenses_properties ep ON
    ep.expense_property = etp.id
WHERE p.id = '$property'
GROUP BY p.id, et.id
ORDER BY p.id, et.id");
            while($row = $query->fetch_assoc()) {
                $rows[$i]["expenses"][$u] = $row;
                $u++;
            }
            $i++;

        }
        return $rows;
    }

    public function getPropertyDates($property, $init_date, $finish_date) {
        $rows = array();
        $query0 = self::$_db->query("SELECT * FROM properties");
        $i = 0;
        while($fetch = $query0->fetch_assoc()) {
            $u = 0;
            $property = $fetch["id"];
            $rows[$i]["property"]["name"] = $fetch["name"];
            $rows[$i]["property"]["id"] = $fetch["id"];
            $query = self::$_db->query("SELECT p.id 'id_property', p.name, et.name 'name_expense', IFNULL(SUM(ep.quantity), 0) 'quantity'
FROM properties p
LEFT JOIN expenses_type et ON
    1 = 1
LEFT JOIN expenses_type_properties etp ON
    etp.property = p.id
    AND etp.expense = et.id
LEFT JOIN expenses_properties ep ON
    ep.expense_property = etp.id
    AND DATE(ep.date) BETWEEN '$init_date' AND '$finish_date'
WHERE p.id = '$property'
GROUP BY p.id, et.id
ORDER BY p.id, et.id");
            while($row = $query->fetch_assoc()) {
                $rows[$i]["expenses"][$u] = $row;
                $u++;
            }
            $i++;

        }
        return $rows;
    }
}
