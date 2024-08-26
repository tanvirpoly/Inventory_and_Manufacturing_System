<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class SmsSend extends CI_Controller {

public function __construct()
    {
    parent::__construct();
    $this->load->model("prime_model","pm");    
}


public function index()
    {
    $where = array(
        'userrole' => 2,
        'status' => 'Active'
            );
    $users = $this->pm->get_data('users',$where);

    foreach ($users as $value)
        {
        $cid = $value['compid'];
        
        $sale = $this->pm->today_sales($cid);
        $purchase = $this->pm->today_purchases($cid);
        $cvoucher = $this->pm->today_cvouchers($cid);
        $dvoucher = $this->pm->today_dvouchers($cid);
        $svoucher = $this->pm->today_svouchers($cid);
        $empp = $this->pm->today_emp_payments($cid);
        $return = $this->pm->today_returns($cid);

        $date = date("d/m/Y");
        $tsa = number_format($sale->total, 2);
        $tpa = number_format($purchase->total, 2);
        $tcva = number_format($cvoucher->total, 2);
        $tdva = number_format($dvoucher->total, 2);
        $tsva = number_format($svoucher->total, 2);
        $tepa = number_format($empp->total, 2);
        $tra = number_format($return->total, 2);
        $tca = number_format((($sale->ptotal+$cvoucher->total)-($purchase->ptotal+$dvoucher->total+$svoucher->total+$empp->total+$return->total)), 2);

        $msg = "Reports in ".$date."\nSales : ".$tsa."\nPurchase : ".$tpa."\nCash Collect : ".$tcva."\nExpense : ".$tdva."\nSupplier Pay : ".$tsva."\nReturn : ".$tra."\nCash in Hand : ".$tca."\n\nThank You\nSunshine IT";
        //var_dump($msg); exit();
        
        $mob = $value['mobile'];
        //$token = "44515996325214391599632521";
        //$token = urlencode("4cc079b5-c2a5-4cdc-ac07-1ee0fe8e6b5d");
        $message = urlencode($msg);
        $to = urlencode($mob);
        $token = urlencode("hdisolyp-8b0czxjl-jjlheqln-yfcuqywa-pjjec9lh");
        //$url = "https://smsplus.sslwireless.com/api/v3/send-sms?api_token=$token&sid=SUNSHINEAPPOTP&sms=$message&msisdn=$to&csms_id=1";
        //$url = "https://smsplus.sslwireless.com/api/v3/send-sms?api_token=$token&sid=NONSUNSHINEIT&sms=$message&msisdn=$to&csms_id=1";
          //var_dump($url); //exit();
        $data = array(
            'to'      => "$to",
            'message' => "$message",
            'token'   =>"$token"
              );
                  
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_ENCODING, '');
        curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $smsresult = curl_exec($ch);
        
        //var_dump($smsresult); exit();
        }
        
        
        
}






}