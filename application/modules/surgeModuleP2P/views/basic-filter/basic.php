<div class="">
<section class="content-header">
    <h1>
        <?php echo $pageTitle; ?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Report</li>
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
                <div class="m-t-30">
                    <div class="right-page-header">
                        <form method="post" id="download_report" action="../borrower/filter_report">
                            <div class="col-md-12">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <input type="text" readonly name="start_date" id="daterange-btn_onlymonth" placeholder="Filter by date" class="form-control filter-by-date">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <input type="submit" value="View" name="View" class="btn btn-primary">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <input type="submit" value="Download" name="Download" class="btn btn-primary">
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                    <table id="demo-foo-addrow" class="table table-bordered table m-t-30 table-hover contact-list " data-page-size="100">
                       
                        <tr>
                            <th>Basic filtration criteria</th>
                            <th>Total Visitor</th>
                            <th>Count of Pass(After particular filtration criteria)</th>
                            <th>Count of Stop/Decline(After particular filtration criteria)</th>
                        </tr>
                       

                       
                      
                        <tr>
                            <td>1. DOB </td>
                            <td><?=$age_success_fail['success'] + $age_success_fail['fail']?></td>
                            <td><?=$age_success_fail['success']?></td>
                            <td><?=$age_success_fail['fail']?></td>
                        </tr>
                        <!--<tr>
                            <td>2. PAN not validate with filled details</td>
                            <td><?/*=$get_pan_success_fail['success'] + $get_pan_success_fail['fail']*/?></td>
                            <td><?/*=$get_pan_success_fail['success']*/?></td>
                            <td><?/*=$get_pan_success_fail['fail']*/?></td>
                        </tr>-->
                        <tr>
                            <td>2. Negative PIN CODE</td>
                            <td><?=$get_pincode_success_fail['success'] + $get_pincode_success_fail['fail']?></td>
                            <td><?=$get_pincode_success_fail['success']?></td>
                            <td><?=$get_pincode_success_fail['fail']?></td>
                        </tr>
                        <tr>
                            <td>3. Qualification</td>
                            <td><?=$get_Qualification_success_fail['success'] + $get_Qualification_success_fail['fail']?></td>
                            <td><?=$get_Qualification_success_fail['success']?></td>
                            <td><?=$get_Qualification_success_fail['fail']?></td>
                        </tr>
                        <tr>
                            <td>4. Occupation</td>
                            <td><?=$get_Occupation_success_fail['success'] + $get_Occupation_success_fail['fail']?></td>
                            <td><?=$get_Occupation_success_fail['success']?></td>
                            <td><?=$get_Occupation_success_fail['fail']?></td>
                        </tr>
                        <tr>
                            <td>5. Company not match with our CAT list</td>
                            <td><?=$get_Company_success_fail['success'] + $get_Company_success_fail['fail']?></td>
                            <td><?=$get_Company_success_fail['success']?></td>
                            <td><?=$get_Company_success_fail['fail']?></td>
                        </tr>
                        <tr>
                            <td>6. Salary </td>
                            <td><?=$get_salary_success_fail['success'] + $get_salary_success_fail['fail']?></td>
                            <td><?=$get_salary_success_fail['success']?></td>
                            <td><?=$get_salary_success_fail['fail']?></td>
                        </tr>
                        <tr>
                            <td>7. Experian </td>
                            <td><?=$get_credit_score_success_fail['success'] + $get_credit_score_success_fail['fail']?></td>
                            <td><?=$get_credit_score_success_fail['success']?></td>
                            <td><?=$get_credit_score_success_fail['fail']?></td>
                        </tr>
                        
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
<script type="text/javascript">
    function myFunction(docid) {
        $.ajax({
            type: "POST",
            url: "<?=base_url();?>p2padmin/documentverification/updatedoc",
            dataType: "html",
            data: "doc_id=" + docid,
            async: false,
            success: function (data) {
                var response = JSON.parse(data);
                if (response['status'] == 1) {
                    alert(response['response']);
                    window.location.reload();

                } else {
                    alert(response['response']);
                }
            }
        });
    }


    function myFunction2(docid) {
        $('#comment' + docid).show();
    }


    function updatecomment(docid, email) {

        var comment = $('#v_comment' + docid).val();
        $.ajax({
            type: "POST",
            url: "<?=base_url();?>p2padmin/documentverification/updatecomment",
            dataType: "html",
            data: "doc_id=" + docid + "&comment=" + comment + "&email=" + email,
            async: false,
            success: function (data) {
                var response = JSON.parse(data);
                if (response['status'] == 1) {
                    alert(response['response']);
                    window.location.reload();

                } else {
                    alert(response['response']);
                }
            }
        });
    }


    $(document).ready(function () {
        var i = 0;
        $(".upload-mfile-btn").click(function () {
            i = i + 1;
            var domElement = $('<div class="col-md-6 col-sm-4"><div class="form-group"><input class="form-control" type="text" name="doc_name[]" placeholder="Enter Document Name"/><br><input class="form-control" type="file" name="doc_file[]"/></div></div></div>');
            $('.upload-mfile').before(domElement);
        });


    });


    function ititiateEnach(borrowerId) {
        $.ajax({
            async: true,
            type: "POST",
            url: baseURL + "P2padmin/Repayment/initiateEnach",
            data: {borrowerId: borrowerId},
            success: function (data) {
                var response = $.parseJSON(data);
                if (response.status == 1) {
                    $("#initiate_enach").hide();
                    alert(response.msg);
                } else {
                    alert(response.msg);
                }
            }
        });
    }


    function verifyBank(borrowerId) {
        $("verify_banking").hide();
        $.ajax({
            async: true,
            type: "POST",
            url: baseURL + "P2padmin/P2pborrower/verifyBankdetails",
            data: {borrowerId: borrowerId},
            success: function (data) {
                var response = $.parseJSON(data);
                if (response.status == 1) {
                    alert(response.msg);
                    window.location.reload();
                } else {
                    alert(response.msg);
                }
            }
        });
    }

    function acceptborrowerRequest(requestId, borrowerId) {
        $.ajax({
            async: true,
            type: "POST",
            url: baseURL + "P2padmin/P2pborrower/acceptborrowerRequest",
            data: {requestId: requestId, borrowerId: borrowerId},
            success: function (data) {
                // var response = $.parseJSON(data);
                // console.log(response);
                if (data == 1) {
                    alert("Record Update successfully");
                    window.location.reload();
                }
            }
        });
    }

    function updatepan() {
        $.ajax({
            type: "POST",
            url: baseURL + "p2padmin/p2pborrower/update_borrower_pan_v2",
            data: $("#update_pan").serialize(),
            success: function (data) {
                var response = $.parseJSON(data);
                alert(response.msg);
                window.location.reload();
            }
        });

    }

    function verifyPanstep(borrowerId) {
        var result_confirmation = confirm("Are you sure active Pan step?");
        if (result_confirmation) {
            $.ajax({
                async: true,
                type: "POST",
                url: baseURL + "P2padmin/P2pborrower/verifyPanstep",
                data: {borrowerId: borrowerId},
                success: function (data) {
                    var response = $.parseJSON(data);
                    alert(response.msg);
                }
            });
        } else {
            return false;
        }

    }

    function sendVerificationlink(borrowerId) {
        var email_id = $("#update_email").val();
        if(email_id){
            $.ajax({
                async: true,
                type: "POST",
                url: baseURL+"P2padmin/p2pborrower/resendverificationlink",
                data: {borrowerId:borrowerId, email:email_id},
                success: function (data) {
                    var response =  $.parseJSON(data);
                    if(response.status == 1)
                    {
                        alert(response.msg);
                    }
                    else {
                        alert(response.msg);
                    }
                }
            });
        }
        else{
            alert("Please enter borrower email ID");
        }

    }

    function clearForm(){
        $('#search_admin').find("input[type=text], select").val("");
        $("#borrower_list").show();
        $("#borrower_search_list").html('');
    }

    $("#search_by_admin").click(function () {


        $.ajax({
            url: baseURL+"searchmodule/adminsearch",
            type: "POST",
            data: $("#search_admin").serialize(),
            dataType: "json",
            success: function (data) {
                //console.log(data);
                var response = JSON.stringify(data);
                var j = JSON.parse(response);

                $("#borrower_list").hide();

                $("#borrower_search_list").html(j.search_result);



            }
        });
    });
    function isNumberKey(evt) {
        var charCode = (evt.which) ? evt.which : event.keyCode;
        if ((charCode > 47 && charCode < 58) || (charCode == 8)) {
            return true;
        } else {
            return false;
        }
    }
</script>
<script>
    $('#daterange-btn_onlymonth').val();
    $(function () {
        //Date range as a button
        $('#daterange-btn_onlymonth').daterangepicker(
            {

                ranges   : {
                    'Today'       : [moment(), moment()],
                    'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month'  : [moment().startOf('month'), moment().endOf('month')],
                    'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                },
                "dateLimit": {
                    "month": 1
                },
                autoApply: false,
                startDate: moment().subtract(29, 'days'),
                endDate  : moment(),
            },
            function (start, end) {
                $('#daterange-btn_onlymonth span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))

            }
        )
        $('.filter-by-date').val("");

    });
    //Date picker
    $('#datepicker').datepicker({
        autoclose: true,
        format: 'dd/mm/yyyy',
    })
</script>

<script>
    $('#daterange-btn_onlymonth_1').val();
    $(function () {
        //Date range as a button
        $('#daterange-btn_onlymonth_1').daterangepicker(
            {

                ranges   : {
                    'Today'       : [moment(), moment()],
                    'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month'  : [moment().startOf('month'), moment().endOf('month')],
                    'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                },
                "dateLimit": {
                    "month": 1
                },
                autoApply: false,
                startDate: moment().subtract(29, 'days'),
                endDate  : moment(),
            },
            function (start, end) {
                $('#daterange-btn_onlymonth_1 span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))

            }
        )
        $('.filter-by-date').val("");

    });
    //Date picker
    $('#datepicker').datepicker({
        autoclose: true,
        format: 'dd/mm/yyyy',
    })
</script>