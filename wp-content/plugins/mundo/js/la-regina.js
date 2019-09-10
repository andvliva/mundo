jQuery(document).ready(function($) {
    if( typeof defaultSettings == 'object' && 'box' in defaultSettings ) {
        defaultSettings.box.type.options = "title_overview|subtitle|info|warning|download|bio|shadow";
        defaultSettings.box.type.defaultvalue = 'title_overview';
        defaultSettings.button.color.options = "la-regina|blue|lightblue|teal|silver|black|pink|purple|orange|green|red";
        defaultSettings.button.color.defaultvalue = 'la-regina';
    }
});