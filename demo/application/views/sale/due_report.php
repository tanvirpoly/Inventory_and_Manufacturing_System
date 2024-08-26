<div class="content-wrapper" style="min-height: 1126px;">
    <section class="content" style="border: 20px solid white;">
    <?php
    $exception = $this->session->userdata('exception');
    if(isset($exception))
    {
    echo $exception;
    $this->session->unset_userdata('exception');
    } ?>

    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Due Report List</h3>
        </div>

        <div class="box-body">
            <div id="table-content">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th style="width: 5%;">#SN.</th>
                            <th style="width: 20%;">Invoice No.</th>
                            <th style="width: 15%;">Date</th>
                            <th style="width: 25%;">Sale</th>            
                            <th style="width: 25%;">Paid</th>
                            <th style="width: 20%;">Due</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 0;
                        foreach ($due as $value) {
                        $i++;
                        ?>
                        <tr>
                            <td><?php echo $i; ?></td>
                            <td><?php echo 'INV'.$value->saleID; ?></td>
                            <td><?php echo date('d-m-Y',strtotime($value->saleDate)); ?></td>
                            <td><?php echo number_format($value->totalAmount, 2); ?></td>
                            <td><?php echo number_format($value->paidAmount, 2); ?></td>
                            <td>
                            <?php
                            echo number_format(($value->totalAmount-($value->paidAmount+$value->discountAmount)), 2);
                            ?> 
                            </td>
                        </tr>   
                        <?php } ?> 
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">

    <script type="text/javascript">
        $(document).ready(function(){
        $('#example1').DataTable();
        });
    </script>
