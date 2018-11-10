<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
require_once('includes/functions.php');
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" href="https://www.watters.com/assets/favicon/apple-touch-icon-60x60.png">
    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="assets/css/jquery-ui.min.css">
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/DataTables/datatables.min.css">

    <!-- Custom styles for this template -->
    <style>
        body {
            font-size: .800rem;
        }

        .feather {
            width: 16px;
            height: 16px;
            vertical-align: text-bottom;
        }

        .sidebar {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 100; /* Behind the navbar */
            padding: 28px 0 0; /* Height of navbar */
            box-shadow: inset -1px 0 0 rgba(0, 0, 0, .1);
        }

        .sidebar-sticky {
            position: relative;
            top: 0;
            height: calc(100vh - 48px);
            padding-top: .5rem;
            overflow-x: hidden;
            overflow-y: auto; /* Scrollable contents if viewport is shorter than content. */
        }

        @supports ((position: -webkit-sticky) or (position: sticky)) {
            .sidebar-sticky {
                position: -webkit-sticky;
                position: sticky;
            }
        }

        .sidebar .nav-link {
            font-weight: 500;
            color: #333;
        }

        .sidebar .nav-link {
            margin-right: 4px;
            color: #999;
        }

        .sidebar .nav-link.active {
            color: #007bff;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            color: inherit;
        }

        [role="main"] {
            padding-top: 40px; /* Space for fixed navbar */
        }

    </style>
    <title>Dashboard | WATREX</title>
</head>
<body>
<nav class="navbar navbar-dark bg-dark flex-md-nowrap p-0 shadow">
    <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="javascript:void(1)"><img src="//www.watters.com/assets/img/icons/watters.svg" alt="watters-logo"></a>
    <ul class="navbar-nav px-3">
        <li class="nav-item text-nowrap">
            <a class="nav-link" href="javascript:void(1);" id="btn_refresh_data">Refresh Data</a>
        </li>
        <li class="nav-item text-nowrap">
            <a class="nav-link" href="logout.php">Sign out</a>
        </li>
    </ul>
</nav>
<div class="container-fluid">
    <div class="row">
        <main role="main" class="col-md-12">
            <div class="form-control">
                <form>
                    <div class="row">
                        <div class="col">
                            <label>Arrive BHLDN Date From:</label> <input type="text" id="from_date" name="from_date" class="w-auto form-control" placeholder="Select From Date" />
                        </div>
                        <div class="col">
                            <label>Arrive BHLDN Date To:</label> <input type="text" id="to_date" name="to_date" class="w-auto form-control" placeholder="Select To Date" />
                        </div>
                        <div class="col">
                            <label>Status:</label>
                            <select id="ord_status" class="form-control w-auto">
                                <option value="ALL">All</option>
                                <option value="PENDING">Pending</option>
                                <option value="SHIPPED">Shipped</option>
                                <!-- <option value="CANCELLED">Cancelled</option>
                                <option value="PARTIAL">Partially Shipped</option> -->
                            </select>
                        </div>
                        <div class="col">
                            <label></label>
                            <input type="button" id="btn_search" class="btn btn-outline-primary form-control" value="Filter" />
                        </div>
                        <div class="col">
                            <label></label>
                            <input type="button" id="btn_reset" class="btn btn-outline-danger form-control" value="Reset" />
                        </div>
                    </div>
                </form>
            </div>
            <img src="assets/images/prealoader.gif" class="rounded mx-auto d-block" id="tbl_preloader" style="display: none !important;" />
            <br/>

            <div class="table-responsive" id="data_table_view">
                <table id="data_table_tbl" class="table table-striped table-bordered" style="font-size:11px;">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>BHLDN PO</th>
                        <th>Order Number</th>
                        <th>Style</th>
                        <th>Color Pattern</th>
                        <th>Arrive BHLDN Date</th>
                        <th>Lot Number</th>
                        <!-- <th>Items in Lot</th> -->
                        <th>Items in Order</th>
                        <th>Exit HK Date</th>
                        <th>Factory Ref</th>
                        <th>Unit Price</th>
                        <th>Extended Cost</th>
                        <th>AS400 Comments</th>
                        <th>Order Status</th>
                        <th>Order Comments</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $dataArr = Functions::getDataFromDb($_GET);
                    //print_r($dataArr);exit;
                    if(!empty($dataArr)){
                        foreach($dataArr as $row){
                            echo "    <tr>
                                    <td><a href='javascript:void(1);' data-id='{$row['ord_id']}' id='order_".$row['ord_id']."' name='order_".$row['ord_id']."' class='editBtn' >✏</a></td>
                                    <td>".$row['po_number']."</td>
                                    <td>".$row['order_number']."</td>
                                    <td>".$row['style']."</td>
                                    <td>".$row['color_pattern']."</td>
                                    <td>".date('m/d/Y',strtotime($row['arrive_date']))."</td>
                                    <td>".$row['lot_number']."</td>
                                    <!-- <td>".$row['items_in_lot']."</td> -->
                                    <td>".$row['items_in_order']."</td>
                                    <td>".date('m/d/Y',strtotime($row['exit_date']))."</td>
                                    <td>".$row['factory_id']."</td>
                                    <td>".number_format($row['unit_price'],2)."</td>
                                    <td>".number_format($row['extended_cost'],2)."</td>
                                    <td>".$row['comment_fld']."</td>
                                    <td>".$row['ord_status']."</td>
                                    <td>".$row['ord_comments']."</td>
                                  </tr>";
                        }
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </main>

        <!-- Large modal -->
        <div id="mdl" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Order Action(s)</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="mdl_form">
                        <input type="hidden" name="mdl_ord_id" id="mdl_ord_id" value=""/>
                        <input type="hidden" name="mdl_action" id="mdl_action" value=""/>
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#div_shipped" role="tab">Shipped</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#div_split" role="tab">Split PO</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#div_reflow" role="tab">Re-Flow</a>
                            </li>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div class="tab-pane active tbp" id="div_shipped" role="tabpanel">
                                <div class="form-group">
                                    <label for="mdl_ord_status">Status</label>
                                    <select name="mdl_ord_status" id="mdl_ord_status" class="w-auto form-control">
                                        <option value="SHIPPED">Shipped</option>
                                    </select>
                                </div>
                            </div>
                            <div class="tab-pane tbp" id="div_split" role="tabpanel">
                                <div class="form-group">
                                    Splitting ORDER
                                </div>
                            </div>
                            <div class="tab-pane tbp" id="div_reflow" role="tabpanel">
                                <div class="form-group">
                                    <label for="mdl_arrive_date"> New Arrive BHLDN Date:</label>
                                    <input type="text" id="mdl_arrive_date" name="mdl_arrive_date" class="w-auto form-control" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Additional Comments</label>
                                <textarea name="mdl_ord_comments" id="mdl_ord_comments" class="form-control"></textarea>
                            </div>
                        </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="btn_save">Save changes</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/jquery-ui.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/DataTables/datatables.js"></script>
<script>
    $(document).ready(function () {

        var d = new Date();
        var strDate = d.getFullYear() + "-" + (d.getMonth()+1) + "-" + d.getDate();

        $('#data_table_tbl').DataTable({
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'excelHtml5',
                    title: 'BHLDN_Orders_Report_xls_'+strDate,
                    exportOptions: {
                        stripHtml: true
                    }
                },
                {
                    extend: 'pdfHtml5',
                    orientation: 'landscape',
                    pageSize: 'LEGAL',
                    title: 'BHLDN_Orders_Report_pdf_'+strDate,
                    exportOptions: {
                        stripHtml: true
                    }
                }
            ],
            /*responsive: true,*/
            ordering: false,
            "language": {
                "zeroRecords": "No Records Found!"
            }
        });

        var dateFormat = "mm/dd/yy",
            from = $("#from_date")
                .datepicker({
                    changeMonth: true,
                    changeYear: true,
                    dateFormat: "mm/dd/yy",
                    minDate: 0
                }).on( "change", function() {
                    to.datepicker( "option", "minDate", getDate( this ) );
                }),
            to = $("#to_date").datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: "mm/dd/yy",
                minDate: 0
            }).on( "change", function() {
                from.datepicker( "option", "maxDate", getDate( this ) );
            });

        $('#btn_search').on('click', function(e){
            e.preventDefault();
            e.stopPropagation();
            $(e.currentTarget).attr('disabled','disabled');
            $('#from_date').attr('disabled','disabled');
            $('#to_date').attr('disabled','disabled');
            $('#ord_status').attr('disabled','disabled');
            $('#data_table_view').remove();
            $('#tbl_preloader').show();

            // Change URL as per Params selected
            var url = 'dashboard.php?tc=1';

            var filter_date_start = $("#from_date").val();

            if (filter_date_start) {
                url += '&from_date=' + (filter_date_start);
            }

            var filter_date_end = $("#to_date").val();

            if (filter_date_end) {
                url += '&to_date=' + (filter_date_end);
            }

            var filter_status = $('#ord_status option:selected').val();

            if (filter_status) {
                url += '&ord_status=' + (filter_status);
            }

            setTimeout(
                function() {
                    window.location.href = url;
                }, 2500);

        });

        $('.dt-buttons').addClass('float-sm-right');
        $('#data_table_tbl_filter').addClass('float-sm-left');
        $('#data_table_tbl_paginate').addClass('float-sm-right');
        $('#tbl_preloader').hide();

        // GET From URL
        <?php if (isset($_GET['from_date']) && !empty($_GET['from_date'])) { ?>
        $("#from_date").datepicker("setDate", "<?php echo $_GET['from_date']; ?>");
        <?php } ?>

        <?php if (isset($_GET['to_date']) && !empty($_GET['to_date'])) { ?>
        $("#to_date").datepicker("setDate", "<?php echo $_GET['to_date']; ?>");
        <?php } ?>

        <?php if (isset($_GET['ord_status']) && !empty($_GET['ord_status'])) { ?>
        $('#ord_status').val("<?php echo (trim($_GET['ord_status'])); ?>");
        <?php } else { ?>
        $('#ord_status').val('PENDING');
        <?php } ?>

        function getDate( element ) {
            var date;
            try {
                date = $.datepicker.parseDate( dateFormat, element.value );
            } catch( error ) {
                date = null;
            }
            return date;
        }

        $('#btn_reset').on('click', function(e){
            e.stopPropagation();
            e.preventDefault();
            $(e.currentTarget).attr('disabled','disabled');
            $('#from_date').attr('disabled','disabled');
            $('#to_date').attr('disabled','disabled');
            $('#ord_status').attr('disabled','disabled');
            $('#data_table_view').remove();
            $('#tbl_preloader').show();

            // Change URL as per Params selected
            var url = 'dashboard.php';
            setTimeout(
                function() {
                    window.location.href = url;
                }, 2500);

        });

        $("#mdl_arrive_date").datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: "mm/dd/yy",
            minDate: 0
        });

        // Trigger Modal Programmatically
        $('.editBtn').on('click', function(e){
            e.preventDefault();
            e.stopPropagation();
            var recordId = $(e.currentTarget).attr('data-id');

            $('#mdl_ord_id').val('').val(recordId);

            // Open the Modal
            $('#mdl').modal('show');

        });

        $('#btn_save').on('click', function(e){
            e.stopPropagation();
            e.preventDefault();
            $('#btn_save').attr('disabled','disabled');

            // Check which Tab is active & set the value accordingly
            $(".tbp").each(function() {
                //console.log($(this));
                var classList = $(this).attr("class");
                //console.log(classList);
                if(classList.indexOf("active") >= 0){
                    var IdStr = $(this).attr('id').split('_');
                    //console.log(IdStr);
                    $('#mdl_action').val(IdStr[1]);
                }
            });

            //console.log($('#mdl_action').val());exit;
            var formData = $('#mdl_form').serialize();
            $.ajax({
                type: "POST",
                url: "ajax_process.php",
                dataType : 'json',
                data: formData,
                async: false,
                success: function(data) {
                    //console.log(data);
                    if (data.status) {
                        window.location.reload();
                    }else{
                        alert(data.response);
                    }
                }
            });

            $('#mdl').modal('hide');
        });

        $('#btn_refresh_data').on('click',function(e){
            e.stopPropagation();
            e.preventDefault();
            alert('Refreshing Data...');
        });

    });

</script>
</body>
</html>
