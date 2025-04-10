<style>
table {
    border-collapse: collapse;
}

table, td, th {
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.2/xlsx.full.min.js"></script>

<script>
  function printDiv() {
        var divToPrint = document.getElementById('divToPrint');
        var WindowObject = window.open('', 'Print-Window');
        WindowObject.document.open();
        WindowObject.document.writeln('<!DOCTYPE html>');
        WindowObject.document.writeln('<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"><title></title><style type="text/css">');
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

  function exportToExcel() {
        var table = document.getElementById("example");
        var wb = XLSX.utils.table_to_book(table, { sheet: "Sheet1" });

        // Make sure to include headers in the Excel export
        wb.Sheets["Sheet1"]["!cols"] = []; // Optional: You can also define column widths if needed
        var distName = "<?php if( $dist==2){
            echo "_associ";
             }else if( $dist==1){
                
                echo "_trust";    
             }; ?>";  // Get the value of $dist from PHP
        
        var fileName = "Recv_pay" + distName + ".xlsx";

        // Write the Excel file and trigger the download
        
        XLSX.writeFile(wb, fileName);
  }
</script>

<div class="wraper"> 
    <div class="col-lg-12 container contant-wraper">
        <div id="divToPrint">
            <div style="text-align:center;">
                <?php if($dist == 1){ ?>
                    <h2>BOSEC WELFARE TRUST</h2>
                    <h4>(Regd No.S/IL/78070of 2010-11)<br>
                    13,Camac Street,Kolkata-7000017</h4>
                <?php } else { ?>
                    <h2>BOKARO STEEL PEOPLE WELFARE ASSOCIATION</h2>
                    <h4>13,Camac Street,Kolkata-7000017</h4>
                <?php } ?>
                <h4>RECEIPT & PAYMENT ACCOUNT FOR THE YEAR <?php echo $this->session->userdata['loggedin']['fin_yr'];?></h4>
                <h4>AS ON  <?php echo date('d-m-Y',strtotime( $_POST['to_date'] ))?></h4>
            </div>
            <br>  

            <table style="width: 100%;" id="example">
                <thead>
                    <tr>
                        <th>Particulars</th>
                        <th>CR</th>
                        <th>DR</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    if ($recptpay) {
                        $dr_amt = 0.00;
                        $cr_amt = 0.00;
                        $grandTotalDrAmt =0.00;
                        $grandTotalCrAmt =0.00;
                        // Loop through each manager
                        foreach ($mngrl as $mn) {
                            // Reset amounts for the manager
                            $totalDrAmt = 0.00;
                            $totalCrAmt = 0.00;
                           

                            // Loop through the cashbook data to get details for the current manager
                            foreach ($recptpay as $tb) {
                                if ($tb->mngr_id == $mn->sl_no) {
                                    $totalDrAmt += $tb->dr_amt;
                                    $totalCrAmt += $tb->cr_amt;
                                }
                            }

                            // Only display manager's name if there's a non-zero receipt or payment
                            if ($totalDrAmt > 0 || $totalCrAmt > 0) {
                                // Display manager's name
                                echo "<tr><td colspan='3' style='text-align:left; background-color:#f0f0f0;'><b><u>{$mn->name}</u></b></td></tr>";

                                // Loop through again to display the details for that manager
                                foreach ($recptpay as $tb) {
                                    if ($tb->mngr_id == $mn->sl_no) {
                                        echo "<tr>";
                                        echo "<td>{$tb->ac_name}</td>";
                                        echo "<td>{$tb->dr_amt}</td>";
                                        echo "<td>{$tb->cr_amt}</td>";
                                        echo "</tr>";
                                    }
                                }

                                // Show the total row for each manager group
                                $totalDrAmt=$totalDrAmt;
                                // $totalCrAmt=number_format($totalCrAmt,2);
                                echo "<tr><td colspan='1'><b>Total for {$mn->name}</b></td><td><b>" . number_format($totalDrAmt, 2) . "</b></td><td><b>" . number_format($totalCrAmt, 2) . "</b></td></tr>";
                                $grandTotalDrAmt += $totalDrAmt;
                                $grandTotalCrAmt += $totalCrAmt;
                            }
                        }
                    // Display grand total at the bottom of the table
                    $grandTotalDrAmt = number_format($grandTotalDrAmt, 2);
                    $grandTotalCrAmt = number_format($grandTotalCrAmt, 2);
                    echo "<tr><td colspan='1'><b>Grand Total</b></td><td><b>{$grandTotalDrAmt}</b></td><td><b>{$grandTotalCrAmt}</b></td></tr>";
                } else {
                    echo "<tr><td colspan='3' style='text-align:center;'>No Data Found</td></tr>";
                }
                ?>
                </tbody>
            </table>
        </div>   
        <!-- <h4 style="text-align:left; margin-top: 30px;">Summary </h4> -->

<table style="width: 100%; background-color: #D5D5D5;" id="example">

    <thead>

        <tr>

            <!-- <th>Sl No.</th> -->
            <th>Name </th>
            <th>Opening</th>
            <th>Receive</th>
            <th>Payment</th>
            <th>Closing</th>

        </tr>

    </thead>

    <tbody>

        <?php

             $summary_tot = 0;
        if ($recptpay) {
            $i = 1;
            $total = 0;
            $totalnetamt = 0;
            $totalTds = 0;
            foreach ($recptpayop as $cashop) {
                // $total=($ptableData->adv_amt+$total);
                // $total += $cashop->op_bal;
        ?>

                <tr>
                    <td><?php echo $casho->ac_name; ?></td>

                                    </tr>


            <?php    } ?>
        <?php
        } else {

            echo "<tr><td colspan='14' style='text-align:center;'>No Data Found</td></tr>";
        }

        ?>

    </tbody>

</table>


        <div style="text-align: center;">
            <button class="btn btn-primary" type="button" onclick="printDiv();">Print</button>
            <button class="btn btn-success" type="button" onclick="exportToExcel();">Export to Excel</button>
        </div>
    </div>
</div>
