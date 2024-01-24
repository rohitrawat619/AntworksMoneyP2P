<style>
    .tabl-hd [class*="col-md"] {background: #01548f; color:#fff; border: 1px solid #00477a; padding:10px 10px;}
    .tabl-row [class*="col-md"] {border: 1px solid #e4e7ea; height: 48px; padding:5px 10px; vertical-align:middle;}
</style>

<section class="sec-pad service-box-one service">
    <div class="white-box">
        <div class="col-md-12">
            <div class="col-md-12 col-sm-12 col-xs-12 m-t-30">
                <form method="post" action="<?php echo base_url();?>p2padmin/update_borrower_rating" id="borrower_paramenter">
                    <!-- /.sec-title -->
                    <div class="row tabl-hd">
                        <div class="col-md-1">S. No.</div>
                        <div class="col-md-6">Parameter Name</div>
                        <div class="col-md-3">Parameter Value</div>
                        <div class="col-md-2">Action</div>
                    </div>
                    <?php if($results){$a = 1; foreach($results AS $result){?>
                    <!-- / Toggle row -->
                            <div class="row tabl-row">
                                <div class="col-md-1"><?php echo $a; ?></div>
                                <div class="col-md-6"><?php echo $result['parameter_name']; ?></div>
                                <div class="col-md-3"><input class="form-control" type="text" name="parameter_<?php echo $result['id']; ?>" id="parameter_<?php echo $result['id']; ?>" value="<?php echo $result['parameter_value']; ?>"></div>
                                <div class="col-md-2">
                                    <button type="button" class="btn" onclick="deactivateparameter(this.value)" value="1"><i class="glyphicon glyphicon-ok"></i> </button>
                                    <button type="button" class="btn btn-danger" role="button" data-toggle="collapse" href="#collapseExample_<?php echo $result['id']; ?>" aria-expanded="false" aria-controls="collapseExample_<?php echo $result['id']; ?>"><i class="glyphicon glyphicon-plus"></i></button>
                                </div>
                                <!-- /Toggle Box -->
                                <div class="collapse" id="collapseExample_<?php echo $result['id']; ?>">
                                <?php
                                    $tags_value = $this->P2padminmodel->get_tegs_value($result['id']);
                                    foreach ($tags_value AS $tag){
                                    ?>
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-sm-1"></div>
                                            <div class="col-sm-10">
                                                <div class="col-sm-3">
                                                    <input type="text" name="parameter_tag_1_<?php echo $result['id']; ?>" class="form-control" value="<?php echo $tag['parameter_tag_name'] ?>" disabled>
                                                </div>
                                                <div class="col-sm-3">
                                                    <input type="text" name="parameter_value_1_<?php echo $result['id']; ?>" class="form-control" value="<?php echo $tag['parameter_tag_value'] ?>">
                                                </div>
                                            </div>
                                            <div class="col-sm-1">

                                            </div>
                                        </div>
                                    </div>
                                   <?php }?>
                                </div>
                                <!-- /Toggle Box eeeeeeeeeeeeeeeeee-->
                            </div>
                    <!-- / Toggle row -->
                   <?php $a++; }} ?>
                    <input type="submit" name="submit" value="Submit">
                </form>

    </div>
    </div>
    </div>
    <!-- /.container -->
</section>