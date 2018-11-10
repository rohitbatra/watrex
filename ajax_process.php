<?php
require_once("includes/functions.php");
//print_r($_POST);die();
if(isset($_POST)){

    switch($_POST['mdl_action']){

        case 'split':

                // TODO: Pending Discussion

            break;

        case 'reflow':

                /*
                    -> Archive the Record
                    -> Update the Record Arrive BHLD Date
                */
            Functions::archiveRecord($_POST['mdl_ord_id']);
            $ret = Functions::updateOrder(array('ord_id' => $_POST['mdl_ord_id'], 'arrive_date' => $_POST['mdl_arrive_date']));
//var_dump($ret);
            if(!empty($_POST['mdl_ord_comments'])){
                Functions::updateOrder(array('ord_id' => $_POST['mdl_ord_id'], 'ord_comments' => $_POST['mdl_ord_comments']));
            }
            break;

        case 'shipped':

                /*
                    -> Archive the Record
                    -> Update the Order Status as 'SHIPPED'
                */
            Functions::archiveRecord($_POST['mdl_ord_id']);
            $ret = Functions::updateOrder(array('ord_id' => $_POST['mdl_ord_id'], 'ord_status' => $_POST['mdl_ord_status']));
//var_dump($ret);
            if(!empty($_POST['mdl_ord_comments'])){
                Functions::updateOrder(array('ord_id' => $_POST['mdl_ord_id'], 'ord_comments' => $_POST['mdl_ord_comments']));
            }
            break;
    }

    print json_encode(array('status' => '1'));

}
