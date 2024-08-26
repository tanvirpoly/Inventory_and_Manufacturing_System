<div class="content-wrapper" style="min-height: 1126px;">
    <section class="content-header">
      <h1>Pages</h1>
    </section>

    
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Page Information</h3>
        </div>

        <div class="box-body">
            <form method="post" action="<?php echo base_url() ?>Pages/SavePage" >
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <input type="hidden" class="form-control" name="pageId" value="<?php echo(isset($page['pageId']))?$page['pageId']:'' ?>" >
                    <div class="form-group col-md-4 col-sm-4 col-xs-12">
                        <label>Page Name *</label>
                        <input type="text" class="form-control" name="pageName" required placeholder="Page Name" value="<?php echo(isset($page['pageName']))?$page['pageName']:'' ?>" >
                    </div>
                    <div class="form-group col-md-4 col-sm-4 col-xs-12">
                        <label>Controller Name *</label>
                        <input type="text" class="form-control" name="controllerName" placeholder="Controller Name" value="<?php echo(isset($page['controllerName']))?$page['controllerName']:'' ?>" required >
                    </div>
                    <div class="form-group col-md-4 col-sm-4 col-xs-12">
                        <label>List View Name </label>
                        <input type="text" class="form-control" name="listViewName" placeholder="List View Name" value="<?php echo(isset($page['listViewName']))?$page['listViewName']:'' ?>"  >
                    </div>
                    <div class="form-group col-md-4 col-sm-4 col-xs-12">
                        <label>Add View Name </label>
                        <input type="text" class="form-control" name="addViewName" placeholder="Add View Name" value="<?php echo(isset($page['addViewName']))?$page['addViewName']:'' ?>"  >
                    </div>
                    <div class="form-group col-md-4 col-sm-4 col-xs-12">
                        <label>Edit View Name </label>
                        <input type="text" class="form-control" name="editViewName" placeholder="Edit View Name" value="<?php echo(isset($page['editViewName']))?$page['editViewName']:'' ?>"  >
                    </div>
                    <div class="form-group col-md-4 col-sm-4 col-xs-12" >
                        <label>Status</label>
                        <div>
                            <input type="radio" name="status" value="Active" checked="checked" >&nbsp;Active&nbsp;&nbsp;
                            <input type="radio" name="status" value="Inactive" >&nbsp;Inactive
                        </div>
                    </div>
                </div>
                <div class="form-group col-md-12 col-sm-12 col-xs-12" style="margin-top: 20px;">
                    <div class="col-md-9 col-md-offset-4">  
                        <button type="submit" class="btn btn-info"><i class="fa fa-floppy-o"></i> Submit</button>
                        <a href="<?php echo site_url('Pages') ?>" class="btn btn-danger"><i class="fa fa-arrow-left"></i> Back</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>