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
$(document).ready(function(){
    $(".side-fixed-btn").click(function(){
        $("body").addClass('sf-close');
    });
    $(".side-fixed-btn-active").click(function(){
        $("body").removeClass('sf-close');
    });
});
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
        url: baseURL+"bidding/proposal_listing_shortlist/",
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

var elements = document.getElementsByClassName("column");

// Declare a loop variable
var i;

// List View
function listView() {
    for (i = 0; i < elements.length; i++) {
        elements[i].style.width = "100%";
    }
}

// Grid View
function gridView() {
    for (i = 0; i < elements.length; i++) {
        elements[i].style.width = "50%";
    }
}

/* Optional: Add active class to the current button (highlight it) */
var container = document.getElementById("btnContainer");
var btns = container.getElementsByClassName("btn");
for (var i = 0; i < btns.length; i++) {
    btns[i].addEventListener("click", function() {
        var current = document.getElementsByClassName("active");
        current[0].className = current[0].className.replace(" active", "");
        this.className += " active";
    });
}