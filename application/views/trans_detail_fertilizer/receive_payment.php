<style>
    #overlay {
        background: rgba(100, 100, 100, 0.2);
        color: #ffff;
        position: fixed;
        height: 100%;
        width: 100%;
        z-index: 5000;
        top: 0;
        left: 0;
        float: left;
        text-align: center;
        padding-top: 25%;
        opacity: .80;
    }
    .spinner {
        margin: 0 auto;
        height: 64px;
        width: 64px;
        animation: rotate 0.8s infinite linear;
        border: 5px solid #228ed3;
        border-right-color: transparent;
        border-radius: 50%;
    }

    @keyframes rotate {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }
</style>
<div class="wraper">

    <div class="col-md-12 container form-wraper">

            <div class="form-header">

                <h4>View Customer Payment</h4>

            </div>
            <?php
                        foreach($paydtls as $pay);{
                        ?>

            <div class="form-group row">
                <label for="soc_id" class="col-sm-2 col-form-label">Society :</label>
                <div class="col-sm-4">

                    <select name="soc_id" class="form-control" id="soc_id" disabled>

                        <option value="">Select</option>

                        <?php
                    	
                    		foreach($socdtls as $soc){
                    	
                    	?>
                        <option value="<?php echo $soc->soc_id;?>"
                            <?php if($pay->soc_id==$soc->soc_id) echo "selected" ?>><?php echo $soc->soc_name;?>
                        </option>
                        <?php
                    	
                    		}
                    	
                    	?>
                    </select>
                </div>

                <label for="do_dt" class="col-sm-2 col-form-label">Paid Date:</label>
                <div class="col-sm-3">
                    <input type="text" id=do_dt name="do_dt" class="form-control" value="<?=date("d-m-Y", strtotime($pay->paid_dt))?>"
                        readonly />
                </div>
            </div>
            <div class="form-group row">
                <label for="trans_do" class="col-sm-2 col-form-label">Invoice No:</label>
                <div class="col-sm-4">
                    <input type="text" id=trans_do name="trans_do" class="form-control" value="<?=$pay->sale_invoice_no?>"
                        readonly />
                </div>
                <label for="do_dt" class="col-sm-2 col-form-label">Invoice Date:</label>
                <div class="col-sm-3">

                    <input type="text" id=do_dt name="do_dt" class="form-control" value="<?=date("d-m-Y", strtotime($pay->sale_invoice_dt))?>"
                        readonly />
                </div>
            </div>

            <div class="form-group row">

                <label for="sale_ro" class="col-sm-2 col-form-label">Ro no:</label>
                <div class="col-sm-4">
                    <input type="text" id=sale_ro name="sale_ro" class="form-control" value="<?=$pay->ro_no?>"
                        readonly />
                </div>
                <label for="tot_recvble_amt" class="col-sm-2 col-form-label">Total Invoice RO Amount::</label>
                <div class="col-sm-3">
                    <input type="text" id=tot_recvble_amt name="tot_recvble_amt" class="form-control"
                        value="<?=$pay->tot_recvble_amt?>" readonly />
                </div>
            </div>

            <div class="form-group row">
                <label for="tot_dr_amt" class="col-sm-2 col-form-label">Total Cr Note Amount:</label>
                <div class="col-sm-4">
                    <input type="text" name="tot_dr_amt" id="tot_dr_amt" value="<?=$pay->adj_dr_note_amt?>"
                        class="form-control" readonly />
                </div>
                <label for="adv_amt" class="col-sm-2 col-form-label">Advance Amount:</label>
                <div class="col-sm-3">
                    <input type="text" name="adv_amt" id="adv_amt" class="form-control" value="<?=$pay->adj_adv_amt?>"
                        readonly />
                </div>
            </div>

            <div class="form-group row">
                <label for="net_amt" class="col-sm-2 col-form-label">RO Net Amount(Total Amount - Paid Amount)::</label>
                <div class="col-sm-4">

                    <input type="text" name="net_amt" id="net_amt" value="<?=$pay->net_recvble_amt?>"
                        class="form-control" readonly />
                </div>

                <label for="bnk_id" class="col-sm-2 col-form-label">Bank:</label>

                <div class="col-sm-3">

                    <input type="text" name="bnk_id" id="bnk_id" class="form-control" value="<?=$pay->bank_name?>"
                        readonly />
                </div>
            </div>

            <div class="form-group row">
                <label for="rndnet_amt" class="col-sm-2 col-form-label">Net Amount(Rounded)<br>(Total Amount - Paid
                    Amount):</label>
                <div class="col-sm-4">
                    <input type="text"  id="rndnet_amt" name="rndnet_amt"
                        value="<?=round($pay->net_recvble_amt) ?>" class="form-control" readonly />
                </div>
                <div class="col-sm-2">
                    <input id="cshbank" name="cshbank" type="radio" class="radio-label cshbankk" value="0" <?php if($pay->cshbnk_flag==0){echo'checked';} ?> disabled>

                    <label for="cshbank" class="radio-label cshbankk">Cash</label>
                </div>
                <div class="col-sm-2">
                    <input id="cshbank" name="cshbank" type="radio" class="radio-label cshbank" value="1" <?php if($pay->cshbnk_flag==1){echo'checked';} ?>  disabled>

                    <label for="cshbank" class="radio-label cshbank">Bank</label>
                </div>
            </div>

            <div class="form-group row">
                <label for="ifsc" class="col-sm-2 col-form-label">IFSC</label>
                <div class="col-sm-4">
                    <input type="text" name="ifsc" id="ifsc" class="form-control" value="<?=$pay->ifsc?>" readonly />
                    <input type="hidden" name="sl_no" id="sl_no" class="form-control" value="<?=$pay->sl_no?>"
                        readonly />
                </div>
                <label for="ac_no" class="col-sm-2 col-form-label">A/C No:</label>
                <div class="col-sm-3">
                    <input type="text" name="ac_no" id="ac_no" class="form-control" value="<?=$pay->ac_no?>" readonly />
                </div>
            </div>

            <div class="form-group row">
                <label for="remarks" class="col-sm-2 col-form-label">Remarks</label>
                <div class="col-sm-4">
                    <textarea style="width:590px" name="remarks" id="remarks" disabled
                        class="form-control"><?php echo $pay->remarks; ?></textarea>
                </div>
            </div>

            <?php } ?>
            <div class="form-header">

                <h4>Pay Type and Paid Details</h4>

            </div>
            <hr>

            <div class="row" style="margin: 5px;">

                <div class="form-group">

                    <table class="table table-striped table-bordered table-hover">

                        <thead>

                            <th style="text-align: center">Pay Type</th>
                            <th style="text-align: center">Reference Date</th>
                            <th style="text-align: center">Reference No</th>
                            <th style="text-align: center">Amount</th>

                        </thead>

                        <tbody id="intro">
                            <?php          $sum=0;
                                     $taxable_amt=0;
                                      $cgst=0;
                                       $sgst=0;
                    foreach($paydtls as $pay)
                    { ?>
                            <tr>

                                <td>
                                    <input type='hidden' value="<?php echo $pay->pay_type; ?>" name="pay_status[]" />
                                    <input type="hidden" name="pay_type[]" value="<?php echo $pay->pay_type; ?>">
                                    <select class="col-sm-3" id="pay_type"
                                        style="width:200px;height:40px" disabled>

                                        <option value="">Select</option>
                                        <option value="1" <?php echo ($pay->pay_type == 1)? 'selected' : '';?>>Cash
                                        </option>
                                        <option value="2" <?php echo ($pay->pay_type == 2)? 'selected' : '';?>>Advance
                                        </option>
                                        <option value="3" <?php echo ($pay->pay_type == 3)? 'selected' : '';?>>Cheque
                                        </option>
                                        <option value="4" <?php echo ($pay->pay_type == 4)? 'selected' : '';?>>Draft
                                        </option>
                                        <option value="5" <?php echo ($pay->pay_type == 5)? 'selected' : '';?>>Pay Order
                                        </option>
                                        <option value="6" <?php echo ($pay->pay_type == 6)? 'selected' : '';?>>CR Note
                                        </option>
                                        <option value="7" <?php echo ($pay->pay_type == 7)? 'selected' : '';?>>NEFT/RTGS
                                        </option>

                                    </select>

                                </td>
                                <td>
                                    <input type="text" name="ref_dt[]" class="form-control ref_dt"
                                        value="<?=$pay->ref_dt?>" id="ref_dt"  disabled>
                                </td>
                                <td>
                                    <input type="text" name="ref_no[]" class="form-control ref_no" disabled
                                        value="<?=$pay->ref_no?>" id="ref_no">
                                </td>

                                <td>
                                    <input type="text" name="paid_amt[]" class="form-control paid_amt"
                                        value="<?=$pay->paid_amt?>" id="paid_amt" readonly>
                                    <?php
                                        $sum = 0;
                                        foreach($paydtls as $pay) {
                    $sum+= $pay->paid_amt;
                                        }
                                     
                    ?>
                                </td>


                            </tr>

                            <?php } ?>

                        </tbody>

                        <tfoot>
                            <tr>
                                <td colspan="3" style="text-align:left">
                                    <strong>Total:</strong>

                                </td>
                                <td colspan="5" style="text-align:right">
                                    <b>
                                        <div class="col-md-3" Total: <span id="Total"> <?php   echo $sum;?></span></div>
                                    </b>
                                </td>
                            </tr>
                        </tfoot>

                    </table>

                </div>

            </div>


            <div class="form-group row">

            </div>

    </div>

</div>

</div>

<!-- For Add row table -->
<script>
    $(".sch_cd").select2(); // Code For Select Write Option

    $(document).ready(function () {

        // For add row option
        $('#addrow').click(function () {

            $.get(

                '<?php echo site_url("trade/f_get_sale_ro");?>',

                {

                    comp_id: $('#comp_id').val()
                    // dist_cd : $('#dist_cd').val()

                }

            ).done(function (data) {

                var string = '<option value="">Select</option>';
                //console.log(data);
                $.each(JSON.parse(data), function (index, value) {

                    string += '<option value="' + value.ro_no + '">' + value.ro_no +
                        '</option>'

                });

                var newElement = '<tr>' +
                    '<td>' +
                    '<select name="ro[]" id="ro" style="width:150px"class="form-control required ro" required>' +
                    '<option value="">Select Project</option>'

                    +
                    ' <option value=" ' + string + '</option>'

                    +
                    '</select> ' +
                    '</td>' +
                    '<td>' +
                    '<select name="prod_id[]" id="prod_id" style="width:150px"class="form-control required prod_id" required>' +
                    '<option value="">Select Product</option>' +
                    '<?php foreach($proddtls as $key1) { ?> ' +
                        ' <option value="<?php echo $key1->prod_id; ?>"><?php echo $key1->prod_desc; ?></option>' +
                        '<?php } ?> ' +
                    '</select> ' +
                    '</td>' +
                    '<td>' +
                    '<input type="text" name="stock_qty[]" class="form-control required stock_qty" value= "" id="stock_qty" required>' +
                    '</td>' +
                    '<td>' +
                    '<input type="text" name="qty[]" class="form-control required qty" value= "" id="qty" required>' +
                    '</td>' +
                    '<td>' +
                    '<input type="text" name="sale_rt[]" class="form-control required sale_rt" value= "" id="sale_rt" required>' +
                    '</td>' +
                    '<td>' +
                    '<input type="text" name="taxable_amt[]" class="form-control required taxable_amt" value= "" id="taxable_amt" required>' +
                    '</td>' +
                    '<td>' +
                    '<input type="text" name="cgst[]" class="form-control required cgst" value= "" id="cgst" required>' +
                    '</td>' +
                    '<td>' +
                    '<input type="text" name="sgst[]" class="form-control required sgst" value= "" id="sgst" required>' +
                    '</td>' +
                    '<td>' +
                    '<input type="text" name="tot_amt[]" class="form-control tot_amt required" value= "" id="tot_amt" required>' +
                    '</td>' +
                    '<td>' +
                    '<button class="btn btn-danger" type= "button" data-toggle="tooltip" data-original-title="Remove Row" data-placement="bottom" id="removeRow"><i class="fa fa-remove" aria-hidden="true"></i></button>' +
                    '</td>'
                '</tr>';

                $("#intro").append($(newElement));

            });
        });
        // For remove row 
        $("#intro").on("click", "#removeRow", function () {
            $(this).parents('tr').remove();
            $('.total').change();
        });

        // For getting total amount after giving nt_amount
        $('#nt').on("change", function () {
            var total = $(this).val();
            $('#total').val(total);
        })


        // For getting total calculation after remove row
        $('.total').change(function () {

            var total = $('#nt').val();
            var ntAmount = $('#nt').val();
            $('.cgst_val').each(function () {

                var curr_gst_val = $(this).val();
                total = parseFloat(total) + parseFloat(parseFloat(curr_gst_val) * 2);
                //console.log(total);

            })
            $('#total').val(parseFloat(total).toFixed());

            // Checking whather total to sub_amnt exeeds NT Rs or not-- 
            //var total_subAmnt = $('#sub_amnt').val();
            var total_subAmnt = 0;
            $('.sub_amnt').each(function () {

                var tot_sub_amnt = $(this).val();
                total_subAmnt = parseFloat(total_subAmnt) + parseFloat(tot_sub_amnt);

                if (parseFloat(ntAmount) < parseFloat(total_subAmnt)) {
                    $('#nt').css('border-color', 'red');
                    $('#submit').prop('disabled', true);
                    return false;
                } else {
                    $('#nt').css('border-color', 'green');
                    $('#submit').prop('disabled', false);
                    return true;
                }


            })

        });

    })
</script>




<script>
    $(document).ready(function () {
        $('#intro').on("change", ".ro", function () {

            $.get('<?php echo site_url("trade/js_get_stock_qty");?>', {
                    ro: $(this).val()
                })

                .done(function (data) {
                    //console.log(data);
                    var unitData = JSON.parse(data);
                    console.log(unitData);
                    $('.stock_qty').eq($('.ro').index(this)).val(unitData.qty);
                    $('.prod_id').eq($('.ro').index(this)).val(unitData.prod_id);
                    $('.gst_rt').eq($('.ro').index(this)).val(unitData.gst_rt);
                    $('.qty').eq($('.ro').index(this)).val(0);
                    $('.sale_rt').eq($('.ro').index(this)).val(0);
                    $('.taxable_amt').eq($('.ro').index(this)).val(0);
                    $('.cgst').eq($('.ro').index(this)).val(0);
                    $('.sgst').eq($('.ro').index(this)).val(0);
                    $('.tot_amt').eq($('.ro').index(this)).val(0);

                });

        });

    });
</script>
<script>
    $(document).ready(function () {
        $('#intro').on("change", ".sale_rt", function () {

            var sum = 0;
            var gst_rt = $('.gst_rt').eq($('.ro').index(this)).val();
            var qty = $('.qty').eq($('.ro').index(this)).val();
            var sale_rt = $('.sale_rt').eq($('.ro').index(this)).val();
            if (sale_rt == 0) {
                alert('Sale rate Can not be zero');
                var txtBox = document.getElementById("sale_rt");
                txtBox.focus();
                return false;
            }
            var taxable_amt = parseFloat(qty * sale_rt).toFixed('2');
            var cgst = parseFloat(taxable_amt * gst_rt / 100 / 2).toFixed('2')
            var tot_amt = parseFloat(taxable_amt + cgst * 2).toFixed('2')
            var total = 0.00;
            total = parseFloat(total) + parseFloat(tot_amt);


            //    total += parseFloat(tot_amt); 
            $.get('<?php echo site_url("trade/js_get_stock_qty");?>', {
                    ro: $(this).val()
                })


                .done(function (data) {
                    console.log(data);
                    var unitData = JSON.parse(data);
                    console.log(unitData);


                    $('.taxable_amt').eq($('.ro').index(this)).val(taxable_amt);
                    $('.cgst').eq($('.ro').index(this)).val(cgst);
                    $('.sgst').eq($('.ro').index(this)).val(cgst);
                    $('.tot_amt').eq($('.ro').index(this)).val(tot_amt);

                    // $('#total').val(parseFloat(total).toFixed());  

                    $("input[class *= 'tot_amt']").each(function () {
                        sum += parseFloat($(this).val());

                    });

                    $("#total").val("0");
                    $("#total").val(sum).toFixed();

                });

        });


    });

    $('.table tbody').on('change', '.qty', function () {

        let row = $(this).closest('tr');
        var qty = row.find('td:eq(3) .qty').val();

        var stock = row.find('td:eq(2) .stock_qty').val();

        if (parseFloat(qty) > parseFloat(stock)) {
            //  var zero_qty          = null;

            row.find('td:eq(3)  input').val("0");

            alert('Sale Quantity Should Not Be Greater Than Stock Quantity!');

        }


    })

    $('.table tbody').on('change', '.dis', function () {


        var sum = 0;
        let row = $(this).closest('tr');
        var dis = parseFloat(row.find('td:eq(8) .dis').val());
        var tot_amt = row.find('td:eq(9) .tot_amt').val();

        row.find('td:eq(9) .tot_amt').val(tot_amt - dis);


        $("input[class *= 'tot_amt']").each(function () {
            sum += parseFloat($(this).val());

        });

        $("#total").val("0");
        $("#total").val(sum).toFixed(2);


    })
</script>
<script>
    $(document).ready(function () {

        $('#intro').on("change", ".paid_amt", function () {

            $("#total").val('');
            var total = 0;
            $('.paid_amt').each(function () {
                total += +$(this).val();
                alert(total);
            })
            $("#Total").html(total);
            //  var total       =   $('#Total').html();
            // if(parseFloat(total) > parseFloat(net_amt))
            if (parseFloat(total) > parseFloat(rnd_net_amt)) {
                $('#total').css('border-color', 'red');
                alert('Paid Amount Should Not Greater Than Net Amount!');
                $('#submit').prop('disabled', true);

                return false;
            } else {
                $('#submit').prop('disabled', false);
                $('#total').css('border-color', 'gray');
                return true;
            }

        })

    })
</script>
