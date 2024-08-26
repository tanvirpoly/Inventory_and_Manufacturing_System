<?php
if (!defined('BASEPATH'))
  exit('No direct script access allowed');

class Webhome extends CI_Controller {

public function __construct()
  {
  parent::__construct();
  $this->load->model("prime_model",'pm');       
 // $this->checkPermission();
}

        ################################################
        #   /* Pages  start*/                          #
        ################################################

public function store_details($id,$id2)
  {
  $data['title'] = 'Home';

  $where = [
    'sid' => $id
        ];

  $store = $this->pm->get_data('store',$where);
  $data['store'] = $store[0];

  $pwhere = [
    'compid' => $store[0]['compid'],
    'spstatus' => 1
        ];
  $other = array(
    'limit' => 100,
    'order_by' => 'productID'
        );
  //var_dump($data['title']); exit();
  $data['product'] = $this->pm->get_data('products',$pwhere,false,false,$other);

  $cwhere = [
    'compid' => $store[0]['compid'],
    'fpShow' => 1
        ];
  $cother = array(
    'limit' => 5,
    'order_by' => 'categoryID'
        );
  $data['category'] = $this->pm->get_data('categories',$cwhere,false,false,$cother);
  $data['compid'] = $store[0]['compid'];
  
  $cmother = array(
    'limit' => 3,
    'order_by' => 'categoryID'
        );
  $data['mcategory'] = $this->pm->get_data('categories',$cwhere,false,false,$cmother);
    
  $this->load->view('webhome/product_home',$data);
}

public function category_product_details($id,$id2)
  {
  $data['title'] = 'Home';

  $where = [
    'sid' => $id2
        ];

  $store = $this->pm->get_data('store',$where);
  $data['store'] = $store[0];

  $pwhere = [
    'categoryID' => $id,
    'compid' => $store[0]['compid'],
    'spstatus' => 1
        ];
  //var_dump($data['title']); exit();
  $data['product'] = $this->pm->get_data('products',$pwhere);
  
  $cwhere = [
    'compid' => $store[0]['compid'],
    'fpShow' => 1
        ];
  $cother = array(
    'limit' => 5,
    'order_by' => 'categoryID'
        );
  $data['category'] = $this->pm->get_data('categories',$cwhere,false,false,$cother);
  $data['compid'] = $store[0]['compid'];
  
  $cmother = array(
    'limit' => 3,
    'order_by' => 'categoryID'
        );
  $data['mcategory'] = $this->pm->get_data('categories',$cwhere,false,false,$cmother);
    
  $this->load->view('webhome/cat_product',$data);
}

public function product_details($id,$id2)
  {
  $data['title'] = 'Home';

  $where = [
    'sid' => $id2
        ];

  $store = $this->pm->get_data('store',$where);
  $data['store'] = $store[0];

  $pwhere = [
    'productID' => $id
        ];
  //var_dump($data['title']); exit();
  $products = $this->pm->get_data('products',$pwhere);
  $data['product'] = $products[0];
  
  $cwhere = [
    'compid' => $store[0]['compid'],
    'fpShow' => 1
        ];
  $cother = array(
    'limit' => 5,
    'order_by' => 'categoryID'
        );
  $data['category'] = $this->pm->get_data('categories',$cwhere,false,false,$cother);
  $data['compid'] = $store[0]['compid'];
  
  $cmother = array(
    'limit' => 3,
    'order_by' => 'categoryID'
        );
  $data['mcategory'] = $this->pm->get_data('categories',$cwhere,false,false,$cmother);
    
  $this->load->view('webhome/product_info',$data);
}

public function add_to_cart()
  {
  //alert('Hello');
  $data = array(
    'id'    => $this->input->post('pid'),
    'name'  => $this->input->post('name'), 
    'price' => $this->input->post('pprice'), 
    'qty'   => 1
          );

  $this->cart->insert($data);
  echo $this->show_cart();
}

public function get_cart_quantity()
  {
  $someJSON = json_encode($psid);
  echo $someJSON;
}
 
public function show_cart()
  {
  $output = '';
  $no = 0;
  foreach ($this->cart->contents() as $items)
    {
    $no++;
    $output .='
      <tr>
        <td>'.$items['name'].'</td>
        <td>'.number_format($items['price']).'</td>
        <td>'.$items['qty'].'</td>
        <td>'.number_format($items['subtotal']).'</td>
        <td><button type="button" id="'.$items['rowid'].'" class="romove_cart btn btn-danger btn-sm">Cancel</button></td>
      </tr>';
    }
  $output .= '
    <tr>
      <th colspan="3">Total Amount</th>
      <th colspan="2">'.'৳ '.number_format($this->cart->total()).'</th>
    </tr>';
  return $output;
}
 
public function load_cart()
  { 
  echo $this->show_cart();
}
 
public function delete_cart()
  { 
  $data = array(
    'rowid' => $this->input->post('row_id'), 
    'qty' => 0, 
        );
  $this->cart->update($data);
  echo $this->show_cart();
}

public function check_out_order($id)
  {
  $data['title'] = 'Check Out';
  $where = [
    'sid' => $id
        ];

  $store = $this->pm->get_data('store',$where);
  $data['store'] = $store[0];
  
  $cwhere = [
    'compid' => $store[0]['compid'],
    'fpShow' => 1
        ];
  $cother = array(
    'limit' => 5,
    'order_by' => 'categoryID'
        );
  $data['category'] = $this->pm->get_data('categories',$cwhere,false,false,$cother);
  $data['compid'] = $store[0]['compid'];
  
  $cmother = array(
    'limit' => 3,
    'order_by' => 'categoryID'
        );
  $data['mcategory'] = $this->pm->get_data('categories',$cwhere,false,false,$cmother);

  $this->load->view('webhome/check_out',$data);
}

public function load_product_cart()
  { 
  echo $this->show_product_cart();
}

public function show_product_cart()
  { 
  $output = '';
  $no = 0;
  foreach ($this->cart->contents() as $items)
    {
    $no++;
    $output .='
      <tr>
        <td>'.$items['name'].'<input type="hidden" name="product[]"" value="'.$items['id'].'" required ></td>
        <td>'.number_format($items['price']).'<input type="hidden" name="price[]"" value="'.$items['price'].'" id="salePrice_'.$items['id'].'" onkeyup="totalPrice('.$items['id'].')" required ></td>
        <td><input type="text" name="quantity[]"" value="'.$items['qty'].'" id="pices_'.$items['id'].'" onkeyup="totalPrice('.$items['id'].')" required ></td>
        <td><input type="text" class="tPrice" name="tprice[]"" value="'.$items['subtotal'].'" id="totalPrice_'.$items['id'].'" required readonly ></td>
        <td><button type="button" id="'.$items['rowid'].'" class="romove_cart btn btn-danger btn-sm">Cancel</button></td>
      </tr>';
    }
  $output .= '
    <tr>
      <th colspan="3">Total Amount</th>
      <th colspan="2" id="tamount">'.$this->cart->total().'</th>
    </tr>';
  return $output;
}

public function save_order_product()
  {
  $info = $this->input->post();
  
  $query = $this->db->select('oid')
                ->from('order')
                ->limit(1)
                ->order_by('oid','DESC')
                ->get()
                ->row();
  if($query)
    {
    $sn = substr($query->oid,5)+1;
    }
  else
    {
    $sn = 1;
    }
    
  $pc = sprintf("%'05d",$sn);

  $cusid = 'O-'.$pc;
  
  $id = $info['sid'];
  $id2 = $info['sName'];

  $sale = array(
    'compid'     => $info['compid'],
    'order_no'   => $cusid,
    'custName'   => $info['name'],
    'custMobile' => $info['mobile'],
    'custEmail'  => $info['email'],
    'custAddres' => $info['address'],
    'tAmount'    => array_sum($info['tprice'])
            );
        //var_dump($sale); exit();
  $result = $this->pm->insert_data('order',$sale);
       
  $length = count($info['product']);

  for($i = 0; $i < $length; $i++)
    {
    $spdata = array(
      'oid'      => $result,
      'product'  => $info['product'][$i],                    
      'quantity' => $info['quantity'][$i],
      'sprice'   => $info['price'][$i],
      'tPrice'   => $info['tprice'][$i]
          );

    $result2 = $this->pm->insert_data('order_product',$spdata); 
    }

  if($result2)
    {
    $sdata = [
      'exception' =>'<div class="alert alert-success alert-dismissible">
        <h4><i class="icon fa fa-check"></i> Product Order Place Successfully !</h4>
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
  redirect('store/'.$id.'/'.$id2);
}

public function order_product_list()
  {
  $data['title'] = 'Order';

  $where = [
    'compid' => $_SESSION['compid']
        ];
  $other = array(
    'order_by' => 'oid'
        );

  $data['order'] = $this->pm->get_data('order',$where,false,false,$other);
    
  $this->load->view('webhome/product_order',$data);
}

public function order_product_details($id)
  {
  $data['title'] = 'Home';
  
  $where = [
    'oid' => $id
        ];
  
  $field = array(
    'order' => 'order.*',
    'customers' => 'customers.*'
        );
  $join = array(
    'customers' => 'customers.customerID = order.customerID'
        );
  $store = $this->pm->get_data('order',$where);
  $data['order'] = $store[0];
  $other = array(
    'join' => 'left'
        );
  $field = array(
    'order_product' => 'order_product.*',
    'products' => 'products.productName,products.productcode'
        );
  $join = array(
    'products' => 'products.productID = order_product.product'
        );
  $data['product'] = $this->pm->get_data('order_product',$where,$field,$join,$other);
  $data['company'] = $this->pm->company_details();
  
  $this->load->view('webhome/order_view',$data);
}

public function information_page_details($id,$id2)
  {
  $data['title'] = 'Home';
  
  $where = [
    'sid' => $id
        ];

  $store = $this->pm->get_data('store',$where);
  $data['store'] = $store[0];

  $cwhere = [
    'compid' => $store[0]['compid'],
    'fpShow' => 1
        ];
  $cother = array(
    'limit' => 5,
    'order_by' => 'categoryID'
        );
  $data['category'] = $this->pm->get_data('categories',$cwhere,false,false,$cother);
  $data['compid'] = $store[0]['compid'];
  
  $cmother = array(
    'limit' => 3,
    'order_by' => 'categoryID'
        );
  $data['mcategory'] = $this->pm->get_data('categories',$cwhere,false,false,$cmother);
  
    //var_dump($data['title']); exit();
  $data['page'] = $this->pm->get_data('page_setting',$where);
  
  $this->load->view('webhome/page_info',$data);
}

public function contact_information($id,$id2)
  {
  $data['title'] = 'Contact Us';

  $where = [
    'sid' => $id
        ];

  $store = $this->pm->get_data('store',$where);
  $data['store'] = $store[0];

  $cwhere = [
    'compid' => $store[0]['compid'],
    'fpShow' => 1
        ];
  $cother = array(
    'limit' => 5,
    'order_by' => 'categoryID'
        );
  $data['category'] = $this->pm->get_data('categories',$cwhere,false,false,$cother);
  $data['compid'] = $store[0]['compid'];
  
  $cmother = array(
    'limit' => 3,
    'order_by' => 'categoryID'
        );
  $data['mcategory'] = $this->pm->get_data('categories',$cwhere,false,false,$cmother);
    
  $this->load->view('webhome/contact_us',$data);
}

public function save_notice_msg()
  {
  $info = $this->input->post();
  
  $id = $info['sid'];
  $id2 = $info['sName'];

  $data = array(
    'ntype'  => $info['ntype'],
    'subject' => $info['subject'],
    'message' => $info['message']
        );
  //var_dump($data); exit();
  $result = $this->pm->insert_data('notice',$data);
  if($result)
    {
    $sdata = [
      'exception' =>'<div class="alert alert-success alert-dismissible">
        <h4><i class="icon fa fa-check"></i> Message Send Successfully !</h4>
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
  redirect('store/'.$id.'/'.$id2);
}


        ################################################
        #   /* Pages  end*/                            #
        ################################################
}