<?php

print("\n <br/> In Cron Execution... \n <br/>");

// Default Includes file
require_once("includes/functions.php");

// IBM DB2 Wrapper Loaded
require_once("includes/class.DB2.php");

$sql = trim(file_get_contents(AppParms::BASE_DIR.AppParms::SQL_FILE));

$result_set = $db2Database->query($sql);

$resultArr = $db2Database->fetch_all_array_assoc($result_set);

$db2Database->close_connection();

$resultCount = count($resultArr);

// Store the RAW Result Array into MySQL DB
$jsonData = json_encode($resultArr);
$sql_insert = "INSERT into `".DbConfig::DB_NAME.".raw_dump` (`data`,`records_count`) VALUES ('{$jsonData}','{$resultCount}')";
$database->query($sql_insert);

if($resultCount > 0) {
    // Process the Results & Transform into there respective Tables in MySQL
    foreach ($resultArr as $record){

        // SQL Check for the PO Number if exists then don't add the Order Record
        $sql_check = "SELECT `ord_id` FROM `".DbConfig::DB_NAME.".orders` WHERE `po_number` = '{$record['BHLDN_PO#']}'";
        $database->query($sql_check);
        if($database->affected_rows() < 1){
            $sql_insert = "INSERT into `".DbConfig::DB_NAME.".orders` 
                            (
                            `po_number`,`order_number`,`style`,`color_pattern`,`arrive_date`,
                            `lot_number`,`items_in_lot`,`items_in_order`,`exit_date`,
                            `factory_id`,`unit_price`,`extended_cost`,`comment_fld`
                            ) 
                            VALUES 
                            (
                            '".$database->escape_value($record['BHLDN_PO#'])."','".$database->escape_value($record['ORDER#'])."','".$database->escape_value($record['STYLE#'])."','".$database->escape_value($record['COLOR_DESC'])."','".date('Y-m-d',strtotime($record['ARRIVE_BHLDN']))."',
                            '".$database->escape_value($record['LOT#'])."','".(int) $database->escape_value($record['TOTAL_PCS_IN_LOT'])."','".(int) $database->escape_value($record['TOTAL_PCS_IN_ORDER'])."','".date('Y-m-d',strtotime($record['XHK_DATE']))."',
                            '".$database->escape_value($record['FACTORY'])."','".$database->escape_value($record['UNIT_PRICE'])."','".$database->escape_value($record['EXTENDED_COST'])."','".$database->escape_value($record['COMMENT'])."'
                            )";

            $database->query($sql_insert);
        }
    }

}

die("\n <br/> Cron Ends!!! ");