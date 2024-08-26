<div class="content-wrapper" style="min-height: 1126px;">
    <section class="content-header">
        <h1>Pages</h1>
    </section>

    <?php if ($this->session->flashdata('msg')) { ?>
    <div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-success"></i> Success</h4>
        <?php echo $this->session->flashdata('msg'); ?>
    </div>
    <?php } ?>

    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Page List</h3>
            <a href="<?php echo site_url('Pages/AddPage') ?>" class="btn btn-primary" style="float: right" ><i class="fa fa-plus"></i> New Page</a>
        </div>

        <div class="box-body">
            <div id="table-content ">
                <table id="datatable" class="table table-responsive table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>#SN.</th>
                            <th>Page</th>
                            <th>Controller</th>
                            <th>list View</th>
                            <th>Add View</th>
                            <th>Edit View</th>
                            <th>Staus</th>
                            <th>Created Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>#SN.</th>
                            <th>Page</th>
                            <th>Controller</th>
                            <th>list View</th>
                            <th>Add View</th>
                            <th>Edit View</th>
                            <th>Staus</th>
                            <th>Created Date</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php
                        $i = 0;
                        foreach ($pages as $key => $value) { 
                        $i++;
                        ?>
                        <tr class="gradeX">      
                            <td><?php echo $i; ?></td>
                            <td><?php echo $value['pageName']; ?></td>
                            <td><?php echo $value['controllerName']; ?></td>
                            <td><?php echo $value['listViewName']; ?></td>
                            <td><?php echo $value['addViewName']; ?></td>
                            <td><?php echo $value['editViewName']; ?></td>
                            <td><?php echo $value['status']; ?></td>     
                            <td><?php echo date('d-m-Y',strtotime($value['createdDate'])); ?></td>
                            <td>
                                <a class=" btn btn-success" href="<?php echo site_url('Pages/AddPage').'/'.$value['pageId']; ?>" ><i class="fa fa-edit"></i>Edit</a>
                            </td>
                        </tr>   
                        <?php } ?> 
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>