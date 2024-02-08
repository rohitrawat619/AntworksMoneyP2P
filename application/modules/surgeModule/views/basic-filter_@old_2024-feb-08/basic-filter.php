<section class="content-header">
    <h1>
        <?php echo $pageTitle; ?>
    </h1>
    <ol class="breadcrumb">
        <li class="active">Basic Filter</li>
    </ol>
</section>
<section class="content">

    <!-- Default box -->
    <div class="box">
        <div class="box-header with-border">
            <?= getNotificationHtml(); ?>
        </div>

        <div class="box-body">
            <div class="row">
                <form method="post" action="<?= base_url('p2padmin/basicfilter/action') ?>"
                      enctype="multipart/form-data">
                    <div class="col-md-6 form-group">
                        <level>Minimum AGE</level>
                        <input type="text" required name="min_age" id="min_age" value="<?php if ($rule['min_age']) {
                            echo $rule['min_age'];
                        } ?>" class="form-control">
                    </div>
                    <div class="col-md-6 form-group">
                        <level>Maximum AGE</level>
                        <input type="text" required name="max_age" id="max_age" value="<?php if ($rule['max_age']) {
                            echo $rule['max_age'];
                        } ?>" class="form-control">
                    </div>
                    <div class="col-md-6 form-group">
                        <level>Salary Less than</level>
                        <input type="text" name="salary_less_than" value="<?php if ($rule['salary_less_than']) {
                            echo $rule['salary_less_than'];
                        } ?>" class="form-control" required>
                    </div>
                    <div class="col-md-6 form-group">
                        <level>Minimum Experian Score Less Than</level>
                        <input type="text" name="credit_score" value="<?php if ($rule['credit_score']) {
                            echo $rule['credit_score'];
                        } ?>" class="form-control" required>
                    </div>
                    <div class="col-md-6 form-group">
                        <level>Qualification You want Allow</level>

                            <?php $q = array();
                            if ($rule['qualification']) {
                                $q = explode(',', $rule['qualification']);
                            }
                            foreach ($qualification_list as $q_list) {

                                ?>
                                <input type="checkbox" name="qualification[]" value="<?= $q_list['qualification'] ?>" <?php if (in_array($q_list['qualification'], $q)) {
                                    echo "checked";
                                } ?>> <?= $q_list['qualification'] ?>
                            <?php } ?>
                    </div>
                    <div class="col-md-6 form-group">
                        <level>Occupation You want allow</level>
                            <?php
                            $o = array();
                            if ($rule['occupation']) {
                                $o = explode(',', $rule['occupation']);
                            }
                            foreach ($occupation_list as $o_list) { ?>
                                <input type="checkbox" name="occupation[]" value="<?= $o_list['name'] ?>" <?php if (in_array($o_list['name'], $o)) {
                                    echo "checked";
                                } ?>> <?= $o_list['name'] ?>
                            <?php } ?>
                    </div>
                    <div class="col-md-6 form-group">
                        <level>CAT LIST</level>
                        <a href="<?= base_url('sample-files/p2p_list_company.csv') ?>">Download Sample CAT List
                            File.</a> &nbsp;
                        <a href="<?=base_url('p2padmin/basicfilter/company_list')?>" target="_blank">View CAT List ?</a>
                        <input type="file" name="cat_list" class="form-control">

                        <?php
                        $c = array();
                        if ($rule['company_category']) {
                            $c = explode(',', $rule['company_category']);
                        }
                        foreach ($company_category_list as $c_list) { ?>
                            <input type="checkbox" name="company_category[]" value="<?= $c_list['company_category'] ?>" <?php if (in_array($c_list['company_category'], $c)) {
                                echo "checked";
                            } ?>> <?= $c_list['company_category'] ?>
                        <?php } ?>
                    </div>
                    <div class="col-md-6 form-group">
                        <level>Negative Pincode</level>
                        <a href="<?= base_url('sample-files/negative_pincode_list.csv') ?>"> Download Sample File
                            Pincode. </a> &nbsp;
                        <a href="<?=base_url('p2padmin/basicfilter/negative_pincode_list')?>" target="_blank"> View Pincode </a>
                        <input type="file" name="negative_pincode" class="form-control">
                    </div>
                    <!--<div class="col-md-6 form-group">
                        <level>Pan not Validate with filled details</level>
                        <span><input type="radio" name="pan_validate_with_filled_details" value="Yes"
                                     class="" <?/* if ($rule['pan_validate_with_filled_details'] == 'Yes') {
                                echo "checked";
                            } */?> required> Yes</span>
                        <span><input type="radio" name="pan_validate_with_filled_details"
                                     value="No" <?/* if ($rule['pan_validate_with_filled_details'] == 'No') {
                                echo "checked";
                            } */?>>NO</span>
                    </div>-->
                    <div class="col-md-6 form-group">
                        <input type="submit" name="submit" class="form-control">
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
