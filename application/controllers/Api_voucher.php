<?php
	class Api_voucher extends CI_Controller{
		protected $sysdate;
		protected $kms_year;
		public function __construct(){
		parent::__construct();	
        $this->load->model('Transaction_model');
        $this->load->model('Api_model');
        }

	
        public function f_acc_code(){
		 
            $select	=	array("a.*");
            $data    = $this->Api_model->f_select("md_achead a",$select,NULL,0);
            // $curl = curl_init();
            echo json_encode($data);
        }
        public function company_payAdd(){
            $acc = $this->Transaction_model->f_select('md_achead ',Null,NULL,0); 

            $curl = curl_init();
		
			curl_setopt_array($curl, array(
		
			CURLOPT_URL => 'http://localhost/benfed/benfed_fertilizer/index.php/compay/comp_acc',
             //CURLOPT_URL => 'http://benfed.in/benfed_fertilizer/index.php/compay/comp_acc',
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => '',
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 0,
			  CURLOPT_FOLLOWLOCATION => true,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => 'POST',
			  CURLOPT_POSTFIELDS =>'{
				"data": '.json_encode($acc).'
			}',
			
			  CURLOPT_HTTPHEADER => array(
				'Content-Type: application/json',
				'Cookie: ci_session=eieqmu6gupm05pkg5o78jqbq97jqb22g'
			  ),
			));
			
			$response = curl_exec($curl);
			
			curl_close($curl);
			echo $response;
			
	
        }
/************************Member_subscription Voucher ************************* */
public function member_subscription(){
             
    $input = file_get_contents("php://input");
   
    $dt = json_decode($input, true);
    $fin_yr['fin_yr']= $dt['data']['fin_yr'];      ///    Finance ID
   
    $sl_no    = $this->Transaction_model->f_get_voucher_id($fin_yr['fin_yr']);
    $v_srl=$sl_no->sl_no;

    $v_id= $dt['data']['br_nm'].'/'.$dt['data']['fin_fulyr'].'/'.$v_srl;

     $input_data = array(
    'voucher_date'   => date('Y-m-d'),
    'sl_no'          => $v_srl,
    'voucher_id'     => $v_id,
    'branch_id'      => $dt['data']['branch_id'],
    'trans_no'       => $dt['data']['trans_no'],
    'trans_dt'       => $dt['data']['trans_dt'],  
    'voucher_type'   => 'G',
    'transfer_type'  => $dt['data']['transfer_type'],
    'voucher_mode'   => $dt['data']['voucher_mode'],
    'voucher_through'=> 'A',
    'acc_code'       => $dt['data']['acc_cd_cr'],
    'dr_cr_flag'     => 'Cr',
    'amount'         => $dt['data']['amount'],
    'ins_no'         => $dt['data']['ins_no'],
    'ins_dt'         => $dt['data']['ins_no'],
    'bank_name'      => '',
    'remarks'        => $dt['data']['remarks'],
    'approval_status'=> 'A',
    'user_flag'      =>'',
    'created_dt'     => $dt['data']['created_dt'],
    'created_by'     => $dt['data']['created_by'],
    'modified_by'    => '',
    'modified_dt'    => '',
    'approved_by'    => 'AUTO',
    'approved_dt'    => $dt['data']['created_dt'],
    'fin_yr'         => $dt['data']['fin_yr']    
);
$input_dr = array(
    'voucher_date'   => date('Y-m-d'),
    'sl_no'          => $v_srl,
    'voucher_id'     =>  $v_id,
    'branch_id'      => $dt['data']['branch_id'],
    'trans_no'       => $dt['data']['trans_no'],
    'trans_dt'       => $dt['data']['trans_dt'],  
    'voucher_type'   => 'G',
    'transfer_type'  => $dt['data']['transfer_type'],
    'voucher_mode'   => $dt['data']['voucher_mode'],
    'voucher_through'=> 'A',
    'acc_code'       => $dt['data']['acc_cd_dr'],
    'dr_cr_flag'     => 'Dr',
    'amount'         => $dt['data']['amount'],
    'ins_no'         => $dt['data']['ins_no'],
    'ins_dt'         => $dt['data']['ins_dt'],
    'bank_name'      => '',
    'remarks'        => $dt['data']['remarks'],
    'approval_status'=> 'A',
    'user_flag'      => '',
    'created_dt'     => $dt['data']['created_dt'],
    'created_by'     => $dt['data']['created_by'],
    'modified_by'    => '',
    'modified_dt'    => '',
    'approved_by'    => 'AUTO',
    'approved_dt'    => $dt['data']['created_dt'],
    'fin_yr'         => $dt['data']['fin_yr']    
   );
    // print_r($input_data);
    // print_r($input_dr);

    if($this->db->insert('td_vouchers', $input_data) && $this->db->insert('td_vouchers', $input_dr)){
    return 1;
    }else{
        return 0;
    }  
                 
    }

/************************************************* */


        public function sale_voucher(){
             
        $input = file_get_contents("php://input");
        $count = 0;
        $dt = json_decode($input, true);
        $fin_yr['fin_yr']= $dt['data']['fin_yr'];

        
        $select    = array("max(sl_no)+1 as sl" );
        $where     =$fin_yr;
           // print_r( $where);
		$sl_no    = $this->Transaction_model->f_get_voucher_id($fin_yr['fin_yr']);
        $v_srl=$sl_no->sl_no;
		$v_id= $dt['data']['br_nm'].'/'.$dt['data']['fin_fulyr'].'/'.$v_srl;	
        $query1 = $this->db->get_where('td_vouchers', array('trans_no =' => $dt['data']['trans_do'],'acc_code ='=>$dt['data']['acc_cd']))->result();
        if(count($query1) == 0){
         $input_data = array(
        'voucher_date'   => $dt['data']['do_dt'],
        'sl_no'          => $v_srl,
        'voucher_id'     => $v_id,
        'branch_id'      => $dt['data']['br_cd'],
        'trans_no'       => $dt['data']['trans_do'],
        'trans_dt'       => $dt['data']['do_dt'],  
        'voucher_type'   => 'SL',
        'transfer_type'  => 'T',
        'voucher_mode'   => 'J',
        'voucher_through'=> 'A',
        'acc_code'       => $dt['data']['acc_cd'],
        'dr_cr_flag'     => 'DR',
        'amount'         => $dt['data']['tot_amt'],
        'ins_no'         => '',
        'ins_dt'         => '',
        'bank_name'      => '',
        'remarks'        => $dt['data']['rem'],
        'approval_status'=> 'A',
        'user_flag'      =>'',
        'created_dt'     => $dt['data']['created_dt'],
        'created_by'     => $dt['data']['created_by'],
        'modified_by'    => '',
        'modified_dt'    => '',
        'approved_by'    => 'AUTO',
        'approved_dt'    => $dt['data']['created_dt'],
        'fin_yr'         => $dt['data']['fin_yr']    
         );
        $this->db->insert('td_vouchers', $input_data);
        $count ++;
      }

      $query2 = $this->db->get_where('td_vouchers', array('trans_no =' => $dt['data']['trans_do'],'acc_code ='=>8245))->result();
      if(count($query2) == 0){
        $input_cgst = array(
            'voucher_date'   => $dt['data']['do_dt'],
            'sl_no'          => $v_srl,
            'voucher_id'     => $v_id,
            'branch_id'      => $dt['data']['br_cd'],
            'trans_no'       => $dt['data']['trans_do'],
            'trans_dt'       => $dt['data']['do_dt'],  
            'voucher_type'   => 'SL',
            'transfer_type'  => 'T',
            'voucher_mode'   => 'J',
            'voucher_through'=> 'A',
            'acc_code'       => 8245,            //   Change on 31/03/2023 will active from 01/04/2023
            'dr_cr_flag'     => 'CR',
            'amount'         => $dt['data']['cgst'],
            'ins_no'         => '',
            'ins_dt'         => '',
            'bank_name'      => '',
            'remarks'        => $dt['data']['rem'],
            'approval_status'=> 'A',
            'user_flag'      => '',
            'created_dt'     => $dt['data']['created_dt'],
            'created_by'     => $dt['data']['created_by'],
            'modified_by'    => '',
            'modified_dt'    => '',
            'approved_by'    => 'AUTO',
            'approved_dt'    => $dt['data']['created_dt'],
            'fin_yr'         => $dt['data']['fin_yr']    
        );
        $this->db->insert('td_vouchers', $input_cgst) ;
        $count ++;
     }
     $query3 = $this->db->get_where('td_vouchers', array('trans_no =' => $dt['data']['trans_do'],'acc_code ='=>8246))->result();
      if(count($query3) == 0){
       $input_sgst = array(
        'voucher_date'   => $dt['data']['do_dt'],
        'sl_no'          => $v_srl,
        'voucher_id'     => $v_id,
        'branch_id'      => $dt['data']['br_cd'],
        'trans_no'       => $dt['data']['trans_do'],
        'trans_dt'       => $dt['data']['do_dt'],  
        'voucher_type'   => 'SL',
        'transfer_type'  => 'T',
        'voucher_mode'   => 'J',
        'voucher_through'=> 'A',
        'acc_code'       => 8246,        //   Change on 31/03/2023 will active from 01/04/2023
        'dr_cr_flag'     => 'CR',
        'amount'         => $dt['data']['sgst'],
        'ins_no'         => '',
        'ins_dt'         => '',
        'bank_name'      => '',
        'remarks'        => $dt['data']['rem'],
        'approval_status'=> 'A',
        'user_flag'      => '',
        'created_dt'     => $dt['data']['created_dt'],
        'created_by'     => $dt['data']['created_by'],
        'modified_by'    => '',
        'modified_dt'    => '',
        'approved_by'    => 'AUTO',
        'approved_dt'    => $dt['data']['created_dt'],
        'fin_yr'         => $dt['data']['fin_yr']    
     );
     $this->db->insert('td_vouchers', $input_sgst);
     $count ++;
     }
     $query4 = $this->db->get_where('td_vouchers', array('trans_no =' => $dt['data']['trans_do'],'acc_code ='=>2207))->result();
     if(count($query4) == 0){
        $input_sale = array(
            'voucher_date'   => $dt['data']['do_dt'],
            'sl_no'          =>  $v_srl,
            'voucher_id'     => $v_id,
            'branch_id'      => $dt['data']['br_cd'],
            'trans_no'       => $dt['data']['trans_do'],
            'trans_dt'       => $dt['data']['do_dt'],  
            'voucher_type'   => 'SL',
            'transfer_type'  => 'T',
            'voucher_mode'   => 'J',
            'voucher_through'=> 'A',
            'acc_code'       => 2207,
            'dr_cr_flag'     => 'CR',
            'amount'         => $dt['data']['taxable_amt'],
            'ins_no'         => '',
            'ins_dt'         => '',
            'bank_name'      => '',
            'remarks'        => $dt['data']['rem'],
            'approval_status'=> 'A',
            'user_flag'      => '',
            'created_dt'     => $dt['data']['created_dt'],
            'created_by'     => $dt['data']['created_by'],
            'modified_by'    => '',
            'modified_dt'    => '',
            'approved_by'    => 'AUTO',
            'approved_dt'    => $dt['data']['created_dt'],
            'fin_yr'         => $dt['data']['fin_yr']    
        );

        $this->db->insert('td_vouchers', $input_sale);
        $count ++;
        }

       //  echo '<pre>';
       //echo 'input_data<br>'; var_dump($input_data);
      
       //exit;

        if($count == 4    ){
			//echo $this->db->last_query();
			//exit;
        return 1;
    }else{
        return 0;
    }  
                     
        }

    public function sale_voucher_ins(){
             
            $input = file_get_contents("php://input");
           
            $dt = json_decode($input, true);
            $fin_yr['fin_yr']= $dt['data']['fin_yr'];
            
            $select    = array("max(sl_no)+1 as sl" );
            $where     =$fin_yr;
                
            $sl_no    = $this->Transaction_model->f_get_voucher_id($fin_yr['fin_yr']);
            $v_srl=$sl_no->sl_no;
            $v_id= $dt['data']['br_nm'].'/'.$dt['data']['fin_fulyr'].'/'.$v_srl;	
          
             $input_data = array(
            'voucher_date'   => $dt['data']['do_dt'],
            'sl_no'          => $v_srl,
            'voucher_id'     => $v_id,
            'branch_id'      => $dt['data']['br_cd'],
            'trans_no'       => $dt['data']['trans_do'],
            'trans_dt'       => $dt['data']['do_dt'],  
            'voucher_type'   => 'SL',
            'transfer_type'  => 'T',
            'voucher_mode'   => 'J',
            'voucher_through'=> 'A',
            'acc_code'       => $dt['data']['acc_cd'],
            'dr_cr_flag'     => 'DR',
            'amount'         => $dt['data']['tot_amt'],
            'ins_no'         => '',
            'ins_dt'         => '',
            'bank_name'      => '',
            'remarks'        => $dt['data']['rem'],
            'approval_status'=> 'A',
            'user_flag'      =>'',
            'created_dt'     => $dt['data']['created_dt'],
            'created_by'     => $dt['data']['created_by'],
            'modified_by'    => '',
            'modified_dt'    => '',
            'approved_by'    => 'AUTO',
            'approved_dt'    => $dt['data']['created_dt'],
            'fin_yr'         => $dt['data']['fin_yr']    
        );
        $input_cgst = array(
            'voucher_date'   => $dt['data']['do_dt'],
             'sl_no'          => $v_srl,
            'voucher_id'     => $v_id,
            'branch_id'      => $dt['data']['br_cd'],
            'trans_no'       => $dt['data']['trans_do'],
            'trans_dt'       => $dt['data']['do_dt'],  
            'voucher_type'   => 'SL',
            'transfer_type'  => 'T',
            'voucher_mode'   => 'J',
            'voucher_through'=> 'A',
            'acc_code'       => 8245,            //   Change on 31/03/2023 will active from 01/04/2023
            'dr_cr_flag'     => 'CR',
            'amount'         => $dt['data']['cgst'],
            'ins_no'         => '',
            'ins_dt'         => '',
            'bank_name'      => '',
            'remarks'        => $dt['data']['rem'],
            'approval_status'=> 'A',
            'user_flag'      => '',
            'created_dt'     => $dt['data']['created_dt'],
            'created_by'     => $dt['data']['created_by'],
            'modified_by'    => '',
            'modified_dt'    => '',
            'approved_by'    => 'AUTO',
            'approved_dt'    => $dt['data']['created_dt'],
            'fin_yr'         => $dt['data']['fin_yr']    
        );
        
        $input_sgst = array(
            'voucher_date'   => $dt['data']['do_dt'],
            'sl_no'          => $v_srl,
            'voucher_id'     => $v_id,
            'branch_id'      => $dt['data']['br_cd'],
            'trans_no'       => $dt['data']['trans_do'],
            'trans_dt'       => $dt['data']['do_dt'],  
            'voucher_type'   => 'SL',
            'transfer_type'  => 'T',
            'voucher_mode'   => 'J',
            'voucher_through'=> 'A',
            'acc_code'       => 8246,        //   Change on 31/03/2023 will active from 01/04/2023
            'dr_cr_flag'     => 'CR',
            'amount'         => $dt['data']['sgst'],
            'ins_no'         => '',
            'ins_dt'         => '',
            'bank_name'      => '',
            'remarks'        => $dt['data']['rem'],
            'approval_status'=> 'A',
            'user_flag'      => '',
            'created_dt'     => $dt['data']['created_dt'],
            'created_by'     => $dt['data']['created_by'],
            'modified_by'    => '',
            'modified_dt'    => '',
            'approved_by'    => 'AUTO',
            'approved_dt'    => $dt['data']['created_dt'],
            'fin_yr'         => $dt['data']['fin_yr']    
         );
         
            $input_sale = array(
                'voucher_date'   => $dt['data']['do_dt'],
                'sl_no'          =>  $v_srl,
                'voucher_id'     => $v_id,
                'branch_id'      => $dt['data']['br_cd'],
                'trans_no'       => $dt['data']['trans_do'],
                'trans_dt'       => $dt['data']['do_dt'],  
                'voucher_type'   => 'SL',
                'transfer_type'  => 'T',
                'voucher_mode'   => 'J',
                'voucher_through'=> 'A',
                'acc_code'       => 11335,
                'dr_cr_flag'     => 'CR',
                'amount'         => $dt['data']['taxable_amt'],
                'ins_no'         => '',
                'ins_dt'         => '',
                'bank_name'      => '',
                'remarks'        => $dt['data']['rem'],
                'approval_status'=> 'A',
                'user_flag'      => '',
                'created_dt'     => $dt['data']['created_dt'],
                'created_by'     => $dt['data']['created_by'],
                'modified_by'    => '',
                'modified_dt'    => '',
                'approved_by'    => 'AUTO',
                'approved_dt'    => $dt['data']['created_dt'],
                'fin_yr'         => $dt['data']['fin_yr']    
            );
    
            if($this->db->insert('td_vouchers', $input_data) && $this->db->insert('td_vouchers', $input_cgst) && $this->db->insert('td_vouchers', $input_sgst) && $this->db->insert('td_vouchers', $input_sale) ){
            return 1;
        }else{
            return 0;
        }  
    }


    public function salecrn_voucher(){
             
        $input = file_get_contents("php://input");
       
        $dt = json_decode($input, true);
        $fin_yr['fin_yr']= $dt['data']['fin_yr'];

        
        $select    = array("max(sl_no)+1 as sl" );
        $where     =$fin_yr;
           // print_r( $where);
        $v_id = $this->Transaction_model->f_select('td_vouchers ',$select,$where,1);
          // echo $this->db->last_query();
         //  print_r( $v_id);
        // var_dump($v_id);
       // exit;
  
         $input_data = array(
        'voucher_date'   => $dt['data']['do_dt'],
        // 'sl_no'          => $v_id->sl,
        'voucher_id'     => 'SALE'.$dt['data']['trans_do'],
        'branch_id'      => $dt['data']['br_cd'],
        'trans_no'       => $dt['data']['trans_do'],
        'trans_dt'       => $dt['data']['do_dt'],  
        'voucher_type'   => 'SL',
        'transfer_type'  => 'T',
        'voucher_mode'   => 'J',
        'voucher_through'=> 'A',
        'acc_code'       => $dt['data']['soc_id'],
        'dr_cr_flag'     => 'CR',
        'amount'         => $dt['data']['tot_amt'],
        'ins_no'         => '',
        'ins_dt'         => '',
        'bank_name'      => '',
        'remarks'        => $dt['data']['rem'],
        'approval_status'=> 'A',
        'user_flag'      =>'',
        'created_dt'     => $dt['data']['created_dt'],
        'created_by'     => $dt['data']['created_by'],
        'modified_by'    => '',
        'modified_dt'    => '',
        'approved_by'    => 'AUTO',
        'approved_dt'    => $dt['data']['created_dt'],
        'fin_yr'         => $dt['data']['fin_yr']    
    );
    $input_cgst = array(
        'voucher_date'   => $dt['data']['do_dt'],
        // 'sl_no'          => $v_id->sl,
        'voucher_id'     => 'SALE'.$dt['data']['trans_do'],
        'branch_id'      => $dt['data']['br_cd'],
        'trans_no'       => $dt['data']['trans_do'],
        'trans_dt'       => $dt['data']['do_dt'],  
        'voucher_type'   => 'SL',
        'transfer_type'  => 'T',
        'voucher_mode'   => 'J',
        'voucher_through'=> 'A',
        'acc_code'       => 2205,
        'dr_cr_flag'     => 'DR',
        'amount'         => $dt['data']['cgst'],
        'ins_no'         => '',
        'ins_dt'         => '',
        'bank_name'      => '',
        'remarks'        => $dt['data']['rem'],
        'approval_status'=> 'A',
        'user_flag'      => '',
        'created_dt'     => $dt['data']['created_dt'],
        'created_by'     => $dt['data']['created_by'],
        'modified_by'    => '',
        'modified_dt'    => '',
        'approved_by'    => 'AUTO',
        'approved_dt'    => $dt['data']['created_dt'],
        'fin_yr'         => $dt['data']['fin_yr']    
    );
    
    $input_sgst = array(
        'voucher_date'   => $dt['data']['do_dt'],
        // 'sl_no'          => $v_id->sl,
        'voucher_id'     => 'SALE'.$dt['data']['trans_do'],
        'branch_id'      => $dt['data']['br_cd'],
        'trans_no'       => $dt['data']['trans_do'],
        'trans_dt'       => $dt['data']['do_dt'],  
        'voucher_type'   => 'SL',
        'transfer_type'  => 'T',
        'voucher_mode'   => 'J',
        'voucher_through'=> 'A',
        'acc_code'       => 2206,
        'dr_cr_flag'     => 'DR',
        'amount'         => $dt['data']['sgst'],
        'ins_no'         => '',
        'ins_dt'         => '',
        'bank_name'      => '',
        'remarks'        => $dt['data']['rem'],
        'approval_status'=> 'A',
        'user_flag'      => '',
        'created_dt'     => $dt['data']['created_dt'],
        'created_by'     => $dt['data']['created_by'],
        'modified_by'    => '',
        'modified_dt'    => '',
        'approved_by'    => 'AUTO',
        'approved_dt'    => $dt['data']['created_dt'],
        'fin_yr'         => $dt['data']['fin_yr']    
    );
     
        $input_sale = array(
            'voucher_date'   => $dt['data']['do_dt'],
            // 'sl_no'          => $v_id->sl,
            'voucher_id'     => 'SALE'.$dt['data']['trans_do'],
            'branch_id'      => $dt['data']['br_cd'],
            'trans_no'       => $dt['data']['trans_do'],
            'trans_dt'       => $dt['data']['do_dt'],  
            'voucher_type'   => 'SL',
            'transfer_type'  => 'T',
            'voucher_mode'   => 'J',
            'voucher_through'=> 'A',
            'acc_code'       => 2207,
            'dr_cr_flag'     => 'DR',
            'amount'         => $dt['data']['taxable_amt'],
            'ins_no'         => '',
            'ins_dt'         => '',
            'bank_name'      => '',
            'remarks'        => $dt['data']['rem'],
            'approval_status'=> 'A',
            'user_flag'      => '',
            'created_dt'     => $dt['data']['created_dt'],
            'created_by'     => $dt['data']['created_by'],
            'modified_by'    => '',
            'modified_dt'    => '',
            'approved_by'    => 'AUTO',
            'approved_dt'    => $dt['data']['created_dt'],
            'fin_yr'         => $dt['data']['fin_yr']    
        );

        // echo '<pre>';
        // echo 'input_data<br>'; var_dump($input_data);
        // echo 'input_cgst<br>'; var_dump($input_cgst);
        // echo 'input_sgst<br>'; var_dump($input_sgst);
        // echo 'input_sale<br>'; var_dump($input_sale);
        // exit;

        if($this->db->insert('td_vouchers', $input_data) && $this->db->insert('td_vouchers', $input_cgst) && $this->db->insert('td_vouchers', $input_sgst) && $this->db->insert('td_vouchers', $input_sale) ){
        return 1;
    }else{
        return 0;
    }  
                     
        }
        //salecrn_voucher

/***************************************** */

// public function salecr_voucher(){
             
//     $input = file_get_contents("php://input");
   
//     $dt = json_decode($input, true);
//     $fin_yr['fin_yr']= $dt['data']['fin_yr'];
    
//     $select    = array("max(sl_no)+1 as sl" );
//     $where     =$fin_yr;
//     // print_r( $where);
//     $v_id = $this->Transaction_model->f_select('td_vouchers ',$select,$where,1);
//     echo $this->db->last_query();
    
//      print_r( $v_id);
//     // var_dump($v_id);
//    // exit;

//      $input_data = array(
//     'voucher_date'   => $dt['data']['do_dt'],
//     'sl_no'          => $v_id->sl,
//     'voucher_id'     => 'SALE'.$dt['data']['trans_do'],
//     'branch_id'      => $dt['data']['br_cd'],
//     'trans_no'       => $dt['data']['trans_do'],
//     'trans_dt'       => $dt['data']['do_dt'],  
//     'voucher_type'   => 'CRN',
//     'transfer_type'  => 'T',
//     'voucher_mode'   => 'J',
//     'voucher_through'=> 'A',
//     'acc_code'       => $dt['data']['soc_id'],
//     'dr_cr_flag'     => 'CR',
//     'amount'         => $dt['data']['tot_amt'],
//     'ins_no'         => '',
//     'ins_dt'         => '',
//     'bank_name'      => '',
//     'remarks'        => 'CRN',
//     'approval_status'=> 'U',
//     'user_flag'      =>'',
//     'created_dt'     => $dt['data']['created_dt'],
//     'created_by'     => $dt['data']['created_by'],
//     'modified_by'    => '',
//     'modified_dt'    => '',
//     'approved_by'    => '',
//     'approved_dt'    => '',
//     'fin_yr'         => $dt['data']['fin_yr']    
// );
// $input_cgst = array(
//     'voucher_date'   => $dt['data']['do_dt'],
//     'sl_no'          => $v_id->sl,
//     'voucher_id'     => 'CRN'.$dt['data']['trans_do'],
//     'branch_id'      => $dt['data']['br_cd'],
//     'trans_no'       => $dt['data']['trans_do'],
//     'trans_dt'       => $dt['data']['do_dt'],  
//     'voucher_type'   => 'CRN',
//     'transfer_type'  => 'T',
//     'voucher_mode'   => 'J',
//     'voucher_through'=> 'A',
//     'acc_code'       => 2205,
//     'dr_cr_flag'     => 'CR',
//     'amount'         => $dt['data']['cgst'],
//     'ins_no'         => '',
//     'ins_dt'         => '',
//     'bank_name'      => '',
//     'remarks'        => 'CRN',
//     'approval_status'=> 'U',
//     'user_flag'      => '',
//     'created_dt'     => $dt['data']['created_dt'],
//     'created_by'     => $dt['data']['created_by'],
//     'modified_by'    => '',
//     'modified_dt'    => '',
//     'approved_by'    => '',
//     'approved_dt'    => '',
//     'fin_yr'         => $dt['data']['fin_yr']    
// );

// $input_sgst = array(
//     'voucher_date'   => $dt['data']['do_dt'],
//     'sl_no'          => $v_id->sl,
//     'voucher_id'     => 'CRN'.$dt['data']['trans_do'],
//     'branch_id'      => $dt['data']['br_cd'],
//     'trans_no'       => $dt['data']['trans_do'],
//     'trans_dt'       => $dt['data']['do_dt'],  
//     'voucher_type'   => 'CRN',
//     'transfer_type'  => 'T',
//     'voucher_mode'   => 'J',
//     'voucher_through'=> 'A',
//     'acc_code'       => 2206,
//     'dr_cr_flag'     => 'DR',
//     'amount'         => $dt['data']['sgst'],
//     'ins_no'         => '',
//     'ins_dt'         => '',
//     'bank_name'      => '',
//     'remarks'        => 'CRN',
//     'approval_status'=> 'U',
//     'user_flag'      => '',
//     'created_dt'     => $dt['data']['created_dt'],
//     'created_by'     => $dt['data']['created_by'],
//     'modified_by'    => '',
//     'modified_dt'    => '',
//     'approved_by'    => '',
//     'approved_dt'    => '',
//     'fin_yr'         => $dt['data']['fin_yr']    
// );
 
//     $input_sale = array(
//         'voucher_date'   => $dt['data']['do_dt'],
//         'sl_no'          => $v_id->sl,
//         'voucher_id'     => 'CRN'.$dt['data']['trans_do'],
//         'branch_id'      => $dt['data']['br_cd'],
//         'trans_no'       => $dt['data']['trans_do'],
//         'trans_dt'       => $dt['data']['do_dt'],  
//         'voucher_type'   => 'CRN',
//         'transfer_type'  => 'T',
//         'voucher_mode'   => 'J',
//         'voucher_through'=> 'A',
//         'acc_code'       => 2207,
//         'dr_cr_flag'     => 'DR',
//         'amount'         => $dt['data']['taxable_amt'],
//         'ins_no'         => '',
//         'ins_dt'         => '',
//         'bank_name'      => '',
//         'remarks'        => 'CRN',
//         'approval_status'=> 'U',
//         'user_flag'      => '',
//         'created_dt'     => $dt['data']['created_dt'],
//         'created_by'     => $dt['data']['created_by'],
//         'modified_by'    => '',
//         'modified_dt'    => '',
//         'approved_by'    => '',
//         'approved_dt'    => '',
//         'fin_yr'         => $dt['data']['fin_yr']    
//     );

//     if($this->db->insert('td_vouchers', $input_data) && $this->db->insert('td_vouchers', $input_cgst) && $this->db->insert('td_vouchers', $input_sgst) && $this->db->insert('td_vouchers', $input_sale) ){
//     return 1;
// }else{
//     return 0;
// }  
                 
//     }

/****************************************************** */
/****************************************************** */
public function recv_voucher_dr(){
             
    $input = file_get_contents("php://input");
   
    $dt = json_decode($input, true);
    // var_dump($dt);exit;
    $fin_yr['fin_yr']= $dt['data']['fin_yr'];
    $paid_id=$dt['data']['paid_id'];
    $select    = array("ISNULL(max(sl_no))+1 as sl" );
    $where     =$fin_yr;
    // print_r( $where);
    $v_id = $this->Transaction_model->f_select('td_vouchers ',$select,NULL,1); 
    // echo $this->db->last_query();
    
     $input_bank     = array(
    'voucher_date'   => $dt['data']['paid_dt'],
    'voucher_id'     =>$dt['data']['paid_id'],
    'branch_id'      => $dt['data']['branch_id'],
    'trans_no'       =>$dt['data']['paid_id'],
    'trans_dt'       => $dt['data']['paid_dt'],  
    'voucher_type'   => 'RECV',
    'transfer_type'  => 'T',
    'voucher_mode'   => 'J',
    'voucher_through'=> 'A',
    'acc_code'       => $dt['data']['adv_acc'],
    'dr_cr_flag'     => 'DR',
    'amount'         => $dt['data']['paid_amt'],
    'ins_no'         => '',
    'ins_dt'         => '',
    'bank_name'      => '',
    'remarks'        => $dt['data']['rem'],
    'approval_status'=> 'A',
    'user_flag'      =>'',
    'created_dt'     => $dt['data']['created_dt'],
    'created_by'     => $dt['data']['created_by'],
    'modified_by'    => '',
    'modified_dt'    => '',
    'approved_by'    => 'AUTO',
    'approved_dt'    => $dt['data']['created_dt'],
    'fin_yr'         => $dt['data']['fin_yr']    
);
if($this->db->insert('td_vouchers', $input_bank) ){
    return 1;
}else{
    return 0;
}  
 }

 public function delete_voucher_dr(){
    $input = file_get_contents("php://input");
    $dt = json_decode($input, true);
     $input_bank     = array(
        'voucher_id'     =>$dt['data']['paid_id'],
    );



    $data=$this->Transaction_model->f_select('td_vouchers',null,$input_bank,0);
    foreach ($data as $keydata) {
        $keydata->delete_by = $dt['data']['delete_by'];
        $keydata->delete_dt = date('Y-m-d H:m:s');
        // print_r($keydata);
        $this->db->insert('td_vouchers_delete', $keydata);

    }

    if($this->db->delete('td_vouchers', $input_bank) ){
        echo 1;
    }else{
        echo 0;
    }  
 }

 public function  recv_voucher_soc(){
             
    $input = file_get_contents("php://input");
    $dt = json_decode($input, true);
    // var_dump($dt);exit;
    $fin_yr['fin_yr']= $dt['data']['fin_yr'];
    $paid_id=$dt['data']['paid_id'];
    $select    = array("ISNULL(max(sl_no))+1 as sl" );
    $where     =$fin_yr;
    // print_r( $where);
    $v_id = $this->Transaction_model->f_select('td_vouchers ',$select,NULL,1);
    
    // echo $this->db->last_query();
    
     $input_bank     = array(
    'voucher_date'   => $dt['data']['paid_dt'],
    'voucher_id'     =>  $dt['data']['paid_id'],
    'branch_id'      => $dt['data']['branch_id'],
    'trans_no'       =>$dt['data']['paid_id'],
    'trans_dt'       => $dt['data']['paid_dt'],  
    'voucher_type'   => 'RECV',
    'transfer_type'  => 'T',
    'voucher_mode'   => 'J',
    'voucher_through'=> 'A',
    // 'acc_code'       => $dt['data']['soc_id'],
    'acc_code'       => $dt['data']['acc_cd'],
    'dr_cr_flag'     => 'CR',
    'amount'         => $dt['data']['paid_amt'],
    'ins_no'         => '',
    'ins_dt'         => '',
    'bank_name'      => '',
    'remarks'        => $dt['data']['rem'],
    'approval_status'=> 'A',
    'user_flag'      =>'',
    'created_dt'     => $dt['data']['created_dt'],
    'created_by'     => $dt['data']['created_by'],
    'modified_by'    => '',
    'modified_dt'    => '',
    'approved_by'    => 'AUTO',
    'approved_dt'    => $dt['data']['created_dt'],
    'fin_yr'         => $dt['data']['fin_yr']    
);
if($this->db->insert('td_vouchers', $input_bank) ){
    return 1;
}else{
    return 0;
}  
 }


public function recv_voucher(){
             
    $input = file_get_contents("php://input");
    
    $dt = json_decode($input, true);
    // var_dump($dt);exit;
    $fin_yr['fin_yr']= $dt['data']['fin_yr'];
    $paid_id=$dt['data']['paid_id'];
    $cshbank_flag['cshbank'] = $dt['data']['cshbank'];
    $br_id['branch_id'] = $dt['data']['branch_id'];
    $select    = array("ISNULL(max(sl_no))+1 as sl" );
    // $where     =$fin_yr;
    // print_r( $where);
    $v_id = $this->Transaction_model->f_select('td_vouchers ',$select,NULL,1);
    
    if ( $cshbank_flag['cshbank']==0){
        $select_cash    = array("sl_no" );
        $where_cash  = array(
            "mngr_id"   => 6 ,
            "subgr_id"  => 56,
            "br_id"     => $br_id['branch_id']);
        $cshbank_code = $this->Transaction_model->f_select('md_achead ',$select_cash ,$where_cash,1);
        
        $input_data = array(
            'voucher_date'   => $dt['data']['paid_dt'],
            //'sl_no'          => $v_id->sl,
            'voucher_id'     =>$dt['data']['paid_id'],
            'branch_id'      => $dt['data']['branch_id'],
            'trans_no'       => $dt['data']['paid_id'],
            'trans_dt'       => $dt['data']['paid_dt'],  
            'voucher_type'   => 'A',
            'transfer_type'  => 'T',
            'voucher_mode'   => 'J',
            'voucher_through'=> 'A',
            // 'acc_code'       => $dt['data']['soc_id'],
            'acc_code'       => $cshbank_code->sl_no ,
            'dr_cr_flag'     => 'DR',
            'amount'         => $dt['data']['paid_amt'],
            'ins_no'         => '',
            'ins_dt'         => '',
            'bank_name'      => '',
            'remarks'        => $dt['data']['rem'],
            'approval_status'=> 'A',
            'user_flag'      =>'',
            'created_dt'     => $dt['data']['created_dt'],
            'created_by'     => $dt['data']['created_by'],
            'modified_by'    => '',
            'modified_dt'    => '',
            'approved_by'    => 'AUTO',
            'approved_dt'    => $dt['data']['created_dt'],
            'fin_yr'         => $dt['data']['fin_yr']    
        );
         // if($this->db->insert('td_vouchers', $input_bank) && $this->db->insert('td_vouchers', $input_soc) ){
            if( $this->db->insert('td_vouchers', $input_data)){
                // echo 'true';
        echo '1';
    }else{
        // echo 'False';
        echo '0';
    }  
    }else{

    

$input_soc = array(
    'voucher_date'   => $dt['data']['paid_dt'],
    'voucher_id'     =>  $dt['data']['paid_id'],
    'branch_id'      => $dt['data']['branch_id'],
    'trans_no'       => $dt['data']['paid_id'],
    'trans_dt'       => $dt['data']['paid_dt'],  
    'voucher_type'   => 'RECV',
    'transfer_type'  => 'T',
    'voucher_mode'   => 'J',
    'voucher_through'=> 'A',
    // 'acc_code'       => $dt['data']['bnk_id'],
    'acc_code'       => $dt['data']['abk_acc_code'],
    'dr_cr_flag'     => 'DR',
    'amount'         => $dt['data']['paid_amt'],
    'ins_no'         => '',
    'ins_dt'         => '',
    'bank_name'      => '',
    'remarks'        => $dt['data']['rem'],
    'approval_status'=> 'A',
    'user_flag'      => '',
    'created_dt'     => $dt['data']['created_dt'],
    'created_by'     => $dt['data']['created_by'],
    'modified_by'    => '',
    'modified_dt'    => '',
    'approved_by'    => 'AUTO',
    'approved_dt'    => $dt['data']['created_dt'],
    'fin_yr'         => $dt['data']['fin_yr']    
);
 // if($this->db->insert('td_vouchers', $input_bank) && $this->db->insert('td_vouchers', $input_soc) ){
    if( $this->db->insert('td_vouchers', $input_soc) ){
        // echo 'true';
echo '1';
}else{
// echo 'False';
echo '0';
}  
}
   
                 
    }


 /* public function compay_voucher(){

        $input = file_get_contents("php://input");
       
        $dt = json_decode($input, true);
         $fin_yr['fin_yr']= $dt['data']['fin_yr'];
        
        $select    = array("max(sl_no)+1 as sl" );
        $where     = $fin_yr;
        
        $v_id = $this->Transaction_model->f_select('td_vouchers ',$select,$where,1);
        $input_bank     = array(
            'voucher_date'   => $dt['data']['pay_dt'],
            'voucher_id'     =>  'PMT'.$dt['data']['pay_no'],
            'branch_id'      => 332,
            'trans_no'       =>'PMT'.$dt['data']['pay_no'],
            'trans_dt'       => $dt['data']['pay_dt'],  
            'voucher_type'   => 'PMT',
            'transfer_type'  => 'T',
            'voucher_mode'   => 'J',
            'voucher_through'=> 'A',
            'acc_code'       => $dt['data']['bnk_ac_cd'],
            'dr_cr_flag'     => 'DR',
            'amount'         => $dt['data']['paid_amt'],
            'ins_no'         => '',
            'ins_dt'         => '',
            'bank_name'      => '',
            'remarks'        => $dt['data']['rem'],
            'approval_status'=> 'U',
            'user_flag'      =>'',
            'created_dt'     => $dt['data']['created_dt'],
            'created_by'     => $dt['data']['created_by'],
            'modified_by'    => '',
            'modified_dt'    => '',
            'approved_by'    => '',
            'approved_dt'    => '',
            'fin_yr'         => $dt['data']['fin_yr']    
        );

        $input_acc    = array(
            'voucher_date'   => $dt['data']['pay_dt'],
            'voucher_id'     =>  'PMT'.$dt['data']['pay_no'],
            'branch_id'      => 332,
            'trans_no'       =>'PMT'.$dt['data']['pay_no'],
            'trans_dt'       => $dt['data']['pay_dt'],  
            'voucher_type'   => 'PMT',
            'transfer_type'  => 'T',
            'voucher_mode'   => 'J',
            'voucher_through'=> 'A',
            'acc_code'       => $dt['data']['acc_code'],
            'dr_cr_flag'     => 'CR',
            'amount'         => $dt['data']['paid_amt'],
            'ins_no'         => '',
            'ins_dt'         => '',
            'bank_name'      => '',
            'remarks'        => $dt['data']['rem'],
            'approval_status'=> 'U',
            'user_flag'      =>'',
            'created_dt'     => $dt['data']['created_dt'],
            'created_by'     => $dt['data']['created_by'],
            'modified_by'    => '',
            'modified_dt'    => '',
            'approved_by'    => '',
            'approved_dt'    => '',
            'fin_yr'         => $dt['data']['fin_yr']    
        );

        if($this->db->insert('td_vouchers', $input_bank) &&  $this->db->insert('td_vouchers',$input_acc)  ){

            return 1;
        }
        else{
            return 0;
        }  

    }*/
/*		 public function compay_voucher(){

        $input = file_get_contents("php://input");
       
        $dt = json_decode($input, true);
         $fin_yr['fin_yr']= $dt['data']['fin_yr'];
        
        $select    = array("max(sl_no)+1 as sl" );
        $where     = $fin_yr;

        
        $v_id = $this->Transaction_model->f_select('td_vouchers ',$select,$where,1);
        $input_bank     = array(
            'voucher_date'   => $dt['data']['pay_dt'],
            'voucher_id'     =>  'PMT'.$dt['data']['pay_no'],
            'branch_id'      => 342,
            'trans_no'       =>'PMT'.$dt['data']['pay_no'],
            'trans_dt'       => $dt['data']['pay_dt'],  
            'voucher_type'   => 'PMT',
            'transfer_type'  => 'T',
            'voucher_mode'   => 'J',
            'voucher_through'=> 'A',
            'acc_code'       => $dt['data']['dr_acCode'],
            'dr_cr_flag'     => 'DR',
            //'amount'         => $dt['data']['total_gross_amount'],
			'amount'         =>$dt['data']['total_net_amount'],
            'ins_no'         => '',
            'ins_dt'         => '',
            'bank_name'      => '',
            'remarks'        => $dt['data']['rem'],
            'approval_status'=> 'A',
            'user_flag'      =>'',
            'created_dt'     => $dt['data']['created_dt'],
            'created_by'     => $dt['data']['created_by'],
            'modified_by'    => '',
            'modified_dt'    => '',
            'approved_by'    => '',
            'approved_dt'    => '',
            'fin_yr'         => $dt['data']['fin_yr']    
        );
        
	if($dt['data']['total_tds']>0){
        $input_tds    = array(
            'voucher_date'   => $dt['data']['pay_dt'],
            'voucher_id'     =>  'PMT'.$dt['data']['pay_no'],
            'branch_id'      => 342,
            'trans_no'       =>'PMT'.$dt['data']['pay_no'],
            'trans_dt'       => $dt['data']['pay_dt'],  
            'voucher_type'   => 'PMT',
            'transfer_type'  => 'T',
            'voucher_mode'   => 'J',
            'voucher_through'=> 'A',
            'acc_code'       =>$dt['data']['tds_acc'],
            'dr_cr_flag'     => 'CR',
            'amount'         => $dt['data']['total_tds'],
            'ins_no'         => '',
            'ins_dt'         => '',
            'bank_name'      => '',
            'remarks'        => $dt['data']['rem'],
            'approval_status'=> 'A',
            'user_flag'      =>'',
            'created_dt'     => $dt['data']['created_dt'],
            'created_by'     => $dt['data']['created_by'],
            'modified_by'    => '',
            'modified_dt'    => '',
            'approved_by'    => '',
            'approved_dt'    => '',
            'fin_yr'         => $dt['data']['fin_yr']    
        );
	 }
        $input_acc    = array(
            'voucher_date'   => $dt['data']['pay_dt'],
            'voucher_id'     =>  'PMT'.$dt['data']['pay_no'],
            'branch_id'      => 342,
            'trans_no'       =>'PMT'.$dt['data']['pay_no'],
            'trans_dt'       => $dt['data']['pay_dt'],  
            'voucher_type'   => 'PMT',
            'transfer_type'  => 'T',
            'voucher_mode'   => 'J',
            'voucher_through'=> 'A',
            'acc_code'       => $dt['data']['bnk_ac_cd'],
            'dr_cr_flag'     => 'CR',
            //'amount'         => $dt['data']['total_net_amount'],
			'amount'         =>$dt['data']['total_gross_amount'],
            'ins_no'         => '',
            'ins_dt'         => '',
            'bank_name'      => '',
            'remarks'        => $dt['data']['rem'],
            'approval_status'=> 'A',
            'user_flag'      =>'',
            'created_dt'     => $dt['data']['created_dt'],
            'created_by'     => $dt['data']['created_by'],
            'modified_by'    => '',
            'modified_dt'    => '',
            'approved_by'    => '',
            'approved_dt'    => '',
            'fin_yr'         => $dt['data']['fin_yr']    
        );
if($dt['data']['total_tds']>0){
 if($this->db->insert('td_vouchers', $input_bank) &&  $this->db->insert('td_vouchers',$input_acc) &&  $this->db->insert('td_vouchers',$input_tds) ){

            return 1;
        }else{
            return 0;
        } 
}else{
	 if($this->db->insert('td_vouchers', $input_bank) &&  $this->db->insert('td_vouchers',$input_acc) ){

            return 1;
        }else{
            return 0;
        } 
}
			 

    }*/

      /********************************************** */   
      public function purchase_voucher(){
        
        $cramt=0.0;
        $dramt=0.0;
        $count = 0;
        $rndoff = 0.0;
             
        $input = file_get_contents("php://input");
        // $dt = $input ? $input[0] : $input;
        $dt = json_decode($input, true);
        $fin_yr['fin_yr']= $dt['data']['fin_yr'];
        
        // $select    = array("max(sl_no)+1 as sl" );
        // $where     =$fin_yr;
        //  print_r( $where);
        $sl_no    = $this->Transaction_model->f_get_voucher_id($fin_yr['fin_yr']);
        $v_srl=$sl_no->sl_no;

        $v_id= $dt['data']['br_nm'].'/'.$dt['data']['fin_fulyr'].'/'.$v_srl;
        
       

        $cramt = $dt['data']['tot_amt']+ $dt['data']['rnd_of_less'] + $dt['data']['rbt_less'];

        $dramt = $dt['data']['rnd_of_add'] + $dt['data']['cgst'] + $dt['data']['sgst'] + $dt['data']['net_amt'] + $dt['data']['rbt_add'];
        $dramt=round($cramt,2);
        $cramt= round($cramt,2);

        // echo json_encode(array($dramt,$cramt));
        // exit();
        if($cramt == $dramt){
            $query1 = $this->db->get_where('td_vouchers', array('trans_no =' => $dt['data']['ro_no'],'acc_code ='=>$dt['data']['comp_acc_cd']))->result();
    
            if(count($query1) == 0){

                $input_data = array(
                    'voucher_date'   => $dt['data']['trans_dt'],
                    'sl_no'          => $v_srl,
                    'voucher_id'     => $v_id,
                    'branch_id'      => $dt['data']['br'],
                    'trans_no'       => $dt['data']['ro_no'],
                    'trans_dt'       => $dt['data']['trans_dt'],  
                    'voucher_type'   => 'PUR',
                    'transfer_type'  => 'T',
                    'voucher_mode'   => 'J',
                    'voucher_through'=> 'A',
                    'acc_code'       => $dt['data']['comp_acc_cd'],
                    'dr_cr_flag'     => 'CR',
                    'amount'         => $dt['data']['tot_amt'],
                    'ins_no'         => '',
                    'ins_dt'         => '',
                    'bank_name'      => '',
                    'remarks'        => $dt['data']['rem'],
                    'approval_status'=> 'A',
                    'user_flag'      =>'',
                    'created_dt'     => $dt['data']['created_dt'],
                    'created_by'     => $dt['data']['created_by'],
                    'modified_by'    => '',
                    'modified_dt'    => '',
                    'approved_by'    => 'AUTO',
                    'approved_dt'    => $dt['data']['created_dt'],
                    'fin_yr'         => $dt['data']['fin_yr']    
                );
    
                if($this->db->insert('td_vouchers', $input_data)){
                    $count ++;
                }
                
            }
                

            $query2 = $this->db->get_where('td_vouchers', array('trans_no =' => $dt['data']['ro_no'],'acc_code ='=> 8197 ));
    
            if($query2->num_rows() == 0){

            $input_cgst = array(
                'voucher_date'   => $dt['data']['trans_dt'],
                'sl_no'          => $v_srl,
                // 'voucher_id'     => 'Purchase'.$dt['data']['ro_no'],
                'voucher_id'     => $v_id,
                'branch_id'      => $dt['data']['br'],
                'trans_no'       => $dt['data']['ro_no'],
                'trans_dt'       => $dt['data']['trans_dt'],  
                'voucher_type'   => 'PUR',
                'transfer_type'  => 'T',
                'voucher_mode'   => 'J',
                'voucher_through'=> 'A',
                'acc_code'       => 8197,             // Change on 31/03/2023  will effect from 01/04/2023
                'dr_cr_flag'     => 'DR',
                'amount'         => $dt['data']['cgst'],
                'ins_no'         => '',
                'ins_dt'         => '',
                'bank_name'      => '',
                'remarks'        => $dt['data']['rem'],
                'approval_status'=> 'A',
                'user_flag'      => '',
                'created_dt'     => $dt['data']['created_dt'],
                'created_by'     => $dt['data']['created_by'],
                'modified_by'    => '',
                'modified_dt'    => '',
                'approved_by'    => 'AUTO',
                'approved_dt'    => $dt['data']['created_dt'],
                'fin_yr'         => $dt['data']['fin_yr']    
            );

            if($this->db->insert('td_vouchers', $input_cgst)){
                $count ++;
            }

        }

        $query3 = $this->db->get_where('td_vouchers', array('trans_no =' => $dt['data']['ro_no'],'acc_code ='=> 8198 ));
    
        if($query3->num_rows() == 0){
            $input_sgst = array(
                'voucher_date'   => $dt['data']['trans_dt'],
                'sl_no'          => $v_srl,
                'voucher_id'     => $v_id,
                'branch_id'      => $dt['data']['br'],
                'trans_no'       => $dt['data']['ro_no'],
                'trans_dt'       => $dt['data']['trans_dt'],  
                'voucher_type'   => 'PUR',
                'transfer_type'  => 'T',
                'voucher_mode'   => 'J',
                'voucher_through'=> 'A',
                //'acc_code'       => 2206,
                'acc_code'       => 8198,      // Change on 31/03/2023  will effect from 01/04/2023
                'dr_cr_flag'     => 'DR',
                'amount'         => $dt['data']['sgst'],
                'ins_no'         => '',
                'ins_dt'         => '',
                'bank_name'      => '',
                'remarks'        => $dt['data']['rem'],
                'approval_status'=> 'A',
                'user_flag'      => '',
                'created_dt'     => $dt['data']['created_dt'],
                'created_by'     => $dt['data']['created_by'],
                'modified_by'    => '',
                'modified_dt'    => '',
                'approved_by'    => 'AUTO',
                'approved_dt'    => $dt['data']['created_dt'],
                'fin_yr'         => $dt['data']['fin_yr']    
            );
            
            if($this->db->insert('td_vouchers', $input_sgst)){
                $count ++;
            }

        }
        $query4 = $this->db->get_where('td_vouchers', array('trans_no =' => $dt['data']['ro_no'],'acc_code ='=> 2208 ));
    
        if($query4->num_rows() == 0){
                $input_pur= array(
                    'voucher_date'   => $dt['data']['trans_dt'],
                    'sl_no'          => $v_srl,
                    'voucher_id'     => $v_id,
                    'branch_id'      => $dt['data']['br'],
                    'trans_no'       => $dt['data']['ro_no'],
                    'trans_dt'       => $dt['data']['trans_dt'],  
                    'voucher_type'   => 'PUR',
                    'transfer_type'  => 'T',
                    'voucher_mode'   => 'J',
                    'voucher_through'=> 'A',
                    'acc_code'       => 2208,
                    'dr_cr_flag'     => 'DR',
                    'amount'         => $dt['data']['net_amt'],
                    'ins_no'         => '',
                    'ins_dt'         => '',
                    'bank_name'      => '',
                    'remarks'        => $dt['data']['rem'],
                    'approval_status'=> 'A',
                    'user_flag'      => '',
                    'created_dt'     => $dt['data']['created_dt'],
                    'created_by'     => $dt['data']['created_by'],
                    'modified_by'    => '',
                    'modified_dt'    => '',
                    'approved_by'    => 'AUTO',
                    'approved_dt'    => $dt['data']['created_dt'],
                    'fin_yr'         => $dt['data']['fin_yr']    
                );

                if($this->db->insert('td_vouchers', $input_pur)){
                    $count ++;
                }

        }
        if ($dt['data']['rnd_of_add']>0){

            $input_rndcr = array(
                'voucher_date'   => $dt['data']['trans_dt'],
                'sl_no'          => $v_srl,
                'voucher_id'     => $v_id,
                'branch_id'      => $dt['data']['br'],
                'trans_no'       => $dt['data']['ro_no'],
                'trans_dt'       => $dt['data']['trans_dt'],  
                'voucher_type'   => 'PUR',
                'transfer_type'  => 'T',
                'voucher_mode'   => 'J',
                'voucher_through'=> 'A',
                'acc_code'       => 2211,
                'dr_cr_flag'     => 'DR',
                'amount'         => $dt['data']['rnd_of_add'],
                'ins_no'         => '',
                'ins_dt'         => '',
                'bank_name'      => '',
                'remarks'        => $dt['data']['rem'],
                'approval_status'=> 'A',
                'user_flag'      =>'',
                'created_dt'     => $dt['data']['created_dt'],
                'created_by'     => $dt['data']['created_by'],
                'modified_by'    => '',
                'modified_dt'    => '',
                'approved_by'    => 'AUTO',
                'approved_dt'    => $dt['data']['created_dt'],
                'fin_yr'         => $dt['data']['fin_yr']    
            );

            $this->db->insert('td_vouchers', $input_rndcr) ;
        }        

        if ($dt['data']['rnd_of_less']>0){

            
            $input_rndcr = array(
                'voucher_date'   => $dt['data']['trans_dt'],
                'sl_no'          => $v_srl,
                'voucher_id'     => $v_id,
                'branch_id'      => $dt['data']['br'],
                'trans_no'       => $dt['data']['ro_no'],
                'trans_dt'       => $dt['data']['trans_dt'],  
                'voucher_type'   => 'PUR',
                'transfer_type'  => 'T',
                'voucher_mode'   => 'J',
                'voucher_through'=> 'A',
                'acc_code'       => 2211,
                'dr_cr_flag'     => 'CR',
                'amount'         => $dt['data']['rnd_of_less'],
                'ins_no'         => '',
                'ins_dt'         => '',
                'bank_name'      => '',
                'remarks'        => $dt['data']['rem'],
                'approval_status'=> 'A',
                'user_flag'      =>'',
                'created_dt'     => $dt['data']['created_dt'],
                'created_by'     => $dt['data']['created_by'],
                'modified_by'    => '',
                'modified_dt'    => '',
                'approved_by'    => 'AUTO',
                'approved_dt'    => $dt['data']['created_dt'],
                'fin_yr'         => $dt['data']['fin_yr']    
            );

            //=============
            $this->db->insert('td_vouchers', $input_rndcr) ;
        }

        if ($dt['data']['rbt_add']>0){

            
            $input_rbt = array(
                'voucher_date'   => $dt['data']['trans_dt'],
                'sl_no'          => $v_srl,
                // 'voucher_id'     => 'Purchase'.$dt['data']['ro_no'],
                'voucher_id'     => $v_id,
                'branch_id'      => $dt['data']['br'],
                'trans_no'       => $dt['data']['ro_no'],
                'trans_dt'       => $dt['data']['trans_dt'],  
                'voucher_type'   => 'PUR',
                'transfer_type'  => 'T',
                'voucher_mode'   => 'J',
                'voucher_through'=> 'A',
                'acc_code'       => 2210,
                'dr_cr_flag'     => 'DR',
                'amount'         => $dt['data']['rbt_add'],
                'ins_no'         => '',
                'ins_dt'         => '',
                'bank_name'      => '',
                'remarks'        => $dt['data']['rem'],
                'approval_status'=> 'A',
                'user_flag'      =>'',
                'created_dt'     => $dt['data']['created_dt'],
                'created_by'     => $dt['data']['created_by'],
                'modified_by'    => '',
                'modified_dt'    => '',
                'approved_by'    => 'AUTO',
                'approved_dt'    => $dt['data']['created_dt'],
                'fin_yr'         => $dt['data']['fin_yr']    
            );


            $this->db->insert('td_vouchers', $input_rbt);
        }


        if ($dt['data']['rbt_less']>0){

            $input_rbt = array(
                'voucher_date'   => $dt['data']['trans_dt'],
                'sl_no'          => $v_srl,
                'voucher_id'     => $v_id,
                'branch_id'      => $dt['data']['br'],
                'trans_no'       => $dt['data']['ro_no'],
                'trans_dt'       => $dt['data']['trans_dt'],  
                'voucher_type'   => 'PUR',
                'transfer_type'  => 'T',
                'voucher_mode'   => 'J',
                'voucher_through'=> 'A',
                'acc_code'       => 2210,
                'dr_cr_flag'     => 'CR',
                'amount'         => $dt['data']['rbt_less'],
                'ins_no'         => '',
                'ins_dt'         => '',
                'bank_name'      => '',
                'remarks'        => $dt['data']['rem'],
                'approval_status'=> 'A',
                'user_flag'      =>'',
                'created_dt'     => $dt['data']['created_dt'],
                'created_by'     => $dt['data']['created_by'],
                'modified_by'    => '',
                'modified_dt'    => '',
                'approved_by'    => 'AUTO',
                'approved_dt'    => $dt['data']['created_dt'],
                'fin_yr'         => $dt['data']['fin_yr']    
            );

            $this->db->insert('td_vouchers', $input_rbt);
        }

    // }

    // if(!empty($input_data)&&!empty($input_cgst)&&!empty($input_sgst)&&!empty($input_pur)){
        
        if($count == 4){
            echo json_encode(1);
        }
        else{
            echo json_encode(0);
        }  

    }else{
        
        echo json_encode(0);
    }
      
    
    }
    public function purchase_voucher_ins(){
        
            $cramt=0.0;
            $dramt=0.0;
    
            $rndoff = 0.0;
                 
            $input = file_get_contents("php://input");
            // $dt = $input ? $input[0] : $input;
            $dt = json_decode($input, true);
            $fin_yr['fin_yr']= $dt['data']['fin_yr'];
            
            // $select    = array("max(sl_no)+1 as sl" );
            // $where     =$fin_yr;
            //  print_r( $where);
            $sl_no    = $this->Transaction_model->f_get_voucher_id($fin_yr['fin_yr']);
            $v_srl=$sl_no->sl_no;
    
            $v_id= $dt['data']['br_nm'].'/'.$dt['data']['fin_fulyr'].'/'.$v_srl;
            
           
    
            $cramt = $dt['data']['tot_amt']+ $dt['data']['rnd_of_less'] + $dt['data']['rbt_less'];
    
            $dramt = $dt['data']['rnd_of_add'] + $dt['data']['cgst'] + $dt['data']['sgst'] + $dt['data']['net_amt'] + $dt['data']['rbt_add'];
            $dramt=round($cramt,2);
            $cramt= round($cramt,2);
    
            // echo json_encode(array($dramt,$cramt));
            // exit();
            if($cramt == $dramt){
                    $input_data = array(
                    'voucher_date'   => $dt['data']['trans_dt'],
                    'sl_no'          => $v_srl,
                    // 'voucher_id'     => 'Purchase'.$dt['data']['ro_no'],
                    'voucher_id'     => $v_id,
                    'branch_id'      => $dt['data']['br'],
                    'trans_no'       => $dt['data']['ro_no'],
                    'trans_dt'       => $dt['data']['trans_dt'],  
                    'voucher_type'   => 'PUR',
                    'transfer_type'  => 'T',
                    'voucher_mode'   => 'J',
                    'voucher_through'=> 'A',
                    'acc_code'       => $dt['data']['comp_acc_cd'],
                    'dr_cr_flag'     => 'CR',
                    'amount'         => $dt['data']['tot_amt'],
                    'ins_no'         => '',
                    'ins_dt'         => '',
                    'bank_name'      => '',
                    'remarks'        => $dt['data']['rem'],
                    'approval_status'=> 'A',
                    'user_flag'      =>'',
                    'created_dt'     => $dt['data']['created_dt'],
                    'created_by'     => $dt['data']['created_by'],
                    'modified_by'    => '',
                    'modified_dt'    => '',
                    'approved_by'    => 'AUTO',
                    'approved_dt'    => $dt['data']['created_dt'],
                    'fin_yr'         => $dt['data']['fin_yr']    
                );
            if ($dt['data']['rnd_of_add']>0){
    
                $input_rndcr = array(
                    'voucher_date'   => $dt['data']['trans_dt'],
                    'sl_no'          => $v_srl,
                    // 'voucher_id'     => 'Purchase'.$dt['data']['ro_no'],
                    'voucher_id'     => $v_id,
                    'branch_id'      => $dt['data']['br'],
                    'trans_no'       => $dt['data']['ro_no'],
                    'trans_dt'       => $dt['data']['trans_dt'],  
                    'voucher_type'   => 'PUR',
                    'transfer_type'  => 'T',
                    'voucher_mode'   => 'J',
                    'voucher_through'=> 'A',
                    'acc_code'       => 2211,
                    'dr_cr_flag'     => 'DR',
                    'amount'         => $dt['data']['rnd_of_add'],
                    'ins_no'         => '',
                    'ins_dt'         => '',
                    'bank_name'      => '',
                    'remarks'        => $dt['data']['rem'],
                    'approval_status'=> 'A',
                    'user_flag'      =>'',
                    'created_dt'     => $dt['data']['created_dt'],
                    'created_by'     => $dt['data']['created_by'],
                    'modified_by'    => '',
                    'modified_dt'    => '',
                    'approved_by'    => 'AUTO',
                    'approved_dt'    => $dt['data']['created_dt'],
                    'fin_yr'         => $dt['data']['fin_yr']    
                );
    
                $this->db->insert('td_vouchers', $input_rndcr) ;
            }
    
                $input_cgst = array(
                    'voucher_date'   => $dt['data']['trans_dt'],
                    'sl_no'          => $v_srl,
                    // 'voucher_id'     => 'Purchase'.$dt['data']['ro_no'],
                    'voucher_id'     => $v_id,
                    'branch_id'      => $dt['data']['br'],
                    'trans_no'       => $dt['data']['ro_no'],
                    'trans_dt'       => $dt['data']['trans_dt'],  
                    'voucher_type'   => 'PUR',
                    'transfer_type'  => 'T',
                    'voucher_mode'   => 'J',
                    'voucher_through'=> 'A',
                    'acc_code'       => 8197,             // Change on 31/03/2023  will effect from 01/04/2023
                    'dr_cr_flag'     => 'DR',
                    'amount'         => $dt['data']['cgst'],
                    'ins_no'         => '',
                    'ins_dt'         => '',
                    'bank_name'      => '',
                    'remarks'        => $dt['data']['rem'],
                    'approval_status'=> 'A',
                    'user_flag'      => '',
                    'created_dt'     => $dt['data']['created_dt'],
                    'created_by'     => $dt['data']['created_by'],
                    'modified_by'    => '',
                    'modified_dt'    => '',
                    'approved_by'    => 'AUTO',
                    'approved_dt'    => $dt['data']['created_dt'],
                    'fin_yr'         => $dt['data']['fin_yr']    
                );
        
                $input_sgst = array(
                    'voucher_date'   => $dt['data']['trans_dt'],
                    'sl_no'          => $v_srl,
                    // 'voucher_id'     => 'Purchase'.$dt['data']['ro_no'],
                    'voucher_id'     => $v_id,
                    'branch_id'      => $dt['data']['br'],
                    'trans_no'       => $dt['data']['ro_no'],
                    'trans_dt'       => $dt['data']['trans_dt'],  
                    'voucher_type'   => 'PUR',
                    'transfer_type'  => 'T',
                    'voucher_mode'   => 'J',
                    'voucher_through'=> 'A',
                    //'acc_code'       => 2206,
                    'acc_code'       => 8198,      // Change on 31/03/2023  will effect from 01/04/2023
                    'dr_cr_flag'     => 'DR',
                    'amount'         => $dt['data']['sgst'],
                    'ins_no'         => '',
                    'ins_dt'         => '',
                    'bank_name'      => '',
                    'remarks'        => $dt['data']['rem'],
                    'approval_status'=> 'A',
                    'user_flag'      => '',
                    'created_dt'     => $dt['data']['created_dt'],
                    'created_by'     => $dt['data']['created_by'],
                    'modified_by'    => '',
                    'modified_dt'    => '',
                    'approved_by'    => 'AUTO',
                    'approved_dt'    => $dt['data']['created_dt'],
                    'fin_yr'         => $dt['data']['fin_yr']    
                );
    
                    $input_pur= array(
                        'voucher_date'   => $dt['data']['trans_dt'],
                        'sl_no'          => $v_srl,
                        'voucher_id'     => $v_id,
                        'branch_id'      => $dt['data']['br'],
                        'trans_no'       => $dt['data']['ro_no'],
                        'trans_dt'       => $dt['data']['trans_dt'],  
                        'voucher_type'   => 'PUR',
                        'transfer_type'  => 'T',
                        'voucher_mode'   => 'J',
                        'voucher_through'=> 'A',
                        'acc_code'       => 11334,
                        'dr_cr_flag'     => 'DR',
                        'amount'         => $dt['data']['net_amt'],
                        'ins_no'         => '',
                        'ins_dt'         => '',
                        'bank_name'      => '',
                        'remarks'        => $dt['data']['rem'],
                        'approval_status'=> 'A',
                        'user_flag'      => '',
                        'created_dt'     => $dt['data']['created_dt'],
                        'created_by'     => $dt['data']['created_by'],
                        'modified_by'    => '',
                        'modified_dt'    => '',
                        'approved_by'    => 'AUTO',
                        'approved_dt'    => $dt['data']['created_dt'],
                        'fin_yr'         => $dt['data']['fin_yr']    
                    );
    
            if ($dt['data']['rnd_of_less']>0){
    
                
                $input_rndcr = array(
                    'voucher_date'   => $dt['data']['trans_dt'],
                    'sl_no'          => $v_srl,
                    'voucher_id'     => $v_id,
                    'branch_id'      => $dt['data']['br'],
                    'trans_no'       => $dt['data']['ro_no'],
                    'trans_dt'       => $dt['data']['trans_dt'],  
                    'voucher_type'   => 'PUR',
                    'transfer_type'  => 'T',
                    'voucher_mode'   => 'J',
                    'voucher_through'=> 'A',
                    'acc_code'       => 2211,
                    'dr_cr_flag'     => 'CR',
                    'amount'         => $dt['data']['rnd_of_less'],
                    'ins_no'         => '',
                    'ins_dt'         => '',
                    'bank_name'      => '',
                    'remarks'        => $dt['data']['rem'],
                    'approval_status'=> 'A',
                    'user_flag'      =>'',
                    'created_dt'     => $dt['data']['created_dt'],
                    'created_by'     => $dt['data']['created_by'],
                    'modified_by'    => '',
                    'modified_dt'    => '',
                    'approved_by'    => 'AUTO',
                    'approved_dt'    => $dt['data']['created_dt'],
                    'fin_yr'         => $dt['data']['fin_yr']    
                );
    
                //=============
                $this->db->insert('td_vouchers', $input_rndcr) ;
            }
    
            if ($dt['data']['rbt_add']>0){
    
                
                $input_rbt = array(
                    'voucher_date'   => $dt['data']['trans_dt'],
                    'sl_no'          => $v_srl,
                    // 'voucher_id'     => 'Purchase'.$dt['data']['ro_no'],
                    'voucher_id'     => $v_id,
                    'branch_id'      => $dt['data']['br'],
                    'trans_no'       => $dt['data']['ro_no'],
                    'trans_dt'       => $dt['data']['trans_dt'],  
                    'voucher_type'   => 'PUR',
                    'transfer_type'  => 'T',
                    'voucher_mode'   => 'J',
                    'voucher_through'=> 'A',
                    'acc_code'       => 2210,
                    'dr_cr_flag'     => 'DR',
                    'amount'         => $dt['data']['rbt_add'],
                    'ins_no'         => '',
                    'ins_dt'         => '',
                    'bank_name'      => '',
                    'remarks'        => $dt['data']['rem'],
                    'approval_status'=> 'A',
                    'user_flag'      =>'',
                    'created_dt'     => $dt['data']['created_dt'],
                    'created_by'     => $dt['data']['created_by'],
                    'modified_by'    => '',
                    'modified_dt'    => '',
                    'approved_by'    => 'AUTO',
                    'approved_dt'    => $dt['data']['created_dt'],
                    'fin_yr'         => $dt['data']['fin_yr']    
                );
    
    
                $this->db->insert('td_vouchers', $input_rbt);
            }
    
    
            if ($dt['data']['rbt_less']>0){
    
                
                $input_rbt = array(
                    'voucher_date'   => $dt['data']['trans_dt'],
                    'sl_no'          => $v_srl,
                    'voucher_id'     => $v_id,
                    'branch_id'      => $dt['data']['br'],
                    'trans_no'       => $dt['data']['ro_no'],
                    'trans_dt'       => $dt['data']['trans_dt'],  
                    'voucher_type'   => 'PUR',
                    'transfer_type'  => 'T',
                    'voucher_mode'   => 'J',
                    'voucher_through'=> 'A',
                    'acc_code'       => 2210,
                    'dr_cr_flag'     => 'CR',
                    'amount'         => $dt['data']['rbt_less'],
                    'ins_no'         => '',
                    'ins_dt'         => '',
                    'bank_name'      => '',
                    'remarks'        => $dt['data']['rem'],
                    'approval_status'=> 'A',
                    'user_flag'      =>'',
                    'created_dt'     => $dt['data']['created_dt'],
                    'created_by'     => $dt['data']['created_by'],
                    'modified_by'    => '',
                    'modified_dt'    => '',
                    'approved_by'    => 'AUTO',
                    'approved_dt'    => $dt['data']['created_dt'],
                    'fin_yr'         => $dt['data']['fin_yr']    
                );
    
                $this->db->insert('td_vouchers', $input_rbt);
            }
    
        // }
    
        // if(!empty($input_data)&&!empty($input_cgst)&&!empty($input_sgst)&&!empty($input_pur)){
            
            if($this->db->insert('td_vouchers', $input_data) && $this->db->insert('td_vouchers', $input_cgst) && $this->db->insert('td_vouchers', $input_sgst) && $this->db->insert('td_vouchers', $input_pur) ){
                echo json_encode(1);
            }
            else{
                echo json_encode(0);
            }  
    
        }else{
            
            echo json_encode(0);
        }
          
        
        }
      /******************************************* */

      public function adv_voucher(){
             
        $input = file_get_contents("php://input");
        // $dt = $input ? $input[0] : $input;
        $dt = json_decode($input, true);
        $j =0;
        
        $fin_yr['fin_yr']= $dt['data']['fin_yr'];
        $cshbank_flag['cshbnk_flag'] = $dt['data']['cshbnk_flag'];
        $br_id['branch_id'] = $dt['data']['branch_id'];

        $sl_no    = $this->Transaction_model->f_get_voucher_id($fin_yr['fin_yr']);
        $v_srl=$sl_no->sl_no;

        $v_id= $dt['data']['br_nm'].'/'.$dt['data']['fin_fulyr'].'/'.$v_srl;
        // print_r($br_id['branch_id']); 
 
        if($cshbank_flag['cshbnk_flag']==0){
            $select_cash    = array("sl_no" );
            $where_cash  = array(
                "mngr_id"   => 6 ,
                "subgr_id"  => 56,
                "br_id"     => $br_id['branch_id']);

            $cshbank_code = $this->Transaction_model->f_select('md_achead ',$select_cash ,$where_cash,1);
            if($cshbank_code->sl_no>0){
            
            $input_data = array(
                'voucher_date'   => $dt['data']['trans_dt'],
                'sl_no'          => $v_srl,
               'voucher_id'     =>$v_id,
                'branch_id'      => $dt['data']['branch_id'],
                'trans_no'       => $dt['data']['receipt_no'],
                'trans_dt'       => $dt['data']['trans_dt'],  
                'voucher_type'   => 'A',
                'transfer_type'  => 'H',
                'voucher_mode'   => 'C',
                'voucher_through'=> 'A',
                'acc_code'       => $cshbank_code->sl_no ,
                'dr_cr_flag'     => 'DR',
                'amount'         => $dt['data']['adv_amt'],
                'ins_no'         => '',
                'ins_dt'         => '',
                'bank_name'      => '',
                'remarks'        => $dt['data']['rem'],
                'approval_status'=> 'A',
                'user_flag'      =>'',
                'created_dt'     => $dt['data']['created_dt'],
                'created_by'     => $dt['data']['created_by'],
                'modified_by'    => '',
                'modified_dt'    => '',
                'approved_by'    => 'AUTO',
                'approved_dt'    => $dt['data']['created_dt'],
                'fin_yr'         => $dt['data']['fin_yr']    
            );
            }

            $query1 = $this->db->get_where('td_vouchers', array('trans_no =' => $dt['data']['receipt_no'],'acc_code ='=>$dt['data']['acc_code']))->result();
            if(count($query1) == 0){
                if($this->db->insert('td_vouchers', $input_data)){
                    $j++;
                } 
               
            }
        }else{
            if($dt['data']['acc_code']>0){
                $input_data = array(
                    'voucher_date'   => $dt['data']['trans_dt'],
                    'sl_no'          => $v_srl,
                   'voucher_id'     =>$v_id,
                    'branch_id'      => $dt['data']['branch_id'],
                    'trans_no'       => $dt['data']['receipt_no'],
                    'trans_dt'       => $dt['data']['trans_dt'],  
                    'voucher_type'   => 'A',
                    'transfer_type'  => 'T',
                    'voucher_mode'   => 'B',
                    'voucher_through'=> 'A',
                    'acc_code'       =>  $dt['data']['acc_code'],
                    'dr_cr_flag'     => 'DR',
                    'amount'         => $dt['data']['adv_amt'],
                    'ins_no'         => '',
                    'ins_dt'         => '',
                    'bank_name'      => '',
                    'remarks'        => $dt['data']['rem'],
                    'approval_status'=> 'A',
                    'user_flag'      =>'',
                    'created_dt'     => $dt['data']['created_dt'],
                    'created_by'     => $dt['data']['created_by'],
                    'modified_by'    => '',
                    'modified_dt'    => '',
                    'approved_by'    => 'AUTO',
                    'approved_dt'    => $dt['data']['created_dt'],
                    'fin_yr'         => $dt['data']['fin_yr']    
                ); 
            } 
            $query1 = $this->db->get_where('td_vouchers', array('trans_no =' => $dt['data']['receipt_no'],'acc_code ='=>$dt['data']['acc_code']))->result();
            if(count($query1) == 0){
                if($this->db->insert('td_vouchers', $input_data)){
                    $j++;
                } 
               
            }
        }

        if ($cshbank_flag['cshbnk_flag']==0){
             $ls_transfer_type = 'H';
             $ls_voucher_mode  = 'C';
        }else{
            $ls_transfer_type = 'T';
            $ls_voucher_mode  = 'B';
        }

        if($dt['data']['adv_acc']>0){
              
                $input_cr= array(
                    'voucher_date'   => $dt['data']['trans_dt'],
                    'sl_no'          => $v_srl,
                    'voucher_id'     =>$v_id,
                    'branch_id'      => $dt['data']['branch_id'],
                    'trans_no'       => $dt['data']['receipt_no'],
                    'trans_dt'       => $dt['data']['trans_dt'],  
                    'voucher_type'   => 'A',
                    'transfer_type'  => $ls_transfer_type,
                    'voucher_mode'   => $ls_voucher_mode,
                    'voucher_through'=> 'A',
                    'acc_code'       => $dt['data']['adv_acc'],
                    'dr_cr_flag'     => 'CR',
                    'amount'         => $dt['data']['adv_amt'],
                    'ins_no'         => '',
                    'ins_dt'         => '',
                    'bank_name'      => '',
                    'remarks'        => $dt['data']['rem'],
                    'approval_status'=> 'A',
                    'user_flag'      => '',
                    'created_dt'     => $dt['data']['created_dt'],
                    'created_by'     => $dt['data']['created_by'],
                    'modified_by'    => '',
                    'modified_dt'    => '',
                    'approved_by'    => 'AUTO',
                    'approved_dt'    => $dt['data']['created_dt'],
                    'fin_yr'         => $dt['data']['fin_yr']    
                );
            }
        if(!empty($input_data)&&!empty($input_cr)){
            
            $query2 = $this->db->get_where('td_vouchers', array('trans_no =' => $dt['data']['receipt_no'],'acc_code ='=>$dt['data']['adv_acc']))->result();
            if(count($query2) == 0){
                if($this->db->insert('td_vouchers', $input_cr)){
                    $j++;
                }
                
            }

            if($j==2) {
                    echo json_encode(1);
                }
                else{
                
                    echo json_encode(0);
                } 
        }else{
            
            echo json_encode(0);
        }
      
    
        }

		
/*******************************************Advance to Company************** */
/*public function compadv_voucher(){
        //  echo 'hi';
        //  die();    
    $input = file_get_contents("php://input");
    // $dt = $input ? $input[0] : $input;
    $dt = json_decode($input, true);
    
      $fin_yr['fin_yr']            = $dt['data']['fin_yr'];
    // $cshbank_flag['cshbnk_flag'] = $dt['data']['cshbnk_flag'];
    $br_id['branch_id']          = $dt['data']['branch_id'];
    $sl_no                       = $this->Transaction_model->f_get_voucher_id($fin_yr['fin_yr']);
    $v_srl                       = $sl_no->sl_no;

    $v_id= $dt['data']['br_nm'].'/'.$dt['data']['fin_fulyr'].'/'.$v_srl;
    // print_r($br_id['branch_id']); 
    // exit;
        $input_data = array(
            'voucher_date'   => $dt['data']['trans_dt'],
            'voucher_id'     => $v_id,
            'branch_id'      => $dt['data']['branch_id'],
            'trans_no'       => $dt['data']['receipt_no'],
            'trans_dt'       => $dt['data']['trans_dt'],  
            'voucher_type'   => 'A',
            'transfer_type'  => 'T',
            'voucher_mode'   => 'B',
            'voucher_through'=> 'A',
            'acc_code'       =>  $dt['data']['bank_acc'],
            'dr_cr_flag'     => 'CR',
            'amount'         => $dt['data']['adv_amt'],
            'ins_no'         => '',
            'ins_dt'         => '',
            'bank_name'      => '',
            'remarks'        => $dt['data']['rem'],
            'approval_status'=> 'U',
            'user_flag'      =>'',
            'created_dt'     => $dt['data']['created_dt'],
            'created_by'     => $dt['data']['created_by'],
            'modified_by'    => '',
            'modified_dt'    => '',
            'approved_by'    => '',
            'approved_dt'    => '',
            'fin_yr'         => $dt['data']['fin_yr']    
        );    
         
    $input_cr= array(
        'voucher_date'   => $dt['data']['trans_dt'],
        'voucher_id'     => $v_id,
        'branch_id'      => $dt['data']['branch_id'],
        'trans_no'       => $dt['data']['receipt_no'],
        'trans_dt'       => $dt['data']['trans_dt'],  
        'voucher_type'   => 'A',
        'transfer_type'  => 'T',
        'voucher_mode'   => 'B',
        'voucher_through'=> 'A',
        'acc_code'       => $dt['data']['acc_cd'],
        'dr_cr_flag'     => 'DR',
        'amount'         => $dt['data']['adv_amt'],
        'ins_no'         => '',
        'ins_dt'         => '',
        'bank_name'      => '',
        'remarks'        => $dt['data']['rem'],
        'approval_status'=> 'U',
        'user_flag'      => '',
        'created_dt'     => $dt['data']['created_dt'],
        'created_by'     => $dt['data']['created_by'],
        'modified_by'    => '',
        'modified_dt'    => '',
        'approved_by'    => '',
        'approved_dt'    => '',
        'fin_yr'         => $dt['data']['fin_yr']    
    );
        // echo '<pre>';
        // echo 'input_data<br>'; var_dump($input_data);
        // exit;

    if($this->db->insert('td_vouchers', $input_data) && $this->db->insert('td_vouchers', $input_cr) ){
    return 1;
}
else{
    return 0;
}  
  

    }*/

      /*********************************************** */

       public function crn_voucher(){
             
        $input = file_get_contents("php://input");
        // $dt = $input ? $input[0] : $input;
        $dt = json_decode($input, true);
        $fin_yr['fin_yr']= $dt['data']['fin_yr'];
        $sl_no    = $this->Transaction_model->f_get_voucher_id($fin_yr['fin_yr']);
        $v_srl=$sl_no->sl_no;

        $v_id= $dt['data']['br_nm'].'/'.$dt['data']['fin_fulyr'].'/'.$v_srl;
      
              
        $input_cr= array(
            'voucher_date'   => $dt['data']['trans_dt'],
            // 'sl_no'          =>  $v_srl,
            //'voucher_id'     => 'CRN'.$dt['data']['ro'],
            'voucher_id'     =>$dt['data']['recpt_no'],
            'branch_id'      => $dt['data']['branch_id'],
            'trans_no'       =>  $dt['data']['trans_no'],
            'trans_dt'       => $dt['data']['trans_dt'],  
            'voucher_type'   => 'CRN',
            'transfer_type'  => 'T',
            'voucher_mode'   => 'J',
            'voucher_through'=> 'A',
            'acc_code'       => $dt['data']['acc_cd'],
            'dr_cr_flag'     => 'DR',
            'amount'         => $dt['data']['tot_amt'],
            'ins_no'         => '',
            'ins_dt'         => '',
            'bank_name'      => '',
            'remarks'        => $dt['data']['rem'],
            'approval_status'=> 'A',
            'user_flag'      => '',
            'created_dt'     => $dt['data']['created_dt'],
            'created_by'     => $dt['data']['created_by'],
            'modified_by'    => '',
            'modified_dt'    => '',
            'approved_by'    => 'AUTO',
            'approved_dt'    => $dt['data']['created_dt'],
            'fin_yr'         => $dt['data']['fin_yr']    
        );
        if($this->db->insert('td_vouchers', $input_cr)){

        // if($this->db->insert('td_vouchers', $input_data) && $this->db->insert('td_vouchers', $input_cr) ){
        echo 1;
    }
    else{
        echo 0;
    }  
    
        }

        public function crn_voucher_tcs(){
             
            $input = file_get_contents("php://input");
            // $dt = $input ? $input[0] : $input;
            $dt = json_decode($input, true);
            
            $fin_yr['fin_yr']= $dt['data']['fin_yr'];
            $sl_no    = $this->Transaction_model->f_get_voucher_id($fin_yr['fin_yr']);
            $v_srl=$sl_no->sl_no;
    
            $v_id= $dt['data']['br_nm'].'/'.$dt['data']['fin_fulyr'].'/'.$v_srl;
          
                  
            $input_cr= array(
                'voucher_date'   => $dt['data']['trans_dt'],
                // 'sl_no'          =>  $v_srl,
                //'voucher_id'     => 'CRN'.$dt['data']['ro'],
                'voucher_id'     =>$dt['data']['recpt_no'],
                'branch_id'      => $dt['data']['branch_id'],
                'trans_no'       =>  $dt['data']['trans_no'],
                'trans_dt'       => $dt['data']['trans_dt'],  
                'voucher_type'   => 'DRNTCS',
                'transfer_type'  => 'T',
                'voucher_mode'   => 'J',
                'voucher_through'=> 'A',
                'acc_code'       => $dt['data']['acc_cd'],
                'dr_cr_flag'     => 'CR',
                'amount'         => $dt['data']['tot_amt'],
                'ins_no'         => '',
                'ins_dt'         => '',
                'bank_name'      => '',
                'remarks'        => $dt['data']['rem'],
                'approval_status'=> 'A',
                'user_flag'      => '',
                'created_dt'     => $dt['data']['created_dt'],
                'created_by'     => $dt['data']['created_by'],
                'modified_by'    => '',
                'modified_dt'    => '',
                'approved_by'    => 'AUTO',
                'approved_dt'    => $dt['data']['created_dt'],
                'fin_yr'         => $dt['data']['fin_yr']    
            );
            $input_dr= array(
                'voucher_date'   => $dt['data']['trans_dt'],
                // 'sl_no'          =>  $v_srl,
                //'voucher_id'     => 'CRN'.$dt['data']['ro'],
                'voucher_id'     =>$dt['data']['recpt_no'],
                'branch_id'      => $dt['data']['branch_id'],
                'trans_no'       =>  $dt['data']['trans_no'],
                'trans_dt'       => $dt['data']['trans_dt'],  
                'voucher_type'   => 'DRNTCS',
                'transfer_type'  => 'T',
                'voucher_mode'   => 'J',
                'voucher_through'=> 'A',
                'acc_code'       => $dt['data']['dr_acc_cd'],
                'dr_cr_flag'     => 'DR',
                'amount'         => $dt['data']['tot_amt'],
                'ins_no'         => '',
                'ins_dt'         => '',
                'bank_name'      => '',
                'remarks'        => $dt['data']['rem'],
                'approval_status'=> 'A',
                'user_flag'      => '',
                'created_dt'     => $dt['data']['created_dt'],
                'created_by'     => $dt['data']['created_by'],
                'modified_by'    => '',
                'modified_dt'    => '',
                'approved_by'    => 'AUTO',
                'approved_dt'    => $dt['data']['created_dt'],
                'fin_yr'         => $dt['data']['fin_yr']    
            );
         
            if($this->db->insert('td_vouchers', $input_cr) && $this->db->insert('td_vouchers', $input_dr)){

            echo 1;
        }
        else{
            echo 0;
        }  
        
        }

        public function totcrn_voucher(){
             
            $input = file_get_contents("php://input");
            // $dt = $input ? $input[0] : $input;
            $dt = json_decode($input, true);
            $fin_yr['fin_yr']= $dt['data']['fin_yr'];
            $sl_no    = $this->Transaction_model->f_get_voucher_id($fin_yr['fin_yr']);
            $v_srl=$sl_no->sl_no;
    
            $v_id= $dt['data']['br_nm'].'/'.$dt['data']['fin_fulyr'].'/'.$v_srl;
           
     
             $input_data = array(
            'voucher_date'   => $dt['data']['trans_dt'],
            'voucher_id'     =>$dt['data']['recpt_no'],
            'branch_id'      => $dt['data']['branch_id'],
            'trans_no'       =>$dt['data']['trans_no'],
            'trans_dt'       => $dt['data']['trans_dt'],  
            'voucher_type'   => 'CRN',
            'transfer_type'  => 'T',
            'voucher_mode'   => 'J',
            'voucher_through'=> 'A',
            'acc_code'       => $dt['data']['acc_cd'],
            'dr_cr_flag'     => 'CR',
            'amount'         => $dt['data']['tot_amt'],
            'ins_no'         => '',
            'ins_dt'         => '',
            'bank_name'      => '',
            'remarks'        => $dt['data']['rem'],
            'approval_status'=> 'A',
            'user_flag'      =>'',
            'created_dt'     => $dt['data']['created_dt'],
            'created_by'     => $dt['data']['created_by'],
            'modified_by'    => '',
            'modified_dt'    => '',
            'approved_by'    => 'AUTO',
            'approved_dt'    => $dt['data']['created_dt'],
            'fin_yr'         => $dt['data']['fin_yr']    
        );
                  
            
            if($this->db->insert('td_vouchers', $input_data)){
    
            // if($this->db->insert('td_vouchers', $input_data) && $this->db->insert('td_vouchers', $input_cr) ){
            return 1;
        }
        else{
            return 0;
        }  
        
            }



            public function delete_voucher_advvance_jrnal(){
                $input = file_get_contents("php://input");
                $dt = json_decode($input, true);
                $input_bank     = array(
                'trans_no'     =>$dt['data']['receipt_no'],
                );
                // print_r($dt);
                // exit();

                

                // Transaction_model->f_select('md_achead ',$select_cash ,$where_cash,1)
                $data=$this->Transaction_model->f_select('td_vouchers',null,$input_bank,0);
                foreach ($data as $keydata) {
                    $keydata->delete_by = $dt['data']['delete_by'];
                    $keydata->delete_dt = date('Y-m-d H:m:s');
                    // print_r($keydata);
                    $this->db->insert('td_vouchers_delete', $keydata);

                }

                if($this->db->delete('td_vouchers', $input_bank)){
                    echo 1;
                }else{
                    echo 0;
                }
            }

    public function advtrns_voucher(){
             
                $input = file_get_contents("php://input");
                // $dt = $input ? $input[0] : $input;
                $dt = json_decode($input, true);
                // print_r($br_id['branch_id']); 
                // exit;
              
                
                $fin_yr['fin_yr']= $dt['data']['fin_yr'];
                $cshbank_flag['cshbnk_flag'] = $dt['data']['cshbnk_flag'];
                $br_id['branch_id'] = $dt['data']['branch_id'];
        
                $sl_no    = $this->Transaction_model->f_get_voucher_id($fin_yr['fin_yr']);
                $v_srl=$sl_no->sl_no;
        
                $v_id= $dt['data']['br_nm'].'/'.$dt['data']['fin_fulyr'].'/'.$v_srl;
                // print_r($br_id['branch_id']); 
                // exit;
    
         
                    if($dt['data']['acc_code']>0){
                        $input_data = array(
                            'voucher_date'   => $dt['data']['trans_dt'],
                            'sl_no'          => $v_srl,
                        // 'voucher_id'     => 'ADV'.$dt['data']['sl_no'],
                            'voucher_id'     =>$v_id,
                            'branch_id'      => $dt['data']['branch_id'],
                            'trans_no'       => $dt['data']['receipt_no'],
                            'trans_dt'       => $dt['data']['trans_dt'],  
                            'voucher_type'   => 'A',
                            'transfer_type'  => 'T',
                            'voucher_mode'   => 'B',
                            'voucher_through'=> 'A',
                            // 'acc_code'       => $dt['data']['soc_id'],
                            'acc_code'       =>  $dt['data']['acc_code'],
                            'dr_cr_flag'     => 'DR',
                            'amount'         => $dt['data']['adv_amt'],
                            'ins_no'         => '',
                            'ins_dt'         => '',
                            'bank_name'      => '',
                            'remarks'        => $dt['data']['rem'],
                            'approval_status'=> 'A',
                            'user_flag'      =>'',
                            'created_dt'     => $dt['data']['created_dt'],
                            'created_by'     => $dt['data']['created_by'],
                            'modified_by'    => '',
                            'modified_dt'    => '',
                            'approved_by'    => 'AUTO',
                            'approved_dt'    => $dt['data']['created_dt'],
                            'fin_yr'         => $dt['data']['fin_yr']    
                        ); 
                    }   

        
                if ( $cshbank_flag['cshbnk_flag']==0){
                     $ls_transfer_type = 'H';
                     $ls_voucher_mode  = 'C';
                }else{
                    $ls_transfer_type = 'T';
                    $ls_voucher_mode  = 'B';
                }
        
                if($dt['data']['adv_acc']>0){
                      
                        $input_cr= array(
                            'voucher_date'   => $dt['data']['trans_dt'],
                            'sl_no'          => $v_srl,
                            // 'voucher_id'     => 'ADV'.$dt['data']['sl_no'],
                            'voucher_id'     =>$v_id,
                            'branch_id'      => $dt['data']['branch_id'],
                            'trans_no'       => $dt['data']['receipt_no'],
                            'trans_dt'       => $dt['data']['trans_dt'],  
                            'voucher_type'   => 'A',
                            'transfer_type'  => $ls_transfer_type,
                            'voucher_mode'   => $ls_voucher_mode,
                            'voucher_through'=> 'A',
                            'acc_code'       => $dt['data']['adv_acc'],
                            'dr_cr_flag'     => 'CR',
                            'amount'         => $dt['data']['adv_amt'],
                            'ins_no'         => '',
                            'ins_dt'         => '',
                            'bank_name'      => '',
                            'remarks'        => $dt['data']['rem'],
                            'approval_status'=> 'A',
                            'user_flag'      => '',
                            'created_dt'     => $dt['data']['created_dt'],
                            'created_by'     => $dt['data']['created_by'],
                            'modified_by'    => '',
                            'modified_dt'    => '',
                            'approved_by'    => 'AUTO',
                            'approved_dt'    => $dt['data']['created_dt'],
                            'fin_yr'         => $dt['data']['fin_yr']    
                        );
                    }
                  
                if(!empty($input_data)&&!empty($input_cr)){
        
                    if($this->db->insert('td_vouchers', $input_data) && $this->db->insert('td_vouchers', $input_cr) ){
                      
                            echo json_encode(1);
                        }
                        else{
                        
                            echo json_encode(0);
                        } 
                }else{
                    
                    echo json_encode(0);
                }
              
            
        }     

      /******************************************** */
                
    }
?>
