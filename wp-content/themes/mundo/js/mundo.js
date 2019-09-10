
//************************************** Slider single js ***************//
var slide_layer_left_right = function(ratio) {
  $ = jQuery;
  if(ratio < 1) {
    ratio = 1;
  }
  var $w = (1024 * ratio) +1;
  var $win_w = $(window).width();
  if( $win_w < 768 ) {
    $('.slider-layer').hide();
    return;
  }
  var $lr = ($win_w - $w) / 2;
  var $lr = $lr - 72;
  $('.slider-layer.layer-left').css({'width':$lr})
  $('.slider-layer.layer-right').css({'width':$lr})
}
jssor_1_slider_init = function() {
    $ = jQuery;
    if($('#jssor_1').length < 1)
      { return;}
    var $win_w = $(window).width();
    var $lr = ($win_w - 1024) / 2;

    $('#jssor_1').width($win_w);
    $('#jssor_1 div[data-u="slides"]').width($win_w);
    // $('#jssor_1').height(430);
    // $('#jssor_1 div[data-u="slides"]').height(430);

    var jssor_1_options = {

      $AutoPlay: 0,
      $SlideWidth: 1024,
      $SlideHeight: 640,
      $SlideSpacing: 73,
      
      $Cols: 2,
      $Align: $lr,
      $OriginalWidth:$win_w, 
      $ArrowNavigatorOptions: {
        $Class: $JssorArrowNavigator$
      },
      $BulletNavigatorOptions: {
        $Class: $JssorBulletNavigator$
      },


    };
    //console.log($lr);
    //console.log($win_w);

    var jssor_1_slider = new $JssorSlider$("jssor_1", jssor_1_options);
    window.abc = jssor_1_slider;

    /*#region responsive code begin*/

    var MAX_WIDTH = $win_w;

    function ScaleSlider() {
        var containerElement = jssor_1_slider.$Elmt.parentNode;
        var containerWidth = containerElement.clientWidth;

        if (containerWidth) {

            var expectedWidth = Math.min(MAX_WIDTH || containerWidth, containerWidth);


            jssor_1_slider.$ScaleWidth(expectedWidth);


            var ratio = expectedWidth / jssor_1_slider.$OriginalWidth();
            slide_layer_left_right(ratio);
        }
        else {
            window.setTimeout(ScaleSlider, 30);
        }
    }

    ScaleSlider();

    $Jssor$.$AddEvent(window, "load", ScaleSlider);
    $Jssor$.$AddEvent(window, "resize", ScaleSlider);
    $Jssor$.$AddEvent(window, "orientationchange", ScaleSlider);

   //============================================================//
    
    // event fired when slider is "parked"
    jssor_1_slider.$On( $JssorSlider$.$EVT_PARK, function(slideIndex){

        var allImages = $(jssor_1_slider.$Elmt).find("img[u=image]");
        var currentImage = allImages.eq(slideIndex);
        var currentDiv = currentImage.parent("div");
        currentDiv.addClass("current");
        
    });
    
    // event fired when slider starts moving
    jssor_1_slider.$On( $JssorSlider$.$EVT_POSITION_CHANGE, function(position){
        
        // remove 'current' class from all slides
        $(jssor_1_slider.$Elmt).find(".current").removeClass("current");       
        
    });
    
    //============================================================//
    // console.log('run-slide');
};
jQuery(window).load(function(){
  jssor_1_slider_init();
    
});

jQuery.fn.vjustify=function() {
    var maxHeight=0;
    this.each(function(){
        if (this.offsetHeight>maxHeight) {maxHeight=this.offsetHeight;}
    });
    this.each(function(){
        jQuery(this).height(maxHeight + "px");
        if (this.offsetHeight>maxHeight) {
            jQuery(this).height((maxHeight-(this.offsetHeight-maxHeight))+"px");
        }
    });
};

jQuery(document).ready(function($){ 
    // $(".dowload-pdf").click(function(){
    //     Tawk_API.hideWidget();
    // });
    
    $(".tnp-email").attr("placeholder", title_email);
    $(".tnp-submit").val(btn_email);
    $('.tnp-widget form').removeAttr('onsubmit');
    $(".tnp-widget form").validate({
      rules: {
            'ne': {
                    required: true,
                    email: true
                  },
    },
    messages: {
            'ne': {
                    required: fill_out,
                    email: check_email
                  },
        }
    });
    $(".tnp-submit").click(function(){
        if( $(".tnp-widget form").valid() == false ) {
          return;
        }
    });
    $(".call-whatsapp-mobile").click(function(){
        $(".mobile-tab").toggle();
    });

    $('.navbar-nav a').click(function() {
        $(".navbar-nav a").removeClass("active")
        $(this).addClass("active");
    });
    // $("article.tour.type-tour a").click(function(){
    //     var post_id = $(this).parent('article').attr('id');
    //     alert(post_id);
    //     var href = $(this).attr('href');
    //     var data = {
    //               'action':'save_post_view',
    //               'post_id': post_id,
    //             }; 
    //     console.log(data);  
    //     $.post('/wp-admin/admin-ajax.php', data, function(response)
    //     {
    //     if( !!response.error && response.error ) {
    //         $.alert({
    //             title: 'Alert!',
    //             content: response.mess,
    //         });
    //     }else{
    //         window.location.href = href;            
    //     }
    //     }, 'json').fail(function() {
    //     });
    //     return false;
    // })
    // click vao pdf để print trang tour
    $(".dowload-pdf").click(function(){
        // var post_id = $(this).data('post');
        // var data = {
        //           'action':'get_infomation_tour_pdf',
        //           'post_id': post_id,
        //         }; 
        //         console.log(data);
        // $.post('/wp-admin/admin-ajax.php', data, function(response)
        // {
        // if( !!response.error && response.error ) {
        //     $.alert({
        //         title: 'Alert!',
        //         content: response.mess,
        //     });
        // }else{
        //     $('.information-pdf').html(response.html);
        // }
        // }, 'json').fail(function() {
        // });
        $("a").removeAttr("href");
        $(".hotels_in_tour a").removeAttr("href");
        
        window.print();
    })
    

    //click order by trang travel style
    //  $.removeCookie('post_tour', { expires: 365, path: '/' });
    //$.cookie('post_tour', '' , { expires: 365 });
    //var post_tour_new = $.cookie('post_tour');
    // console.log(post_tour_new);
    // var post_tour_new = $.cookie('post_tour');
    // console.log(post_tour_new+'end');
    $(".shortlisted-right .black-color").click(function(){
        var tour_id = $(this).data('post');
        var post_tour = $.cookie('post_tour');
        var tour_id_new = post_tour.replace('-' +tour_id,'');
        $.cookie('post_tour', tour_id_new , { expires: 365, path: '/' } );
        // if (isEmptyObject( $.cookie('post_tour') )) {
        //     $.removeCookie('post_tour', { expires: 365, path: '/' });
        // }
        location.reload();
    });
    $(".save-tour-head").click(function(){
        var tour_id = $(".dowload-pdf").data('post');
        var post_tour = $.cookie('post_tour');
        //console.log(post_tour + 'tour_id' + tour_id)
        //console.log(post_tour.indexOf(tour_id));
        if ( post_tour != undefined ) {
            if ( post_tour.indexOf(tour_id) == -1 ) { //Nếu ko có thì nạp vào cookie
                var tour_id_new = post_tour + '-' + tour_id;
                $.cookie('post_tour', tour_id_new , { expires: 365, path: '/' } );

                $('.save-tour-head').html('<img src="https://test.mundoasiatours.com/wp-content/themes/mundo/icon/salecolor.png"> Remove tour');
                //console.log('đã thêm');
            }else{ //Nếu đã có tour id trong mảng thì hủy tour này
                var tour_id_new = post_tour.replace('-' +tour_id,'');
                //console.log(tour_id_new+'new');

                $.cookie('post_tour', tour_id_new , { expires: 365, path: '/' } );

                // if (isEmptyObject( $.cookie('post_tour') )) {
                //  $.removeCookie('post_tour', { expires: 365, path: '/' });
                // }
                $('.save-tour-head').html('<img src="https://test.mundoasiatours.com/wp-content/themes/mundo/icon/salecolor.png"> Save tour');
                //console.log('đã hủy');
            }
        }else{
            //var tour_id_new = '-' + tour_id;
            $.cookie('post_tour', '-' + tour_id  , { expires: 365, path: '/' } );

            $('.save-tour-head').html('<img src="https://test.mundoasiatours.com/wp-content/themes/mundo/icon/salecolor.png"> Remove tour');
            //console.log('đã thêm');
        }
        
        var post_tour_new = $.cookie('post_tour');
        //console.log(post_tour_new+'end');   
    });
    $('.currentcy-menu .sub-menu a.exchange_rate_show').click(function(){
        var exchange_rate_title = $(this).data('title');
        var exchange_rate_symbol = $(this).data('symbol');
        var exchange_detail = $(this).data('number');
        var exchange_rate = exchange_rate_title + '-' + exchange_rate_symbol + '-' + exchange_detail;
        //console.log(exchange_rate);
        $.cookie('exchange_rate', exchange_rate, { expires: 1, path: '/'} );
        location.reload();
    });
    $(".sort-by-price").click(function(){
        $('.order-result .dropdown').removeClass("open");
        var order_price = $(this).data('value');  
        var text_click = $(this).data('name'); 
        // console.log(text_click); 
        var title = $("#tour_name").val();
        var destination = $("#destination").val();
        var travel_style = $("#travel_style").val();
        var duration = $("#duration").val();
        var date_tour = $("#date_tour").val();
        var offset = $(".custom_post_show_more").data('offset');
        var module_id = $('#submit_travel_style').data('id');
        var travel_style_cat = $('#submit_travel_style').data('travel_style_cat');
        //console.log(travel_style_cat);
        var data = {
                  'action':'search_tour_in_travel_style',
                  'title': title,
                  'destination': destination,
                  'travel_style': travel_style,
                  'duration':duration,
                  'date_tour': date_tour,
                  'offset': offset,
                  'module_id':module_id,
                  'order_price': order_price,
                  'travel_style_cat': travel_style_cat,
                }; 
        // console.log(data);  
        $.post('/wp-admin/admin-ajax.php', data, function(response)
        {
        if( !!response.error && response.error ) {
            $.alert({
                title: 'Alert!',
                content: response.mess,
            });
        }else{
           // alert(response.html);
            $('#dropdownMenu1').html(text_click + ' <span class="caret"></span>');
            $('#'+module_id).html(  response.html );

            $('.total_posts').first().html(  response.total_posts ); 
            // if( order_price == 'ASC'){
            //     $("#price").data('value', 'DESC');
            // }else{
            //     $("#price").data('value', 'ASC');
            // }         
            $(this).parents(".dropdown").find('.btn').html($(this).text() + ' <span class="caret"></span>');
            $(this).parents(".dropdown").find('.btn').val($(this).data('value')); 
            
            $('#tours_travel_style .post_content').vjustify();


            show_more_posts();
           
        }
        }, 'json').fail(function() {
        });
        return false;
        
    })                  
    //click order by trang travel style
    $("#most_popular").click(function(){
        $('.order-result .dropdown').removeClass("open");
        var order_most_popular = $(this).data('value');  
        var text_click = $(this).data('name'); 
        //alert(order_most_popular);    
        var title = $("#tour_name").val();
        var destination = $("#destination").val();
        var travel_style = $("#travel_style").val();
        var duration = $("#duration").val();
        var date_tour = $("#date_tour").val();
        var offset = $(".custom_post_show_more").data('offset');
        var module_id = $('#submit_travel_style').data('id');
        var travel_style_cat = $('#submit_travel_style').data('travel_style_cat');
        // console.log(travel_style_cat);
        var data = {
                  'action':'search_tour_in_travel_style',
                  'title': title,
                  'destination': destination,
                  'travel_style': travel_style,
                  'duration':duration,
                  'date_tour': date_tour,
                  'offset': offset,
                  'module_id':module_id,
                  'travel_style_cat': travel_style_cat,
                  'order_most_popular': order_most_popular,
                }; 
        // console.log(data);  
        $.post('/wp-admin/admin-ajax.php', data, function(response)
        {
        if( !!response.error && response.error ) {
            $.alert({
                title: 'Alert!',
                content: response.mess,
            });
        }else{
           // alert(response.html);
            $('#dropdownMenu1').html(text_click + ' <span class="caret"></span>');
            $('#'+module_id).html(  response.html);
            $('.total_posts').first().html(  response.total_posts); 
            if( order_most_popular == 'ASC'){
                $("#most_popular").data('value', 'DESC');
            }else{
                $("#most_popular").data('value', 'ASC');
            }         
            $(this).parents(".dropdown").find('.btn').html($(this).text() + ' <span class="caret"></span>');
            $(this).parents(".dropdown").find('.btn').val($(this).data('value')); 
            
            $('#tours_travel_style .post_content').vjustify();

            show_more_posts();

        }
        }, 'json').fail(function() {
        });
        return false;
        
    })                  
    //submit tim kiem trang travel style
    $("#submit_travel_style").click(function(){
        var title = $("#tour_name").val();
        var destination = $("#destination").val();
        var travel_style = $("#travel_style").val();
        var duration = $("#duration").val();
        var date_tour = $("#date_tour").val();
        var offset = $(".custom_post_show_more").data('offset');
        var module_id = $(this).data('id');
        var data = {
                  'action':'search_tour_in_travel_style',
                  'title': title,
                  'destination': destination,
                  'travel_style': travel_style,
                  'duration':duration,
                  'date_tour': date_tour,
                  'offset': offset,
                  'module_id':module_id,
                }; 
        // console.log(data);  
        $.post('/wp-admin/admin-ajax.php', data, function(response)
        {
        if( !!response.error && response.error ) {
            $.alert({
                title: 'Alert!',
                content: response.mess,
            });
        }else{
           // alert(response.html);
            $('#'+module_id).html(  response.html);
            $('.total_posts').first().html(  response.total_posts);  
            if( $('#tours_travel_style').length && $( window ).width()>=500 ) {
               setTimeout(function() {
                    $('#tours_travel_style .post_content').height('auto').vjustify();
                    $('#tours_travel_style .post-thumbnail a').height('auto').vjustify();
                    $('#tours_travel_style .item').height('auto').vjustify();
                }, 1e3);
            }          
            show_more_posts();
        }
        }, 'json').fail(function() {
        });
        return false;
    });
    $('#search_hotel, #name_res_search').select2(
        {width: '100%',
        allowClear: true,
        multiple: false,
        maximumSelectionSize: 1,
        }
    );
    
     // select tim kiem trang restaurant list
    $("#name_res_search").change(function() {
        var title = $(this).val();
        var city = $('#res_city_search').val();
        var res_style = $('#res_style_search').val();
        var offset = $(".custom_post_show_more").data('offset');
        var module_id = $(".custom_post_show_more").data('id');
        var data = {
                  'action':'form_search_restaurants',
                  'title': title,
                  'city': city,
                  'res_style': res_style,
                  'offset': offset,
                }; 
        // console.log(data);  
        $.post('/wp-admin/admin-ajax.php', data, function(response)
        {
        if( !!response.error && response.error ) {
            $.alert({
                title: 'Alert!',
                content: response.mess,
            });
        }else{
           // alert(response.html);
            $('.total_posts').first().html(  response.total_posts ); 
            $('#city_of_vietnam_list_restaurants').html(  response.html);
            show_more_posts();
        }
        }, 'json').fail(function() {
        });
        return false;
       
    }); 
    // select tim kiem trang restaurant list
    $("#res_city_search").change(function() {
        var title = $("#name_res_search").val();
        var city = $('#res_city_search').val();
        var res_style = $('#res_style_search').val();
        var offset = $(".custom_post_show_more").data('offset');
        var module_id = $(".custom_post_show_more").data('id');
        var data = {
                  'action':'form_search_restaurants',
                  'title': title,
                  'city': city,
                  'res_style': res_style,
                  'offset': offset,
                }; 
        // console.log(data);  
        $.post('/wp-admin/admin-ajax.php', data, function(response)
        {
        if( !!response.error && response.error ) {
            $.alert({
                title: 'Alert!',
                content: response.mess,
            });
        }else{
           // alert(response.html);
            $('.total_posts').first().html(  response.total_posts ); 
            $('#city_of_vietnam_list_restaurants').html(  response.html);
            show_more_posts();
        }
        }, 'json').fail(function() {
        });
        return false;
       
    }); 
    // select tim kiem trang hotel list
    $("#res_style_search").change(function() {
         var title = $("#name_res_search").val();
        var city = $('#res_city_search').val();
        var res_style = $('#res_style_search').val();
        var offset = $(".custom_post_show_more").data('offset');
        var module_id = $(".custom_post_show_more").data('id');
        var data = {
                  'action':'form_search_restaurants',
                  'title': title,
                  'city': city,
                  'res_style': res_style,
                  'offset': offset,
                }; 
        // console.log(data);  
        $.post('/wp-admin/admin-ajax.php', data, function(response)
        {
        if( !!response.error && response.error ) {
            $.alert({
                title: 'Alert!',
                content: response.mess,
            });
        }else{
           // alert(response.html);
            $('.total_posts').first().html(  response.total_posts ); 
            $('#city_of_vietnam_list_restaurants').html(  response.html);
            show_more_posts();
        }
        }, 'json').fail(function() {
        });
        return false;
       
    });
    
    
    
    
    
    // select tim kiem trang hotel list
    $("#search_hotel").change(function() {
        var title = $(this).val();
        var city = $('#hotel_city_search').val();
        var hotel_style = $('#hotel_style_search').val();
        var offset = $(".custom_post_show_more").data('offset');
        var module_id = $(".custom_post_show_more").data('id');
        var data = {
                  'action':'form_search_hotel',
                  'title': title,
                  'city': city,
                  'hotel_style': hotel_style,
                  'offset': offset,
                }; 
        // console.log(data);  
        $.post('/wp-admin/admin-ajax.php', data, function(response)
        {
        if( !!response.error && response.error ) {
            $.alert({
                title: 'Alert!',
                content: response.mess,
            });
        }else{
           // alert(response.html);
            $('#city_of_vietnam_list_hotel').html(  response.html);
            setTimeout(function() {
                  $('#city_of_vietnam_list_hotel article').height('auto').vjustify();
              },1e3)
            show_more_posts();
        }
        }, 'json').fail(function() {
        });
        return false;
       
    }); 
    // select tim kiem trang hotel list
    $("#hotel_style_search").change(function() {
        var title = $("#search_hotel").val();
        var city = $('#hotel_city_search').val();
        var hotel_style = $(this).val();
        var offset = $(".custom_post_show_more").data('offset');
        var module_id = $(".custom_post_show_more").data('id');
        var data = {
                  'action':'form_search_hotel',
                  'title': title,
                  'city': city,
                  'hotel_style': hotel_style,
                  'offset': offset,
                }; 
        // console.log(data);  
        $.post('/wp-admin/admin-ajax.php', data, function(response)
        {
        if( !!response.error && response.error ) {
            $.alert({
                title: 'Alert!',
                content: response.mess,
            });
        }else{
           // alert(response.html);
            $('#city_of_vietnam_list_hotel').html(  response.html);
            setTimeout(function() {
                  $('#city_of_vietnam_list_hotel article').height('auto').vjustify();
              },1e3)
            show_more_posts();
        }
        }, 'json').fail(function() {
        });
        return false;
       
    }); 
    // select tim kiem trang hotel list
    $("#hotel_city_search").change(function() {
        var title = $("#search_hotel").val();
        var city = $(this).val();
        var hotel_style = $("#hotel_style_search").val();
        var offset = $(".custom_post_show_more").data('offset');
        var module_id = $(".custom_post_show_more").data('id');
        var data = {
                  'action':'form_search_hotel',
                  'title': title,
                  'city': city,
                  'hotel_style': hotel_style,
                  'offset': offset,
                }; 
        // console.log(data);  
        $.post('/wp-admin/admin-ajax.php', data, function(response)
        {
        if( !!response.error && response.error ) {
            $.alert({
                title: 'Alert!',
                content: response.mess,
            });
        }else{
            //console.log(response.html);
            $('.total_posts').first().html(  response.total_posts ); 
            $('#city_of_vietnam_list_hotel').html(  response.html);
            setTimeout(function() {
                  $('#city_of_vietnam_list_hotel article').height('auto').vjustify();
              },1e3)
            show_more_posts();
        }
        }, 'json').fail(function() {
        });
        return false;
       
    });
    $.datepicker.formatDate( "yy-mm-dd", new Date( 2007, 1 - 1, 26 ) );
    
    // $( "#date_tour" ).datepicker({
    //     dateFormat: "dd/mm/yy",
    // });
    $("#date_tour").datepicker({
        dateFormat: "dd/mm/yy",
        changeMonth: true,
        changeYear: true,
        dayNamesMin: [ "SUN", "MON", "TUE", "WED", "THU", "FRI", "SAT" ],
    });
    $("#date_tour").datepicker().datepicker("setDate", new Date());

    $( '.i4ewOd-pzNkMb-tJHJj' ).hide();
    // $( " a.share-head" ).hover(function() {
    //     $( '.triangle2' ).show();
    // }, function() {
    //     $( '.triangle2' ).hide();
    // });
    $('.destination_search').select2({
        minimumResultsForSearch: Infinity,
        placeholder: choose_des,
        allowClear: true
    }); 
    $('.home  .destination_search').select2({
        minimumResultsForSearch: Infinity,
        placeholder: choose_des_home,
        allowClear: true
    });
    $('.travel_style_search').select2({
        minimumResultsForSearch: Infinity,
        placeholder: choose_style,
        allowClear: true
    }); 
    $('.home  .travel_style_search ').select2({
        minimumResultsForSearch: Infinity,
        placeholder: choose_style_home,
        allowClear: true
    });
    $('.duration_search').select2({
        minimumResultsForSearch: Infinity,
        placeholder: choose_duration,
        allowClear: true
    }); 
    $('.form-make-enquiry-duration .duration_search').select2({
        minimumResultsForSearch: Infinity,
        placeholder: choose_duration_enqiry,
        allowClear: true
    }); 
    $('.home .duration_search').select2({
        minimumResultsForSearch: Infinity,
        placeholder: durations_home,
        allowClear: true
    });
    $('#duration').select2({
        minimumResultsForSearch: Infinity,
        placeholder: choose_duration,
        allowClear: true
    });

    $('.hotel-city-search').select2({
        //minimumResultsForSearch: Infinity,
        multiple: false,
        maximumSelectionSize: 1,
        allowClear: true
    }); 
    $('.hotel-style-search').select2({
        minimumResultsForSearch: Infinity,
        // placeholder: "Destination",
        allowClear: true
    }); 
    $(document).on('touchend', function(){
        $(".select2-search").attr("focus", "false");
    })

    $(".select2-search input").attr("readonly", "true");
    $(".select2-search input").attr("focus", "false");
    $(".select2-search input").blur();


    $(".select2-search input").on("focus", function(){
        $(this).blur();
    });
    $(window).on('load resize', function() { 

        // $('.on_request_calender').click(function(){
        //     $("#ui-datepicker-div tr td").addClass("ui-datepicker-unselectable ui-state-disabled ");
        //     $(".ui-icon").hide();
        //     $('.ui-datepicker-year').prop('disabled', true);
        //     $('.ui-datepicker-month').prop('disabled', true);
        // });
        // if ($('.on_request_calender').width) {
        //     $('.on_request_calender').click(function(){
        //         $(".ui-icon").addClass("ui-datepicker-unselectable ui-state-disabled ");
        //     });
        // }
        
        if( $('.form_cuctomize_tour').length && $( window ).width()>1024 ) {
            $('.mundo-tooltip').removeAttr('id');
        }

        $(".expert_team-expert-team  a").removeAttr("href");
        $("#doi_tac_slider  a.entry-featured-image-url").removeAttr("href");
        $("#post_expert_home  a").removeAttr("href");
        $("#post_expert_detination  a").removeAttr("href");
        $("#city_of_vietnam  a").removeAttr("href");
        if( $('#page-container').length && $( window ).width()>=580 ) {
            $(".show_on_mobile").remove();
        }else{
            $(".show_on_desktop").remove();
        }
        if ($('.why-mundo-travel-list .et_pb_column_1_4').length && $(window).width() > 1000){
            $('.why-mundo-travel-list .et_pb_column_1_4').height('auto').vjustify();
        }
        if( $('#city_of_vietnam_list_restaurants').length && $( window ).width()>=768 ) {
            setTimeout(function() {
                  $('#city_of_vietnam_list_restaurants .et_pb_image_container').height('auto').vjustify();
              },1e3)
        }
        if( $('#excursion_relate').length && $( window ).width()>=768 ) {
            setTimeout(function() {
                  $('#excursion_relate .entry-title.content').height('auto').vjustify();
                  $('#excursion_relate .highlight_city.content').height('auto').vjustify();
              },1e3)
        }
        if( $('#excursions_list_page').length && $( window ).width()>=768 ) {
            setTimeout(function() {
                  $('#excursions_list_page .post_content').height('auto').vjustify();
              },1e3)
        }
        if( $('#city_of_vietnam_list_hotel').length && $( window ).width()>=768 ) {
            setTimeout(function() {
                  $('#city_of_vietnam_list_hotel article').height('auto').vjustify();
              },1e3)
        }
        if( $('.single-post .exploretour .row').length && $( window ).width()>=768 ) {
            setTimeout(function() {
                  $('.single-post .exploretour .post_content').height('auto').vjustify();
              },1e3)
        }
        if( $('.et_pb_row_3').length && $( window ).width()>=768 ) {
                  $('.why-us-travel').vjustify();
        }
        
        if( $('#departure_month').length && $( window ).width()>=0 ) {    
            setTimeout(function() {
                $('#departure_month .owl-item .clearfix').height('auto').vjustify();
                $('#departure_month .owl-item .clearfix .post_content').height('auto').vjustify();
            }, 1e3);
        } 
        if( $('#post_home').length && $( window ).width()>=768 ) {
            setTimeout(function() {
                $('#post_home .owl-item .clearfix').height('auto').vjustify();
            }, 1e3);
        } 
        if( $('#post_destination_page').length && $( window ).width()>=768 ) {
            setTimeout(function() {
                $('#post_destination_page .owl-item .clearfix').height('auto').vjustify();
            }, 1e3);
        } 
        if( $('.et_pb_row').length && $( window ).width()>=768 ) {
          $('.travel-with-confidence-top').vjustify();
        }
        if( $('.alternative_hotel').length && $( window ).width()>=768 ) {
          setTimeout(function() {
                $('.alternative_hotel .entry-title').height('auto').vjustify();
            }, 1e3);
        } 
        if( $('.hotel_things_to_do').length && $( window ).width()>=768 ) {
            setTimeout(function() {
                $('.hotel_things_to_do .thing-to-do-content').height('auto').vjustify();
            }, 1e3);
        } 
        if( $('.highlight').length && $( window ).width()>=768 ) { 
          setTimeout(function() {
                $('.highlight h2.et_pb_slide_title').height('auto').vjustify();
                $('.highlight .owl-content').height('auto').vjustify();
                $('.highlight .et_pb_bg_layout_dark .et_pb_slide_content').height('auto').vjustify();
                
            }, 1e3);
        }
        if( $('.highlight ').length && $( window ).width()>=480 ) {
            //$('.highlight img').height('auto').height('auto').vjustify();
        }
        if( $('.price-match-guarantee').length && $( window ).width()>=768 ) {
          $('.price-match-guarantee h1').vjustify();
          $('.price-match-guarantee .text_gray').vjustify();
        }  
        if( $('#post_tour_slider_js').length && $( window ).width()>=0 ) {
            // $('#post_tour_slider_js article').vjustify();
            setTimeout(function() {
                $('#post_tour_slider_js article h2.entry-title').height('auto').vjustify();
                $('#post_tour_slider_js .post_content').height('auto').vjustify();
                $('#post_tour_slider_js article').height('auto').vjustify();
            }, 1e3);
        } 
        if( $('#sic_destination_page').length && $( window ).width()>=0 ) {
            // $('#post_tour_slider_js article').vjustify();
            setTimeout(function() {
                $('#sic_destination_page article h2.entry-title').height('auto').vjustify();
                $('#sic_destination_page .post_content').height('auto').vjustify();
                $('#sic_destination_page article').height('auto').vjustify();
            }, 1e3);
        } 
        if( $('#post_tour_slider_js_mobile').length && $( window ).width()>=0 ) {
            // $('#post_tour_slider_js article').vjustify();
            setTimeout(function() {
                $('#post_tour_slider_js_mobile article h2.entry-title').height('auto').vjustify();
                $('#post_tour_slider_js_mobile .post_content').height('auto').vjustify();
                $('#post_tour_slider_js_mobile article').height('auto').vjustify();
            }, 1e3);
        } 
        if( $('#post_home').length && $( window ).width()>=768 ) {
            setTimeout(function() {
                $('#post_home article h2.entry-title').height('auto').vjustify();
            }, 1e3);
        }   
        if( $('#post_destination_page').length && $( window ).width()>=768 ) {
            setTimeout(function() {
                $('#post_destination_page article h2.entry-title').height('auto').vjustify();
                
            }, 1e3);
        } 
        if( $('.travel-post-list ').length && $( window ).width()>=768 ) {
            setTimeout(function() {
                $('.travel-post-list .post-content').height('auto').vjustify();
            }, 1e3);
        }   
        $('.title-highlight').vjustify();
        $('.content-highlight').vjustify();
        if( $('#post_responsible').length && $( window ).width()>=768 ) {
           $('#post_responsible article h2.entry-title').vjustify();
        }   
        if( $('.single-tour .exploretour .et_pb_row').length && $( window ).width()>=768 ) {
          $('.single-tour .exploretour .et_pb_row .post_content').vjustify();
        }
        if( $('#tours_travel_style').length && $( window ).width()>=500 ) {
           $('#tours_travel_style .post_content').vjustify();
           $('#tours_travel_style .post-thumbnail a').vjustify();
           $('#tours_travel_style .item').vjustify();
        }  
        if( $('#tours_travel_style_honeymoon').length && $( window ).width()>=500 ) {
            $('#tours_travel_style_honeymoon .post_content').vjustify();
        }
         if( $('#city_of_vietnam').length && $( window ).width()>=360 ) {
            setTimeout(function() {
                $('#city_of_vietnam article').height('auto').vjustify();
            }, 1e3)
        }
        if( $('.single-tour .row  .entry-title ').length && $( window ).width()>=768 ) {
          $('.single-tour .row  .entry-title ').vjustify();
        }
        
        $('.four-column-blog-grid.our-expert-list-wrapper .et_pb_column .et_pb_blog_grid .column.size-1of1 .et_pb_post').vjustify();
    });
    $(".tab_name").click(function(){
        var term = $(this).data('slug');
        $('.tab_name').not(this).removeClass('active');
        $(this).addClass('active');
        var taxonomy = $(this).parent($(".tab_header")).data('taxonomy');
        var module_id = $(this).parent($(".tab_header")).data('module_id');
        var items = 3;
            var post_type = 'post';
            var show_home = true;

        if (module_id == 'post_tour_slider_js'){
            var items = 1;
            var post_type = 'tour';
            var show_home = true;
            var posts_per_page = 6;
            var destination_id = $('#destination_id').val();
            // console.log(destination_id);
            var items = {
                            0:{
                                items:1,
                                stagePadding:20,
                                margin:15,
                            },
                            480:{
                                items:1,
                                stagePadding:30,
                            },
                            768:{
                                items:0.6,
                                stagePadding:30,
                            },
                            900:{
                                items:1
                            }
              
            };
        }
        if (module_id == 'post_tour_slider_js_mobile'){
            var posts_per_page = 3;
            var items = {
                            0:{
                                items:1,
                                stagePadding:20,
                                margin:15
                            },
                            550:{
                                items:1,
                                stagePadding:60,
                            },
                            768:{
                                items:2,
                            },
                            981:{
                                items:3,
                            }
            };
            var post_type = 'tour';
            var show_home = true;
            var destination_id = $('#destination_id').val();
        }
        if (module_id == 'departure_month'){
            //var items = 3;
            var posts_per_page = 3;
            var items = {
                            0:{
                                items:1,
                                stagePadding:20,
                                margin:15
                            },
                            550:{
                                items:1,
                                stagePadding:60,
                            },
                            768:{
                                items:2,
                            },
                            981:{
                                items:3,
                            }
            };
            
            var post_type = 'tour';
            var show_home = true;
        }
        if (module_id == 'expert_about_page'){
            var items = 4;
            var post_type = 'expert';
            var show_home = false;

            var items = {
                            0:{
                                items:1,
                                stagePadding:80,
                            },
                            550:{
                                items:2,
                                stagePadding:60,
                            },
                            768:{
                                items:3,
                            },
                            768:{
                                items:4,
                            }
                        };
        };
        if (module_id == 'travel_guide_tour'){
            var items = 3;
            var post_type = 'tour';
            var show_home = false;
            var post_id = $('.post_id').val();
            var items = {
                            0:{
                                items:1,
                                stagePadding:20,
                                margin:15
                            },
                            480:{
                                items:2,
                                stagePadding:30,
                            },
                            768:{
                                items:3,
                            }
                        };
        };
        var data = {
                  'posts_per_page' : posts_per_page,
                  'action':'get_items',
                  'taxonomy': taxonomy,
                  'module_id': module_id,
                  'term': term,
                  'post_type': post_type,
                  'items': items,
                  'show_home': show_home,
                  'destination_id': destination_id,
                  'post_id' : post_id,
                }; 
        // console.log(data);  
        $.post('/wp-admin/admin-ajax.php', data, function(response)
        {
        if( !!response.error && response.error ) {
            // console.log('thất bại');
            $.alert({
                title: 'Alert!',
                content: response.mess,
            });
        }else{
            // console.log('thành công');
            $('#'+module_id).html( response.html );
            if( $('#post_tour_slider_js').length && $( window ).width()>=0 ) {
              $('#post_tour_slider_js .owl-item .clearfix').vjustify();
            } 
            if( $('#post_tour_slider_js').length && $( window ).width()>=0 ) {
               $('#post_tour_slider_js article h2.entry-title').vjustify();
            } 
            if( $('#post_tour_slider_js').length && $( window ).width()>=0 ) {
              $('#post_tour_slider_js .post_content').vjustify();
            }
            if( $('#post_tour_slider_js_mobile').length && $( window ).width()>=0 ) {
                // $('#post_tour_slider_js article').vjustify();
                setTimeout(function() {
                    $('#post_tour_slider_js_mobile article h2.entry-title').height('auto').vjustify();
                    $('#post_tour_slider_js_mobile .post_content').height('auto').vjustify();
                    $('#post_tour_slider_js_mobile article').height('auto').vjustify();
                }, 1e3);
            } 
            if( $('#departure_month').length && $( window ).width()>=0 ) {
                // $('#post_tour_slider_js article').vjustify();
                setTimeout(function() {
                    $('#departure_month article h2.entry-title').height('auto').vjustify();
                    $('#departure_month .post_content').height('auto').vjustify();
                    $('#departure_month article').height('auto').vjustify();
                }, 1e3);
            }
        $('.owl-carousel').owlCarousel({
                    loop:true,
                    margin:20,
                    nav:true,
                    items: items,
                    responsive: items,
                });
            
        }
        }, 'json').fail(function() {
        });
        return false;

    });
    
    // click button show more
    function show_more_posts(){
        $("#btn_show_more_posts").click(function(){
            var args = $("#btn_show_more_posts").data('args');
            var offset = $(".custom_post_show_more").data('offset');
            var module_id = $(".custom_post_show_more").data('id');
            var post_number = $(".custom_post_show_more").data('post_number');
            var step = $("#btn_show_more_posts").data('step');
            var data_fullwidth = $(".custom_post_show_more").data('fullwidth');
            var data = {
              'action':'get_post_show_more',
              'args': args,
              'offset': offset,
              'step': step,
              'module_id' :module_id,
              'post_number':post_number,
              'data_fullwidth' : data_fullwidth,
            }; 
            // console.log(data);  
            $.post('/wp-admin/admin-ajax.php', data, function(response)
            {
            if( !!response.error && response.error ) {
                $.alert({
                    title: 'Alert!',
                    content: response.mess,
                });
            }else{
                $('.show_more_posts').last().html(  response.html);
                if( $('.show_more_posts').length && $( window ).width()>=768 ) {
                    $(".show_more_posts .post_content").vjustify();
                }
                show_more_posts();

            }
            }, 'json').fail(function() {
            });
            return false;
        });
        $("#btn_show_more_posts_blog").click(function(){
            var args = $("#btn_show_more_posts_blog").data('args');
            var offset = $(".custom_post_show_more").data('offset');
            var module_id = $(".custom_post_show_more").data('id');
            var post_number = $(".custom_post_show_more").data('post_number');
            var step = $("#btn_show_more_posts_blog").data('step');
            var data_fullwidth = $(".custom_post_show_more").data('fullwidth');
            var data = {
              'action':'get_post_show_more_blog',
              'args': args,
              'offset': offset,
              'step': step,
              'module_id' :module_id,
              'post_number':post_number,
              'data_fullwidth' : data_fullwidth,
            }; 
            // console.log(data);  
            $.post('/wp-admin/admin-ajax.php', data, function(response)
            {
            if( !!response.error && response.error ) {
                $.alert({
                    title: 'Alert!',
                    content: response.mess,
                });
            }else{
                $('.show_more_posts').last().html(  response.html);
                if( $('.show_more_posts').length && $( window ).width()>=768 ) {
                    $(".show_more_posts .post_content").vjustify();
                }
                show_more_posts();

            }
            }, 'json').fail(function() {
            });
            return false;
        });
    }
    
    show_more_posts();
    $(".other_tour_tab_name").click(function(){

        $('.other_tour_tab_name').not(this).removeClass('active');
        $(this).addClass('active');
        var post_id = $(this).data('post');
        var title = $(this).data('title');
        var data = {
                  'action':'get_another_tour',
                  'post_id': post_id,
                  'title': title,
                }; 
        // console.log(data);  
        $.post('/wp-admin/admin-ajax.php', data, function(response)
        {
        if( !!response.error && response.error ) {
            $.alert({
                title: 'Alert!',
                content: response.mess,
            });
        }else{
            $('.tab_content_tour_info').html(  response.html);
            $(".hotels_in_tour a").removeAttr("href");
        }
        }, 'json').fail(function() {
        });
        return false;

    });
    $(".other_travel_guide_tab_name").click(function(){
        $('.other_travel_guide_tab_name').not(this).removeClass('active');
        $(this).addClass('active');
        var post_id = $(this).data('post');
        var title = $(this).data('title');
        var data = {
                  'action':'get_another_travel',
                  'post_id': post_id,
                  'title': title,
                }; 
                // console.log(data);
        $.post('/wp-admin/admin-ajax.php', data, function(response)
        {
        if( !!response.error && response.error ) {
            $.alert({
                title: 'Alert!',
                content: response.mess,
            });
        }else{
            $('.tab_content_tour_info').html(  response.html);
        }
        }, 'json').fail(function() {
        });
        return false;

    });
    $(".month_select").datepicker({
        dateFormat: "dd/mm/yy",
        changeMonth: true,
        changeYear: true,
        dayNamesMin: [ "SUN", "MON", "TUE", "WED", "THU", "FRI", "SAT" ],
    });
    //$(".month_select").datepicker().datepicker("setDate", new Date());
    $(".month_select").change(function(){
        var month  = $(this).val();
        var adult  = $(".adult_select").val();
        var language = $(".language_select").val();
        var flight = $(".flight_select").val();
        var post_id = $("#form_cuctomize_tour").data('post');
        var data = {
                  'action':'get_customize_price',
                  'post_id': post_id,
                  'month': month,
                  'adult': adult,
                  'language': language,
                  'flight': flight,
                }; 
        // console.log(data);  
        $.post('/wp-admin/admin-ajax.php', data, function(response)
        {
        if( !!response.error && response.error ) {
            alert(response.mess);
        }else{
            $('#per_person').html( response.price_per_person );
            $('#total').html( response.total );
        }
        }, 'json').fail(function() {
        });
        return false;

    });
    // select theo adult
     $(".adult_select").change(function(){
        var month  = $(".month_select").val();
        var adult  = $(this).val();
        var language = $(".language_select").val();
        var flight = $(".flight_select").val();
        var post_id = $("#form_cuctomize_tour").data('post');
        var data = {
                  'action':'get_customize_price',
                  'post_id': post_id,
                  'month': month,
                  'adult': adult,
                  'language': language,
                  'flight': flight,
                }; 
        // console.log(data);  
        $.post('/wp-admin/admin-ajax.php', data, function(response)
        {
        if( !!response.error && response.error ) {
            $.alert({
                title: 'Alert!',
                content: response.mess,
            });
        }else{
            $('#per_person').html( response.price_per_person );
            $('#total').html( response.total );
        }
        }, 'json').fail(function() {
        });
        return false;

    });
    // select theo language
     $(".language_select").change(function(){
        var month  = $(".month_select").val();
        var adult  = $(".adult_select").val();
        var language = $(this).val();
        var flight = $(".flight_select").val();
        var post_id = $("#form_cuctomize_tour").data('post');
        var data = {
                  'action':'get_customize_price',
                  'post_id': post_id,
                  'month': month,
                  'adult': adult,
                  'language': language,
                  'flight': flight,
                }; 
        // console.log(data);  
        $.post('/wp-admin/admin-ajax.php', data, function(response)
        {
        if( !!response.error && response.error ) {
            $.alert({
                title: 'Alert!',
                content: response.mess,
            });
        }else{
            $('#per_person').html( response.price_per_person );
            $('#total').html( response.total );
        }
        }, 'json').fail(function() {
        });
        return false;

    });
    // select theo language
     $(".flight_select").change(function(){
        var month  = $(".month_select").val();
        var adult  = $(".adult_select").val();
        var language = $(".language_select").val();
        var flight = $(this).val();
        var post_id = $("#form_cuctomize_tour").data('post');
        var data = {
                  'action':'get_customize_price',
                  'post_id': post_id,
                  'month': month,
                  'adult': adult,
                  'language': language,
                  'flight': flight,
                }; 
        // console.log(data);  
        $.post('/wp-admin/admin-ajax.php', data, function(response)
        {
        if( !!response.error && response.error ) {
            $.alert({
                title: 'Alert!',
                content: response.mess,
            });
        }else{
            $('#per_person').html( response.price_per_person );
            $('#total').html( response.total );
        }
        }, 'json').fail(function() {
        });
        return false;

    });
    //chon so luong nguoi trong tour customize
    // select theo adult
     $(".adult_sic_select").change(function(){
        var row  = $(this).parent($("#adult")).data('row');
        var adult  = $(this).val();
        $(".btn_submit."+row).addClass('active');
        var date = $(".departing."+row).data('date');
        var post_id = $("#form_sic_tour").data('post');
        var data = {
                  'action':'get_sic_price',
                  'post_id': post_id,
                  'adult': adult,
                  'date': date,
                }; 
        // console.log(data);  
        $.post('/wp-admin/admin-ajax.php', data, function(response)
        {
        if( !!response.error && response.error ) {
            $.alert({
                title: 'Alert!',
                content: response.mess,
            });
        }else{
            $(".total."+row).html( response.total );
        }
        }, 'json').fail(function() {
        });
        return false;
    }); 
    //chon so luong nguoi trong tour customize form contact
    // select theo adult form contact
     $("#et_pb_contact_contact-number-people_1").change(function(){
        var adult  = $(this).val();
        var date = $(".date-from-book").val();
        var post_id = $(".post-id-book").val();
        var data = {
                  'action':'get_sic_price_contact',
                  'post_id': post_id,
                  'adult': adult,
                  'date': date,
                }; 
        // console.log(data);  
        $.post('/wp-admin/admin-ajax.php', data, function(response)
        {
        if( !!response.error && response.error ) {
            $.alert({
                title: 'Alert!',
                content: response.mess,
            });
        }else{
            $(".price-book").html( response.total );
        }
        }, 'json').fail(function() {
        });
        return false;
    }); 
    $("#sic_tour_rate").click(function(){
        var departings_affter  = $('#data').data('departings_affter');
        var post_id  = $('#data').data('post');
        var dem  = $('#data').data('dem');
        var data = {
                  'action':'get_row_sic_rate',
                  'post_id': post_id,
                  'departings_affter': departings_affter,
                  'dem': dem,
                }; 
        // console.log(data);  
        $.post('/wp-admin/admin-ajax.php', data, function(response)
        {
        if( !!response.error && response.error ) {
            $.alert({
                title: 'Alert!',
                content: response.mess,
            });
        }else{
            $("#data").last().html( response);
        }
        }, 'text').fail(function() {
            alert('false');
        });
        return false;

    }); 
  

     $("#contact_form .et_pb_contact_form").validate({
      rules: {
            'et_pb_contact_your_name*_1': "required",
            'et_pb_contact_email_address*_1': {
                                                required: true,
                                                email: true
                                              },
    },
    messages: {
            'et_pb_contact_your_name*_1': check_field,
            'et_pb_contact_email_address*_1': {
                                                required: check_field,
                                                email: check_email
                                              },
        }
    }); 
    $("#contact_form .et_pb_button").click(function(){
        if( $("#contact_form .et_pb_contact_form ").valid() == false ) {
            $('#contact_form .et_pb_contact_field_2').css('top','80px');
            $('#contact_form .et_pb_contact_field_3').css('top','162px');
          return;
        }
    });

    $("#booking_form_home .et_pb_contact_form ").validate({
      rules: {
            'et_pb_contact_name_1': "required",
            'et_pb_contact_email_1': {
                                        required: true,
                                        email: true
                                      },
    },
    messages: {
            'et_pb_contact_name_1': check_field,
            'et_pb_contact_email_1': {
                                        required: check_field,
                                        email: check_email
                                      },
        }
    }); 
       //mundo booking from home
     $("#booking_form_home .et_pb_button").click(function(){
        //alert('sá');
        if( $("#booking_form_home .et_pb_contact_form ").valid() == false ) {
          return;
        }
        // var name =$('#et_pb_contact_name_1 ').val();
        // var add = $('#et_pb_contact_email_1 ').val();
        // if ($.trim(name).length == 0) {
        //     alert('Please enter valid your name');
        //     return false;
        // }
        // if ($.trim(add).length == 0) {
        //     alert('Please enter valid email address');
        //     return false;
        // }
        //if (validateEmail(add)) {
            $("#booking_form_home .et_pb_button").attr('readonly',true);
            var form = $('#booking_form_home .et_pb_contact_form');
            var form_contact = form.serializeArray();
            var form_search_home = $('#form-search-home');
            var form_search_home = form_search_home.serializeArray();
            var data = {
                      'action':'booking_from_home',
                      'form_contact': form_contact,
                      'form_search_home': form_search_home,
                    }; 
            // console.log(data);  
            $.post('/wp-admin/admin-ajax.php', data, function(response)
            {
            if( !!response.error && response.error ) {
                alert (response.mess);
            }else{
                window.location.href = response.href;
            }
            }, 'json').fail(function() {
            });
        // }
        // else {
     //        alert('Invalid Email Address');
     //        return false;
     //    }
        return false;

    }); 
    $("#form_contact_sic_booking .et_pb_contact_form ").validate({
      rules: {
            'et_pb_contact_your_name_1': "required",
            'et_pb_contact_email_address_1': {
                                                required: true,
                                                email: true
                                              },
    },
    messages: {
            'et_pb_contact_your_name_1': check_field,
            'et_pb_contact_email_address_1': {
                                                required: check_field,
                                                email: check_email
                                              },
        }
    }); 
     //mundo booking 
     $("#form_contact_sic_booking .et_pb_button").click(function(){
        if( $("#form_contact_sic_booking .et_pb_contact_form ").valid() == false ) {
          return;
        }
        var form = $('#form_contact_sic_booking .et_pb_contact_form');
        var form_contact = form.serializeArray();
        var form_tour_infor = $('#form_sic_tour');
        var form_tour_infor = form_tour_infor.serializeArray();
        var data = {
                  'action':'booking_sic_tour',
                  'form_contact': form_contact,
                  'form_tour_infor': form_tour_infor,
                }; 
        // console.log(data);  
        $.post('/wp-admin/admin-ajax.php', data, function(response)
        {
        if( !!response.error && response.error ) {
            alert (response.mess);
            //$.alert({
//                title: 'Alert!',
//                content: response.mess,
//            });
        }else{
            window.location.href = response.href;
        }
        }, 'json').fail(function() {
        });
        return false;

    }); 
    //mundo booking 
   function validateEmail(sEmail) {
    var filter = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/;
    if (filter.test(sEmail)) {
        return true;
    }
    else {
        return false;
        }
    }

    $("#form_booking_customize_tour .et_pb_contact_form ").validate({
      rules: {
            'et_pb_contact_your_name_1': "required",
            'et_pb_contact_email_address_1': {
                                                required: true,
                                                email: true
                                              },
    },
    messages: {
            'et_pb_contact_your_name_1': check_field,
            'et_pb_contact_email_address_1': {
                                                required: check_field,
                                                email: check_email
                                              },
        }
    }); 

    
     $("#form_booking_customize_tour .et_pb_button").click(function(){
        if( $("#form_booking_customize_tour .et_pb_contact_form ").valid() == false ) {
          return;
        }
    
     
            var form = $('#form_booking_customize_tour .et_pb_contact_form');
            var form_contact = form.serializeArray();
            var form_tour_infor = $('#form_cuctomize_tour');
            var form_tour_infor = form_tour_infor.serializeArray();
            var post_id  = $('#form_cuctomize_tour').data('post');
            var data = {
                      'action':'booking_customize_tour',
                      'form_contact': form_contact,
                      'form_tour_infor': form_tour_infor,
                    }; 
            // console.log(data);  
            $.post('/wp-admin/admin-ajax.php', data, function(response)
            {
            if( !!response.error && response.error ) {
                $.alert({
                    title: 'Alert!',
                    content: response.mess,
                });
            }else{
                window.location.href = response.href;
            }
            }, 'json').fail(function() {
            });
        


        

        
        return false;

    }); 
     $(".other_tour_tab_name").click(function(){
        $('.other_tour_tab_name').not(this).removeClass('active');
        $(this).addClass('active');
        var post_id = $(this).data('post');
        var title = $(this).data('title');
        var data = {
                  'action':'get_another_tour',
                  'post_id': post_id,
                  'title': title,
                }; 
        // console.log(data);  
        $.post('/wp-admin/admin-ajax.php', data, function(response)
        {
        if( !!response.error && response.error ) {
            $.alert({
                title: 'Alert!',
                content: response.mess,
            });
        }else{
            $('.tab_content_tour_info').html(  response.html);
        }
        }, 'json').fail(function() {
        });
        return false;

    });
    $( window ).load(function() {
        $("#expert_about_page article a").removeAttr("href");
        var menu_width_1 = $('.mundo-add-1').width();
        var menu_width_2 = $('.mundo-add-2 ').width();
        var menu_width_3 = $('.mundo-ft-cate').width();
        var menu_width_4 = $('.mundo-social-ft').width();
        var menu_width = menu_width_1 + menu_width_2 + menu_width_3 + menu_width_4;
        var footer_with = $('.footer-top').width();
        // console.log(footer_with);
      if( $('.footer-top').length && $( window ).width()>=1024 ) {
        //console.log(menu_width);
          var margin_right = (footer_with - menu_width)/4;
          $('.mundo-add-1').css('margin-right',margin_right);
          $('.mundo-add-2').css('margin-right',margin_right);
          $('.mundo-ft-cate').css('margin-right',margin_right);
      }
    });
    if( $('.footer-top').length && $( window ).width()>1024 ) {
        var wrapper_div  = $('.combo-tour-wrapper .et_pb_column_12 ').width();
        var div1 = $('.combo-tour-wrapper .et_pb_text').width(); 
        var div2 = wrapper_div - div1-5;
        $('.combo-tour-wrapper .et_pb_button_module_wrapper').css('width',div2);
    }
    $( "<span class='what-ever-or-content'>"+or_text+"</span>" ).insertAfter( ".what-ever-or" );
    //$( "<hr>" ).insertAfter( ".page-template-default .et_pb_section_4 .et_pb_row_3" );
    $( "<div class='text-left'><hr><div class='clear-both'></div></div>" ).insertAfter( ".highlight .et_pb_bg_layout_dark .et_pb_slide_content" );
    $( "<hr class='hr-about'>" ).insertAfter( ".wrapper_about_info .text-top p" );
    $( "<hr class='hr-whyus'>" ).insertAfter( ".travel-with-confidence h3" );
    $( "<hr class='hr-bloglisst'>" ).insertBefore( ".content-blog-detail h5" );
    $( "<span class='travel-guide-show-more'></span>" ).insertAfter( ".traveller_reviews  .make-enquire" );
    $( "<span class='icon-calendar'></span>" ).insertAfter( ".form-search-travel-style .date_tour" );
    $( "<div class='wrapper-hr-blockquote'><hr class='hr-blockquote'></div>" ).insertBefore( ".vertical_tabs .et_pb_tab_content blockquote" );
    //$( "<div class='wrapper-hr-blockquote'><hr class='hr-blockquote'></div>" ).insertBefore( ".mundo-qoutes blockquote" );
    $( "<span class='cookies-click'>"+by_click+"</span>" ).insertAfter( ".ctcc-left-side" );
    //single tour mũi tên
    $( "<span class='mui-ten-xuong'></span>" ).insertAfter( " .language_select" );
    $( "<span class='mui-ten-xuong'></span>" ).insertAfter( " .adult_select" );
    $( "<span class='mui-ten-xuong'></span>" ).insertAfter( " .flight_select" );
    $( "<span class='mui-ten-xuong'></span>" ).insertAfter( " .month_select" );
    $( window ).scroll( function () {
    if ( $( this ).scrollTop() > 600 ) {
      $('.navbar').css({position: "fixed", top: 0});
    } 
    else {
      $('.navbar').css({position: "relative", top: 0});
    }
    });
    //js scroll
    $('.scroll-to-div a').click(function() {
      var scroll_to_div = '#'+$(this).attr('scroll-to');
      $('html, body').animate({
        scrollTop: $(scroll_to_div).offset().top-88
      }, 1000)
    });
     
})

//$(window).on('load resize', function() {
$(window).on('load', function() {
    $('.et_fullscreen_slider').each(function() {
        et_fullscreen_slider($(this));
    });
});
function et_fullscreen_slider(et_slider) {
    var et_viewport_height = $(window).height(),
        et_slider_height = $(et_slider).find('.et_pb_slider_container_inner').innerHeight(),
        $admin_bar = $('#wpadminbar'),
        $main_header = $('#main-header'),
        $top_header = $('#top-header');
    $(et_slider).height('auto');
    if ($admin_bar.length) {
        var et_viewport_height = et_viewport_height - $admin_bar.height();
    }
    if ($top_header.length) {
        var et_viewport_height = et_viewport_height - $top_header.height();
    }
    if (!$('.et_transparent_nav').length && !$('.et_vertical_nav').length) {
        var et_viewport_height = et_viewport_height - $main_header.height();
    }
    if (et_viewport_height > et_slider_height) {
        $(et_slider).height(et_viewport_height);
    }
}    
jQuery(function($){
    $('.faq-mundo .et_pb_accordion .et_pb_toggle_open').addClass('et_pb_toggle_close').removeClass('et_pb_toggle_open');

    $('.faq-mundo .et_pb_accordion .et_pb_toggle').click(function() {
      $this = $(this);
      setTimeout(function(){
         $this.closest('.faq-mundo .et_pb_accordion').removeClass('et_pb_accordion_toggling');
      },700);
    });
    $('.single-toggle-mundo .et_pb_accordion .et_pb_toggle_open').addClass('et_pb_toggle_close').removeClass('et_pb_toggle_open');

    $('.single-toggle-mundo .et_pb_accordion .et_pb_toggle').click(function() {
      $this = $(this);
      setTimeout(function(){
         $this.closest('.single-toggle-mundo .et_pb_accordion').removeClass('et_pb_accordion_toggling');
      },700);
    });

    var name_input = $('#et_pb_contact_your_name_1').attr('placeholder');
    //$( "#et_pb_contact_your_name_1" ).insertAfter( '<label >' +name_input +'</label>');
    
});
