    <div class="col-md-12">
        <section class="mytitle">
            <h1>
                <?php echo $pageTitle; ?>
            </h1>
            <!--ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            </ol-->
        </section>

        <!-- Main content -->
        <section class="white-box">
            <div class="row">
                <div class="col-md-3">
                    <!-- AREA CHART -->
                    <div class="analytics-info">
                        <h3 class="box-title">Due in 7 Days</h3><hr></hr>
                        <font color="red">             
                         <?=  $week ; ?> 
                         </font>                
                    </div>
               </div>
             
                <div class="col-md-3">
               
                    <div class="analytics-info">
                        <h3 class="box-title">Due in 15 Days</h3><hr></hr>
                        <font color="red">
                        <?=  $twoweek ; ?>  
                         </font>   
                    </div>
                 </div>  
                 <div class="col-md-3">
               
                    <div class="analytics-info">
                        <h3 class="box-title">Total Due</h3><hr></hr>
                        <font color="red"> 
                        <?=  $list; ?>
                         </font>       
                    </div>
                 </div> 
                 <div class="col-md-3">
               
                    <div class="analytics-info">
                        <h3 class="box-title">Missed/Bounced Payments</h3><hr></hr>
                        <font color="red"> 
                        
                         <?=  $bounced; ?> 
                          </font>     
                    </div>
                 </div>      
            </div> 
        </section>

  </div>
