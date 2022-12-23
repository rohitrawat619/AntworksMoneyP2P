<?=getNotificationHtml();?>


<div class="mytitle row">
    <div class="left col-md-4">
        <h1><?=$pageTitle;?></h1>
    </div>
</div>


<div class="white-box">
    <div class="col-md-12">
        <div class="table-responsive kyc-main">
            <form action="<?php echo base_url(); ?>borroweraction/add_docs_borrower_new" method="post" enctype="multipart/form-data">
            <table class="table m-t-30 table-bordered kyc-main">
                <tr>
                    <th>Document Type</th>
                    <th>Document No</th>
                    <th>Upload Document</th>
                </tr>
                <tr>
                   
                    <td>Pan</td>
                    <td><input type="text" class="form-control" name="doc_no_pan" placeholder="Pan No"></td>
                    <td><input type="file" name="pan_file" id="kyc-doc"></td>
                </tr>
                <tr>
                   
                    <td>Aadhaar</td>
                    <td><input type="text" class="form-control" name="doc_no_aadhar" placeholder="Aadhaar No"></td>
                    <td>
                        <input type="file" name="aadhar_file" id="kyc-doc">
                    </td>
                </tr>
                <tr>
                   
                    <td>Election ID Card</td>

                    <td><input type="text" class="form-control" name="doc_no_voterid" placeholder="Election ID No"></td>
                    <td><input type="file" name="voterid_file" id="kyc-doc"></td>
                </tr>
                <tr>
                   
                    <td>Ration Card</td>

                    <td><input type="text" class="form-control" name="doc_no_rashancard" placeholder="Ration Card No"></td>
                    <td><input type="file" name="ration_card" id="kyc-doc"></td>
                </tr>
                <tr>
                   
                    <td>Passport</td>

                    <td><input type="text" class="form-control" name="doc_no_passport" placeholder="Passport No"></td>
                    <td><input type="file" name="passport" id="kyc-doc"></td>
                </tr>
                <tr>
                   
                    <td>Other</td>
                    <td><input type="text" class="form-control" name="doc_no_other" placeholder="Document No"></td>
                    <td><input type="file" name="other" id="kyc-doc"></td>
                </tr>
            </table>
                <div class="col-md-12">
                    <div class="col-md-12 text-center">
                        <input type="submit" name="submit" class="btn btn-primary"  value="Upload">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

