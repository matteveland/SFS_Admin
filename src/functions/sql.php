<?php
require('../../config/dbconfig.php');

function find_by_sql($mysqli)
{
    global $mysqli;
    $result = $mysqli->query("SELECT * From login l inner JOIN members m on l.lastName = m.lastName AND l.firstName = m.firstName AND l.dodId = m.dodId WHERE '" . $_SESSION['page_user'] . "' = user_name OR '" . $_SESSION['page_admin'] . "' = user_name");

    //$result_set = $mysqli->while_loop($result);
    return $result;
}
function find_all($table) {
    global $db;
    if ($table->existsInDatabase()) {
        echo "Yes, this table still exists in the session's schema.";


    }
}




