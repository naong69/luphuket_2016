/* ========================================================================= */
/*	Preloader
/* ========================================================================= */

jQuery(window).load(function(){

	$("#preloader").fadeOut("slow");

});

/* ========================================================================= */
/*  Welcome Section Slider
/* ========================================================================= */

$(function() {

    var Page = (function() {

        var $navArrows = $( '#nav-arrows' ),
            $nav = $( '#nav-dots > span' ),
            slitslider = $( '#slider' ).slitslider( {
                onBeforeChange : function( slide, pos ) {

                    $nav.removeClass( 'nav-dot-current' );
                    $nav.eq( pos ).addClass( 'nav-dot-current' );

                }
            } ),

            init = function() {

                initEvents();
                
            },
            initEvents = function() {

                // add navigation events
                $navArrows.children( ':last' ).on( 'click', function() {

                    slitslider.next();
                    return false;

                } );

                $navArrows.children( ':first' ).on( 'click', function() {
                    
                    slitslider.previous();
                    return false;

                } );

                $nav.each( function( i ) {
                
                    $( this ).on( 'click', function( event ) {
                        
                        var $dot = $( this );
                        
                        if( !slitslider.isActive() ) {

                            $nav.removeClass( 'nav-dot-current' );
                            $dot.addClass( 'nav-dot-current' );
                        
                        }
                        
                        slitslider.jump( i + 1 );
                        return false;
                    
                    } );
                    
                } );

            };

            return { init : init };

    })();

    Page.init();

});

// index array 
var index_array;
var index_json_obj;

$(document).ready(function(){

	/* ========================================================================= */
	/*	Menu item highlighting
	/* ========================================================================= */

	jQuery('#nav').singlePageNav({
		offset: jQuery('#nav').outerHeight(),
		filter: ':not(.external)',
		speed: 2000,
		currentClass: 'current',
		easing: 'easeInOutExpo',
		updateHash: true,
		beforeStart: function() {
			console.log('begin scrolling');
		},
		onComplete: function() {
			console.log('done scrolling');
		}
	});
	
    $(window).scroll(function () {
        if ($(window).scrollTop() > 400) {
            $(".navbar-brand a").css("color","#fff");
            $("#navigation").removeClass("animated-header");
        } else {
            $(".navbar-brand a").css("color","inherit");
            $("#navigation").addClass("animated-header");
        }
    });
	
	/* ========================================================================= */
	/*	Fix Slider Height
	/* ========================================================================= */	

    // Slider Height
    var slideHeight = $(window).height();
    
    $('#home-slider, #slider, .sl-slider, .sl-content-wrapper').css('height',slideHeight);

    $(window).resize(function(){'use strict',
        $('#home-slider, #slider, .sl-slider, .sl-content-wrapper').css('height',slideHeight);
    });
	
	
	
	$("#works, #testimonial").owlCarousel({	 
		navigation : true,
		pagination : false,
		slideSpeed : 700,
		paginationSpeed : 400,
		singleItem:true,
		navigationText: ["<i class='fa fa-angle-left fa-lg'></i>","<i class='fa fa-angle-right fa-lg'></i>"]
	});

	/* ========================================================================= */
	/*	Legend box
	/* ========================================================================= */	
	
	$("#legend-phuket").show();
	//$("#legend-validate").show();
	//$("#legend-act-cp").show()
	
	/* ========================================================================= */
	/*	Featured Project Lightbox
	/* ========================================================================= */

	$(".acts-fancybox").fancybox({
		padding: 0,

		openEffect : 'elastic',
		openSpeed  : 650,

		closeEffect : 'elastic',
		closeSpeed  : 550,

		closeClick : false,
			
		beforeShow: function () {
			var key = "'"+$(this.element).attr('title')+"'";
			this.title = $(this.element).attr('title');
			this.title = '<h4>' + this.title + '</h4>' + '<p><span sytle="float:right; width: 70%; font-size:20px; display:block">' + 
			$(this.element).parents('.lu-acts-item').find('p').text() + 
			'</span><span style="float:right; display:block"><a href="javascript:loadLawDoc('+ key +' ) ">โหลดเอกสารกฏหมาย</a></span></p>';
		},
		
		helpers : {
			title : { 
				type: 'inside' 
			},
			overlay : {
				css : {
					'background' : 'rgba(0,0,0,0.8)'
				}
			}
		}
		
	});
	/*
	$("#validate-btn").on('click',function(){
		$(".result-fancybox").fancybox({
			href : 'php/lu_act_validate.php?data='+mapZone+'&index='+$('#oper-prod-index').val(),
			width         : '75%',
			height        : '700',
			autoScale     : false,
			transitionIn  : 'elastic',
			transitionOut : 'elastic',
			type          : 'iframe',
			
			helpers : {
				overlay : {
					css : {
						'background' : 'rgba(0,0,0,0.8)'
					}
				}
			}
			
		});
		
	});
	*/
	
	$('#validate-btn').click(function(){
		 if(twoZone) {
			if(vectorLayer.getVisible())
				vectorLayer.setVisible(false)
			$('#zoom-alert').fadeIn().delay(2500).fadeOut();
			return false;
		 } else if($('#oper-prod-index').val()=="-") {
			$('#oper-prod-index').parent().addClass('form-control-error')
			if($('#category-index').val()=="-")
				$('#category-index').parent().addClass('form-control-error')
			if($('#group-index').val()=="-")
				$('#group-index').parent().addClass('form-control-error')
			 //$("#validate-msg").show();
			return false;
		 } else {
			 //alert(mapZone);
			 //alert($('#oper-prod-index').val());
			$(".result-fancybox").fancybox({
				href : 'php/lu_act_validate.php?data='+mapZone+'&index='+$('#oper-prod-index').val()+'&xy='+xy,
				width         : '75%',
				height        : '700',
				autoScale     : false,
				transitionIn  : 'elastic',
				transitionOut : 'elastic',
				type          : 'iframe',
				
				helpers : {
					overlay : {
						css : {
							'background' : 'rgba(0,0,0,0.8)'
						}
					}
				}
				
			}); 
			 
		 }
	});

	$('#category-index').change(function(){
		// remove error 
		$('#category-index').parent().removeClass('form-control-error')
		
		if($('#category-index').val()!="-"){
			//fill options based on category-index
			$('#group-index').find('option').not(':first').remove();
				// get indexs
			$.post( "php/get_indexs.php",{ cat: $('#category-index').val() }, function (j){
				index_json_obj = $.parseJSON(j);
				
				$.each(index_json_obj, function() {
					$('#group-index').append($('<option>', {
						value: this['group_index'],
						text: this['group_name_sub']
					}));
				});
			});
				
			// enable group-index select
			$('#group-index').prop('disabled', false);
		} else {
			$('#group-index').prop('disabled', true);
			$('#group-index').val("-");
			$('#oper-prod-index').prop('disabled', true);
			$('#oper-prod-index').val("-");
			$('#category-index').parent().addClass('form-control-error')
		}
		
	});

	$('#group-index').change(function(){
		// remove error 
		$('#group-index').parent().removeClass('form-control-error')
		
		if($('#group-index').val()!="-"){
			//fill options based on category-index
			$('#oper-prod-index').find('option').not(':first').remove();
			$.post( "php/get_indexs.php",{ group: $('#group-index').val() }, function (j){
					index_json_obj = $.parseJSON(j);
					$.each(index_json_obj, function() {
						$('#oper-prod-index').append($('<option>', {
							value: this['indexID'],
							text: this['oper_prod_name_sub']
						}));
					});
				});
			// enable group-index select
			$('#oper-prod-index').prop('disabled', false);
		} else {
			$('#group-index').parent().addClass('form-control-error');
			$('#oper-prod-index').prop('disabled', true);
			$('#oper-prod-index').val("-");
		}
		
	});

	$('#oper-prod-index').change(function(){
		// remove error 
		$('#oper-prod-index').parent().removeClass('form-control-error');
		
		if($('#oper-prod-index').val()=="-")
			$('#oper-prod-index').parent().addClass('form-control-error');
	});

	
	$('#back-to-map').click(function(){
		$('#map-title').scrollView();
	})

});

$('input[name=email]').on('input', function() {
    $('input[name=email]').removeClass('form-control-error')
});

$('textarea[name=message]').on('input', function() {
    $('textarea[name=message]').removeClass('form-control-error')
});



function msgSubmit(){
	if($('input[name=email]').val() == "" || $('textarea[name=message]').val() == "") {
		if($('input[name=email]').val() == "")
			$('input[name=email]').addClass('form-control-error')
		if($('textarea[name=message]').val() == "")
			$('textarea[name=message]').addClass('form-control-error')
	} else {
		$.post( "php/msg_submit.php",{ name: $('input[name=name]').val(), 
									  email: $('input[name=email]').val(), 
									  subject: $('input[name=subject]').val(), 
									  message: $('textarea[name=message]').val(), }, function (){
			$('#submit-info').fadeIn().delay(2000).fadeOut();
			$('input[name=name]').val('');
			$('input[name=email]').val('');
			$('input[name=subject]').val('');
			$('textarea[name=message]').val('');
		});	
	}
}



function validateInit(){
	
	$('#category-index').parent().removeClass('form-control-error');
	$('#category-index').val("-");
	if(vectorLayer.getVisible() == true){
		$('#category-index').prop('disabled', false);
	} else {
		$('#category-index').prop('disabled', true);
	}

	$('#group-index').parent().removeClass('form-control-error');
	$('#group-index').val("-");
	$('#group-index').prop('disabled', true);
	
	$('#oper-prod-index').parent().removeClass('form-control-error');
	$('#oper-prod-index').val("-");
	$('#oper-prod-index').prop('disabled', true);
}


function loadLawDoc(law){
	
	if(law == 'กฏหมายควบคุมอาคาร (๒๕๒๙)'){
		window.open('acts/pdf/ควบคุมอาคารฉบับที่_15_(2529).pdf', '_blank');
	}
	
	if(law == 'กฏหมายควบคุมอาคาร (๒๕๓๒) '){
		window.open('acts/pdf/ควบคุมอาคารฉบับที่_20_(2532).pdf', '_blank');
	}
	
	if(law == 'กฏหมายสิ่งแวดล้อม'){
		window.open('acts/pdf/ประกาศกระทรวงทรัพย์ฯ_(2553).pdf', '_blank');
	}
	
	if(law == 'กฏหมายผังเมืองรวม'){
		window.open('acts/pdf/ผังเมืองรวมภูเก็ต_(2554).pdf', '_blank');
		window.open('acts/pdf/ผังเมืองรวมภูเก็ต_(2558).pdf', '_blank');
	}
	
	if(law == 'เทศบัญญัติเทศบาลเมืองป่าตอง'){
		window.open('acts/pdf/เทศบัญญัติเทศบาลเมืองป่าตอง_(2548).pdf', '_blank');
	}

}

/* ==========  START GOOGLE MAP ========== */

// When the window has finished loading create our google map below
google.maps.event.addDomListener(window, 'load', init);

function init() {
    // Basic options for a simple Google Map
    // For more options see: https://developers.google.com/maps/documentation/javascript/reference#MapOptions

	    var myLatLng = new google.maps.LatLng(7.894724, 98.352156);

	    var mapOptions = {
	        zoom: 15,
	        center: myLatLng,
	        disableDefaultUI: true,
	        scrollwheel: false,
	        navigationControl: true,
	        mapTypeControl: false,
	        scaleControl: false,
	        draggable: true,

        // How you would like to style the map. 
        // This is where you would paste any style found on Snazzy Maps.
        styles: [{
            featureType: 'water',
            stylers: [{
                color: '#46bcec'
            }, {
                visibility: 'on'
            }]
        }, {
            featureType: 'landscape',
            stylers: [{
                color: '#f2f2f2'
            }]
        }, {
            featureType: 'road',
            stylers: [{
                saturation: -100
            }, {
                lightness: 45
            }]
        }, {
            featureType: 'road.highway',
            stylers: [{
                visibility: 'simplified'
            }]
        }, {
            featureType: 'road.arterial',
            elementType: 'labels.icon',
            stylers: [{
                visibility: 'off'
            }]
        }, {
            featureType: 'administrative',
            elementType: 'labels.text.fill',
            stylers: [{
                color: '#444444'
            }]
        }, {
            featureType: 'transit',
            stylers: [{
                visibility: 'off'
            }]
        }, {
            featureType: 'poi',
            stylers: [{
                visibility: 'off'
            }]
        }]
    };

    // Get the HTML DOM element that will contain your map 
    // We are using a div with id="map" seen below in the <body>
    var mapElement = document.getElementById('map-canvas');

    // Create the Google Map using our element and options defined above
    var map = new google.maps.Map(mapElement, mapOptions);

    // Let's also add a marker while we're at it
    var marker = new google.maps.Marker({
        position: new google.maps.LatLng(7.894724, 98.352156),
        map: map,
		icon: 'img/icons/map-marker.png',
		title: 'คณะเทคโนโลยีและสิ่งแวดล้อม มหาวิทยาลัยสงขลานครินทร์ วิทยาเขตภูเก็ต'
    });
	
	marker.addListener('click', function() {
	 window.open('https://www.google.co.th/maps/place/Faculty+of+Technology+and+Environment/@7.8922156,98.3471783,15z/data=!4m5!3m4!1s0x0:0x43ed556e96eb7eb8!8m2!3d7.8947623!4d98.352077?hl=en','_blank')
	});

}

// ========== END GOOGLE MAP ========== //

var wow = new WOW ({
	offset:       75,          // distance to the element when triggering the animation (default is 0)
	mobile:       false,       // trigger animations on mobile devices (default is true)
});
wow.init();

