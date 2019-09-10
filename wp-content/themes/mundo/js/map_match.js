var map;
var array1 = [ ['23.634501, -102.552783', '17.987557, -92.929147'], ['17.987557, -92.929147', '21.177778, -77.291417'], ['21.177778, -77.291417', '13.993333, -84.478395'],['13.993333, -84.478395','23.634501, -102.552783'] ];
//var json_location;
//var json_location = <?php echo json_encode($location_tour_map) ?>;


function init(array1) {
    //var startLatLng = new google.maps.LatLng(23.634501, -102.552783);
    map = new google.maps.Map(document.getElementById('map-canvas'), {
        //center: startLatLng,
        //zoom: 12
    });
    // setZoom(zoom:1)
    //add style gray scale and markin color
    var styles = [
	{ stylers: [{ saturation: -100}] }, { featureType: "landscape", stylers: [{ visibility: "off"}] }, { featureType: "poi", stylers: [{ visibility: "off"}] }, { featureType: "road", stylers: [{ visibility: "on"}] }, { stylers: [{ lightness: 20}] }
	];
	var styledMapType = new google.maps.StyledMapType(styles,
	{ name: 'Styled Map' });
	map.mapTypes.set('styled_maps', styledMapType);
	map.setMapTypeId('styled_maps');

    var i = 0;
    var bounds = new google.maps.LatLngBounds();
    array1.forEach(function(items,index) {
        //console.log(items);
        // bien1 =  items.location_first.split(",").map(Number);
        // bien2 =  items.location_last.split(",").map(Number);
        //Tạo ra các tọa dộ cho gg map nhận định
        bien1 =  items[0]['id'].split(",").map(Number);
        bien2 =  items[1]['id'].split(",").map(Number);
        var p1 = new google.maps.LatLng(parseFloat(bien1[0]),parseFloat(bien1[1]));
        var p2 = new google.maps.LatLng(parseFloat(bien2[0]),parseFloat(bien2[1]));

	    //End add infor window
        //Tại các marker đánh dấu
        
        bounds.extend(p1);
        bounds.extend(p2);
        // map.fitBounds(bounds);

        var markerP1 = new google.maps.Marker({
            position: p1,
            map: map,
            zIndex: 9000 ,
        });
        var markerP2 = new google.maps.Marker({
            position: p2,
            map: map,
            zIndex: 9000 ,
        });
        var line_cur = parseFloat(items['curvature']);
        if(line_cur){
            line_cur = line_cur;
        }else{
            line_cur = 1;
        }
        //Tạo các đường line chỉ đường
        google.maps.event.addListener(map, 'projection_changed', function () {
            var p1 = map.getProjection().fromLatLngToPoint(markerP1.getPosition());
            var p2 = map.getProjection().fromLatLngToPoint(markerP2.getPosition());
            var e = new google.maps.Point(p1.x - p2.x, p1.y - p2.y);
            var m = new google.maps.Point(e.x / 2, e.y / 2);
            var o = new google.maps.Point(0, line_cur );// chỉnh độ võng của line
            var c = new google.maps.Point(m.x + o.x, m.y + o.y);
            var curveMarker2 = new google.maps.Marker({
                position: markerP1.getPosition(),
                icon: {
                    path: "M 0 0 q " + c.x + " " + c.y + " " + e.x + " " + e.y,
                    scale: 24,
                    strokeWeight: 2,
                    fillColor: '#009933',
                    fillOpacity: 0,
                    rotation: 180,
                    zIndex: -1 ,
                    zoom: 1,
                    anchor: new google.maps.Point(0, 0)
                }
            });
            curveMarker2.setMap(map);
            google.maps.event.addListener(map, 'zoom_changed', function () {
                var zoom = map.getZoom();
                var scale = 1 / (Math.pow(2, -zoom));
                var icon = {
                    path: "M 0 0 q " + c.x + " " + c.y + " " + e.x + " " + e.y,
                    scale: scale,
                    strokeWeight: 2,
                    fillColor: '#009933',
                    fillOpacity: 0,
                    rotation: 180,
                    zIndex: -1 ,
                    anchor: new google.maps.Point(0, 0)
                };
                curveMarker2.setIcon(icon);
            });
            3
        });i++;
        //Tạo ra các infor box
        var infowindow1 = new InfoBox({
        shadowStyle: 1,
        padding: 5,
        borderRadius: 4,
        arrowSize: 10,
        borderWidth: 1,
        disableAutoPan: false,
        hideCloseButton: true,
        arrowPosition: 30,
        boxStyle: 'infoBox',
        arrowStyle: 2,
        zIndex: 1000 ,
        infoBoxClearance: new google.maps.Size(1, 1)
        });
        var description1 = items[0]['description'];
        var image_src1 = items[0]['image'];
        if (image_src1) {
            var image1 = '<img src="'+image_src1+'">';
        }else{
            var image1 = '';
        }
        //console.log(image1);
        google.maps.event.addListener(markerP1, 'click', function () {
            infowindow1.setContent('<div class="mapInfo">'+image1+'<br>'+description1+'</div>');
            infowindow1.open(map, markerP1);
        });
         var description2 = items[1]['description'];
        var image_src2 = items[1]['image'];
        var image2 = '<img src="'+image_src2+'">';
        google.maps.event.addListener(markerP2, 'click', function () {
            infowindow1.setContent('<div class="mapInfo">'+image2+'<br>'+description2+'</div>');
            infowindow1.open(map, markerP2);
        });
    }); 
    map.fitBounds(bounds);
}
if (typeof json_location == 'object') {
    google.maps.event.addDomListener(window, 'load', init(json_location));
}


// function InitializeMap_gray()
// {   var map2
//     map2 = new google.maps.Map(document.getElementById('map-travel'), {
//         zoom: 12
//     });
//     var styles = [
//     { stylers: [{ saturation: -100}] }, { featureType: "landscape", stylers: [{ visibility: "off"}] }, { featureType: "poi", stylers: [{ visibility: "off"}] }, { featureType: "road", stylers: [{ visibility: "on"}] }, { stylers: [{ lightness: 20}] }
//     ];
//     var styledMapType = new google.maps.StyledMapType(styles,
//     { name: 'Styled Map' });
//     map2.mapTypes.set('styled_maps', styledMapType);
//     map2.setMapTypeId('styled_maps');
// }
// jQuery('#gray-sacle-map').ready(function ($) {
//     InitializeMap_gray();
// });
// google.maps.event.addDomListener(window, 'load', InitializeMap_gray());