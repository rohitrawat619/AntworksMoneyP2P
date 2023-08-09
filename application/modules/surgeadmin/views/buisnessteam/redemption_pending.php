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


<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap.min.css">
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap.min.js"></script>


<script>
    $(document).ready(function() {
        $('#investlist').DataTable();
    });
    </script>

<script src="<?=base_url('assets-p2padmin\dist\js/xlsx.full.min.js')?>"></script>

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
    <div class="table-responsive">
        <div class="filter-container" style="margin: 30px auto -30px auto; width: 300px; position: relative; z-index: 9;">
           <center><label for="date-filter">Date:</label>
            <input type="date" id="dateFilter"></center>
        </div>
    <table id="investlist" class="table table-hover" style="margin-top: 40px;">
        <thead>
        <tr>
             <th></th>
            <th>S.no.</th>
            <th>Created Date</th>
            <th>Lender Id</th>
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
            <td><?php echo $row1['created_date']; ?></td>
            <td><?php echo $row1['lender_id']; ?></td>
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


   
    const checkboxes = document.querySelectorAll('#investlist tbody input[type="checkbox"]');

    
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
            var manualRedemptionBtn = document.createElement("button");
            manualRedemptionBtn.textContent = "Manual Redemption List";
            manualRedemptionBtn.classList.add("btn", "btn-success");
            manualRedemptionBtn.addEventListener("click", function() {
                exportDataToExcel();
            });

            var cmsRedemptionBtn = document.createElement("button");
            cmsRedemptionBtn.textContent = "CMS Redemption List";
            cmsRedemptionBtn.classList.add("btn", "btn-danger");
            cmsRedemptionBtn.addEventListener("click", function() {
                alert("CMS Redemption List button clicked!");
            });

            containerDiv.appendChild(manualRedemptionBtn);
            containerDiv.appendChild(cmsRedemptionBtn);

            buttonsGenerated = true;
        } else {
            containerDiv.innerHTML = "";
            buttonsGenerated = false;
        }
    });

    function exportDataToExcel() {
        var csv = [];
        var headerRow = [
            "Amount", "Debit Account No", "IFSC Code",
            "Beneficiary A/C No", "Beneficiary Name", "Location",
            "Sender", "Receiver"
        ];
        
        // Add header row
        csv.push(headerRow.join(","));

        // Gather data from p2p reinvestment table
        var p2p_lender_reinvestment = document.getElementById("investlist");
        var reinvestmentRows = p2p_lender_reinvestment.getElementsByTagName("tr");
        console.log(reinvestmentRows);
        gatherTableData(reinvestmentRows, csv);
      
        // Gather data from p2p yes transaction table
        var p2p_yes_transactions = document.getElementById("investlist");
        var transactionRows = p2p_yes_transactions.getElementsByTagName("tr");
        gatherTableData(transactionRows, csv);

      

        var csvBlob = new Blob([csv.join("\n")], { type: "text/csv" });
        var link = document.createElement("a");
        link.href = window.URL.createObjectURL(csvBlob);
        link.download = "manual_redemption.csv";
        link.style.display = "none";
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);

      
    }
   
    function gatherTableData(rows, csv) {
        for (var i = 0; i < rows.length; i++) {
            var cols = rows[i].querySelectorAll("td");
            var rowData = [];
            for (var j = 0; j < cols.length; j++) {
                rowData.push(cols[j].textContent.trim());
            }
            csv.push(rowData.join("p2p_lender_reinvestment","p2p_yes_transactions"));

            
        }
    }
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
                      reinvestment_id: selectedIDs
                  },
                  success: function (response) {

                      selectedRows.closest("tr").remove();

                      
                      $("##investlist tbody").append(response);
                  },
                  error: function (xhr, status, error) {
                      console.error(error);
                      alert("An error occurred while processing the request.");
                  }
              });
          }
      });


</script>

