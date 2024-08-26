<?php
if (!defined('BASEPATH'))
  exit('No direct script access allowed');

class Category extends CI_Controller {

public function __construct()
  {
  parent::__construct();
  $this->load->model("prime_model","pm");
  $this->checkPermission();
}

public function index()
  {
  $data['title'] = 'Category';

  $where = array(
    'compid' => $_SESSION['compid']
          );

  $data['category'] = $this->pm->get_data('categories',$where);
  
  $this->load->view('category/category',$data);
}

public function save_category()
  {
  $info = $this->input->post();

  $data = array(
    'compid'       => $_SESSION['compid'],
    'categoryName' => $info['catName'],
    'fpShow'       => $info['fpShow'], 
    'regby'        => $_SESSION['uid']
        );

  $result = $this->pm->insert_data('categories',$data);

  if($result)
    {
    $sdata = [
      'exception' =>'<div class="alert alert-success alert-dismissible">
        <h4><i class="icon fa fa-check"></i> Category add Successfully !</h4>
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
  redirect('Category');
}

public function get_category_data()
  {
  $section = $this->pm->get_category_data($_POST['id']);
  $someJSON = json_encode($section);
  echo $someJSON;
}

public function update_category()
  {
  $info = $this->input->post();

  $data = array(
    'compid'       => $_SESSION['compid'],
    'categoryName' => $info['categoryName'],
    'fpShow'       => $info['fpShow'], 
    'status'       => $info['status'],            
    'upby'         => $_SESSION['uid']
        );

  $where = array(
    'categoryID' => $info['cat_id']
        );

  $result = $this->pm->update_data('categories',$data,$where);

  if($result)
    {
    $sdata = [
      'exception' =>'<div class="alert alert-success alert-dismissible">
        <h4><i class="icon fa fa-check"></i> Category update Successfully !</h4>
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
  redirect('Category');
}

public function delete_category($id)
  {
  $where = array(
    'categoryID' => $id
        );

  $empu = $this->pm->get_data('products',$where);

  if(!$empu)
    {
    $result = $this->pm->delete_data('categories',$where);

    if($result)
      {
      $sdata = [
        'exception' =>'<div class="alert alert-danger alert-dismissible">
          <h4><i class="icon fa fa-check"></i> Category delete Successfully !</h4>
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
    }
  else
    {
    $sdata = [
      'exception' =>'<div class="alert alert-danger alert-dismissible">
        <h4><i class="icon fa fa-ban"></i> All ready add this Category in Product !</h4>
        </div>'
            ];
    }
  $this->session->set_userdata($sdata);
  redirect('Category');
}

public function product_units()
  {
  $data['title'] = 'Unit';

//   $where = array(
//     'compid' => $_SESSION['compid']
//         );

//   $data['unit'] = $this->pm->get_data('sma_units',$where);
  $data['unit'] = $this->pm->get_sma_units_data();

  $this->load->view('category/product_units',$data);
}

public function save_units()
  {
  $info = $this->input->post();

  $data = array(
    'compid'   => $_SESSION['compid'],
    'unitName' => $info['unitName'],         
    'regby'    => $_SESSION['uid']
        );

  $result = $this->pm->insert_data('sma_units',$data);

  if($result)
    {
    $sdata = [
      'exception' =>'<div class="alert alert-success alert-dismissible">
        <h4><i class="icon fa fa-check"></i>Units add Successfully !</h4>
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
  redirect('Unit');
}

public function get_unit_data()
  {
  $section = $this->pm->get_unit_data($_POST['id']);
  $someJSON = json_encode($section);
  echo $someJSON;
}

public function update_units()
  {
  $info = $this->input->post();

  $data = array(
    'compid'   => $_SESSION['compid'],
    'unitName' => $info['unitName'],
    'status'   => $info['status'],            
    'upby'     => $_SESSION['uid']
        );

  $where = array(
    'id' => $info['unit_id']
        );

  $result = $this->pm->update_data('sma_units',$data,$where);

  if($result)
    {
    $sdata = [
      'exception' =>'<div class="alert alert-success alert-dismissible">
        <h4><i class="icon fa fa-check"></i>Unit update Successfully !</h4>
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
  redirect('Unit');
}

public function delete_units($id)
  {
  $where = array(
    'unit' => $id
        );
  $empu = $this->pm->get_data('products',$where);

  if(!$empu)
    {
    $uwhere = array(
      'id' => $id
          );

    $result = $this->pm->delete_data('sma_units',$uwhere);

    if($result)
      {
      $sdata = [
        'exception' =>'<div class="alert alert-danger alert-dismissible">
          <h4><i class="icon fa fa-check"></i> Unit delete Successfully !</h4>
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
    }
  else
    {
    $sdata = [
      'exception' =>'<div class="alert alert-danger alert-dismissible">
        <h4><i class="icon fa fa-ban"></i> All ready add this Unit in Product !</h4>
        </div>'
            ];
    }
  $this->session->set_userdata($sdata);
  redirect('Unit');
}

public function online_store_info()
  {
  $data['title'] = 'Online Store';

  $where = array(
    'compid' => $_SESSION['compid']
        );

  $data['store'] = $this->pm->get_data('store',$where);
  //$data['store'] = $onlinestore[0];

  $this->load->view('category/online_store',$data);
}

public function save_online_store()
  {
  $info = $this->input->post();
      //var_dump('hello'); exit();
  $config['upload_path'] = './upload/company/';
  $config['allowed_types'] = 'gif|jpg|png|jpeg|JPEG|JPG|PNG';
  $config['max_size'] = 0;
  $config['max_width'] = 0;
  $config['max_height'] = 0;

  $this->load->library('upload',$config);
  $this->upload->initialize($config);
  
  $store = $this->db->select('sbImage')
                  ->from('store')
                  ->where('compid',$_SESSION['compid'])
                  ->get()
                  ->row();
                    
  if($this->upload->do_upload('userfile'))
    {
    $limg = $this->upload->data('file_name');
    }
  else
    {
    if($store)
      {
      $limg = $store->sbImage;
      }
    else
      {
      $limg = '';
      }
    } 

  $data = [
    'compid'    => $_SESSION['compid'],
    'sName'  => $info['sName'],
    'sMobile' => $info['sMobile'],
    'sEmail'   => $info['sEmail'],
    'sAddress' => $info['sAddress'],
    'sdCharge' => $info['sdCharge'],
    'sFacebook' => $info['sFacebook'],
    'sGoogle' => $info['sGoogle'],
    'sTwitter' => $info['sTwitter'],
    'sInstagram' => $info['sInstagram'],
    'sbImage'    => $limg,
    'regby'       => $_SESSION['uid']
          ];
        //var_dump($info); exit();
    
  if($store)
    {
    $where = array(
      'compid' => $_SESSION['compid']
          );

    $result = $this->pm->update_data('store',$data,$where);
    }
  else
    {
    $result = $this->pm->insert_data('store',$data);
    }

    
  if($result)
    {
    $sdata = [
      'exception' =>'<div class="alert alert-success alert-dismissible">
      <h4><i class="icon fa fa-check"></i> Online Store Setting Successfully !</h4></div>'
            ];
    }
  else
    {
    $sdata = [
      'exception' =>'<div class="alert alert-danger alert-dismissible">
      <h4><i class="icon fa fa-ban"></i> Failed !</h4></div>'
            ];
    }
  $this->session->set_userdata($sdata);
  redirect('onlineStore');
}






}