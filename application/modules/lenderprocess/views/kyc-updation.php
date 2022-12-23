<style>
    #pan {
        text-transform: uppercase;
    }
    .input-error{ border-color: red !important;}
    .error{
        color: red;
    }
</style>
<div class="mytitle row">
    <div class="left col-md-4">
        <h1><?=$pageTitle;?></h1>
        <?=getNotificationHtml();?>
    </div>
</div>
<div class="white-box">
    <div class="container">
         <form id="upload_kyc_documents" action="<?php echo base_url() ?>lenderaction/lenderkyc/lenderkyc" method="post" enctype="multipart/form-data">

            <div class="col-md-12">
                <div class="table-responsive kyc-main">
                    <p class="m-t-20">Please Upload your Pan Card Image</p>
                    <table class="table table-bordered kyc-main table-responsive">
                        <tr>
                            <th class="col-md-4">Document Type</th>
                            <th class="col-md-4">Upload</th>
                            <th class="col-md-4">Pan Number</th>
                            <th class="col-md-4">Status</th>
                        </tr>
                        <tr>
                            <td class="col-md-4">Pan</td>
                            <td class="col-md-4"><input class="form-control" type="text" name="pan" id="pan" value="<?php echo $info['pan'] ?>" readonly placeholder="Pan No" maxlength="10">
                                <span id="error_pan" class="validation-error error" style="display: none"></span>
                            </td>
                            <td class="col-md-4"><input type="file" name="pan_file" id="pan_file">
                                <span id="error_pan_file" class="validation-error error" style="display: none"></span>
                            </td>
                            <td><i class="fa fa-check" style="font-size: 18px;color: #00bb4b;"></i> </td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="col-md-12">
                <p class="m-t-30 m-b-0">Please upload your Address Proof.</p>
                <p>Is your Present Address same as Permanent Address? <label class="m-l-20 m-r-10"><input type="radio" value="yes" name="optionsPermanent" id="optionsPermanent1" checked> Yes</label> <label><input type="radio" value="no" name="optionsPermanent" id="optionsPermanent2"> No</label></p>
                <div class="table-responsive kyc-main">
                    <table class="table table-bordered kyc-main table-responsive">
                        <tr>

                            <th class="col-md-4">Document Type</th>
                            <th class="col-md-4">Upload</th>
                            <th class="col-md-4">Document No</th>
                        </tr>
                        <tr>
                            <td class="col-md-4">
                                <select class="form-control" name="document_type" id="document_type">
                                    <option value="">--select--</option>
                                    <option value="aadhar">Aadhar</option>
                                    <option value="voterid">Voter Id</option>
                                    <option value="passport">Passport</option>
                                </select>
                                <span id="error_document_type" class="validation-error error" style="display: none"></span>
                            </td>
                            <td class="col-md-4"><input type="text" class="form-control" placeholder="Document No" id="doc_no" name="doc_no">
                                <span id="error_doc_no" class="validation-error error" style="display: none"></span>
                            </td>
                            <td class="col-md-4"><input type="file" name="kyc_file" id="kyc_file">
                                <span id="error_kyc_file" class="validation-error error" style="display: none"></span>
                            </td>


                        </tr>
                    </table>


                </div>
            </div>
            <div class="col-md-12" id="second_address_option" style="display: none">
                <p class="m-t-30 m-b-0">If (No) - Second Address Proof Required</p>
                <div class="table-responsive kyc-main">
                    <table class="table table-bordered kyc-main table-responsive">
                        <tr>
                            <th class="col-md-4">Document Type</th>
                            <th class="col-md-4">Upload</th>
                            <th class="col-md-4">Document No</th>
                        </tr>
                        <tr>
                            <td class="col-md-4"><select class="form-control" name="secondry_document_type" id="secondry_document_type">
                                    <option value="">--Select--</option>
                                    <option value="landline">Landline / Telephone Bill</option>
                                    <option value="electricity_bill">Electricity Bill</option>
                                    <option value="lpg">LPG</option>
                                    <option value="png">PNG</option>
                                </select>
                                <span id="error_secondry_document_type" class="validation-error error" style="display: none"></span>
                            </td>
                            <td class="col-md-4"><input type="text" class="form-control" placeholder="Document No" name="secondry_doc_no" id="secondry_doc_no">
                                <span id="error_secondry_doc_no" class="validation-error error" style="display: none"></span>
                            </td>
                            <td class="col-md-4"><input type="file" name="secondry_kyc_file" id="secondry_kyc_file">
                                <span id="error_secondry_kyc_file" class="validation-error error" style="display: none"></span>
                            </td>

                        </tr>
                    </table>

                </div>
            </div>
            <div class="col-md-6 text-right">
                <input type="submit" class="btn btn-primary" id="verify_pan" name="verify_pan" value="verify"></td>
            </div>
            </form>
            <div class="col-md-6 text-right">
                <a href="<?php echo base_url(); ?>lenderprocess/bank-account-details">
                    <button class="btn btn-default">Skip</button>
                </a>
            </div>
        </div>
    </div>


<script>
    $('#upload_kyc_documents').submit(function(e){
        var validation = true;
        var pan = $("#pan").val();
        if(pan == '')
        {
            $("#error_pan").html('<p>Please enter Valid Pan Number</p>');
            $("#error_pan").show();
            validation = false;
        }
        var ss = pan.toUpperCase();
        var pattern = new RegExp("[A-Z]{5}[0-9]{4}[A-Z]{1}");
        var status = pattern.test(ss);
        if (status) {
            $("#error_pan").hide();
        } else {
            $("#error_pan").html('<p>Please enter Valid Pan Number</p>');
            $("#error_pan").show();
            validation = false;
        }

        var extpan = $('#pan_file').val().split('.').pop().toLowerCase();
        if($.inArray(extpan, ['gif','png','jpg','jpeg','pdf']) == -1) {
            $("#error_pan_file").html('<p>Please Select Valid Pancard Image</p>');
            $("#error_pan_file").show();
            validation = false;
        }
        if($("#document_type").val() == '')
        {
            $("#error_document_type").html('<p>Please Select Document Type</p>');
            $("#error_document_type").show();
            validation = false;
        }

        if($("#doc_no").val() == '')
        {
            $("#error_doc_no").html('<p>Please Enter Vald Document No</p>');
            $("#error_doc_no").show();
            validation = false;
        }

        var extkyc = $('#kyc_file').val().split('.').pop().toLowerCase();
        if($.inArray(extkyc, ['gif','png','jpg','jpeg','pdf']) == -1) {
            $("#error_kyc_file").html('<p>Please Select Valid Image</p>');
            $("#error_kyc_file").show();
            validation = false;
        }

        if($('input[name=optionsPermanent]:checked').val() == 'no')
        {
            if($("#secondry_document_type").val() == '')
            {
                $("#error_secondry_document_type").html('<p>Please Select Document Type</p>');
                $("#error_secondry_document_type").show();
                validation = false;
            }
            if($("#secondry_doc_no").val() == '')
            {
                $("#error_secondry_doc_no").html('<p>Please Enter Valid Document No</p>');
                $("#error_secondry_doc_no").show();
                validation = false;
            }
            var extsecondrykyc = $('#secondry_kyc_file').val().split('.').pop().toLowerCase();
            if($.inArray(extsecondrykyc, ['gif','png','jpg','jpeg','pdf']) == -1) {
                $("#error_secondry_kyc_file").html('<p>Please Select Valid Image</p>');
                $("#error_secondry_kyc_file").show();
                validation = false;
            }
        }

        if(validation == true)
        {
            return true
        }
        else{
            e.preventDefault();
            return false;
        }

    });
</script>
<script>
    $('input[type=radio][name=optionsPermanent]').change(function() {
        if (this.value == 'yes') {
            $("#second_address_option").hide();
        }
        else if (this.value == 'no') {
            $("#second_address_option").show();
        }
    });
</script>
<script>
    $('input').keydown(function() {
        $("#error_"+this.id).hide();
    });

    $('input').change(function() {
        $("#error_"+this.id).hide();
    });

    $('select').change(function() {
        $("#error_"+this.id).hide();
    });
</script>