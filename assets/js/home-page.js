$(document).ready(
    function (){
        $(".inner-banner,.checkout-section,.service,.container,.sec-pad,footer").click(function(){

            $(".hidden-sidebar").removeClass("collapse in");

        });
    });
    //////borrower

    var connectSlider2 = document.getElementById('interest-calcb');
    var input3 = document.getElementById('interest-range-calcb');
    noUiSlider.create(connectSlider2, {
        start: [10000],
        step: 1000,
        range: {
            'min': [10000],
            'max': [1000000]
        },
        format: wNumb({
            decimals: 0,
        })
    });
    connectSlider2.noUiSlider.on('update', function( value ) {
        input3.value = value;
    });
    $("#interest-range-calcb").change(function () {
        var value = this.value;
        connectSlider2.noUiSlider.set(value);
    });

    var connectSlider5 = document.getElementById('tenor-calcb');
    var input5 = document.getElementById('tenor-range-calcb');
    noUiSlider.create(connectSlider5, {
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
    connectSlider5.noUiSlider.on('update', function( value ) {
        input5.value = value;
    });
    $("#tenor-range-calcb").change(function () {
        var value = this.value;
        connectSlider5.noUiSlider.set(value);
    });

    var connectSlider_emi2 = document.getElementById('emi-calcb');
    var input_emi2 = document.getElementById('slider_emib');
    noUiSlider.create(connectSlider_emi2, {
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
    connectSlider_emi2.noUiSlider.on('update', function( value ) {
        input_emi2.value = value;
    });

    $("#slider_emib").change(function () {
        var value = this.value;
        connectSlider_emi2.noUiSlider.set(value);
    });

    ///////////////////////////////////////////////////////////

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