
  
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="<?=base_url('/dist/img/user2-160x160.jpg')?>" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>Alexander Pierce</p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- search form -->
      <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
          <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat">
                  <i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form>
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        
      
        <li><a href="index2.html"><i class="fa fa-dashboard"></i> <span>Dashboard 1</span></a></li>

      
        <li><a href="index3.html"><i class="fa fa-book"></i> <span>Dashboard 2 </span></a></li>
   
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dashboard
        <small>Version 2.0</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Info boxes -->
      
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">All Vendors</h3>

              <div class="box-tools">
                <div class="input-group input-group-sm" style="width: 150px;">
                  <input type="text" name="table_search" class="form-control pull-right" placeholder="Search">

                  <div class="input-group-btn">
                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                  </div>
                </div>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                <tr>
                  <th>Vendor Name</th>
                  <th>Vendor </th>
                  <th>Date</th>
                  <th>Status</th>
                  <th>Reason</th>
                </tr>
                <?php   
                 if(isset($data['0']['Company_Name']))
                {
                   foreach($data as $row){ ?>      
                    <tr>
                  <td>183</td>
                  <td>John Doe</td>
                  <td>11-7-2014</td>
                  <td><span class="label label-success">Approved</span></td>
                  <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
                </tr>
                    <?php }}
        else { echo "Sorry There are no Vendors yet!"; } ?>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
      
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 2.4.0
    </div>
    <strong>Copyright &copy; 2020-2023 <a href="https://adminlte.io">Star Developer</a>.</strong> All rights
    reserved.
  </footer>

  <!-- Control Sidebar -->

  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>

</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<!-- <script src="bower_components/jquery/dist/jquery.min.js"></script> -->
<script src="<?=base_url('/bower_components/jquery/dist/jquery.min.js')?>"></script>

<!-- Bootstrap 3.3.7 -->
<!-- <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script> -->

<script src="<?=base_url('/bower_components/bootstrap/dist/js/bootstrap.min.js')?>"></script>
<!-- FastClick -->
<script src="<?=base_url('/bower_components/fastclick/lib/fastclick.js')?>"></script>
<!-- <script src="bower_components/fastclick/lib/fastclick.js"></script> -->
<!-- AdminLTE App -->
<script src="<?=base_url('/dist/js/adminlte.min.js')?>"></script>
<!-- <script src="dist/js/adminlte.min.js"></script> -->
<!-- Sparkline -->
<script src="<?=base_url('/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js')?>"></script>
<!-- <script src="bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script> -->
<!-- jvectormap  -->
<script src="<?=base_url('/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js')?>"></script>
<script src="<?=base_url('/plugins/jvectormap/jquery-jvectormap-world-mill-en.js')?>"></script>
<!-- <script src="plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script> -->
<!-- <script src="plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script> -->
<!-- SlimScroll -->
<script src="<?=base_url('/bower_components/jquery-slimscroll/jquery.slimscroll.min.js')?>"></script>
<!-- <script src="bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script> -->
<!-- ChartJS -->
<script src="<?=base_url('/bower_components/chart.js/Chart.js')?>"></script>
<!-- <script src="bower_components/chart.js/Chart.js"></script> -->
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="<?=base_url('/dist/js/pages/dashboard2.js')?>"></script>
<!-- <script src="dist/js/pages/dashboard2.js"></script> -->
<!-- AdminLTE for demo purposes -->
<script src="<?=base_url('/dist/js/demo.js')?>"></script>
<!-- <script src="dist/js/demo.js"></script> -->
</body>
</html>