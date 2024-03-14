<?= getNotificationHtml(); ?>

<section class="content-header">
    <h1>
        <?php echo $pageTitle; ?>
    </h1>
    <ol class="breadcrumb">
        <li class="active">Change Password</li>
    </ol>
</section>
<section class="content">

    <!-- Default box -->
    <div class="box">
        <div class="row">
            <form method="post" action="<?=base_url('p2padmin/changepassword/action_change_password')?>">
            <div class="col-md-6 form-group">
                <level>Old Password</level>
                <input type="password" required name="old_password" class="form-control">
            </div>
            <div class="col-md-6 form-group">
                <level>Password</level>
                <input type="password" name="password" required class="form-control">
            </div>
            <div class="col-md-6 form-group">
                <level>Confirm Password</level>
                <input type="password" name="c_password" required class="form-control">
            </div>
            <div class="col-md-6 form-group">

            </div>
            <div class="col-md-6 form-group">
                <input type="submit" name="change_password" value="Change Password" class="btn btn-primary">
            </div>
            </form>
        </div>
    </div>
</section>
