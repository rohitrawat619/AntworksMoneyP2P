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
                    </div>
                    <div class="clearfix"></div>
                    <div class="scrollable">
                        <div class="table-responsive">
                            <table id="demo-foo-addrow" class="table m-t-30 table-hover contact-list" data-page-size="100">
                                <thead>
                                </thead>
                                <tbody>
                                <?php echo '<iframe src = "'.base_url().'management/view_disbursement_cases?proposal_id='.$_GET['proposal_id'].'" width = "900" height = "500">
                              Sorry your browser does not support inline frames.
                            </iframe>'; ?>
                                <div style="text-align: center;">
                                <form action="<?php echo base_url(); ?>management/loan_aggrement" method="post">
                                    <input type="hidden" value="<?php echo $_GET['proposal_id'];  ?>" name="proposal_id" id="proposal_id">
                                    <input type="submit" name="approved_loan" id="approved_loan" value="Approved" class="btn btn-primary">
                                </form>
                                </div>
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