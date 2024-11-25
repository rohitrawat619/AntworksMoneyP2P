<?=getNotificationHtml();?>
<div class="col-lg-12 col-sm-6 row-in-br  b-r-none">
    <div class="col-in row">
        <div class="col-md-12">
            <form action="<?php echo base_url() ?>p2padmin/loanmanagement/uploadStatement" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <div class="col-md-4">
                        <input type="file" name="responseLoanEmi" id="responseLoanEmi" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-4">
                        <a href="<?php echo base_url(); ?>assets-admin/samplefile/AntworksPNBSAMPLE.csv"><input type="button" class="form-control" value="Download Sample File"> </a>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-4">
                        <input type="submit" name="submit_responseLoanEmi" id="submit_responseLoanEmi" value="Upload Statement" class="form-control">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>