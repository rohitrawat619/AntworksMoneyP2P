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


<?php
?>

<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap.min.css">
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap.min.js"></script>


<script>
    $(document).ready(function() {
        $('#investlist').DataTable();
    });
    </script>

<script src="<?=base_url('assets-p2padmin\dist\js/xlsx.full.min.js')?>"></script>


<section class="content">
<div class="box">
<div class="box-body">

<div class="row">
<div class="col-md-12">
<div class="box-body table-responsive no-padding">
    <h2 style="text-align:center;">Redemption Pending List</h2>
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
             <th></th>
            <th>S.no.</th>
            <th>Created Date</th>
            <th>Lender Id</th>
            <th>Lender Name</th>
            <th>Account Number</th>
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
       
        <td><input type="checkbox" name="checkbox[]" value="<?php echo $row1['reinvestment_id']; ?>" /></td>
            <td><?php echo $i; ?></td>
            <td><?php echo date('Y-m-d', strtotime($row1['created_date'])); ?></td>
            <td><?php echo $row1['lender_id']; ?></td>
            <td><?php echo $row1['name']; ?></td>
            <td><?php echo $row1['account_no']; ?></td>
            <td><?php echo $row1['investment_No']; ?></td>
            <td><?php echo $row1['mobile']; ?></td>
            <td>₹<?php echo $row1['amount']; ?></td>
            <td><?php echo $row1['basic_rate']; ?></td>
            <td><?php echo $row1['source']; ?></td>
            <td><?php echo $row1['pre_mat_rate']; ?></td>
            <td><?php echo $row1['total_current_value']; ?></td>
            <td><?php echo $row1['total_no_of_days']; ?></td>
            <td>
                <?php if ($row1['redemption_status'] == 5) { ?>
                    <span class="label label-danger">Pending for Redemption</span>
                    <?php }?>
            </td>
           
         
            
        </tr>
        <?php $i++;
         }}
        else { echo "Sorry There are no pending for Redemption list yet!"; } ?>
        </tbody>    
        </table>
        
      <div style="text-align:center;">
        <button id="gbfileBtn" class="btn btn-warning">Generate Bank File</button>
        <div class="btn-container"></div>
      </div>

      
      
                
       <!-- <div style="margin-left:930px;">
       <button id="downloadExcelBtn" class="btn btn-success"><i class="fa fa-download"></i> Excel</button>
        </div> -->
        </div><div class="clearfix"></div>
    </div>
  </div>
</div>


</div>
</div>
</section>


<script>
$(document).ready(function() {
    $('#investlist').DataTable();

  
    $('#downloadExcelBtn').on('click', function() {
       
        var tableData = $('#investlist').DataTable().data().toArray();

      
        var wb = XLSX.utils.book_new();
        var ws = XLSX.utils.aoa_to_sheet(tableData);

        
        XLSX.utils.book_append_sheet(wb, ws, 'Disbursement List');

       
        XLSX.writeFile(wb, 'Pending_list.xlsx');
    });

      
       $('#dateFilter').on('keyup', function() {
        var dateValue = $(this).val().trim();
        $('#investlist').DataTable().column(1).search(dateValue).draw();
    });
});


   
    const checkboxes = document.querySelectorAll('#investlist input[type="checkbox"]');

    
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            
            if (this.checked) {
                console.log('Checkbox checked:', this.value); 
            } else {
                console.log('Checkbox unchecked:', this.value);
            }
        });
    });



    
     checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
          
            if (this.checked) {
                console.log('Checkbox checked:', this.value);
                enableGenerateBankFileButton();
            } else {
                console.log('Checkbox unchecked:', this.value);
                if (areAnyCheckboxesChecked()) {
                    enableGenerateBankFileButton();
                } else {
                    disableGenerateBankFileButton();
                }
            }
        });
    });

  
    function areAnyCheckboxesChecked() {
        return Array.from(checkboxes).some(checkbox => checkbox.checked);
    }

   
    function enableGenerateBankFileButton() {
        document.getElementById("gbfileBtn").disabled = false;
    }

    
    function disableGenerateBankFileButton() {
        document.getElementById("gbfileBtn").disabled = true;
    }

    disableGenerateBankFileButton();

    

    $(document).ready(function() {
    var buttonsGenerated = false;
   

    var containerDiv = document.querySelector(".btn-container");

    document.getElementById("gbfileBtn").addEventListener("click", function() {
        if (!buttonsGenerated) {

          /*  var manualRedemptionBtn = document.createElement("a");
          //  var manualRedemptionBtn = document.createElement("button");
            manualRedemptionBtn.textContent = "Manual Redemption List";
            manualRedemptionBtn.href = "Surgeadmin/export_redemption/";
            manualRedemptionBtn.classList.add("btn", "btn-success"); 
            manualRedemptionBtn.addEventListener("click", function(event) {
                exportDataToExcel();
            }); 

            var cmsRedemptionBtn = document.createElement("button");
            cmsRedemptionBtn.textContent = "CMS Redemption List";
            cmsRedemptionBtn.classList.add("btn", "btn-danger");
            cmsRedemptionBtn.addEventListener("click", function() {
                alert("CMS Redemption List button clicked!");
            });*/

          //  containerDiv.appendChild(manualRedemptionBtn);
         //   containerDiv.appendChild(cmsRedemptionBtn);

            buttonsGenerated = true;
        } else {
            containerDiv.innerHTML = "";
            buttonsGenerated = false;
        }
    });

    });







    $("#gbfileBtn").on("click", function () {                  
          
          var selectedRows = $("#investlist input:checked");

          if (selectedRows.length > 0) {
            
              var selectedIDs = selectedRows.map(function () {
                  return $(this).val();
              }).get();

          
              $.ajax({
                  url: "<?php echo base_url('Surgeadmin/update_redemption_status'); ?>",
                  method: "POST",
                  data: {
                      reinvestment_id: selectedIDs,
                     
                  },
                  success: function (response) {
                    if(response!=""){
                        var containerDiv = document.querySelector(".btn-container");
          
                        var manualRedemptionBtn = document.createElement("a");
          //  var manualRedemptionBtn = document.createElement("button");
            manualRedemptionBtn.textContent = "Manual Redemption List";
            manualRedemptionBtn.href = "Surgeadmin/export_redemption/?q="+response;
            manualRedemptionBtn.setAttribute('target', '_blank');
            manualRedemptionBtn.classList.add("btn", "btn-primary");
            containerDiv.appendChild(manualRedemptionBtn);

            var cmsRedemptionBtn = document.createElement("a");
            cmsRedemptionBtn.textContent = "Cms Redemption List";
            cmsRedemptionBtn.href = "Surgeadmin/export_cms_redemption/?q="+response;
            cmsRedemptionBtn.setAttribute('target', '_blank');
            cmsRedemptionBtn.classList.add("btn", "btn-info");
            containerDiv.appendChild(cmsRedemptionBtn);

                    }
                              //  alert(response); 
                      selectedRows.closest("tr").remove();

                      
                      $("##investlist").append(response);
                  },
                  error: function (xhr, status, error) {
                      console.error(error);
                      alert("An error occurred while processing the request.");
                  }
              });
          }
      });



// $(document).ready(function() {
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

</script>

