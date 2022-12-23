
        <section class="content-header">
            <h1>
                <?php echo $pageTitle; ?>
            </h1>
			 <?= getNotificationHtml(); ?> 
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-md-6">
                    <!-- AREA CHART -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Area Chart</h3>

                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="chart">
                                <canvas id="areaChart" style="height:250px"></canvas>
                            </div>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->

                    <!-- DONUT CHART -->
                    <div class="box box-danger">
                        <div class="box-header with-border">
                            <h3 class="box-title">Donut Chart</h3>

                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                            </div>
                        </div>
                        <div class="box-body">
                            <canvas id="pieChart" style="height:250px"></canvas>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->

                </div>
                <!-- /.col (LEFT) -->
                <div class="col-md-6">
                    <!-- LINE CHART -->
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">Line Chart</h3>

                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="chart">
                                <canvas id="lineChart" style="height:250px"></canvas>
                            </div>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->

                    <!-- BAR CHART -->
                    <div class="box box-success">
                        <div class="box-header with-border">
                            <h3 class="box-title">Bar Chart</h3>

                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="chart">
                                <canvas id="barChart" style="height:230px"></canvas>
                            </div>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->

                </div>
                <!-- /.col (RIGHT) -->
            </div>
            <!-- /.row -->

        </section>
        <!-- /.content -->

        <section>
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-4">
                        <div class="box-body">
                            <h3>Submit Crm file</h3>
                            <form class="form-inline" action="<?php echo base_url(); ?>p2padmin/uploadBorrower" method="post" enctype="multipart/form-data">
                                <div class="form-group"><input class="form-control" type="file" name="shreeramResponsefile"></div>
                                <div class="form-group"><input type="submit" name="submitshreeramfile" class="btn btn-primary"></div>
                            </form>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-inline">
                            <div class="box-body">
                                <h3>Lead Closed</h3>
                                <form action="<?php echo base_url(); ?>p2padmin/leadclosed" method="post" enctype="multipart/form-data">
                                    <div class="form-group"><input type="text" class="form-control" name="mobile" placeholder="Enter mobile"></div>
                                    <div class="form-group"><input type="submit" name="submit" class="btn btn-primary"></div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-inline">
                            <div class="box-body">
                                <h3>Lead Reassign</h3>
                                <form action="<?php echo base_url(); ?>p2padmin/leadcreassign" method="post" enctype="multipart/form-data">
                                    <div class="form-group"><input class="form-control" type="text" name="mobile" placeholder="Enter mobile"></div>
                                    <div class="form-group"><input type="submit" name="submit" class="btn btn-primary"></div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

