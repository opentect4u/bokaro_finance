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

tr:hover {background-color: #f5f5f5;}

</style>
    
    <div class="wraper">      
        <div class="col-md-6 container form-wraper">
    
			<form method="POST" id="form" action="<?php echo site_url("report/ac_detail");?>" >

                <div class="form-header">
                    <h4>Account detail Inputs</h4>
                </div>

                <div class="form-group row">

                    <label for="from_dt" class="col-sm-2 col-form-label">From Date:</label>
                    <div class="col-sm-6">
                        <input type="date"
                               name="from_date"
                               class="form-control required"
                               value="<?php echo date('Y-m-d');?>"/> 
                    </div>
                </div>

                <div class="form-group row">

                    <label for="to_date" class="col-sm-2 col-form-label">To Date:</label>

                    <div class="col-sm-6">
                        <input type="date"
                               name="to_date"
                               class="form-control required"
                               value="<?php echo date('Y-m-d');?>"/>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="to_date" class="col-sm-2 col-form-label">Acount Head:</label>
                    <div class="col-sm-6">
						<select class="form-control sch_cd select2"  name="acc_head" required>
						   <option value="">Select</option>
						  <?php foreach($acc_head as $key){?>
						   <option value="<?php if(isset($key->sl_no)){ echo $key->sl_no; }?>"><?php if(isset($key->ac_name)){ echo $key->ac_name.' '.$key->benfed_ac_code; }?></option>
						   <?php } ?>
						</select>
                    </div>
                </div> 
				
                <div class="form-group row">
                    <div class="col-sm-10">
                        <input type="submit" class="btn btn-info" value="Submit" />
                    </div>

                </div>

            </form>    

        </div>

    </div>

    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet" />
<link href="https://cdn.datatables.net/buttons/1.5.1/css/buttons.dataTables.min.css" rel="stylesheet" />

<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
<!-- <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script> -->
<!-- <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script> -->

<script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>

<script>
   $('#example').dataTable({
    destroy: true,
   searching: false,ordering: false,paging: false,

dom: 'Bfrtip',
buttons: [
   {
extend: 'excelHtml5',
title: 'Account details report',
text: 'Export to excel'
//Columns to export
// exportOptions: {
//    columns: [0, 1, 2, 3]
// }
   }
]
   });
</script>