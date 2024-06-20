<style>
    table {
        border-collapse: collapse;
    }

    table,
    td,
    th {
        border: 1px solid #dddddd;
        padding: 6px;
        font-size: 14px;
    }

    th {
        text-align: center;
    }

    tr:hover {
        background-color: #f5f5f5;
    }
</style>
<script>
    function printDiv() {

        var divToPrint = document.getElementById('divToPrint');
        var WindowObject = window.open('', 'Print-Window');
        WindowObject.document.open();
        WindowObject.document.writeln('<!DOCTYPE html>');
        WindowObject.document.writeln(
            '<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8"><title></title><style type="text/css">'
            );
        WindowObject.document.writeln('@media print { .center { text-align: center;}' +
            '                                         .inline { display: inline; }' +
            '                                         .underline { text-decoration: underline; }' +
            '                                         .left { margin-left: 315px;} ' +
            '                                         .right { margin-right: 375px; display: inline; }' +
            '                                          table { border-collapse: collapse; font-size: 12px;}' +
            '                                          th, td { border: 1px solid black; border-collapse: collapse; padding: 6px;}' +
            '                                           th, td { }' +
            '                                         .border { border: 1px solid black; } ' +
            '                                         .bottom { bottom: 5px; width: 100%; position: fixed ' +
            '                                       ' +
            '                                   } } </style>');
        WindowObject.document.writeln('</head><body onload="window.print()">');
        WindowObject.document.writeln(divToPrint.innerHTML);
        WindowObject.document.writeln('</body></html>');
        WindowObject.document.close();
        setTimeout(function () {
            WindowObject.close();
        }, 10);
    }
</script>

<div class="wraper">

    <div class="col-lg-12 container contant-wraper">
        <div id="divToPrint">

            <div style="text-align:center;">
                <h2>THE WEST BENGAL STATE CO.OP.MARKETING FEDERATION LTD.</h2>
                <h4>HEAD OFFICE: SOUTHEND CONCLAVE, 3RD FLOOR, 1582 RAJDANGA MAIN ROAD, KOLKATA-700107.</h4>
                <h4>Ledger Name: <?=$accdetail->ac_name?></h4>
                <h4>Ledger Code: <?=$accdetail->benfed_ac_code?></h4>
                <h4>Account Detail: <?php echo $_SESSION['date']; ?></h4>
                <h5 style="text-align:left"><label>District: </label>
                    <?php echo $this->session->userdata['loggedin']['branch_name']; ?></h5>
            </div>
            <br>

            <table style="width: 100%;" id="example">
                <thead>
                    <tr>
                        <th rowspan='2'>Date</th>
                        <th rowspan='2'>Particulars</th>
                        <th rowspan='2'>Vch Type</th>
                        <th rowspan='2'>Narration</th>
                        <th rowspan='2'>Vch No</th>
                        <th colspan='2'>Trancation</th>
                    </tr>
                    <tr>
                        <th>Debit</th>
                        <th>Credit</th>
                    </tr>

                </thead>

                <tbody>

                    <?php
                                if($accdetail){
									
                                    $i = 1;
                                    $total = 0.00;$ope_bal = 0.00;$cls_bal = 0.00;$opdr=0.00;$opcr=0.00;
									$tot_debit = 0.00;$tot_cre =0.00;
                                    $val =0;
									$type =0;
									
								    if($opebalcal){
										$opdr =$opebalcal->dr_amt;
										$opcr =$opebalcal->cr_amt;
										if($opebalcal->type == 1 || $opebalcal->type == 4){
									       $ope_bal = $ope_bal+$opcr-$opdr;
											//echo $ope_bal ;
											//$ope_bal = $opcr + $opdr;
										}else if($opebalcal->type == 2 || $opebalcal->type == 3){
										$ope_bal = $ope_bal+$opdr-$opcr;
											//$ope_bal = $opcr + $opdr;
										}
									}
                                    
							        ?>
                    <tr class="rep">
                        <td></td>
                        <td colspan="4">Opening Balance</td>
                        <td align="right"><?php   if($opebalcal->trans_flag=='DR'){
                                            echo abs($ope_bal);
                                            }else{
                                                echo "";
                                            }?>
                        </td>
                        <td align="right">
                            <?php   if($opebalcal->trans_flag=='CR'){
                                            echo abs($ope_bal);
                                            }else{
                                                echo "";
                                            
                                            }?>
                        </td>
                    </tr>
                    <?php   foreach($trail_balnce as $tb){
                                           $type = $tb->type;
								   ?>
                    <tr class="rep">

                        <td><?php echo date('d-m-Y',strtotime($tb->voucher_date)); ?></td>
                        <td><?php echo $tb->ac_name; ?></td>
                        <td><?php if($tb->voucher_type == 'PUR'){echo 'Purchase Voucher'; } 
                                            elseif($tb->voucher_type == 'SL'){ echo 'Sale  Voucher'; }
                                            elseif($tb->voucher_type == 'A'){ echo 'Advance  Voucher'; }
                                            elseif($tb->voucher_type == 'P'){ echo 'Paymwent  Voucher'; }
                                            elseif($tb->voucher_type == 'R'){ echo 'Receive  Voucher'; }
                                            elseif($tb->voucher_type == 'CRN'){ echo 'Credit Note  Voucher'; } ?>
                        </td>
                        <td><?php echo $tb->remarks; ?></td>
                        <td><?php echo $tb->voucher_id; ?></td>

                        <td align="right"><?php echo $tb->dr_amt; $tot_debit +=$tb->dr_amt; ?></td>
                        <td align="right"><?php echo $tb->cr_amt; $tot_cre +=$tb->cr_amt;?></td>

                    </tr>
                    <?php  
                                    }
                                ?>
                    <tr class="rep">
                        <td colspan='4'></td>
                        <td>Total</td>
                        <td align="right"><?=$tot_debit?></td>
                        <td align="right"><?=$tot_cre?></td>
                    </tr>
                    <tr class="rep">
                        <td colspan="4"></td>
                        <td>Closing Balance</td>
                        <td align="right"><?php if($type == 1 || $type ==4||$opebalcal->type == 1||$opebalcal->type == 4){
									    //  echo $type;
                                         $clBl=$ope_bal+$tot_cre-$tot_debit;
                                        if($clBl>0){
                                            echo '';
                                        }else{
											echo abs($clBl);
										}
                                    }


                                        if($type == 2 || $type == 3||$opebalcal->type == 2||$opebalcal->type == 3){ 
											//echo $type;
                                            $clbala=$ope_bal+$tot_debit-$tot_cre;
                                            if($clbala>0){
                                              echo abs($clbala);
                                            }else{
                                             echo '';
                                            }
                                        }
                                            
                                        ?>
                        </td>
                        <td align="right">
                            <?php if($type == 1 || $type == 4||$opebalcal->type == 1||$opebalcal->type == 4){
											
                                         $clBl=$ope_bal+$tot_cre-$tot_debit;
                                        if($clBl>0){
                                            echo abs($clBl);
                                        }else{
                                             echo '';
                                        }
                                    }


                                        if($type == 2 || $type == 3||$opebalcal->type == 2||$opebalcal->type == 3){ 
                                            $clbala=$ope_bal+$tot_debit-$tot_cre;
                                            if($clbala>0){
                                                echo '';
                                            }else{
												echo abs($clbala);
											}
                                        }
                                            
                                        ?></td>

                    </tr>


                    <?php 
                                     }
                                else{
                                    echo "<tr><td colspan='14' style='text-align:center;'>No Data Found</td></tr>";
                                }   
                            ?>
                </tbody>
            </table>
        </div>

        <div style="text-align: center;">
            <button class="btn btn-primary" type="button" onclick="printDiv();">Print</button>
            <!-- <button class="btn btn-primary" type="button" id="btnExport" >Excel</button>-->
        </div>
    </div>
</div>

<link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet" />
<link href="https://cdn.datatables.net/buttons/1.5.1/css/buttons.dataTables.min.css" rel="stylesheet" />
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>

<script>
    $('#example').dataTable({
        destroy: true,
        searching: false,
        ordering: false,
        paging: false,

        dom: 'Bfrtip',
        buttons: [{
            extend: 'excelHtml5',
            title: 'Account details report',
            text: 'Export to excel'

        }]
    });
</script>