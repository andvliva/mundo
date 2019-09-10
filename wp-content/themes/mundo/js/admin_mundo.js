function change_lang(){
    $ = jQuery;
    var lang = $("#post_lang_choice").val();
    console.log(lang);
    $(".tour_guide").attr("checked", false);
    if(lang == 'en' && $(".tour_guide").length){
        $("input[value*='71']").attr("checked", true);
    }   
    else if(lang == 'es'){
        $("input[value*='70']").attr("checked", true);
    } 
    else if(lang == 'pt'){
        $("input[value*='72']").attr("checked", true);
    } 
};
jQuery(document).ready(function($){ 
    //tour name 
    $('#tour_name, #tour_name_customize').change(function(){
        var tour_id = $(this).val();
        var data = {
                  'action':'admin_get_tour_name',
                  'tour_id': tour_id,
                }; 
        console.log(data);  
        $.post('/wp-admin/admin-ajax.php', data, function(response)
        {
        if( !!response.error && response.error ) {
            $.alert({
                title: 'Alert!',
                content: response.mess,
            });
        }else{
           // alert(response.html);
           $('#title-prompt-text').remove();
            $('#title').val(response.html);
        }
        }, 'json').fail(function() {
        });
        return false;
    })
    // multiple cho trường visited
    if($("#tour_highlight, #destination, #hotel, #restaurant, #blog, select.rwmb-select_advanced").length){
        $("select").select2();   
        $("select").on("select2:select", function (evt) {
          var element = evt.params.data.element;
          var $element = $(element);
          
          $element.detach();
          $(this).append($element);
          $(this).trigger("change");
        });
    }
     //thay đổi tour guide theo ngôn ngữ
     $("#post_lang_choice").change(function(){
        setTimeout(function() {
            change_lang();
        }, 2e3);
     });
    
});
