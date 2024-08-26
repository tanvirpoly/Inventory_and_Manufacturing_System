<div class="content-wrapper" style="min-height: 1126px;">
    <section class="content-header">
        <h1>Access Permission</h1>
    </section>

    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Access Permission List</h3>
        </div>
        <div class="box-body">
            <div id="table-content">
                <table class="table table-responsive table-bordered" >
                    <thead>
                        <tr>
                            <th style="width: 23%;">Role Name</th>
                            <th>Pages</th>                          
                            <th>Status</th>
                            <th>Created Date</th>
                            <th style="width: 8%;">Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Role Name</th>
                            <th>Pages</th>                          
                            <th>Status</th>
                            <th>Created Date</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php
                        foreach ($accessPermissions as $key => $value) { 
                        $count = count($value['permission'])+1;
                        ?>
                        <tr class="gradeX" >      
                            <td rowspan="<?php echo $count;?>">
                                <label class="btn btn-info"><b><?php echo $value['lavelName'];?></b></label>
                                <a class="btn btn-primary" href="<?php echo site_url('AccessPermission/NewPermission').'/'.$value['accessLavelId']?>"> <i class="fa fa-plus" aria-hidden="true"></i> Add Permission</a>   
                            </td>
                            <?php if($count > 1)
                            {
                            foreach($value['permission'] as $permission)
                            { 
                            $class='btn-success';
                            if($permission['status']=='Inactive')
                                {
                                $class='btn-danger';
                                }
                            echo "</tr><tr class='".$class."'>";
                            ?>
                            <td><?php echo ucfirst($permission['pageName']);?></td>
                            <td><?php echo ($permission['status']=="Active")?'Yes':'No'?></td>
                            <td><?php echo date('d-m-Y',strtotime($permission['createdDate']))?></td>
                            <td><a class=" btn btn-warning" href="<?php echo site_url('AccessPermission/editPermission').'/'.$permission['pageAccessRelationId']?>" > <i class="fa fa-edit" ></i> Edit</a></td>
                            <?php } } ?> 
                        </tr>
                        <?php } ?> 
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>