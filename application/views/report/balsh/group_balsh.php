<style>
table {
    /* border-collapse: collapse; */
}

table, td, th {
    border: 1px solid #dddddd;
    padding: 6px;
    font-size: 14px;
    /* border-collapse: collapse; */
    border-collapse:collapse !important;
}

th {
    text-align: center;
}

tr:hover {background-color: #f5f5f5;}
</style>

<script>
  function printDiv() {

        var divToPrint = document.getElementById('divToPrint');
        var WindowObject = window.open('', 'Print-Window');
        WindowObject.document.open();
        WindowObject.document.writeln('<!DOCTYPE html>');
        WindowObject.document.writeln('<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8"><title></title><style type="text/css">');


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
                        <?php if($district == 1) { ?>
                        <h5 style="text-align:left"><label>District: <?php  echo $this->session->userdata['loggedin']['branch_name']; ?></label> </h5>
                        <?php } ?>
                            <h4>BALANCE SHEET AS AT <?php echo date('d',strtotime($this->input->post('to_date'))); ?>-<?php echo date('F',strtotime($this->input->post('to_date'))); ?>, <?php echo date('Y',strtotime($this->input->post('to_date'))); ?></h4>
                  
                    </div>
                    <div class="printTop023">
						<div class="leftNo"></div>
						
					</div>
                    <br>  
                    <button id="btnExport" class="btn btn-primary" onclick="exportReportToExcel(this)">EXPORT EXCEL</button>
                    <br><br>
                    <div class="col-lg-12">
                    <table style="width: 100%;" class="table table-hover" id="example">
                    <tbody> 
                            <tr style="text-align:center;font-weight:bold">
                                <th>GC</th>
                                <td></td>
                                <td><?php echo $this->session->userdata['loggedin']['fin_yr']; ?></td>
                                <td><?php echo $pre_session->fin_yr; ?></td>
                            </tr>
                            <tr>
                            <th></th>
                            <th>LIABILITIES</th>
                            <th>Amount(Rs)</th>  
                            <th>Amount(Rs)</th>  
                            <?php    $i = 1;$otot_dr =0.00;$otot_cr =0.00;
                                    $total = 0.00;$tot_dr =0.00; $tot_cr =0.00;
                                    $val =0; $ope_bal = 0.00;$cls_bal = 0.00;$type='';
									$ctot_dr =0.00;$ctot_cr =0.00;$ctot_cr1 =0.00;

                                if($lib_bal){
                               
                                ?>
                                </tr>
                                <tr class="rep">
                                <td></td>
                                <td><?=$share_capital->param_desc?></td>
                                <td style="text-align: right;"><?=number_format($share_capital->param_value)?></td>
                                <td style="text-align: right;"><?=number_format($share_capital->param_value)?></td>
                                </tr>
                                <?php   foreach($lib_bal as $tb){
                                    
                                    $type = $tb->type; 
                                   if($tb->op_dr+$tb->op_cr+$tb->dr_amt+$tb->cr_amt!=0) { 
                                        
                                ?>
                                <tr class="rep">
									 
                                     <?php $dmo = date('m-d', strtotime($fd_date));
                                        if($dmo=='04-01'){ ?>
                                            <?php   $otot_dr +=$tb->op_dr; ?>
                                            <?php  $otot_cr +=$tb->op_cr; ?>
                           
                                    <?php  }else{ ?>
									
                                     <?php if($tb->op_dr > 0 && $tb->dr_cr_flag=='DR' ){
                                                $otot_dr +=$tb->op_dr;
                                        }else if($tb->op_cr < 0 && $tb->dr_cr_flag=='DR'){
                                            $otot_cr +=$tb->op_cr;
                                        } ?>
										  
                                        <?php if($tb->op_cr > 0 && $tb->dr_cr_flag=='CR'){
                                                 $otot_cr +=$tb->op_cr;
                                        }else if($tb->op_dr < 0 && $tb->dr_cr_flag=='CR'){
                                            $otot_dr +=$tb->op_dr;
                                        } ?>
									       								
                                     <?php } ?>
                                  
                                    <?php $tot_dr +=$tb->dr_amt; ?>
                                   <?php  $tot_cr +=$tb->cr_amt; ?>
                                   <td><?php echo $tb->benfed_srl;  ?></td>
                                    <td><?php echo $tb->mng_name;  ?></td>
                                    <td style="text-align: right;">
										<?php echo number_format(abs($tb->op_cr+$tb->cr_amt-($tb->op_dr)-($tb->dr_amt)),2);
											$ctot_cr +=abs($tb->op_cr+$tb->cr_amt-($tb->op_dr)-($tb->dr_amt));?>
									</td>
                                    <td style="text-align: right;">
										<?php 
                                            if($this->session->userdata['loggedin']['fin_id'] > 3){
                                                echo number_format(abs($tb->op_cr1+$tb->cr_amt1-($tb->op_dr1)-($tb->dr_amt1)),2);
                                                $ctot_cr1 +=abs($tb->op_cr1+$tb->cr_amt1-($tb->op_dr1)-($tb->dr_amt1));
                                            }else{
                                                echo 0;
                                                $ctot_cr1 += 0;
                                            }
                                            
                                            
                                            ?>
									</td>
                                </tr>
 
                                <?php  
                                   } 
                                   }
                                ?>
                                <?php

                                }
                                else{
                                    echo "<tr><td colspan='4' style='text-align:center;'>No Data Found</td></tr>";
                                }   
                            ?>
                            <tr style="font-weight: bold;">
                            <td></td>      
                            <td >Total:</td>
                            <td style="text-align: right;"><?php echo number_format(abs($ctot_cr),2)?></td>
                            <td style="text-align: right;"><?php echo number_format(abs($ctot_cr1),2)?></td>
                            </tr> 
                            <tr>
                            <th></th>
                            <th>ASSETS</th>
                            <th>Amount(Rs)</th>
                            <th>Amount(Rs)</th>
                            </tr>
                            <?php   $ctot_dr1 = 0;
                                if($assets_bal){
                                ?>
                                
                                <?php   foreach($assets_bal as $tb){ $type = $tb->type; 
                               //     if($tb->op_dr+$tb->op_cr+$tb->dr_amt+$tb->cr_amt!=0) {   
                                        ?>
                                  
                                <tr class="rep">
                                     <?php $dmo = date('m-d', strtotime($fd_date));
                                        if($dmo=='04-01'){ ?>
                          
                                    <?php $otot_dr +=$tb->op_dr; ?>
                                    <?php $otot_cr +=$tb->op_cr; ?>
                           
                                    <?php  }else{ ?>
                                     
                                     <?php if($tb->op_dr > 0 && $tb->dr_cr_flag=='DR' ){
                                              $otot_dr +=$tb->op_dr;
                                        }else if($tb->op_cr < 0 && $tb->dr_cr_flag=='DR'){
                                            $otot_cr +=$tb->op_cr;
                                        } ?>
								
                                        <?php if($tb->op_cr > 0 && $tb->dr_cr_flag=='CR'){
                                                $otot_cr +=$tb->op_cr;
                                        }else if($tb->op_dr < 0 && $tb->dr_cr_flag=='CR'){
                                             $otot_dr +=$tb->op_dr;
                                        } ?>
								   
                                     <?php } ?>

                                     <?php  $tot_dr +=$tb->dr_amt; ?></td>
                                     <?php $tot_cr +=$tb->cr_amt; ?>
                                     <td><?php echo $tb->benfed_srl;  ?></td>
                                     <td><?php echo $tb->mng_name; ?></td>
                                     <td style="text-align: right;">
                                    <?php echo  number_format(abs($tb->op_dr+$tb->dr_amt-($tb->op_cr)-($tb->cr_amt)),2);
                                            $ctot_dr += abs($tb->op_dr+$tb->dr_amt-($tb->op_cr)-($tb->cr_amt));
                                    ?>
									 </td>
                                     <td style="text-align: right;">
                                    <?php 
                                     if($this->session->userdata['loggedin']['fin_id'] > 3){
                                    echo  number_format(abs($tb->op_dr1+$tb->dr_amt1-($tb->op_cr1)-($tb->cr_amt1)),2);
                                            $ctot_dr1 += abs($tb->op_dr1+$tb->dr_amt1-($tb->op_cr1)-($tb->cr_amt1));
                                        }else{
                                            echo 0;
                                            $ctot_dr1 += 0;
                                        }
                                        
                                    ?>
									 </td>
                                </tr>
 
                                <?php 
                            
                            //        }                    
                                    }
                                ?>
                                <?php   
                                       }
                                else{
                                    echo "<tr><td colspan='6' style='text-align:center;'>No Data Found</td></tr>";
                                }   
                            ?>
                            <tr style="font-weight: bold;">
                            <td></td>     
                            <td >Total:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                            <td style="text-align: right;"><?php echo number_format(abs($ctot_dr),2)?></td>
                            <td style="text-align: right;"><?php echo number_format(abs($ctot_dr1),2)?></td>
                    </tr> 
                        

                </table>

                
                    </div>
                </div>   
                
                <div style="text-align: center;">
                    <button class="btn btn-primary" type="button" onclick="printDiv();">Print</button>
                   <!-- <button class="btn btn-primary" type="button" id="btnExport" >Excel</button>-->
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/gh/linways/table-to-excel@v1.0.4/dist/tableToExcel.js"></script>
        <script>
            function exportReportToExcel() {
  let table = document.getElementsByTagName("table"); // you can use document.getElementById('tableId') as well by providing id to the table tag
  TableToExcel.convert(table[0], { // html code may contain multiple tables so here we are refering to 1st table tag
    name: `Balance_Sheet.xlsx`, // fileName you could use any name
    sheet: {
      name: 'Balance_Sheet ' // sheetName
    }
  });
}
        </script>