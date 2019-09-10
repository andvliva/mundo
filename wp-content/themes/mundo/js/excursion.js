jQuery(document).ready(function($) {
    "use strict";
    var excursion_func = function( ele ) {
        var form = ele.closest('form'), form_data = form.serializeArray();
        
        if( ele.hasClass('book_now') ) {
            form_data.push({name: 'trigger_name', value: 'book_now'});
        }

        $.post( excursion_ajaxurl, form_data, function(res) {

            if( res.error ) {
                //alert(res.mess);
            }
            if( 'price_info' in res ) {
                $('.row.'+res.tab+' .price-info').html( res.price_info );
            }
            if( 'price_detail' in res ) {
                $('.price-detail', form).html( res.price_detail );
            }
            if( 'total_price' in res ) {
                $('.price-total', form).html( res.total_price );
            }
            if( 'total_price_checkout' in res ) {
                $('.total-checkout', form).html( res.total_price_checkout );
            }
            if( 'href' in res ) {
                window.location.href = res.href;
            }
        }, 'json' );
    };
    
    if( $('.price-box-form input[name="check_in_date"]').length ) {
        $('.price-box-form input[name="check_in_date"]').each(function() {
            excursion_func( $(this) );
        });
    }
    
    if( $( ".price-datepicker.group" ).length ) {
        $( ".price-datepicker.group" ).datepicker({
            changeMonth: true,
            changeYear: true,
            beforeShowDay: function(date) {
                var string = jQuery.datepicker.formatDate('yy-mm-dd', date);
                if( full_date_group.length && full_date_group.indexOf(string) != -1 ) {
                    return [ false, 'full-book', 'This day is fully booked!' ];
                }

                var day_num = date.getDay();
                if( day_enable_group.length && day_enable_group.indexOf(day_num) == -1 ) {
                    return [ false, 'disable-date', 'This day is fully booked!' ];
                }
                
                return [true, '', ''];
            },
            minDate: 1,
            maxDate: ( max_date_group != '' ? new Date(max_date_group) : null),
            gotoCurrent: true,
            dateFormat: "yy-mm-dd",
            onSelect: function( dateText, inst ) {
                var departure_date = $.datepicker.formatDate( "DD dd MM yy", new Date( dateText ) );
                var input = $(inst.input).siblings('input[name="check_in_date"]');
                input.val( dateText );
                input.closest('form').find('.departure-date').text( departure_date );
                
                excursion_func(input);
            }
        });
        if( group_min_date && group_min_date != '' ) {
            $( ".price-datepicker.group" ).datepicker( "setDate", new Date(group_min_date) );
        }
    }

    if( $( ".price-datepicker.private" ).length ) {
        $( ".price-datepicker.private" ).datepicker({
            changeMonth: true,
            changeYear: true,
            beforeShowDay: function(date) {
                var string = jQuery.datepicker.formatDate('yy-mm-dd', date);
                if( full_date_private.length && full_date_private.indexOf(string) != -1 ) {
                    return [ false, 'full-book', 'This day is fully booked!' ];
                }

                var day_num = date.getDay();
                if( day_enable_private.length && day_enable_private.indexOf(day_num) == -1 ) {
                    return [ false, 'disable-date', 'This day is fully booked!' ];
                }
    
                return [true, '', ''];
            },
            minDate: 1,
            maxDate: ( max_date_private != '' ? new Date(max_date_private) : null),
            gotoCurrent: true,
            dateFormat: "yy-mm-dd",
            onSelect: function( dateText, inst ) {
                var departure_date = $.datepicker.formatDate( "DD dd MM yy", new Date( dateText ) );
                var input = $(inst.input).siblings('input[name="check_in_date"]');
                input.val( dateText );
                input.closest('form').find('.departure-date').text( departure_date );
                
                excursion_func(input);
            }
        });
        if( private_min_date && private_min_date != '' ) {
            $( ".price-datepicker.private" ).datepicker( "setDate", new Date(private_min_date) );
        }
    }

    if( $( ".price-datepicker.checkout" ).length ) {
        $( ".price-datepicker.checkout" ).datepicker({
            changeMonth: true,
            changeYear: true,
            beforeShowDay: function(date) {
                var day_num = date.getDay();
                if( day_enable.indexOf(day_num) == -1 ) {
                    return [ false, 'disable-date', 'This day is fully booked!' ];
                }
    
                var string = jQuery.datepicker.formatDate('yy-mm-dd', date);
                if( full_date.indexOf(string) != -1 ) {
                    return [ false, 'full-book', 'This day is fully booked!' ];
                }
                return [true, '', ''];
            },
            minDate: 1,
            maxDate: ( max_date != '' ? new Date(max_date) : null),
            gotoCurrent: true,
            dateFormat: "yy-mm-dd",
            onSelect: function( dateText, inst ) {
                var departure_date = $.datepicker.formatDate( "DD dd MM yy", new Date( dateText ) );
                var input = $(inst.input).siblings('input[name="check_in_date"]');
                input.val( dateText );
                input.closest('form').find('.departure-date').text( departure_date );
                
                excursion_func(input);
            }
        });
    }
    
    $('.participants.dropdown').on('hide.bs.dropdown', function () {
        //console.log( $(this).closest('form') );
        excursion_func($(this));
    });

    $('.participants-input').on('click', '.btn-minus, .btn-plus', function(e) {
        var input = $(this).siblings('input');
        var so_luong = input.val();
        var tab = $(this).parents('form').find('input[name="tab"]').val();
        
        so_luong = parseInt( so_luong );
        if( isNaN(so_luong) ) {
            so_luong = 0;
        }
        
        if( $(this).hasClass('btn-minus') ) {
            if( so_luong > 0 ) {
                so_luong--;
            }
        }
        else {
            so_luong++;
        }
        if( input.attr('name') == 'adult' ) {
            if( tab == 'group' && so_luong < 2 ) {
                so_luong = 2;
            }
            if( tab == 'private' && so_luong == 0 ) {
                so_luong = 1;
            }
        }

        input.val( so_luong ).trigger('change');
        return false;
    });
    
    $('.participants-input').on('change', 'input', function(e) {

        var form = $(this).closest('form');
        var val = $(this).val();
        var name = $(this).attr('name');
        //console.log(val + name);
        if( val == '0' ) {
            $('.participants-info .p'+name, form).hide();
            $('.participants-info .p'+name+' span', form).text( val );
        }
        else {
            $('.participants-info .p'+name, form).show();
            $('.participants-info .p'+name+' span', form).text( val );
        }
        
        //excursion_func($(this));
    });

    $('.price-box-form').on('click', '.book_now', function(e) {

        excursion_func( $(this) );
    });
    function validateEmail(sEmail) {
    var filter = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/;
    if (filter.test(sEmail)) {
        return true;
    }
    else {
        return false;
        }
    }
    $(".exc-checkout-form ").validate({
      rules: {
            'full_name': "required",
            'email': {
                        required: true,
                        email: true
                      },
    },
    messages: {
            'full_name': check_field,
            'email': {
                        required: check_field,
                        email: check_email
                      },
        }
    });
    $('.exc-checkout-form').on('click', '.book_now', function(e) {
        if( $(".exc-checkout-form ").valid() == false ) {
          return;
        }        
        excursion_func( $(this) );
        
    });
});

jQuery(document).ready(function($) {
    var showChar = 250;  
    var ellipsestext = "...";
    var moretext = "<div class='travel-guide-readmore'>"+read_more+"</div>";
    var lesstext = "<div class='travel-guide-readmore'>"+read_more+"</div>";
    
     $('.tab-travel-guide-ex .et_pb_toggle_content').each(function() {
        var content = $(this).html();
        if(content.length > showChar) {
            var c = content.substr(0, showChar);
            var h = content.substr(showChar, content.length - showChar);
            var html = c + '<span class="moreellipses">' + ellipsestext+ '&nbsp;</span>'+
            '<span class="morecontent"><span>' + h + 
            '</span>&nbsp;&nbsp;<a href="" class="morelink">' + moretext + '</a></span>';
            $(this).html(html);
        }
    });
    $(".morelink").click(function(){
        if($(this).hasClass("less")) {
            $(this).removeClass("less");
            $(this).html(moretext);
        } else {
            $(this).addClass("less");
            $(this).html(lesstext);
        }
        $(this).parent().prev().toggle();
        $(this).prev().toggle();
        return false;
    });
    $('.show-more-review-excursion').click(function(){
        postison_first = $(this).data('number-record');
        var postison_1 = parseInt(postison_first)+parseInt(1);
        var postison_2 = parseInt(postison_first)+parseInt(2);
        $("div.review-none:nth-child("+postison_1+")").removeClass('review-none');
        $("div.review-none:nth-child("+postison_2+")").removeClass('review-none');
        new_record = parseInt(postison_first)+parseInt(2);
        $(this).data('number-record',new_record) ;
        if( $('.review-none').length  <= 0 ) {
            $('.show-more-review-excursion').remove();
        }
    });

    $('.show-more-review-excursion-private').click(function(){
            postison_first = $(this).data('number-record');
            var postison_1 = parseInt(postison_first)+parseInt(1);
            var postison_2 = parseInt(postison_first)+parseInt(2);
            $("div.review-none-private:nth-child("+postison_1+")").removeClass('review-none-private');
            $("div.review-none-private:nth-child("+postison_2+")").removeClass('review-none-private');
            new_record = parseInt(postison_first)+parseInt(2);
            $(this).data('number-record',new_record) ;
            if( $('.review-none-private').length  <= 0 ) {
                $('.show-more-review-excursion-private').remove();
            }
    });
    $('.excursion-private-detail').click(function(){
        $(".show_group_rate").css("display", "none");
        $(".show_private_rate").css("display", "block");
    });
    $('.excursion-group-detail').click(function(){
        $(".show_group_rate").css("display", "block");
        $(".show_private_rate").css("display", "none");
    });
    
});