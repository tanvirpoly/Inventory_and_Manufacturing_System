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
        'userrole' => 2
            );
    $users = $this->pm->get_data('users',$where);

    foreach ($users as $value)
        {
        $cid =  $value['compid'];
        
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
        $to =$value['mobile'];
        $token = "44515996325214391599632521";
        $message = urlencode($msg);
        $url = "http://sms.iglweb.com/api/v1/send?api_key=44516045544714651604554471&contacts=$to&senderid=8801844532630&msg=$message";
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