<?php $this->load->view('header/header'); ?>
<?php $this->load->view('navbar/navbar'); ?>

  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Staff / Employee</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Dashboard">Dashboard</a></li>
              <li class="breadcrumb-item active">Staff / Employee </li>
            </ol>
          </div>
        </div>
      </div>
    </section>

    <?php
    $exception = $this->session->userdata('exception');
    if(isset($exception))
    {
    echo $exception;
    $this->session->unset_userdata('exception');
    } ?>

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12 col-sm-12 col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Staff / Employee / Outlet List</h3>
                <?php if($_SESSION['new_employee'] == 1){ ?>
                <button type="button" class="btn btn-primary add_emp" data-toggle="modal" data-target=".bs-example-modal-aemp" style="float: right" ><i class="fa fa-plus"></i> New Staff / New Outlet</button>
                <?php } ?>
              </div>

              <div class="card-body">
                <table id="example" class="table table-striped table-bordered table-hover">
                  <thead>
                    <tr>
                      <th  style="width: 5px;" >SN</th>
                      <th>ID</th>
                      <th>NAME</th>
                      <th>MOBILE</th>
                      <th>EMAIL</th>
                      <th>ADDRESS</th>
                      <th>JOIN DATE</th>
                      <th>Leave DATE</th>
                      <th>SALARY</th>
                      <th>Consent</th>
                      <th>STATUS</th>
                      <th style="width: 8%;">ACTION</th>
                    </tr>
                  </thead>
                  
                  <tbody>
                    <?php
                    $i = 0;
                    foreach ($employee as $value) {
                    $i++;
                    ?>
                    <tr class="gradeX">
                      <td><?php echo $i; ?></td>
                      <td><?php echo $value['emp_id']; ?></td>
                      <td><?php echo $value['employeeName']; ?></td>
                      <td><?php echo $value['phone']; ?></td>
                      <td><?php echo $value['email']; ?></td>
                      <td><?php echo $value['empaddress']; ?></td>
                      <td><?php echo date('d-m-Y', strtotime($value['joiningDate'])); ?></td>
                      <td><?php echo date('d-m-Y', strtotime($value['leavingDate'])); ?></td>
                      <td><?php echo number_format($value['salary'], 2); ?></td>
                      <td><?php echo $value['consent']; ?></td>
                      <td><?php echo $value['status']; ?></td>
                      <td>
                        <a class="btn btn-info btn-xs" href="<?php echo base_url().'viewEmployee/'.$value['employeeID']; ?>"><i class="fa fa-eye"></i></a>
                        <?php if($_SESSION['edit_employee'] == 1){ ?>
                        <button type="button" class="btn btn-success btn-xs emp_edit" data-toggle="modal" data-target=".bs-example-modal-eemp" data-id="<?php echo $value['employeeID']; ?>" ><i class="fa fa-edit"></i></button>
                        <?php } if($_SESSION['delete_employee'] == 1){ ?>
                        <a class=" btn btn-danger btn-xs" href="<?php echo site_url('employee/delete_Employee').'/'.$value['employeeID'] ?>" ><i class="fa fa-trash"></i></a>
                        <?php } ?> 
                      </td>
                    </tr>   
                    <?php } ?> 
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
  
  

    <div class="modal fade bs-example-modal-aemp" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-md">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Staff Information</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
          </div>
          
          <form action="<?php echo base_url('Employee/save_employee'); ?>" method="post" enctype='multipart/form-data' >
            <div class="col-md-12 col-sm-12 col-12">
              <div class="row">
                <div class="form-group col-md-6 col-sm-6 col-12">
                  <label>Staff / Employee Name *</label>
                  <input type="text" class="form-control" name="employeeName" placeholder="Staff Name" required>
                </div>
                <?php
                $query = $this->db->select('employeeID')
                              ->from('employees')
                            //   ->where('compid',$_SESSION['compid'])
                              ->limit(1)
                              ->order_by('employeeID','DESC')
                              ->get()
                              ->row();
                if($query)
                  {
                  $sn = $query->employeeID+1;
                  }
                else
                  {
                  $sn = 1;
                  }
            
                $cn = strtoupper(substr($_SESSION['compname'],0,3));
                $pc = sprintf("%'05d",$sn);
            
                $cusid = 'E-'.$cn.$pc;
                ?>
                <div class="form-group col-md-6 col-sm-6 col-12">
                  <label>Department</label>
                  <select name="dpt_id" id="department" class="form-control"  >
                    <option value="">Select One</option>
                    <?php foreach ($dept as $value) { ?>
                    <option value="<?php echo $value['dpt_id']; ?>"><?php echo $value['dept_name']; ?></option>
                    <?php } ?>
                  </select>
                </div>
                <div class="form-group col-md-6 col-sm-6 col-12">
                  <label>Address *</label>
                  <input type="text" class="form-control" name="empaddress" placeholder="Address" required >
                </div>
                <div class="form-group col-md-6 col-sm-6 col-12">
                  <label>Contact Number *</label>
                  <input type="text" class="form-control" name="phone" placeholder="Mobile Number *" onkeypress="return isNumberKey(event)" maxlength="11" minlength="11" required >
                </div>
                <div class="form-group col-md-6 col-sm-6 col-12">
                  <label>Email</label>
                  <input type="email" class="form-control" name="email" placeholder="example@gmail.com" >
                </div>
                <div class="form-group col-md-6 col-sm-6 col-12">
                  <label>Joining Date *</label>
                  <input type="text" class="form-control datepicker" name="joiningDate" placeholder="Joining Date" required >
                </div>
                 <div class="form-group col-md-6 col-sm-6 col-12">
                  <label>Leaving Date</label>
                  <input type="text" class="form-control datepicker" name="leavingDate" placeholder="Leaving Date" >
                </div>
                <div class="form-group col-md-6 col-sm-6 col-12">
                  <label>Salary</label>
                  <input type="text" class="form-control" name="salary" placeholder="Salary" >
                </div>
                <div class="form-group col-md-6 col-sm-6 col-12">
                  <label>NID Number</label>
                  <input type="text" class="form-control" name="nid" placeholder="NID Number" >
                </div> <br>
                <div class="form-group col-md-6 col-sm-6 col-12">
                  <label>Consent</label>
                  <textarea type="text" class="form-control" name="consent" cols="10" rows="1" >Consent</textarea>
                </div>
                
                <div class="form-group col-md-6 col-sm-6 col-12">
                  <label>Employee Image</label>
                  <input type="file" name="userfile" >
                </div>
                
                <div class="form-group col-md-6 col-sm-6 col-12">
                  <label>Employee Signature</label>
                  <input type="file" name="usersig" >
                </div>
              </div>
              <div class="modal-footer">
                <button type="submit" class="btn btn-primary"><i class="far fa-save"></i>&nbsp;&nbsp;Submit</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="far fa-window-close"></i>&nbsp;&nbsp;Cancel</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
    

    <div class="modal fade bs-example-modal-eemp" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-md">
        <div class="modal-content" >
          <div class="modal-header">
            <h4 class="modal-title" >Update Staff Information</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
          </div>
          <form action="<?php echo base_url('Employee/update_Employee');?>" method="post" enctype='multipart/form-data' >
            <div class="col-md-12 col-sm-12 col-12">
              <div class="row">
                <div class="form-group col-md-6 col-sm-6 col-12">
                  <label>Staff / Employee / Outlet Name *</label>
                  <input type="text" class="form-control" name="employeeName" id="empname" required >
                </div>
                <div class="form-group col-md-6 col-sm-6 col-12">
                  <label>Department</label>
                  <select name="dpt_id" id="empdept" class="form-control"  >
                    <option value="">Select One</option>
                    <?php foreach ($dept as $key => $value) { ?>
                    <option value="<?php echo $value['dpt_id']; ?>"><?php echo $value['dept_name']; ?></option>
                    <?php } ?>
                  </select>
                </div>
                <div class="form-group col-md-6 col-sm-6 col-12">
                  <label>Address *</label>
                  <input type="text" id="empaddress" class="form-control" name="empaddress" required >
                </div>
                <div class="form-group col-md-6 col-sm-6 col-12">
                  <label>Contact Number *</label>
                  <input type="text" id="mobile" class="form-control" name="phone" onkeypress="return isNumberKey(event)" maxlength="11" minlength="11" required >
                </div>
                <div class="form-group col-md-6 col-sm-6 col-12">
                  <label>Email</label>
                  <input type="email" class="form-control" id="empemail" name="email" >
                </div>
                <div class="form-group col-md-6 col-sm-6 col-12">
                  <label>Joining Date *</label>
                  <input type="text" class="form-control datepicker" id="jdate" name="joiningDate" required >
                </div>
                <div class="form-group col-md-6 col-sm-6 col-12">
                  <label>Leaving Date</label>
                  <input type="text" class="form-control datepicker" id="ldate" name="leavingDate"  >
                </div>
                <div class="form-group col-md-6 col-sm-6 col-12">
                  <label>Salary</label>
                  <input type="text" class="form-control" name="salary" id="salary" >
                </div>
                <div class="form-group col-md-6 col-sm-6 col-12">
                  <label>NID</label>
                  <input type="text" class="form-control" name="nid" id="nid">
                </div>
                <div class="form-group col-md-6 col-sm-6 col-12">
                  <label>Consent</label>
                  <input type="text" class="form-control" name="consent" id="consent">
                </div>
                
                <div class="form-group col-md-6 col-sm-6 col-12">
                  <label>Employee Image</label>
                  <input type="file" name="userfile" >
                </div>
                
                <div class="form-group col-md-6 col-sm-6 col-12">
                  <label>Employee Signature</label>
                  <input type="file" name="usersig" >
                </div>
                <div class="form-group col-md-6 col-sm-6 col-12" >
                  <label>Status</label>
                  <select class="form-control" name="status" id="status" >
                    <option value="Active">Active</option>
                    <option value="Inactive">Inactive</option>
                  </select>
                </div>
              </div>
              <input type="hidden" id="emp_id" name="emp_id" required >
              <div class="modal-footer">
                <button type="submit" class="btn btn-primary"><i class="far fa-save"></i>&nbsp;&nbsp;Update</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="far fa-window-close"></i>&nbsp;&nbsp;Cancel</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
    
<?php $this->load->view('footer/footer'); ?>

    <script type="text/javascript">
      $(document).ready(function(){
        $(".emp_edit").click(function(){
          var catid = $(this).data('id');
          //alert(l_id);
          $('input[name="emp_id"]').val(catid);
          });

        $('.emp_edit').click(function(){
          var id = $(this).data('id');
            //alert(id);
          var url = '<?php echo base_url() ?>Employee/get_emp_data';
            //alert(url);
          $.ajax({
            method: 'POST',
            url     : url,
            dataType: 'json',
            data    : {'id' : id},
            success:function(data){ 
              //alert(data);
              var HTML = data["employeeName"];
              var HTML2 = data["empaddress"];
              var HTML3 = data["phone"];
              var HTML4 = data["email"];
              var HTML5 = data["joiningDate"];
              var HTML15 = data["leavingDate"];
              var HTML6 = data["salary"];
              var HTML7 = data["nid"];
              var HTML17 = data["consent"];
              var HTML8 = data["status"];
              var HTML9 = data["dpt_id"];
              
              //alert(HTML);
              $("#empname").val(HTML);
              $("#empaddress").val(HTML2);
              $("#mobile").val(HTML3);
              $("#empemail").val(HTML4);
              $("#jdate").val(HTML5);
              $("#ldate").val(HTML15);
              $("#salary").val(HTML6);
              $("#nid").val(HTML7);
              $("#consent").val(HTML17);
              $("#status").val(HTML8);
              $("#empdept").val(HTML9);
              },
            error:function(){
              alert('error');
              }
            });
          });
        });
    </script>
    