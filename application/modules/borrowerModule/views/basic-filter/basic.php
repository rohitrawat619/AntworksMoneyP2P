<div class="row">
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
                        <form method="post" id="download_report" action="<?=base_url('p2padmin/basicfilter/filter_report/');?>">
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
                    <table id="demo-foo-addrow" class="table m-t-30 table-hover contact-list " data-page-size="100">
                        <thead>
                        <tr>
                            <th>Basic filtration criteria</th>
                            <th>Total Visitor</th>
                            <th>Count of Pass(After particular filtration criteria)</th>
                            <th>Count of Stop/Decline(After particular filtration criteria)</th>
                        </tr>
                        </thead>

                        <tbody id="">

                        </tbody>
                        <tbody id="">
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
                        </tbody>
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
