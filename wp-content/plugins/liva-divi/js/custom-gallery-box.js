 function extendMagnificIframe(){

    var $start = 0;
    var $iframe = {
        markup: '<div class="mfp-figure video-gallery">'+
                '<div class="mfp-iframe-scaler">' +
                '<div class="mfp-close">close</div>' +
                '<iframe class="mfp-iframe" frameborder="0" allowfullscreen></iframe>' +
                '</div>' +
                '<div class="mfp-bottom-bar">'+
                  '<div class="mfp-title"></div>'+
                  '<div class="mfp-counter"></div>'+
                '</div>'+
                 '</div>',
        // callbacks: {
        //     markupParse: function(template, values, item) {
        //      values.title = item.el.attr('title');
        //     }
        //   },
         patterns: {
                youtube: {
                    index: 'youtube.com/',
                    id: function (url) { return url },
                    src: '%id%'
                },
                vimeo: {
                    index: 'vimeo.com/',
                    id: function (url) { return url },
                    src: '%id%'
                }
            }
    };

    return $iframe;     

}
var iframeif = extendMagnificIframe();
console.log(iframeif);
// $(".gallery-item a'").click(function(){
//     var title_image = $('.mfp-figure img').attr("alt");
//     alert(title_image);
// })
function extendMagnificImage(){
    var title_image = $('.mfp-figure img').attr("alt");
    var title_image = 'hihi';
    var $image_code ={
        tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
        titleSrc: function(title_image) {
                  return title_image;
                },
        verticalFit: true,
    };
    return $image_code;
}
$('.gallery-image-box').magnificPopup(
        {
            delegate: 'a',
            type: 'image',
            iframe : extendMagnificIframe(),
            verticalFit: true,
            tLoading: 'Loading image #%curr%...',
            mainClass: 'mfp-img-mobile',
            gallery: {
                enabled: true,
                navigateByImgClick: true,
                preload: [0,1] // Will preload 0 - before current, and 1 after the current image
            },
            image: {
                tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
                titleSrc: function(item) {
                    var test = item.else;
                          return item.el.attr('title')
                        },
                verticalFit: true,
            }
           
        }
);

