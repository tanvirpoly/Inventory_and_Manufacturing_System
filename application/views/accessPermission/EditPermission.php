<div class="content-wrapper" style="min-height: 1126px;">
    <section class="content-header">
        <h1>Permission Information</h1>
    </section>

    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Access Permission Information</h3>
        </div>
        <div class="box-body">
            <div id="table-content ">
                <div class="col-md-12 col-sm-12 col-xs-12">
                <?php
                $url = site_url('accessPermission/SavePermission');
                $options = array('class' => 'form-inline','id' => 'category','method' => 'post','style'=>'margin:10px');
                echo form_open($url, $options); ?>
                <?php         
                if(isset($permissionAccess)){ 
                echo form_hidden('pageAccessRelationId',$permissionAccess['pageAccessRelationId']);
                ?>
                <?php } ?>
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="col-md-2 col-sm-2 col-xs-12">
                            <?php echo form_label('Page Name','pageName');?>                        
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <?php echo ucfirst($permissionAccess['pageName']); ?>
                        </div>
                        <div class="col-md-2 col-sm-2 col-xs-12">
                            <label>Permission</label>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <?php   
                            $data = array(
                                'name'    => 'status',
                                'id'      => 'active',
                                'value'   => 'Active',        
                                'checked' =>(isset($permissionAccess) && ($permissionAccess['status']=='Inactive'))?false:true
                                    );
                            echo form_radio($data); 
                            echo form_label('Yes','active');

                            $data = array(
                                'name'    => 'status',
                                'id'      => 'inactive',
                                'value'   => 'Inactive',        
                                'checked' =>(isset($permissionAccess) && ($permissionAccess['status']=='Inactive'))?true:false
                                    );
                            echo form_radio($data);
                            echo form_label('No', 'inactive');
                            ?>
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: 20px; text-align: center;">
                        <div class="col-md-12 col-sm-12 col-xs-12">    
                            <?php 
                            $submit = array(
                            'name'  => 'mysubmit',
                            'value' => 'Submit',
                            'class' => 'btn btn-primary',
                            'id'    => 'submit',
                            'style' => 'margin-right:10px'
                                );
                            echo form_submit($submit);

                            $submit['value'] = 'Reset';
                            $submit['class'] = 'btn btn-warning';
                            $submit['id'] = 'reset';
                            echo form_reset($submit);
                            ?>
                            <a href="<?php echo site_url('AccessPermission')?>" class="btn btn-success"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a>
                        </div>
                    </div>
                <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</div>