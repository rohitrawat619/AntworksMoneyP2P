$(document).ready(
    function (){
        $(".inner-banner,.checkout-section,.service,.container,.sec-pad,footer").click(function(){

            $(".hidden-sidebar").removeClass("collapse in");

        });
    });
    ///////////////////////////////////////////////////////////////////Lender
    var connectSlider = document.getElementById('max_loan_preference-slider');
    var input1 = document.getElementById('max_loan_preference');
    noUiSlider.create(connectSlider, {
        start: [10000],
        step: 1000,
        range: {
            'min': [10000],
            'max': [5000000]
        },
        format: wNumb({
            decimals: 0,
        })
    });
    connectSlider.noUiSlider.on('update', function( value ) {
        input1.value = value;
    });
    $("#max_loan_preference").change(function () {
        var value = this.value;
        connectSlider.noUiSlider.set(value);
    });

    var connectSlider1 = document.getElementById('max_tenor-slider');
    var input2 = document.getElementById('max_tenor');
    noUiSlider.create(connectSlider1, {
        start: 6,
        step: 6,
        connect: [true, false],
        range: {
            'min': 6,
            'max': 36
        },
        format: wNumb({
            decimals: 0,
        })
    });
    connectSlider1.noUiSlider.on('update', function( value ) {
        input2.value = value;
    });
    $("#max_tenor").change(function () {
        var value = this.value;
        connectSlider1.noUiSlider.set(value);
    });

    var connectSlider_emi = document.getElementById('max_interest_rate-slider');
    var input_emi = document.getElementById('max_interest_rate');
    noUiSlider.create(connectSlider_emi, {
        start: 12,
        step: 1,
        connect: [true, false],
        range: {
            'min': 12,
            'max': 24
        },
        format: wNumb({
            decimals: 0,
        })
    });
    connectSlider_emi.noUiSlider.on('update', function( value ) {
        input_emi.value = value;
    });

    $("#max_interest_rate").change(function () {
        var value = this.value;
        connectSlider_emi.noUiSlider.set(value);
    });

    $(".top-login-btn-try").click(function(){
        $(".top-login-panels").animate({top:'0px'});
        $("body").css("overflow", "hidden");
    });

    $(document).ready(function() {
    var owl = $('.owl-carousel');
    owl.owlCarousel({
        items: 3,
        loop: true,
        margin: 10,
        autoplay: true,
        autoplayTimeout: 1000,
        pagination: false,
        dots: false,
        autoplayHoverPause: true,
        responsiveClass: true,
        responsive: {
            0:{
                items:1,
            },
            600:{
                items:2,
            },
            1000:{
                items:3,
            }
        }
    });
    $('.play').on('click', function() {
        owl.trigger('play.owl.autoplay', [1000])
    })
    $('.stop').on('click', function() {
        owl.trigger('stop.owl.autoplay')
    })
});

    $('#owl-demo').owlCarousel({
    loop:true,
    margin:10,
    autoplay: true,
    autoplayTimeout: 1000,
    autoplayHoverPause: true,
    responsiveClass:true,
    responsive:{
        0:{
            items:2,
        },
        600:{
            items:3,
        },
        1000:{
            items:5,
        }
    }
});

