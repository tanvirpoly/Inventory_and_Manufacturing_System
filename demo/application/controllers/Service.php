<?php
if(!defined('BASEPATH'))
  exit('No direct script access allowed');

class Service extends CI_Controller {

public function __construct()
  {
  parent::__construct();
  $this->load->model("prime_model","pm");
  $this->checkPermission();
}


public function service_information()
  {
  $data['title'] = 'Service';

  $data['service'] = $this->pm->get_data('service_info',false);
    //var_dump($data['purchase']); exit();
  $this->load->view('service/service_info',$data);
}

public function save_service_info()
  {
  $info = $this->input->post();

  $query = $this->db->select('siid')
                ->from('service_info')
                ->limit(1)
                ->order_by('siid','DESC')
                ->get()
                ->row();
  if($query)
    {
    $sn = $query->siid+1;
    }
  else
    {
    $sn = 1;
    }

  $cn = strtoupper(substr($_SESSION['compname'],0,3));
  $pc = sprintf("%'05d",$sn);

  $cusid = 'S'.$cn.$pc;

  $service = array(
    'compid'    => $_SESSION['compid'],
    'siCode'    => $cusid,
    'siName'    => $info['sName'],
    'siPrice'   => $info['sPrice'],
    'siDetails' => $info['sDetails'],
    'regby'     => $_SESSION['uid']
        );
      //var_dump($quotation); exit();
  $result = $this->pm->insert_data('service_info',$service);
        //var_dump($purchase_id); exit();
  
  if($result)
    {
    $sdata = [
      'exception' =>'<div class="alert alert-success alert-dismissible">
        <h4><i class="icon fa fa-check"></i> Service add Successfully !</h4>
        </div>'
            ];  
    }
  else
    {
    $sdata = [
      'exception' =>'<div class="alert alert-danger alert-dismissible">
        <h4><i class="icon fa fa-ban"></i> Failed !</h4>
        </div>'
            ];
    }
  $this->session->set_userdata($sdata);
  redirect('serviceInfo');
}

public function get_service_info_data()
  {
  $section = $this->pm->get_service_info_data($_POST['id']);
  $someJSON = json_encode($section);
  echo $someJSON;
}

public function update_service_info()
  {
  $info = $this->input->post();

  $service = array(
    'siName'    => $info['sName'],
    'siPrice'   => $info['sPrice'],
    'siDetails' => $info['sDetails'],
    'status'    => $info['status'],
    'regby'     => $_SESSION['uid']
        );

  $where = array(
    'siid' => $info['siid']
        );
      //var_dump($quotation); exit();
  $result = $this->pm->update_data('service_info',$service,$where);
        //var_dump($purchase_id); exit();
  if($result)
    {
    $sdata = [
      'exception' =>'<div class="alert alert-success alert-dismissible">
      <h4><i class="icon fa fa-check"></i> Service Update Successfully !</h4></div>'
            ];  
    }
  else
    {
    $sdata = [
      'exception' =>'<div class="alert alert-danger alert-dismissible">
        <h4><i class="icon fa fa-ban"></i> Failed !</h4>
        </div>'
            ];
    }
  $this->session->set_userdata($sdata);
  redirect('serviceInfo');
}

public function delete_service_info($id)
  {
  $where = array(
    'siid' => $id
        );

  $result = $this->pm->delete_data('service_info',$where);
  
  if($result)
    {
    $sdata = [
      'exception' =>'<div class="alert alert-danger alert-dismissible">
        <h4><i class="icon fa fa-check"></i> Service delete Successfully !</h4>
        </div>'
            ];  
    }
  else
    {
    $sdata = [
      'exception' =>'<div class="alert alert-danger alert-dismissible">
        <h4><i class="icon fa fa-ban"></i> Failed !</h4>
        </div>'
            ];
    }
  $this->session->set_userdata($sdata);
  redirect('serviceInfo');
}

public function service_sale_info()
  {
  $data['title'] = 'Service';

  $other = array(
    'order_by' => 'ssid',
    'join' => 'left'
        );
  $field = array(
    'service_sale' => 'service_sale.*',
    'customers' => 'customers.*'
        );
  $join = array(
    'customers' => 'customers.customerID = service_sale.custid'
        );

  $data['service'] = $this->pm->get_data('service_sale',false,$field,$join,$other);
    //var_dump($data['purchase']); exit();
  $this->load->view('service/service_sale',$data);
}

public function new_sale_service() 
  {
  $data['title'] = 'Service';

  $data['customer'] = $this->pm->get_data('customers',false);
  $data['service'] = $this->pm->get_data('service_info',false);

  $this->load->view('service/new_sservice',$data);
}

public function get_Service_Details()
  {
  $id = $this->input->post('id');

  $where = array(
    'siid' => $id,
        );
   
  $service = $this->pm->get_data('service_info',$where);
  $str='';
  foreach($service as $value)
    {
    $id = $value['siid'];
    $str.="<tr>
    <td>".$value['siName']."<input type='hidden' name='siid[]' value='".$id."' required ></td>
    <td><input type='text' onkeyup='totalPrice(".$id.")' name='pices[]' id='pices_".$id."' value='0' class='form-control' min='1' required ></td>
    <td><input type='text' onkeyup='totalPrice(".$id.")' name='salePrice[]' id='salePrice_".$id."' class='form-control' value='".$value['siPrice']."' required ></td>
    <td><input type='text' class='totalPrice form-control'  name='totalPrice[]' readonly id='totalPrice_".$id."' value='00' required ></td>
    <td><span class='item_remove btn btn-danger btn-xs' onClick='$(this).parent().parent().remove();'>x</span>
    </td></tr>";
    }
  echo json_encode($str);
}

public function save_sale_service()
  {
  $info = $this->input->post();

  $query = $this->db->select('ssid')
                ->from('service_sale')
                ->limit(1)
                ->order_by('ssid','DESC')
                ->get()
                ->row();
  if($query)
    {
    $sn = $query->ssid+1;
    }
  else
    {
    $sn = 1;
    }

  $cn = strtoupper(substr($_SESSION['compname'],0,3));
  $pc = sprintf("%'05d", $sn);

  $cusid = 'SS'.$cn.$pc;

  $sale = array(
    'compid'      => $_SESSION['compid'],
    'ssCode'      => $cusid,
    'ssDate'      => date('Y-m-d', strtotime($info['date'])),
    'custid'      => $info['customer'],
    'amount'      => $info['totalprice'],
    'pAmount'     => $info['totalPaid'],
    'accountType' => $info['accountType'],
    'accountNo'   => $info['accountNo'],
    'terms'       => $info['terms'],
    'note'        => $info['note'],
    'regby'       => $_SESSION['uid']
            );
        //var_dump($sale); exit();
  $result = $this->pm->insert_data('service_sale',$sale);
       
  $length = count($info['siid']);

  for($i = 0; $i < $length; $i++)
    {
    $spdata = array(
      'ssid'     => $result,
      'siid'     => $info['siid'][$i],                       
      'quantity' => $info['pices'][$i],
      'sprice'   => $info['salePrice'][$i],
      'tPrice'   => $info['totalPrice'][$i],
      'regby'    => $_SESSION['uid']
          );

    $this->pm->insert_data('service_sale_details',$spdata);
    }

  if($result)
    {
    $sdata = [
      'exception' =>'<div class="alert alert-success alert-dismissible">
        <h4><i class="icon fa fa-check"></i> Service Sale Successfully !</h4>
        </div>'
            ];  
    }
  else
    {
    $sdata = [
      'exception' =>'<div class="alert alert-danger alert-dismissible">
        <h4><i class="icon fa fa-ban"></i> Failed !</h4>
        </div>'
            ];
    }
  $this->session->set_userdata($sdata);
  redirect('serviceSale');
}

public function view_sale_service($id)
  {
  $data['title'] = 'Service';

  $where = array(
    'ssid' => $id
        );
  $other = array(
    'join' => 'left'
        );
  $field = array(
    'service_sale' => 'service_sale.*',
    'customers' => 'customers.*'
        );
  $join = array(
    'customers' => 'customers.customerID = service_sale.custid'
        );

  $quotation = $this->pm->get_data('service_sale',$where,$field,$join,$other);
  $data['service'] = $quotation[0];

  $sfield = array(
    'service_sale_details' => 'service_sale_details.*',
    'service_info' => 'service_info.siName,service_info.siDetails'
        );
  $sjoin = array(
    'service_info' => 'service_info.siid = service_sale_details.siid'
        );

  $data['sservice'] = $this->pm->get_data('service_sale_details',$where,$sfield,$sjoin,$other);
  
  $data['company'] = $this->pm->company_details();
  
  $this->load->view('service/view_sservice',$data);
}

public function edit_sale_service($id)
  {
  $data['title'] = 'Service';

  $where = array(
    'ssid' => $id
        );

  $quotation = $this->pm->get_data('service_sale',$where);
  $data['service'] = $quotation[0];

  $other = array(
    'join' => 'left'
        );
  $sfield = array(
    'service_sale_details' => 'service_sale_details.*',
    'service_info' => 'service_info.siName'
        );
  $sjoin = array(
    'service_info' => 'service_info.siid = service_sale_details.siid'
        );

  $data['sservice'] = $this->pm->get_data('service_sale_details',$where,$sfield,$sjoin,$other);
  $data['customer'] = $this->pm->get_data('customers',false);
  $data['serviceInfo'] = $this->pm->get_data('service_info',false);
  
  
  $this->load->view('service/edit_sservice',$data);
}

public function update_sale_service()
  {
  $info = $this->input->post();

  $where = array(
    'ssid' => $info['ssid']
        );

  $sale = array(
    'ssDate'      => date('Y-m-d', strtotime($info['date'])),
    'custid'      => $info['customer'],
    'amount'      => $info['totalprice'],
    'pAmount'     => $info['totalPaid'],
    'accountType' => $info['accountType'],
    'accountNo'   => $info['accountNo'],
    'terms'       => $info['terms'],
    'note'        => $info['note'],         
    'regby'       => $_SESSION['uid']
            );
        //var_dump($sale); exit();
  $result = $this->pm->update_data('service_sale',$sale,$where);

  $this->pm->delete_data('service_sale_details',$where);
       
  $length = count($info['siid']);

  for($i = 0; $i < $length; $i++)
    {
    $spdata = array(
      'ssid'     => $result,
      'siid'     => $info['siid'][$i],                       
      'quantity' => $info['pices'][$i],
      'sprice'   => $info['salePrice'][$i],
      'tPrice'   => $info['totalPrice'][$i],
      'regby'    => $_SESSION['uid']
          );

    $this->pm->insert_data('service_sale_details',$spdata);
    }

  if($result)
    {
    $sdata = [
      'exception' =>'<div class="alert alert-success alert-dismissible">
        <h4><i class="icon fa fa-check"></i> Update Service Sale Successfully !</h4>
        </div>'
            ];  
    }
  else
    {
    $sdata = [
      'exception' =>'<div class="alert alert-danger alert-dismissible">
        <h4><i class="icon fa fa-ban"></i> Failed !</h4>
        </div>'
            ];
    }
  $this->session->set_userdata($sdata);
  redirect('serviceSale');
}

public function delete_sale_service($id)
  {
  $where = array(
    'ssid' => $id
        );

  $result = $this->pm->delete_data('service_sale',$where);
  $result2 = $this->pm->delete_data('service_sale_details',$where);
  
  if($result)
    {
    $sdata = [
      'exception' =>'<div class="alert alert-danger alert-dismissible">
        <h4><i class="icon fa fa-check"></i> Service delete Successfully !</h4>
        </div>'
            ];  
    }
  else
    {
    $sdata = [
      'exception' =>'<div class="alert alert-danger alert-dismissible">
        <h4><i class="icon fa fa-ban"></i> Failed !</h4>
        </div>'
            ];
    }
  $this->session->set_userdata($sdata);
  redirect('serviceSale');
}





}