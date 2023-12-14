// JavaScript Document

$(function() {
        $( "#slider-range" ).slider({
            range: true,
			step:1,
            min: 0,
            max: 1000000,
            values: [ 0, 1000000 ],
            slide: function( event, ui ) {
                
                var offset1 = $(this).children('.ui-slider-handle').first().offset();
                var offset2 = $(this).children('.ui-slider-handle').last().offset();
                $(".tooltip1").css('top',offset1.top).css('left',offset1.left).show();
   $(".tooltip2").css('top',offset2.top).css('left',offset2.left).show();
                         
                
                $('#min').val(ui.values[ 0 ]);
                $('#max').val(ui.values[ 1 ]);
                
            },
            stop:function(event,ui){
                $(".tooltip").hide();
            }
        });
    
    $('#min').change(function(){
        $( "#slider-range" ).slider( "values", 0, $('#min').val()  );
    });
    $('#max').change(function(){
        $( "#slider-range" ).slider( "values", 1, $('#max').val()  );
    });
        
    });
	
	
	$(function() {
        $( "#slider-range2" ).slider({
            range: true,
			step:1,
            min: 12,
            max: 36,
            values: [ 12, 36 ],
            slide: function( event, ui ) {
                
                var offset1 = $(this).children('.ui-slider-handle').first().offset();
                var offset2 = $(this).children('.ui-slider-handle').last().offset();
                $(".tooltip1").css('top',offset1.top).css('left',offset1.left).show();
   $(".tooltip2").css('top',offset2.top).css('left',offset2.left).show();
                         
                
                $('#min2').val(ui.values[ 0 ]);
                $('#max2').val(ui.values[ 1 ]);
                
            },
            stop:function(event,ui){
                $(".tooltip").hide();
            }
        });
    
    $('#min2').change(function(){
        $( "#slider-range2" ).slider( "values", 0, $('#min2').val()  );
    });
    $('#max2').change(function(){
        $( "#slider-range2" ).slider( "values", 1, $('#max2').val()  );
    });
        
    });
	
	$(function() {
        $( "#loan-slider" ).slider({
            range: "max",
			step:10000,
            min: 100000,
            max: 20000000,
            value: 100000,
            slide: function( event, ui ) {
                $('#loan').val(ui.value);                
            }
        });
    
		$('#loan').change(function(){
			$( "#loan-slider" ).slider( "value", $('#loan').val());
		});
        
    });
	
	$(function() {
        $( "#min-ir" ).slider({
            range: "max",
			step:1,
            min: 12,
            max: 24,
            value: 12,
            slide: function( event, ui ) {
                $('#min-range').val(ui.value);                
            }
        });
    
		$('#min-range').change(function(){
			$( "#min-ir" ).slider( "value", $('#min-range').val());
		});
        
    });
	
	$(function() {
        $( "#max-ir" ).slider({
            range: "max",
			step:1,
            min: 12,
            max: 24,
            value: 24,
            slide: function( event, ui ) {
                $('#max-range').val(ui.value);                
            }
        });
    
		$('#max-range').change(function(){
			$( "#max-ir" ).slider( "value", $('#max-range').val());
		});
        
    });
	
	$(function() {
        $( "#tenor" ).slider({
            range: "max",
			step:6,
            min: 6,
            max: 360,
            value:6,
            slide: function( event, ui ) {
                $('#tenor-range').val(ui.value);                
            }
        });
    
		$('#tenor-range').change(function(){
			$( "#tenor" ).slider( "value", $('#tenor-range').val());
		});
        
    });