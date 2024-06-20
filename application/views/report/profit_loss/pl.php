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
                            <h4>CONSOLIDATED TRADING AND PROFIT & LOSS ACCOUNT FOR THE YEAR ENDED ON <?php echo date('d',strtotime($this->input->post('to_date'))); ?>-<?php echo date('F',strtotime($this->input->post('to_date'))); ?>, <?php echo date('Y',strtotime($this->input->post('to_date'))); ?></h4>
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
                                <?php       $totrev_markt =0.00;$totexp_markt =0.00;
                                            $total = 0.00;$tot_dr =0.00; $tot_cr =0.00;
                                            $totrev_fer =0.00;$totexp_fer =0.00;
                                            $ctot_dr =0.00;$appro_tot = 0.00;$tot_accul= 0.00;
                                            $pro_tax_tot =0.00; ?>
                              
                                <tr style="font-weight: bold;text-align:center;">
                                    <td >PARTICULARS</td>
                                    <td>SGC</td>
                                    <td><?php echo $this->session->userdata['loggedin']['fin_yr']; ?></td>
                                    <td><?php echo $pre_session->fin_yr; ?></td>
                                </tr>
                                <tr style="font-weight: bold;">
                                    <td>REVENUE FROM OPERATION</td>
                                    <td></td>
                                    <td>Amount Rs.</td>
                                    <td>Amount Rs.</td>
                                </tr>
                                <?php foreach($revenue_market as $rermar) { ?>
                                <tr>
                                    <td><?=$rermar->name?></td>
                                    <td><?=$rermar->benfed_subgr_id?></td>
                                    <td><?php echo $rermar->dcrdrtot; $totrev_markt +=$rermar->dcrdrtot; ?></td>
                                    <td></td>
                                </tr>
                                <?php } ?>
                                <tr style="font-weight: bold;">
                                    <td >(A) TOTAL</td>
                                    <td></td>
                                    <td><?=$totrev_markt?></td>
                                    <td></td>
                                </tr>
                                <tr style="font-weight: bold;">
                                    <td>OPERATIONAL EXPENSES</td>
                                    <td></td>
                                    <td>Amount Rs.</td>
                                    <td>Amount Rs.</td>
                                </tr>
                                <?php foreach($operational_expense as $operm) { ?>
                                <tr>
                                    <td><?=$operm->name?></td>
                                    <td><?=$operm->benfed_subgr_id?></td>
                                    <td><?php echo $operm->dcrdrtot; $totexp_markt +=$operm->dcrdrtot; ?></td>
                                    <td></td>
                                </tr>
                                <?php } ?>
                                <tr style="font-weight: bold;">
                                    <td >(B) TOTAL</td>
                                    <td></td>
                                    <td><?=$totexp_markt?></td>
                                    <td></td>
                                </tr>
                                <tr style="font-weight: bold;">
                                    <td >(C) GROSS PROFIT (A) - (B)</td>
                                    <td></td>
                                    <td><?=$totrev_markt-$totexp_markt?></td>
                                    <td></td>
                                </tr>
                                
                                <tr style="font-weight: bold;">
                                    <td>INDIRECT INCOME</td>
                                    <td></td>
                                    <td>Amount Rs.</td>
                                    <td>Amount Rs.</td>
                                </tr>
                                <?php foreach($indirect_income as $revfer) { ?>
                                <tr>
                                    <td><?=$revfer->name?></td>
                                    <td><?=$revfer->benfed_subgr_id?></td>
                                    <td><?php echo $revfer->dcrdrtot;     $totrev_fer +=$revfer->dcrdrtot; ?></td>
                                    <td></td>
                                </tr>
                                <?php } ?>
                                <tr style="font-weight: bold;">
                                    <td >(D) TOTAL</td>
                                    <td></td>
                                    <td><?=$totrev_fer?></td>
                                    <td></td>
                                </tr>
                                <tr style="font-weight: bold;">
                                    <td>OPERATIONAL EXPENSES</td>
                                    <td></td>
                                    <td>Amount Rs.</td>
                                    <td>Amount Rs.</td>
                                </tr>
                                <?php foreach($indirect_expense as $operfer) { ?>
                                <tr>
                                    <td><?=$operfer->name?></td>
                                    <td><?=$operfer->benfed_subgr_id?></td>
                                    <td><?php echo $operfer->dcrdrtot;  $totexp_fer +=$operfer->dcrdrtot; ?></td>
                                    <td></td>
                                </tr>
                                <?php } ?>
                                <tr style="font-weight: bold;">
                                    <td >(E) TOTAL</td>
                                    <td></td>
                                    <td><?=$totexp_fer?></td>
                                    <td></td>
                                </tr>
                                <tr style="font-weight: bold;">
                                    <td >(F) NET PROFIT BEFORE PROVISIONS AND TAX (C+D-E)</td>
                                    <td></td>
                                    <td><?=$totrev_markt-$totexp_markt +$totrev_fer +$totexp_fer?></td>
                                    <td></td>
                                </tr>
                                <?php foreach($provision_tax as $pro_tax) { ?>
                                <tr>
                                    <td>(G)<?=$pro_tax->name?></td>
                                    <td><?=$pro_tax->benfed_subgr_id?></td>
                                    <td><?php echo $pro_tax->dcrdrtot;  $pro_tax_tot +=$pro_tax->dcrdrtot; ?></td>
                                    <td></td>
                                </tr>
                                <?php } ?>
                                <tr style="font-weight: bold;">
                                    <td >(H) NET PROFIT AFTER TAX (F-G)</td>
                                    <td></td>
                                    <td><?=$totrev_markt-$totexp_markt +$totrev_fer +$totexp_fer-$pro_tax_tot?></td>
                                    <td></td>
                                </tr>
                                <?php foreach($appropration as $appro) { ?>
                                <tr>
                                    <td><?=$appro->name?></td>
                                    <td><?=$appro->benfed_subgr_id?></td>
                                    <td><?php echo $appro->dcrdrtot;  $appro_tot +=$appro->dcrdrtot; ?></td>
                                    <td></td>
                                </tr>
                                <?php } ?>
                                <tr>
                                    <td>(J) ACCUMULATED PROFIT OR LOSS OF THE LAST YEAR</td>
                                    <td></td>
                                    <td><?php echo $accumulated->amount;  $tot_accul += $accumulated->amount ? $accumulated->amount:0; ?></td>
                                    <td></td>
                                </tr>
                                <tr style="font-weight: bold;">
                                    <td>(K) BALANCE CARRIED TO BALANCE SHEET (H-I+J)</td>
                                    <td></td>
                                    <td><?=$totrev_markt-$totexp_markt +$totrev_fer +$totexp_fer-$pro_tax_tot-$appro_tot+$tot_accul?></td>
                                    <td></td>
                                </tr>
                            </tbody>
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
    name: `profit_loss.xlsx`, // fileName you could use any name
    sheet: {
      name: 'profit_loss' // sheetName
    }
  });
}
        </script>

