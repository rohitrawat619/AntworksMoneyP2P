<style type="text/css">
    .navi {
        width: 500px;
        margin: 5px;
        padding:2px 5px;
        border:1px solid #eee;
    }

    .show {
        color: blue;
        margin: 5px 0;
        padding: 3px 5px;
        cursor: pointer;
        font: 15px/19px Arial,Helvetica,sans-serif;
    }
    .show a {
        text-decoration: none;
    }
    .show:hover {
        text-decoration: underline;
    }


    ul.setPaginate li.setPage{
        padding:15px 10px;
        font-size:14px;
    }

    ul.setPaginate{
        margin:0px;
        padding:0px;
        height:100%;
        overflow:hidden;
        font:12px 'Tahoma';
        list-style-type:none;
    }

    ul.setPaginate li.dot{padding: 3px 0;}

    ul.setPaginate li{
        float:left;
        margin:0px;
        padding:0px;
        margin-left:5px;
    }



    ul.setPaginate li a
    {
        background: none repeat scroll 0 0 #ffffff;
        border: 1px solid #cccccc;
        color: #999999;
        display: inline-block;
        font: 15px/25px Arial,Helvetica,sans-serif;
        margin: 5px 3px 0 0;
        padding: 0 5px;
        text-align: center;
        text-decoration: none;
    }

    ul.setPaginate li a:hover,
    ul.setPaginate li a.current_page
    {
        background: none repeat scroll 0 0 #0d92e1;
        border: 1px solid #000000;
        color: #ffffff;
        text-decoration: none;
    }

    ul.setPaginate li a{
        color:black;
        display:block;
        text-decoration:none;
        padding:5px 8px;
        text-decoration: none;
    }

</style>
<?=getNotificationHtml();?>
<div class="row">
    <div class="col-md-12">
        <div class="white-box p-0">
            <!-- .left-right-aside-column-->
            <div class="page-aside">
                <!-- .left-aside-column-->
                <!-- /.left-aside-column-->
                <div class="">
                    <div class="right-page-header">
                        <div class="pull-right">
                            <input type="text" id="demo-input-search2" placeholder="search users" class="form-control">
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="scrollable">
                        <div class="table-responsive">
                            <table id="demo-foo-addrow" class="table m-t-30 table-hover contact-list" data-page-size="100">
                                <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Borrower Name</th>
                                    <th>Lender Name</th>
                                    <th>Loan Amount</th>
                                    <th>Approved Loan Amount in % </th>
                                    <th>Interest Rate %</th>
                                    <th>Tenor</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <? 	if($list){
                                    $i=1;
                                    foreach($list as $row){

                                        ?>
                                        <tr>
                                            <td><?=$i;?></td>
                                            <td> <?=$row['BORROWERNAME'];?></a></td>
                                            <td><?=$row['LENDER_fNAME'];?></td>
                                            <td><?=$row['LOANAMOUNT'];?></td>
                                            <td><?=$row['APPROVERD_LOAN_AMOUNT'];?></td>
                                            <td><?=$row['LOAN_Interest_rate'];?></td>
                                            <td><?=$row['TENORMONTHS'];?></td>
                                            <td><a href="<?=base_url();?>management/view_repayment?proposal_id=<?=$row['PROPOSALID'];?>"><button type="submit" class="btn btn-sm btn-icon btn-pure btn-outline">View</button></a></td>
                                        </tr>
                                        <? $i++;}}else
                                {?>
                                    <tr>
                                        <td colspan="9">No Records Found!</td>
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

<script>
    $(window).load(function() {
        $('li').removeClass('active1');
        $('.user div').removeClass('collapse');
        $('.list-users').addClass('active1');
    });
</script>