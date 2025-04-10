<style>
    td,
    th {
        padding: 5px;
    }
</style>
<script>
    function set_gr(id) {
        var pre_val = '';
        var pre_id = id - 1;
        $.ajax({
            type: "GET",
            url: "<?php echo site_url('transaction/get_gr_dtls'); ?>",
            data: {
                ac_id: $('#acc_code_' + id).val()
            },
            dataType: 'html',
            success: function(result) {
                var result = $.parseJSON(result);
                if (id > 1) {
                    pre_val = $('#acc_code_' + pre_id).val();
                    if (pre_val == $('#acc_code_' + id).val()) {
                        alert('A/C Head Can Not Be Same');
                        $('#acc_code_' + id).val('');
                        $('#gr_id_' + id).val('');
                        $('#gr_id_' + id).attr("title",'');
                        $('#subgr_id_' + id).val('');
                        $('#subgr_id_' + id).attr("title",'');
                    } else {
                        $('#type_' + id).val(result.tname);
                        $('#type_' + id).attr("title",result.tname);
                        $('#gr_id_' + id).val(result.gr_name);
                        $('#gr_id_' + id).attr("title",result.gr_name);
                        $('#subgr_id_' + id).val(result.subgr_name);
                        $('#subgr_id_' + id).attr("title",result.subgr_name);
                        // console.log(result.gr_name);
                    }
                } else {
                    $('#type_' + id).val(result.tname);
                    $('#type_' + id).attr("title",result.tname);
                    $('#gr_id_' + id).val(result.gr_name);
                    $('#gr_id_' + id).attr("title",result.gr_name);
                    $('#subgr_id_' + id).val(result.subgr_name);
                    $('#subgr_id_' + id).attr("title",result.subgr_name);
                }
            }
        });
    }
</script>
<script>
    $(document).ready(function() {
        $('#t_type').change();
        var tot_amt = 0;
        $("#newrow").click(function() {
            if ($('#v_type').val() != '') {
                var tr_len = $('#vau_tab #add>tr').length;
                var x = tr_len + 1;
                $("#add").append('<tr><td><select id="acc_code_' + x + '" class="form-control select_2" name="acc_code[]" class="input_text" style="width: 80%;" onchange="set_gr(' + x + ')" required><option value="" required>Select</option>' +
                    "<?php
                        foreach ($row as $value) {
                            echo "<option value='" . $value->sl_no . "'>" . $value->ac_name . "</option>";
                        }
                        ?>" +'</select></td>' +
                    '<td><input type="text" class="transparent_tag" id="type_'+ x +'" name="type_id[]" style="width: 100%;" readonly></td>'+   
                    '<td><input type="text" class="transparent_tag" id="gr_id_' + x + '" name="gr_id[]" style="width: 100%;" readonly></td>' +
                    '<td><input type="text" class="form-control amount_cls" style="width: 100%; text-align: right;" id="amt" name="amount[]" oninput="validate(this)" required></td>' +
                    '<td><input type="text"  id="dc_flg" name="dc_flg[]" class="transparent_tag" style="width: 100%; text-align: center;" value="' + g_flg + '" readonly></td>' +
                    '<td><button type="button" class="btn btn-danger" id="removeRow"><i class="fa fa-undo" aria-hidden="true"></i></button></td></tr>');
                //$('.preferenceSelect').change();
                $(".select_2").select2();
            } else {
                alert('Please Select Voucher Type First');
                return false;
            }
        });

        $("#add").on('click', '#removeRow', function() {
            $(this).parent().parent().remove();
            //$('.preferenceSelect').change();
            $('.amount_cls').change();
        });

        $('#add').on("change", ".amount_cls", function() {

            $("#tot_amt").val('');
            var tot_amt = 0;
            $('.amount_cls').each(function() {
                tot_amt += +$(this).val();
            });
            $("#tot_amt").val(tot_amt);

        });

        $('#submit').click(function() {

            var date = $('#date').val(),

                sys_date = $('#sys_date').val();

            if (new Date(date) > new Date(sys_date)) {

                alert("Invalid Date");

                return false;

            } else {

                $('#submit').prop('type', 'submit');

                return true;

            }

        });


    });
</script>

<div class="wraper">

    <div class="col-md-12 container form-wraper">

        <form method="POST" action="<?php echo site_url("transaction/bank_save") ?>" onsubmit="return valid_data()">

            <div class="form-header">

                <h4>Bank Voucher</h4>

            </div>

            <input type="hidden" id="sys_date" value="<?= date('Y-m-d') ?>">

            <div class="form-group row">

                <label for="trans_dt" class="col-sm-2 col-form-label">Date:</label>

                <div class="col-sm-4">

                    <input type="date" name="voucher_dt" class="form-control mindate smallinput_text" value="<?= date('Y-m-d') ?>" id="date" min="" required />

                </div>

                <label for="voucher_mode" class="col-sm-2 col-form-label">Mode:</label>

                <div class="col-sm-2">

                    <input type="text" name="voucher_mode" value="BANK" class="transparent_tag" style="width:50px;" readonly required/>

                </div>

            </div>

            <div class="form-group row">
                <label for="voucher_type" class="col-sm-2 col-form-label">Voucher Type:</label>
                <div class="col-sm-4">
                    <select class="form-control " name="voucher_type" id="v_type" onchange="set_dr_cr()" class="input_text" required>
                        <option value="">Select</option>
                        <option value="R">Bank Received</option>
                        <option value="P">Bank Payment</option>
                    </select>
                </div>

                <label for="transfer_type" class="col-sm-2 col-form-label">Transfer Type:</label>
                <div class="col-sm-3">
                    <select class="form-control " name="transfer_type" id="t_type" onchange="set_dr_cr()" class="input_text" required>
                        <option value="">Select</option>
                        <option value="C">Cheque</option>
                        <option value="N" selected>Online</option>
                        <option value="H">CASH</option>
                    </select>
                </div>

            </div>

            <div class="form-group row">

                <label for="acc_cd" class="col-sm-2 col-form-label">Bank A/C:</label>

                <div class="col-sm-4">

                    <!-- <select name="bank_cd" class="form-control select2" style="display: inline;" required> -->
                    <select name="bank_cd" class="form-control select2 required" required>
                        <option value="">Select</option>
                        <?php
                        foreach ($bank as $value) {
                            ?>
                           <option value='<?= $value->sl_no; ?>'><?=$value->ac_name;?></option>
                       <?php }
                        ?>
                    </select>

                    

                </div>
				<div class="col-sm-1">
						<span style="display: inline;">
                        <input type="text" id="dc" title="" class="transparent_tag" name="dr_cr_flag" value="" readonly>
                        </span>
				</div>
				

            </div>

            <div class="form-group row">

                <label for="trans_dt" id="t_label_no" class="col-sm-2 col-form-label">Cheque No.:</label>

                <div class="col-sm-4">

                    <input type="text" name="inst_num" class="form-control smallinput_text">

                </div>

                <label for="trans_dt" id="t_label_dt" class="col-sm-2 col-form-label">Cheque Date:</label>

                <div class="col-sm-3">

                    <input type="date" class="form-control smallinput_text mindate" name="inst_dt" min="">

                </div>

            </div>


            <div class="form-group row">

                <label for="remarks" class="col-sm-2 col-form-label">Remarks:</label>

                <div class="col-sm-9">

                    <textarea class="form-control" name="remarks" required></textarea>

                </div>

            </div>

            <hr class="hr_divide">

            <table id="vau_tab">
                <thead>
                    <tr>
                         <th style="width: 25%;">A/C Head</th>
                        <th style="width: 10%;">Type</th>
                        <th style="width: 25%;">Group</th>
                        <th style="width: 25%;">Amount</th>
                        <th style="width: 10%;"></th>
                        <th><button class="btn btn-success" type="button" id="newrow"><i class="fa fa-arrow-circle-down" aria-hidden="true"></i></button></th>
                    </tr>
                </thead>
                <tbody id="add">
                    <tr>
                        <td><select class="form-control select2" id="acc_code_1" name="acc_code[]" class="input_text" style="width: 80%;" onchange="set_gr(1)" required>
                                <option value="">Select</option>
                                <?php
                                foreach ($row as $value) {
                                    echo "<option value=" . $value->sl_no . ">" . $value->ac_name . "</option>";
                                }
                                ?>
                            </select></td>
                        <td>
                        <input type="text" class="transparent_tag" id="type_1" name="type_id[]" style="width: 100%;" readonly title="">
                        </td>   
                        <td>
                            <input type="text" class="transparent_tag" id="gr_id_1" name="gr_id[]" style="width: 100%;" title="" readonly>
                        </td>
                       
                        <td>
                            <input type="text" class="form-control amount_cls" id="amt" name="amount[]" style="width: 100%; text-align: right;" oninput="validate(this)" title="" required>
                        </td>
                        <td>
                            <input type="text" class="transparent_tag" id="dc_flg" name="dc_flg[]" style="width: 100%; text-align: center;" readonly>
                        </td>
                    </tr>
                </tbody>
                <tr><td colspan="2"><td>
                    <td colspan="3" style="text-align:right;"><strong>Total:</strong> <input name="tot_amt" type="text" class="transparent_tag" id="tot_amt" style="text-align:left; color:#c1264d; font-size: 25px; width:35%;" readonly>
                    </td>
                </tr>
            </table>

            <div class="form-group row">

                <div class="col-sm-10">

                    <input type="button" name="submit" id="submit" value="Save" class="btn btn-info" />

                </div>

            </div>

        </form>

    </div>

</div>


<script>
    $(".select_2").select2();
</script>

<script>
    $('#submit').on('click', function(e) {
        $('input[name^=amount]').map(function(idx, elem) {
            if ($(elem).val() > 0) {} else {
                e.preventDefault();
                alert('Amount Can Not Be 0');
                return false;
            }
            // console.log();
        })
    });

    $('#t_type').on('change', function() {
        var t_val = $(this).val();
        var t_label_no = '';
        var t_label_dt = '';
        if (t_val == 'C') {
            t_label_no = 'Checque No.:';
            t_label_dt = 'Checque Date:';
        } else {
            t_label_no = 'Reference No.:';
            t_label_dt = 'Reference Date:';
        }
        $('#t_label_no').html(t_label_no);
        $('#t_label_dt').html(t_label_dt);
    })
</script>

<script>
    var g_flg;

    function set_dr_cr() {
        var flag;

        if (document.getElementById('v_type').value == 'R') {
            flag = 'Debit';
            g_flg = 'Credit';
        } else if (document.getElementById('v_type').value == 'P') {
            flag = 'Credit';
            g_flg = 'Debit';
        } else {
            flag = '';
            g_flg = '';
        }

        document.getElementById('dc').value = flag;
        document.getElementById('dc_flg').value = g_flg;
    }


    function valid_data() {
        var voucher_type = document.getElementById('v_type').value;
        var start_session_year ='<?php  echo financialyear($this->session->userdata['loggedin']['fin_yr'],0); ?>';
        var end_session_year ='<?php  echo financialyear($this->session->userdata['loggedin']['fin_yr'],1); ?>';
        var voucher_dt   = $('#date').val();
        if(new Date(voucher_dt) < new Date(start_session_year))
        {
            alert("Voucher date cannot be before Financial year");
            return false;  
        }
        if(new Date(voucher_dt) > new Date(end_session_year))
        {
            alert("Voucher date cannot be After Financial year");
            return false;  
        }
        if (voucher_type == '0') {
            alert("Please Supply Voucher Type");
            return false;
        }

        var dc_flag = document.getElementById('dc').value;
        if (dc_flag.trim() == '') {
            alert("Invalid Input");
            return false;
        }

        var dr_cr = document.getelementById('dc_flg').value;
        if (dr_cr.trim() == '') {
            alert("Invalid Input");
            return false;
        }

    }
</script>


<script>
    $('.mindate').attr('min',
    		'<?=$date->end_yr ?>-<?php $month=$date->end_mnth+1; if($month==13){echo sprintf("%02d",1);}else{echo sprintf("%02d",$month);}?>-01'
    		);
</script>