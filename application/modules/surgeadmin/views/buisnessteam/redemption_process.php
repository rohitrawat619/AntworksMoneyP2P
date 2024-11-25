<?php 
if($this->session->userdata('session_data'))
{
    $udata = $this->session->userdata('session_data');

}
else
{
    redirect(base_url('Surgeadmin/login'));
}
 ?>

<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap.min.css">
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap.min.js"></script>
<script>
    $(document).ready(function() {
     //   $('#investlist').DataTable();
    });
    </script>





<script src="<?=base_url('assets-p2padmin\dist\js/xlsx.full.min.js')?>"></script>

<section class="content">
<div class="box">
<div class="box-body">
<div class="row">
<div class="col-md-12">
<div class="box-body table-responsive no-padding">
    <h2 style="text-align:center;">Redemption in process List</h2>
<?php if($this->session->flashdata('flashmsg')): ?>
    <div class="alert alert-success">
        <a href="#" class="close" data-dismiss="alert" area-label="close">x</a>
    <p><?php echo $this->session->flashdata('flashmsg'); unset($_SESSION['flashmsg']); ?></p>
    <?php endif ?>
    </div>

    <div class="table-responsive">
    <div class="col-md-3"></div>
    <div class="col-md-6">
        <div class="row">
        <div class="col-md-6">
            <b>To:</b> <input type="text" id="min" name="min" class="form-control">
        </div>
        <div class="col-md-6">
            <b>From:</b> <input type="text" id="max" name="max" class="form-control">
        </div>
        </div>
    </div>
    
    <table id="investlist" class="table table-hover" style="margin-top: 40px;">

        <thead>
        <tr>
            
        <th>S.no.</th>
            <th>Created Date</th>
            <th>Lender Id</th>
            <th>Lender Name</th>
            <th>Investment No</th>
            <th>Mobile</th>
            <th>Amount</th>
            <th>Basic Rate</th>
            <th>Source</th>
            <th>Pre Mature RATE</th>
            <th>Current Value</th>
            <th>Days</th>
            <th>Status</th>
          
           
        </tr>
        </thead>
        <tbody>
                <?php      
   
    if(@$row)
    {
     $i=1;
        foreach($row as $row1) { ?>
        <tr>
        
          
        <td><?php echo $i; ?></td>
            <td><?php echo date('Y-m-d', strtotime($row1['created_date'])); ?></td>
            <td><?php echo $row1['lender_id']; ?></td>
            <td><?php echo $row1['name']; ?></td>
            <td><?php echo $row1['investment_No']; ?></td>
            <td><?php echo $row1['mobile']; ?></td>
            <td>₹<?php echo $row1['amount']; ?></td>
            <td><?php echo $row1['basic_rate']; ?></td>
            <td><?php echo $row1['source']; ?></td>
            <td><?php echo $row1['pre_mat_rate']; ?></td>
            <td><?php echo $row1['total_current_value']; ?></td>
            <td><?php echo $row1['total_no_of_days']; ?></td>
            <td>
                <?php if ($row1['redemption_status'] == 2) { ?>
                <span class="label label-default">Redemption in process</span>
              
                        <?php } ?>
            </td>
         
           
           
           <!-- <td>
          
                <a class="btn btn-success" href="<?= base_url();?>Surgeadmin/disburseapproved/<?= $row1['reinvestment_id']; ?>/4" class="btn btn-success" onclick="return confirm('Are You Sure Want To Disburse Confirm This')">Disbursed</a>
               
           </td> -->
           
            
        </tr>
        <?php $i++;
         }}
        else { echo "Sorry There are no Redemption in process list yet!"; } ?>
        </tbody>    
        </table>
       <!-- <div style="margin-left:650px;">
        <button id="downloadExcelBtn" class="btn btn-success"><i class="fa fa-download"></i>Manual Disbursment sheet</button>
        <button id="downloadCSVBtn" class="btn btn-primary"><i class="fa fa-download"></i> Cms Disbursment Sheet</button> -->
       </div> 
    </div>
  </div>
</div>
</div>
</div>
</section>




    <script>
    $(document).ready(function() {
   // $('#investlist').DataTable();

    $(document).ready(function() {
  //  $('#investlist').DataTable();


    $('#downloadExcelBtn').on('click', function() {
        var tableData = [];
        var headers = [];

     
        var columnIndexMap = {
            'Amount': -1,
            'Debit Account No.': -1,
            'Ifsc Code': -1,
            'Benificiary A/c No.': -1,
            'Benificiary Name': -1,
            'Location': -1,
            'Sender And Receiver Info.': -1
        };

       
        $('#investlist thead tr th').each(function(index) {
            var headerText = $(this).text();
            if (headerText in columnIndexMap) {
                headers.push(headerText);
                columnIndexMap[headerText] = index;
            }
        });

        
        $('#investlist tbody tr').each(function() {
            var rowData = [];
            var row = $(this);
           
            headers.forEach(function(header) {
                var columnIndex = columnIndexMap[header];
                rowData.push(row.find('td:eq(' + columnIndex + ')').text());
            });

            if (rowData.length > 0) {
                tableData.push(rowData);
            }
        });

        var columnWidths = [20, 20, 20, 20, 20, 20, 20, 20];

        var currentDate = new Date();
        var formattedDate = getCurrentDateTimeFormatted();
        var fileName = 'Manual ' + formattedDate + '.XLSX';

        var wb = XLSX.utils.book_new();
        var ws = XLSX.utils.aoa_to_sheet([headers, ...tableData]); 

        ws['!cols'] = columnWidths.map(function(width) {
          return { wch: width };
         });
        XLSX.utils.book_append_sheet(wb, ws, 'Manual Disbursement List');
        XLSX.writeFile(wb, fileName);
    });

     function getCurrentDateTimeFormatted() {
        var currentDate = new Date();
        var year = currentDate.getFullYear();
        var month = ('0' + (currentDate.getMonth() + 1)).slice(-2);
        var day = ('0' + currentDate.getDate()).slice(-2);
        var hours = ('0' + (currentDate.getHours() %12 || 12)).slice(-2);
        var minutes = ('0' + currentDate.getMinutes()).slice(-2);
        var seconds = ('0' + currentDate.getSeconds()).slice(-2);
        var ampm = currentDate.getHours() >=12 ? 'AM' : 'PM';
        var formattedTime = hours + '-' + minutes + '-' + seconds;
        return day + ' ' + month + ' ' + year + '   ' + formattedTime + ' ' + ampm;
    }

  
    $('#downloadCSVBtn').on('click', function() {
    var tableData = [];
    var headers = [];

    
    var columnIndexMap = {
        'Client Code': -1,
        'Amount': -1,
        'Debit Account No.': -1,
        'Transfer Type': -1,
        'Benificiary Name': -1,
        'Benificiary A/c No.': -1,
        'Remark': -1,
        'Ifsc Code': -1 
    };

   
    $('#investlist thead tr th').each(function(index) {
        var headerText = $(this).text();
        if (headerText in columnIndexMap) {
            headers.push(headerText);
            columnIndexMap[headerText] = index;
        }
    });

  
    $('#investlist tbody tr').each(function() {
        var rowData = [];
        var row = $(this);

        headers.forEach(function(header) {
            var columnIndex = columnIndexMap[header];
            rowData.push(row.find('td:eq(' + columnIndex + ')').text());
        });

        if (rowData.length > 0) {
            tableData.push(rowData);
        }
    });

    var columnWidths = [10, 20, 20, 20, 20, 20, 15, 20]; 

    var currentDate = new Date();
    var formattedDate = getCurrentDateTimeFormatted();
    var fileName = 'Cms ' + formattedDate + '.XLSX';

    var wb = XLSX.utils.book_new();
    var ws = XLSX.utils.aoa_to_sheet([headers, ...tableData]); 
    ws['!cols'] = columnWidths.map(function(width) {
        return { wch: width };
    });

    
    XLSX.utils.book_append_sheet(wb, ws, 'Cms Disbursement List');
    XLSX.writeFile(wb, fileName);
});

     function getCurrentDateTimeFormatted() {
        var currentDate = new Date();
        var year = currentDate.getFullYear();
        var month = ('0' + (currentDate.getMonth() + 1)).slice(-2);
        var day = ('0' + currentDate.getDate()).slice(-2);
        var hours = ('0' + (currentDate.getHours() %12 || 12)).slice(-2);
        var minutes = ('0' + currentDate.getMinutes()).slice(-2);
        var seconds = ('0' + currentDate.getSeconds()).slice(-2);
        var ampm = currentDate.getHours() >=12 ? 'PM' : 'AM';
        var formattedTime = hours + '-' + minutes + '-' + seconds;
        return day + ' ' + month + ' ' + year + '   ' + formattedTime + ' ' + ampm;

     }



    

    $(document).ready(function() {
       // $('#investlist').DataTable();
     var table = $('#investlist').DataTable({
           initComplete: function() {
                var api = this.api();
                $('#min, #max').on('change', function() {
                    api.draw();
                });
            },
           
        });

    
        $('#min').datepicker({
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
            onSelect: function() {
                table.draw();
            },
        });
        $('#max').datepicker({
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
            onSelect: function() {
                table.draw();
            },
        });

      
       
       $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
      
            var min = $('#min').val();
            var max = $('#max').val();
            var date = data[1]; 

            if ((min === "" && max === "") ||
                (min === "" && date <= max) ||
                (min <= date && max === "") ||
                (min <= date && date <= max)
            ) {
                return true;
            }

            return false;
        });

    });
});



});

   

   </script>
