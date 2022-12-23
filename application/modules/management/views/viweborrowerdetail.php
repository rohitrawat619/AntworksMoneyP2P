<?=getNotificationHtml();
//echo "<pre>";
//print_r($list); exit;
?>
<link rel="stylesheet" href="https://www.antworksmoney.com/assets-admin/floratexteditor/css/codemirror.min.css">

<link href="https://www.antworksmoney.com/assets-admin/floratexteditor/css/froala_editor.pkgd.min.css" rel="stylesheet" type="text/css" />

<link href="https://www.antworksmoney.com/assets-admin/floratexteditor/css/froala_style.min.css" rel="stylesheet" type="text/css" />

<script type="text/javascript">$(function() {
        $('textarea#froala-editor').froalaEditor()
    });

</script>
<div class="row">
    <div class="col-md-12">
        <div class="white-box p-0">
            <!-- .left-right-aside-column-->
            <div class="page-aside">
                <!-- .left-aside-column-->

                <!-- /.left-aside-column-->
                <div class="">
                    <div class="right-page-header">
                        <!--<div class="pull-right">
                            <input type="text" id="demo-input-search2" placeholder="search p2p loans" class="form-control">
                        </div>-->
                        <h3>Borrower Details</h3>
                        <br>
                        <h3> Borrower Name: <?= $list[0]['borrower'];?></h3>
                        <h4> Required Loan Amount: <?= $list[0]['amount'];?></h4>
                        <h4> Lenders:></h4>
                    </div>
                    <div class="clearfix"></div>






                    <div class="col-md-10">

                        <div class="table-responsive">
                            <table  class="table table-striped table-bordered" data-page-size="50">

                                <thead>
                                <tr>

                                    <th>Lender Name</th>
                                    <th>Approved Loan Amount</th>
                                    <th>Approved Loan Amount in Percent</th>
                                    <th>Loan Amount</th>
                                    <th>Interest Rate</th>
                                    <th>Tenor Month</th>
                                    <th>Loan Approved Date</th>

                                </tr>
                                </thead>
                                <tbody>

                                <?
                                foreach($list as $row){

                                    ?>
                                    <tr>
                                        <td><?=ucwords($row['lender']);?></td>
                                        <?php
                                       $a_loan_amount =  (($row['approved_loan_amount']*$row['amount'])/100)

                                        ?>

                                        <td><?=ucwords($a_loan_amount);?></td>
                                        <td><?=ucwords($row['approved_loan_amount']);?></td>
                                        <td><?=ucwords($row['amount']);?></td>
                                        <td><?=ucwords($row['interest_rate']);?>%</td>

                                        <td><?=ucwords($row['tenor_months']);?></td>
                                        <td><?=ucwords($row['bid_approved_date']);?></td>
                                    </tr>
                                <? }?>
                                </tbody>
                                <tfoot>

                                </tfoot>
                            </table>
                        </div>

                    </div>

                </div>
                <!-- .left-aside-column-->

            </div>
            <!-- /.left-right-aside-column-->
        </div>
    </div>
</div>
<script type="text/javascript">



    // Get Loan Type Ajax
    function get_loan_info()
    {
        var $selectDropdown =
            $("#loan_purpose")
                .empty()
                .html(' ');
        $selectDropdown.append(
            $("<option></option>")
                .attr("value","")
                .text("Looking for*")
        );

        var loan_type=$('#loan_type').val();
        if(loan_type)
        {
            $.ajax({
                type: "POST",
                url: "<?=base_url();?>bank/get_loan_info/",
                dataType: "html",
                data: "loan_type="+loan_type,
                async: false,
                success: function (data) {
                    window.value=data;
                }
            });

            var dd = (window.value).split(",");
            for (i = 0; i < dd.length; i++) {
                var jj = (dd[i]).split("-");
                console.log();
                $selectDropdown.append(
                    $("<option></option>")
                        .attr("value",jj[0])
                        .text(jj[1])
                );
            }
        }
        $selectDropdown.trigger('contentChanged');
    }


    // Get Credit Card Type Ajax
    $("#loan_purpose").on('change',function ()
    {

        var loan_type=$('#loan_purpose').val();
        if(loan_type)
        {
            if(loan_type=='9')
            {
                $("#card_type_wrapper").show();
            }
            else{
                $("#card_type_wrapper").hide();
            }
        }
        $selectDropdown.trigger('contentChanged');
    });
</script>

<script type="text/javascript">
    // floating / fixed interest selector
    $("#inr_rate_fixed").change(function(){
        var int_type=$("#inr_rate_fixed").val();
        if(int_type==1){
            $("#int_fixed_amount-wrapper").show();
            $("#int_floating-min-wrapper").hide();
            $("#int_floating-max-wrapper").hide();
        }
        else if(int_type==2){
            $("#int_fixed_amount-wrapper").hide();
            $("#int_floating-min-wrapper").show();
            $("#int_floating-max-wrapper").show();
        }
    });

    // processing fee typr selector
    $("#processing_fee_type").change(function(){
        var process_fee_type=$("#processing_fee_type").val();
        if(process_fee_type==1 || process_fee_type==2){
            $("#fixed-processing-wrapper").show();
            $("#min-float-processing-wrapper").hide();
            $("#max-float-processing-wrapper").hide();
        }
        else if(process_fee_type==3 || process_fee_type==4 || process_fee_type==5){
            $("#fixed-processing-wrapper").hide();
            $("#min-float-processing-wrapper").show();
            $("#max-float-processing-wrapper").show();
        }
    });
</script>


<script>
    $(window).load(function() {
        $('li').removeClass('active1');
        $('.adminbidding div').removeClass('collapse');
        $('.admin-bidding-home').addClass('active1');
    });


</script>
<script type="text/javascript">
    // floating / fixed interest selector
    function myFunction(docid)
    {
        $.ajax({
            type: "POST",
            url: "<?=base_url();?>p2padmin/updatedoc",
            dataType: "html",
            data: "doc_id="+docid,
            async: false,
            success: function (data) {
                if(data==1)
                {
                    alert("Verified");
                    window.location.reload();

                }
                else
                {
                    alert("Please Try Again");
                }
            }
        });
    }
</script>


</script>
<script type="text/javascript" src="https://www.antworksmoney.com/assets-admin/floratexteditor/js/jquery.min.js">

</script><script type="text/javascript" src="https://www.antworksmoney.com/assets-admin/floratexteditor/js/codemirror.min.js"></script>

<script type="text/javascript" src="https://www.antworksmoney.com/assets-admin/floratexteditor/js/xml.min.js"></script>

<script type="text/javascript" src="https://www.antworksmoney.com/assets-admin/floratexteditor/js/froala_editor.pkgd.min.js"></script>