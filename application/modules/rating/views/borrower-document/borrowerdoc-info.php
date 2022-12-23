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
                        <h2><?php echo $pageTitle; ?></h2>
                    </div>
                    <div class="clearfix"></div>


                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table  class="table table-striped table-bordered" data-page-size="50">
                                    <thead>
                                    <tr>

                                        <th colspan="2">Borrower Personal Detail</th>

                                    </tr>
                                    </thead>
                                    <tbody>

                                    <tr>
                                        <td>Borrower Id</td>

                                        <td><?=ucwords($list['borrower_id']);?></td>
                                    </tr>
                                    <tr>
                                        <td>Borrower Name</td>
                                        <td><?=ucwords($list['Borrowername']);?></td>
                                    </tr>
                                    <tr>
                                        <td>Father  Name</td>
                                        <td><?=ucwords($list['father_name']);?> </td>
                                    </tr>
                                    <tr>
                                        <td>Date Of Birth</td>
                                        <td><?=ucwords($list['dob']);?></td>
                                    </tr>
                                    <tr>
                                        <td>Gender</td>
                                        <td><?php if($list['gender'] == 1){echo "Male";} else{ echo "Female"; }?> </td>
                                    </tr>
                                    <tr>
                                        <td>Marital Status</td>
                                        <td><?if($list['marital_status'] == 1){echo 'Unmarried';}else{echo "Married";}?> </td>
                                    </tr>
                                    <tr>
                                        <td>Qualification</td>
                                        <td><?=ucwords($list['qualification']);?> </td>
                                    </tr>
                                    <tr>
                                        <td>Pan Card</td>
                                        <td><?=ucwords($list['pan']);?> </td>
                                    </tr>
                                    </tbody>
                                    <tfoot>

                                    </tfoot>
                                </table>
                            </div>
                    </div>


                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table  class="table table-striped table-bordered" data-page-size="50">
                                    <thead>
                                    <tr>

                                        <th colspan="2">Borrower Address Detail</th>

                                    </tr>
                                    </thead>
                                    <tbody>

                                    <tr>
                                        <td>Residance</td>

                                        <td><?=ucwords($list['r_address1']);?> <?=ucwords($list['r_address1']);?> <?=ucwords($list['r_city']);?>, <?=ucwords($list['r_state']);?></td>
                                    </tr>
                                    <tr>
                                        <td>Pincode</td>

                                        <td><?=ucwords($list['r_pincode']);?> </td>
                                    </tr>

                                    <tr>
                                        <td>Permanent Residance</td>

                                        <td><?=ucwords($list['r_address1']);?> <?=ucwords($list['r_address1']);?> <?=ucwords($list['r_city']);?>, <?=ucwords($list['r_state']);?></td>
                                    </tr>

                                    </tbody>
                                    <tfoot>

                                    </tfoot>
                                </table>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table  class="table table-striped table-bordered" data-page-size="50">
                                    <thead>
                                    <tr>

                                        <th colspan="2">Borrower Bank Detail</th>

                                    </tr>
                                    </thead>
                                    <tbody>

                                    <tr>
                                        <td>Bank Name</td>

                                        <td><?=ucwords($list['bank_name']);?> </td>
                                    </tr>
                                    <tr>
                                        <td>Branch Name</td>

                                        <td><?=ucwords($list['branch_name']);?> </td>
                                    </tr>

                                    <tr>
                                        <td>Account No.</td>

                                        <td><?=ucwords($list['account_number']);?> </td>
                                    </tr>
                                    <tr>
                                        <td>Ifsc Code</td>

                                        <td><?=ucwords($list['ifsc_code']);?> </td>
                                    </tr>
                                    <tr>
                                        <td>Account Type</td>

                                        <td><?=ucwords($list['account_type']);?> </td>
                                    </tr>
                                    </tbody>
                                    <tfoot>

                                    </tfoot>
                                </table>
                            </div>
                        </div>

                    <form action="<?php echo base_url(); ?>p2padmin/documentverification/add_docs_borrower" method="post" enctype="multipart/form-data">
                        <div class="col-md-12">

                            <div class="table-responsive">
                                <table id="demo-foo-addrow" class="table table-striped table-bordered" data-page-size="100">

                                    <thead>
                                    <tr>

                                        <th>Document Type</th>
                                        <th>Image</th>
                                        <th>Response</th>
                                        <th>Action</th>
                                        <th>Status</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    <?
                                     if($doc){ foreach($doc as $row){

                                        ?>
                                        <tr>
                                            <td><?=ucwords($row['docs_type']);?></td>

                                            <input type="hidden" name="docname" id="docname_" value="<?=$row['id'];?>">
                                            <td><a href="<?=base_url();?>assets/borrower-documents/<?=$row['docs_name']?>" target="_blank"><img src="<?=base_url();?>assets/borrower-documents/<?=$row['docs_name'];?>" height="100px" width="150px"></a></td>
                                            <td></td>
                                            <td><button type="submit" id="verify" style="font-size:14px" onclick="myFunction(<?=$row['id'];?>)"><i class="fa fa-check"  style="font-size:14px;color:green"></i></button>
                                                <?php if($row['verify'] == 0){
                                                    ?>
                                                <button id="uncheck" style="font-size:14px" onclick="myFunction2(<?=$row['id'];?>)"><i class="fa fa-close" style="font-size:14px;color:red"></i></button>

                                                <?php
                                                }
                                               ?>
                                                <div id="comment<?=$row['id'];?>" style="display: none;">
                                                    <br>

                                                <lable>Comments</lable>
                                                    <br>

                                                    <textarea  class="form-control" name="v_comment" id="v_comment<?=$row['id'];?>" rows="2" cols="30" ></textarea>

                                                    <button type="submit" id="submit_comment" class="btn btn-primary" onclick="updatecomment('<?=$row['id'];?>','<?=$list['borrower_email'];?>')">Submit</button>


                                                </div>
                                            </td>

                                            <?php
                                            if($row['verify'] == 0)
                                            {
                                            ?>
                                                <td>Unverified<br><?=ucwords($row['comment']);?></td>
                                            <?php
                                            }
                                            else if($row['verify'] == 1) {
                                                ?>
                                                <td>Verified</td>
                                                <?php
                                            }
                                            ?>
                                        </tr>
                                        <? }}?>
                                    </tbody>
                                    <tfoot>

                                    </tfoot>
                                </table>

                            </div>
                            <div class="col-md-6 col-sm-4 upload-mfile">
                                <div class="form-group">
                                    <label class="col-md-12">&nbsp;</label>
                                    <div class="col-md-12"><a href="javascript:" class="upload-mfile-btn"><i class="fa fa-plus"></i> Upload more files</a></div>
                                </div>
                            </div>

                        </div>
                        <div class="col-md-6 col-sm-4">
                            <div class="form-group">
                                <input type="hidden" name="borrower_id" value="<?php echo $list['borrower_id']; ?>">
                                <div class="col-md-12"><input type="submit" name="submit" value="submit"></div>
                            </div>
                        </div>

                </div>
                    </form>
                </div>
                <!-- .left-aside-column-->

            </div>
            <!-- /.left-right-aside-column-->
        </div>
    </div>
</div>
<script type="text/javascript">
    function myFunction(docid)
    {
        $.ajax({
            type: "POST",
            url: "<?=base_url();?>p2padmin/documentverification/updatedoc",
            dataType: "html",
            data: "doc_id="+docid,
            async: false,
            success: function (data) {
                var response = JSON.parse(data);
                if(response['status'] == 1)
                {
                    alert(response['response']);
                    window.location.reload();

                }
                else
                {
                    alert(response['response']);
                }
            }
        });
    }
</script>
<script type="text/javascript">

    function myFunction2(docid)
    {
        $('#comment'+docid).show();
    }

</script>
<script type="text/javascript">
    function updatecomment(docid,email)
    {

        var comment =  $('#v_comment'+docid).val();
        $.ajax({
            type: "POST",
            url: "<?=base_url();?>p2padmin/documentverification/updatecomment",
            dataType: "html",
            data: "doc_id="+docid +"&comment="+comment+"&email="+email,
            async: false,
            success: function (data) {
                var response = JSON.parse(data);
                if(response['status'] == 1)
                {
                    alert(response['response']);
                    window.location.reload();

                }
                else
                {
                    alert(response['response']);
                }
            }
        });
    }
</script>
<script>
    $(document).ready(function() {
        var i=0;
        $(".upload-mfile-btn").click(function() {
            i=i+1;
            var domElement = $('<div class="col-md-6 col-sm-4"><div class="form-group"><input class="form-control" type="text" name="doc_name[]" placeholder="Enter Document Name"/><br><input class="form-control" type="file" name="doc_file[]"/></div></div></div>');
            $('.upload-mfile').before(domElement);
        });



    });
</script>