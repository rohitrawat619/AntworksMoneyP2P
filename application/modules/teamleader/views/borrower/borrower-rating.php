<div class="mytitle row">
    <div class="left col-md-4">
        <h1><?=$pageTitle;?></h1>
        <?=getNotificationHtml();?>
    </div>
</div>

<div class="white-box">
    <div class="col-md-12">
        <div class="col-md-12 col-sm-12 col-xs-12 m-t-30">

            <div class="table-responsive">
                <form method="post" action="<?php echo base_url();?>p2padmin/update_borrower_rating" id="borrower_paramenter">
                    <table id="example23" class="table table-bordered table-hover table-striped">
                        <thead>
                        <tr>
                            <th>SNO</th>
                            <th>Parameter Name</th>
                            <th>Parameter Value</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if($results){$i = 1; foreach($results AS $result){?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo $result['parameter_name']; ?></td>
                                <td><input class="form-control" type="text" name="parameter_<?php echo $result['id']; ?>" id="parameter_<?php echo $result['id']; ?>" value="<?php echo $result['parameter_value']; ?>"></td>

                                <td>
                                    <?php if($result['status'] == 1){?>
                                        <button type="button" class="btn" onclick="deactivateparameter(this.value)" value="<?php echo $result['id']; ?>"><i class="glyphicon glyphicon-ok"></i> </button>
                                    <?php } else{ ?>
                                        <button type="button" class="btn"><i class="glyphicon glyphicon-remove"></i> </button>
                                    <?php } ?>
                                    <button type="button"><i class="glyphicon glyphicon-edit"></i></button>
                                </td>

                            </tr>
                            <?php $i++; }} else{
                            echo "<tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>Not Found</td>
                    </tr>";
                        }?>

                        </tbody>
                    </table>
                    <div class="col-md-4"><input type="submit" class="form-control btn-primary" name="update" id="update" style="float: right;" value="Update Parameter"></input></div>

                </form>
            </div>
        </div>

    </div>
</div>

<script>
    $("#borrower_paramenter").submit(function () {
        var arrNumber = new Array();
        $('input[type=text]').each(function(){
            arrNumber.push($(this).val());
        })
        var sum_parameter = eval(arrNumber.join("+"));
        alert(sum_parameter);
        if(sum_parameter > 100)
        {
            alert("Sorry you can't update check values exceed maximum value");
            return false;
        }
        if(sum_parameter < 100)
        {
            alert("Sorry you can't update check values are < 100");
            return false;
        }
    })
</script>

<script>
    function deactivateparameter(parameter) {
        if(parameter)
        {
            $.ajax({
                type:"POST",
                url:"<?php echo base_url(); ?>"
            });
        }
    }
</script>
