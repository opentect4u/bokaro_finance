<?php
$gr_dtls = json_decode($gr_dtls);
$br_dtls = json_decode($br_dtls);
$subgr_dtls = json_decode($subgr_dtls);
?>
<div class="wraper">

    <div class="col-md-6 container form-wraper">
        <form method="POST" action="<?php echo site_url('master/ac_head_save'); ?>">

            <div class="form-header">
                <h4>Add A/C Head</h4>
            </div>

            <div class="form-group row">

                <label for="gr_id" class="col-sm-2 col-form-label">Group</label>

                <div class="col-sm-10">
                    <select class="form-control select2" id="gr_id" name="gr_id" required>
                        <option value="">Select</option>
                        <?php 
                        foreach ($gr_dtls as $dt) {
                            $select = '';
                            if ($dt->sl_no == $selected['gr_id']) {
                                 $select = 'selected';
                             }
                        ?>
                            <option value='<?=$dt->sl_no ?>' <?=$select ?>><?= strtoupper($dt->name) ?></option>
                        <?php } ?>
                    </select>
                </div>

            </div>
            <div class="form-group row">

                <label for="subgr_id" class="col-sm-2 col-form-label">Sub Group</label>

                <div class="col-sm-10">

                    <select class="form-control" id="subgr_id" name="subgr_id" required>
                        <option value="">Select</option>
                        <?php
                        if ($subgr_dtls) {
                            foreach ($subgr_dtls as $dt) {
                                $select = '';
                                if ($dt->sl_no == $selected['subgr_id']) {
                                    $select = 'selected';
                                }
                        ?>
                                <option value='<?= $dt->sl_no ?>' <?= $select ?>><?= strtoupper($dt->name) ?></option>
                        <?php }
                        } ?>
                    </select>
                </div>

            </div>
            <div class="form-group row">

                <label for="br_id" class="col-sm-2 col-form-label">Branch</label>

                <div class="col-sm-10">
                    <select class="form-control select_2" id="br_id" name="br_id" required>
                        <option value="">Select</option>
                        <?php $select = '';
                        foreach ($br_dtls as $dt) {  
                        ?>
                            <option value='<?= $dt->id ?>' <?php if ($dt->id == $selected['br_id']) { echo 'selected'; } ?>>
                            <?= strtoupper($dt->branch_name) ?></option>
                        <?php } ?>
                    </select>
                </div>

            </div>

            <div class="form-group row">

                <label for="ac_flg" class="col-sm-2 col-form-label">A/C Head Name</label>

                <div class="col-sm-10">

                    <input type="text" class="form-control" id="achead" name="achead" required="required" value="<?= $selected['achead'] ?>" required/>

                </div>

            </div>
            <div class="form-group row">

                <label for="benfed_ac_code" class="col-sm-2 col-form-label">Existing Account No(If any)</label>

                <div class="col-sm-10">

                    <input type="text" class="form-control" id="benfed_ac_code" name="benfed_ac_code" required="required" value="<?= $selected['benfed_ac_code'] ?>" required/>

                </div>

            </div>

            <input type="hidden" name="id" value="<?= $selected['id'] ?>">

            <div class="form-group row">

                <div class="col-sm-10">

                    <input type="submit" class="btn btn-info" value="Save" />

                </div>

            </div>

        </form>

    </div>

</div>

<script>
   // $(".select_2").select2();
</script>

<script>
    $("#gr_id").on('change', function() {
        $.ajax({
            type: "GET",
            url: "<?php echo site_url('master/get_subgr_dtls'); ?>",
            data: {
                gr_id: $(this).val()
            },
            dataType: 'html',
            success: function(result) {
                //    console.log(result);
                var result = $.parseJSON(result);
                if (result.length > 0) {
                    $('#subgr_id').empty();
                    $('#subgr_id').append($('<option>', {
                        value: '',
                        text: 'Select'
                    }));
                    $.each(result, function(i, item) {
                        $('#subgr_id').append($('<option>', {
                            value: item.id,
                            text: item.name
                        }));
                    });
                } else {
                    $('#subgr_id').empty();
                    $('#subgr_id').append($('<option>', {
                        value: '',
                        text: 'Select'
                    }));
                }
            }
        });
    });
</script>