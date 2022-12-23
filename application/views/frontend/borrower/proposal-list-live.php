<?php error_reporting(0); ?>
<link href="<?=base_url();?>assets/css/proposal-list.css" rel="stylesheet">
	<div class="container">
	  <div class="white-box">
		<ul class="proposal-listing myproposal-listing">

            <?php foreach($proposal_list AS $proposal) {?>
             <li>
                <div class="box">
                    <div class="title">
                        <div class="name"><?php echo $proposal['name']?>
                            <ul class="prs-n-dtls">
                                <li><?php echo $proposal['age'] ?></li>
                                <li><?php if($proposal['gender'] == 1){echo "Male";} if($proposal['gender'] == 2){echo "Female";}?></li>
                                <li><?php echo $proposal['r_city']; ?></li>
                            </ul>
                        </div>
                        <?php
                        $experian = $this->Biddingmodel->getExperainscoere($proposal['borrower_id']);
                        $userrating = $this->Biddingmodel->getUserrating($proposal['borrower_id']);
                        ?>
                        <div class="cscore">Credit Score
                            <span><?php echo $experian['experian_score'] ?></span>
                        </div>
                        <div class="lefttime">
                            <p>Time Left :
                                <span><?php echo $proposal['time_left'];?> Days</span>
                            </p>
                        </div>
                        <div class="count">
                            <i class="fa fa-question-circle rateinfo" data-container="body" data-toggle="popover" data-placement="top" data-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus." data-original-title="" title=""></i>
                            <span>Antworks Rating</span>(<?php echo round($userrating, 1, PHP_ROUND_HALF_UP) ?>/10)
                        </div>
                    </div>
                    <div class="purpose-loan"><span>Purpose:</span><?php echo $proposal['loan_description'] ?></div>
                    <div class="loan">
                        <div class="amount">
                            <span>Loan Required</span>Rs. <?php echo $proposal['loan_amount'] ?>
                        </div>
                        <div class="amount fund-grph">
                            <span class="pie" data-peity="{ &quot;fill&quot;: [&quot;#99d683&quot;, &quot;#f2f2f2&quot;]}" style="display: none;"><?php echo $proposal['total_bid_amount']; ?>,<?php echo $proposal['loan_amount'] - $proposal['total_bid_amount'] ?></span>
                            <p><?php echo ($proposal['total_bid_amount']*100)/ $proposal['loan_amount']; ?> % Funded
                                <br>
                                <i class="fa fa-inr" aria-hidden="true"></i> <?php echo $proposal['loan_amount'] - $proposal['total_bid_amount'] ?> Needed
                            </p>
                        </div>
                        <a data-toggle="modal" class="forbidnow" data-target="#submit_bids<?=$proposal['proposal_id'];?>">
                            <span class="btn btn-block btn-outline btn-success">Bid Now</span>
                        </a>
                    </div>
                    <div class="desc">
                        <ul>
                            <li>
                                <b>Borrower Interest Prefrence (%)</b> - <?php echo $proposal['min_interest_rate'] ?> %
                            </li>
                            <li>
                                <b>Recommended Interest (%)</b> - <?php echo $proposal['prefered_interest_min'] ?>-<?php echo $proposal['prefered_interest_max'] ?> %
                            </li>
                            <li>
                                <b>Tenor</b> - <?php echo $proposal['tenor_months'] ?> months
                            </li>
                            <!--li><b>Purpose</b> - Appliance Purchase</li-->
                            <li>
                                <b>Monthly Income</b> -<?php echo $proposal['occuption_details']['net_monthly_income'] ?>
                            </li>
                            <li>
                                <b>Current EMI's</b> - <?php echo $proposal['occuption_details']['current_emis'] ?>
                            </li>
                        </ul>
                    </div>
                    <div class="actions">
                        <ul>
                            <li>
                                <a data-toggle="modal" class="express" data-target="#submit_bids<?=$proposal['proposal_id'];?>">
                                    <span class="btn btn-block btn-outline btn-success" style="color: #fff">Bids</span>
                                </a>
                            </li>
                            <div class="modal fade" id="submit_bids<?=$proposal['proposal_id'];?>" style="display: none;">

                            </div>
                            <li>
                                <a class="info-bidding" data-toggle="modal" data-target="#get_more_info<?=$proposal['proposal_id'];?>">
									<span class="btn btn-block btn-outline btn-primary">
										<i class="fa fa-exclamation"></i>
									</span>
                                </a>
                            </li>
                            <div class="modal fade" id="get_more_info<?=$proposal['proposal_id'];?>">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                            <h4 class="modal-title" id="exampleModalLabel1">Description</h4>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <?php echo $proposal['loan_description'] ?>
                                             </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </ul>
                        <a href="<?php echo base_url();?>login/user-login" class="btn btn-details btn-success">Details</a>
                    </div>
                </div>
            </li>
            <?} ?>


		</ul>
	</div>
  </div>

<script>
$(document).ready(function(){
    if ($(window).width() < 1150) {
        $("body").addClass('sf-close');
    } else { 
		$("body").removeClass('sf-close');
	}
});
$(window).resize(function () {
        if ($(window).width() < 1150) {
            $("body").addClass('sf-close');
        } else { 
		$("body").removeClass('sf-close');
	}
});
</script>
<script>
$(document).ready(function(){
    $(".side-fixed-btn").click(function(){
        $("body").addClass('sf-close');
        //$(".side-fixed").css("width", "0px");
		//$(".side-fluid").css("margin-left", "25px");
		//$(".side-fixed-btn-active").css("margin-left", "7px");
		//$(this).css("margin-left", "7px");
		//$(this).hide();
		//$(".side-fixed-btn-active").show();
    });
	$(".side-fixed-btn-active").click(function(){
        $("body").removeClass('sf-close');
		//$(".side-fixed").css("width", "340px");
		//$(".side-fluid").css("margin-left", "340px");
		//$(".side-fixed-btn").css("margin-left", "330px");
		//$(this).css("margin-left", "330px");
		//$(this).hide();
		//$(".side-fixed-btn").show();
    });
});
</script>
<script>
$(window).load(function() {
	$('li').removeClass('active1');
	$('.bidding div').removeClass('collapse');
	$('.proposal-list').addClass('sidebarmenu-active');
	$('.bidding').addClass('sidebarmenu-panel-active');
});

function submit_form(ii,sid)
{
	$.ajax({
	type:"POST",
	url: "<?=base_url();?>bidding/proposal_listing_shortlist/",
	data:"sid="+sid,
	success: function(result){
		$("#short-ajax-id"+ii).html('<button class="btn btn-block btn-primary">Shortlisted</button>');
	}});
}

function total_amount(ii,amt)
{
	var amt_per = $("#loan_amount"+ii).val();
	var total_pay = (amt*amt_per/100);
	
	$("#amt-rs"+ii).html("Amount = "+total_pay+"in Lacs");
	$("#amt-rs"+ii).show();
}
</script>

<script>
	$(document).ready(function(){
		$("#loan_amount").keydown(function (e) {
			// Allow: backspace, delete, tab, escape, enter and .
			if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
					// Allow: Ctrl+A, Command+A
				(e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) ||
					// Allow: home, end, left, right, down, up
				(e.keyCode >= 35 && e.keyCode <= 40)) {
				// let it happen, don't do anything
				return;
			}
			// Ensure that it is a number and stop the keypress
			if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
				e.preventDefault();
			}
		});
		$("#proposel-submit-data").submit(function(){
          var remainingAmount = '<?php echo $remaining_amount;  ?>';
          var loan_amount = $("#loan_amount").val();
			if(loan_amount == "")
			{
				$("#error_amount_max").html('<p style="color: red">* Required</p>');
				return false;
			}
			if(loan_amount > 50000)
			{
				$("#error_amount_max").html('<p style="color: red">Loaning Amount : Maximum 50000</p>');
				return false;
			}


			else{
				return true;
			}
		});

	});
</script>
<script src="https://www.jqueryscript.net/demo/Pie-Donut-Chart-SVG-jChart/src/js/jchart.js?v3"></script>
<script>
    let jchart1;
    $(function () {
        jchart1 = $("#element3").jChart({
            data: [
                {
                    value: 150,
                    color: {
                        normal: '#607eac',
                        active: '#333',
                    },
                },
                {
                    value: 10,
                    color: {
                        normal: '#ff9e16',
                        active: '#333',
                    },
                },
                {
                    value: 20,
                    color: {
                        normal: '#fdc634',
                        active: '#333',
                    },
                },
                {
                    value: 30,
                    color: {
                        normal: '#f7e62d',
                        active: '#333',
                    },
                },
                {
                    value: 60,
                    color: {
                        normal: '#90db24',
                        active: '#333',
                    },
                },
                {
                    value: 90,
                    color: {
                        normal: '#74b23e',
                        active: '#333',
                    },
                },

                {
                    value: 200,
                    color: {
                        normal: '#77cbe0',
                        active: '#333',
                    },
                    draw: true, //false
                    push: true, //false
                },
            ],
            appearance: {
                type: 'pie',
                baseColor: '#ddd',
            }

        });

    });
</script>