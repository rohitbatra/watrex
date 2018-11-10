<?php

// Constants File Loaded
require_once("constants.php");

// Initialize MySQL Database Engine
require_once("class.Mysqli.php");

// Set Timezone & Base Directory
date_default_timezone_set(AppParams::SERVER_TIMEZONE);
set_include_path(AppParams::BASE_DIR);


class Functions
{

    public static function getDataFromDb($filter_data){
        global $db;
        $retArr = array();

        $sqlStr = "";

        // ORDER STATUS
        if(isset($filter_data['ord_status']) && !empty($filter_data['ord_status'])){
            if(strtoupper(trim($filter_data['ord_status'])) == 'ALL'){
                $sqlStr .= " WHERE 1 ";
            }else{
                $sqlStr .= " WHERE `ord_status` LIKE '".strtoupper(trim($filter_data['ord_status']))."'";
            }
        }else{
            $sqlStr .= " WHERE `ord_status` LIKE 'PENDING'";
        }

        // FROM DATE & TO DATE
        if(isset($filter_data['from_date']) && !empty($filter_data['from_date']) && isset($filter_data['to_date']) && !empty($filter_data['to_date'])){
            $sqlStr .= " AND DATE_FORMAT(`arrive_date`, '%m/%d/%Y') BETWEEN '".($filter_data['from_date'])."' AND  '".($filter_data['to_date'])."' ";
        }

        $sql_data = "SELECT * FROM orders {$sqlStr} ";
        //print_r($sql_data);
        $result_set = $db->query($sql_data);

        if($db->affected_rows() > 0){
            while ($row = $db->fetch_array_assoc($result_set)) {
                $retArr[] = $row;
            }
        }
        return $retArr;
    }


    public static function archiveRecord($recordId){
        global $db;

        $sql = "INSERT into order_archive (`ord_id`, `ref_id`, `po_number`,`order_number`,`style`,`color_pattern`,`arrive_date`,`lot_number`,`items_in_lot`,`items_in_order`,`exit_date`,`factory_id`,`unit_price`,`extended_cost`,`comment_fld`,`ord_status`,`ord_comments`, `dataTime`)
                SELECT`ord_id`, `ref_id`, `po_number`,`order_number`,`style`,`color_pattern`,`arrive_date`,`lot_number`,`items_in_lot`,`items_in_order`,`exit_date`,`factory_id`,`unit_price`,`extended_cost`,`comment_fld`,`ord_status`,`ord_comments`, `dataTime`
                FROM orders
                WHERE ord_id = '{$recordId}' ";
        $db->query($sql);
        return $db->affected_rows();

    }


    public static function updateOrder($data){
        global $db;

        foreach($data as $key => $value){
            if($key !== 'ord_id'){
                // SQL to UPDATE
                $sql_update = "UPDATE orders SET `".$key."` = '".$db->escape_value($value)."' WHERE ord_id = '{$data['ord_id']}' ";
                $db->query($sql_update);
                return $db->affected_rows();
            }
        }

    }


}