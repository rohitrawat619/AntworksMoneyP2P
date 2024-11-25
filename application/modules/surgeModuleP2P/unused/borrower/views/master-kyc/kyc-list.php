<div class="row">
<section class="content-header">
    <h1>
        <?php echo "Master KYC"; //$pageTitle; ?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Master KYC</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">

    <!-- Default box -->
    <div class="box">
        <div class="box-header with-border">
            <?=getNotificationHtml();?>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-12">

                </div>
                <div class="col-md-12">
                    <div class="table-responsive">
                    <table id="demo-foo-addrow" class="table m-t-30 table-hover " data-page-size="100">
                     <!-----   <tr>
                            <th>Date</th>
                            <th>Anchor</th>
                            <th colspan=5 >Information Collected</th>
                            <th colspan=9 >Kyc Information Received</th>
                            <th>Type of kyc</th>
                            <th>Kyc status</th>
                            <th>View Download</th>
                        </tr>   ----->
                        <tr style="background-color:#3c8dbc; color:white;">
                            <th>ID</th>
							<th>Borrower ID</th>
                        <th>Date</th>
                            <th>Anchor</th>
                            <th>Name</th>
                            <th>Name on Pan</th>
                            <th>Name on Aadhaar</th>
                            <th>Account Holder's Name</th>
                            <th>Account No</th>
                           <th>IFSC Code</th>
                           <th>Bank Name</th>
                           <th>Mobile</th>
                                               
                                                <th>DOB</th>
                                                <th>Pan No.</th>
                                                <th>Aadhaar No.</th>
                                                
                                               
                                                
                                                  <th>Liveness Check Slots</th>
                                                <th>Face Match Slots</th>
                                                <th>Pan Name Match</th>
                            <th>Bank Verified</th>
                            <th>Aadhaar Verified</th>
                                                <th>Type of kyc</th>
                            <th>Kyc status</th>
                         <!-----   <th>Details</th>  ----->
                            
                                            </tr>
                                       
                        <?php 
						$serialNo = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
						if($serialNo=="index"){
							$serialNo = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
						}
                         if ($lists){
                            foreach ($lists as $list): 
                            ?>
                          
                                <tr>  
                                <td> <?=($serialNo+=1)?></td>
								 <td><?=$list['borrower_id']?></td>
                                    <td><?=date('d-M-Y', strtotime($list['created_date']))?></td>
                                    <td>Antpay</td>
                                   
                                                <td> <?=$list['registered_name']?></td>
                                                <td><?=$list['pan_registered_name'] ?></td>
                                                <td><?=$list['aadhar_registered_name'] ?></td>
                                                <td><?=$list['bank_registered_name'] ?></td>
                                                <td> <?=$list['account_no']?></td>
                                                <td> <?=$list['bank_ifsc_code']?></td>
                                                <td> <?=$list['bank_name']?></td>
                                                <td> <?=$list['registered_mobile']?></td>
                                                <td><?=$list['aadhar_dob'] ?></td>
                                                <td> <?=$list['pan']?></td>
                                                <td> <?=$list['aadhar']?></td>
                                         
                                                <td><?="--" ?></td>
                                                <td><?="-" ?></td>
                                             <td><?=$list['panNameMatchedStatus']; ?></td>
                                                <td><?=$list['bank_is_verified']; ?></td>
                                                <td><?="----" ?></td>
                                                
                                    <td><?=$list['type_of_kyc']?></td>
                                    <td><?=$list['kyc_step']?></td>
                                    <!---- <td><a href="/Export">Download</a> </td> ---->
                                </tr>

                                <?php endforeach; } ?>
								
								<tfoot>
                        <tr>
                            <td colspan="12">
                                <?php

                                echo $pagination;

                                ?></td></tr>

                        
                        </tfoot>

                    </table>
                </div>
                </div>
            </div>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">

        </div>
        <!-- /.box-footer-->
    </div>
    <!-- /.box -->

</section>
</div>
