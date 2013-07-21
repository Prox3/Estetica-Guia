
	function home_map_go(options){
		//this.setOptions(this.getOptions(), options); 
        
        // set ajax search vars
       
        var pscaleFactor;
        var pstartmin;
		var gtbaseurl  = this.options.gtbaseurl;
		var token  = this.options.token;
		var search_string = this.options.token;
		var mm = 0; // marker array
		var maptype = this.options.maptype;
		var zoom = this.options.zoom;
		var latitude = this.options.latitude;
		var longitude = this.options.longitude;
		var maxZoom = this.options.maxZoom;
		var etype = this.options.etype;
		var autozoom =  this.options.autozoom;
		var scrollzoom =  this.options.scrollzoom;
		var streetview =  this.options.streetview;
		var post_ids =  this.options.post_ids;
		var cat_id =  this.options.cat_id;
		var bubble_size =  this.options.bubble_size;
		
		
		
        // valid maptypes for v3 are: 
        // HYBRID      This map type displays a transparent layer of major streets on satellite images.
		// ROADMAP     This map type displays a normal street map.
		// SATELLITE   This map type displays satellite images.
		// TERRAIN     This map type displays maps with physical features such as terrain and vegetation.
		
        var maptype = eval('google.maps.MapTypeId.' + maptype);
        if(autozoom=='Yes'){
		var mapoptions = {
			scrollwheel: scrollzoom,
			zoom: zoom,
			mapTypeControl: true,
    		mapTypeControlOptions: {style: google.maps.MapTypeControlStyle.DEFAULT},
    		navigationControl: true,
    		navigationControlOptions: {style: google.maps.NavigationControlStyle.DEFAULT},
    		streetViewControl: streetview, 
    		mapTypeId: maptype,
    		sensor: 'false'
		}}else{
			var mapoptions = {
			scrollwheel: scrollzoom,
			zoom: zoom,
			mapTypeControl: true,
    		mapTypeControlOptions: {style: google.maps.MapTypeControlStyle.DEFAULT},
    		navigationControl: true,
    		navigationControlOptions: {style: google.maps.NavigationControlStyle.DEFAULT},
    		streetViewControl: streetview, 
    		mapTypeId: maptype,
			center: new google.maps.LatLng(latitude,longitude),
    		sensor: 'false'
		}}

        // create the map
        var map = new google.maps.Map(document.getElementById("advmap_canvas"),mapoptions);
        var markerArray = [];
		var markerIDArray = [];
        var infowindow = new google.maps.InfoWindow();



var pinkParksStyles = [
{
         featureType: "poi.business",
         elementType: "labels",
         stylers: [
           { visibility: "off" }
         ]
       }
];

map.setOptions({styles: pinkParksStyles});
        // set max zoom
        google.maps.event.addListenerOnce(map, 'idle', function(){
            for(var i in google.maps.MapTypeId){
                map.mapTypes[google.maps.MapTypeId[i]].maxZoom = options.maxZoom;
            }
        });

/////////////////////////////////////////////////////////////////////////////
        var maxMap = document.getElementById( 'triggermap' );
		google.maps.event.addDomListener(maxMap, 'click', showAlert);
		
		function showAlert() {
       // window.alert('DIV clicked');
		jQuery('#advmap_canvas').toggleClass('map-fullscreen');
		jQuery('.map_category').toggleClass('map_category_fullscreen');
		jQuery('#trigger').toggleClass('map_category_trigger_fullscreen');
		jQuery('body').toggleClass('body_fullscreen');
		jQuery('#loading_div').toggleClass('loading_div_fullscreen');
		jQuery('#advmap_nofound').toggleClass('nofound_fullscreen');
		jQuery('#triggermap').toggleClass('triggermap_fullscreen');
		jQuery('.TopLeft').toggleClass('TopLeft_fullscreen');

		//var darwin = new google.maps.LatLng(-12.461334, 130.841904);
 			 //map.setCenter(darwin);
			 window.setTimeout(function() { 
var center = map.getCenter(); 
google.maps.event.trigger(map, 'resize'); 
map.setCenter(center); 
        }, 100);
      }
////////////////////////////////////////////////////////////////////////////////
		       
       

        ajaxSearch = function(){
           document.getElementById('loading_div').style.display="block";
            
           
            var ptype           = new Array(),
            search_string   = '',
            stype           = ''
        
           
           
			

          
		  
if(post_ids){
	var myurl = gtbaseurl+"/?ptype=get_markers&stype=post&cat_id="+cat_id+"&post_id="+post_ids+"&search="+search_string+"&etype="+etype;
	}else{
		     
			search_string = (document.slider_search.search_string.value != langText['inputText']) ? document.slider_search.search_string.value : '';

            //loop through available categories
            ptype = document.getElementsByName("ptype[]");
            var checked = "";
            for(i = 0; i < ptype.length; i++){
                if(ptype[i].checked){
                    checked += ptype[i].value+",";
                }
            }
            var strLen = checked.length;
            checked    = checked.slice(0,strLen-1);

var myurl = gtbaseurl+"/?ptype=get_markers&stype=cat&cat_id="+checked+"&search="+search_string+"&etype="+etype;
}



           //alert(myurl);
			
			jQuery.ajax({
					   type: "GET",
					   url: myurl,
					   success: function(msg){
						 
						 document.getElementById('loading_div').style.display="none";
							readMap( msg );
					   }
					 });
			
			 return;
        }



       
             

        //populate property table with listing rows returned
        function listProperties(input) {
            var totalcount = input[0].totalcount;
            
			document.getElementById("advmap_counter").innerHTML = totalcount;
          
           
			mm =0;
            if(totalcount > 0){
                for (var i = 0; i < input.length; i++) {
                    
					var marker = createMarker(input[i]);
                    var url = input[i].proplink;
                    
                   
                       
                }
            }
            
        }

 

        // create the marker and set up the event window
        function createMarker(input) {
			var title = input.formattedprice.replace("&quot;", '"'); // replace quotes 
            if(input.lat_pos && input.long_pos){
                var coord = new google.maps.LatLng(input.lat_pos,input.long_pos);
                var marker  = new google.maps.Marker({
                	position: coord,
                	title: title,
                	visible: true,
                	clickable: true,
                	map: map,
                	icon: input.icon
                });
                
                bounds.extend(coord);
                
				// push the new marker into the marker array so we can remove later
				markerIDArray[input.id] = marker;
				
				markerArray[mm] = marker;
				mm++;
								//alert(mm);


                // Adding a click event to the marker
				google.maps.event.addListener(marker, 'click', function() {
																
						//var marker_url = "info2.html"+input.id; // url to get 
						if(bubble_size){
			var marker_url = gtbaseurl+"/?ptype=get_markers&stype=s&m_id="+input.id+"&small=1"; // url to get
						}else{
			var marker_url = gtbaseurl+"/?ptype=get_markers&stype=s&m_id="+input.id; // url to get 
						}
            //alert(input.id);
			var  loading = '<div id="map_loading"></div>';
               infowindow.open(map, marker);
				infowindow.setContent(loading);
			jQuery.ajax({
					   type: "GET",
					   url: marker_url,
					   cache: false,
					   dataType: "html",
					   error: function(xhr, error){
						 alert(error);
					   },
					   success: function(response){
						infowindow.setContent(response);
						infowindow.open(map, marker);
					   }
					 });
			
			 return;
				
				});
                return true;
            }else{
                //no lat & long, return no marker
                return false;
            }
        }

        openMarker = function(id){
			google.maps.event.trigger( markerIDArray[id], 'click' );
        }
		
		
        
		// Deletes all markers in the array by removing references to them
		function deleteMarkers() {
			//alert(markerArray.length );
		  if (markerArray && markerArray.length > 0) {
			for (i in markerArray) {
				if (!isNaN(i)){
					//alert(i);
					markerArray[i].setMap(null);
                    infowindow.close(map, markerArray[i]);
				}
			}
			markerArray.length = 0;
		  }
		}
				
        // read the data, create markers
        function readMap(data) {
			
			// get the bounds of the map
            bounds = new google.maps.LatLngBounds();
            
            // clear old markers
            deleteMarkers();

            //json evaluate returned data
            jsonData = jQuery.parseJSON(data);
            
            // create the info window
			infowindow = new google.maps.InfoWindow();
            // if no markers found, display advmap_nofound div with no search criteria met message
            if (jsonData[0].totalcount <= 0) {
                document.getElementById('advmap_nofound').style.display = 'block';
                var mapcenter = new google.maps.LatLng(latitude,longitude);
			    listProperties(jsonData);
                map.setCenter(mapcenter);
                map.setZoom(zoom);
            }else{
               document.getElementById('advmap_nofound').style.display = 'none';
			   	var mapcenter = new google.maps.LatLng(latitude,longitude);
                listProperties(jsonData);
                if(autozoom=='Yes'){map.fitBounds(bounds);}
				var center = bounds.getCenter();
                if(autozoom=='Yes'){map.setCenter(center);}//else{map.setCenter(mapcenter);}
                if ( map.getZoom() > maxZoom ){
					map.setZoom(maxZoom);
				}
            }
        }

        //prevent form submission by enter key
        function stopRKey(evt) {
           var evt = (evt) ? evt : ((event) ? event : null);
           var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null);
           if ((evt.keyCode == 13) && (node.type=="text")) {return false;}
        }

        function addSlashes(str) {
            str=str.replace(/\"/g,'\'');
            str=str.replace(/\\/g,'\\\\');
            str=str.replace(/\'/g,'\\\'');
            str=str.replace(/\"/g,'\\"');
            str=str.replace(/\0/g,'\\0');
            return str;
        }
        
		  //START the aearch
        function start_search(options) 
		{		
			this.options = options;
  
			//limitReset(); // limit results, we might not want this
			ajaxSearch();
        } 
        start_search(options); 
        document.onkeypress = stopRKey;

        tooltip = function(){
            var id = 'tt';
            var top = 3;
            var left = 3;
            var maxw = 300;
            var speed = 10;
            var timer = 20;
            var endalpha = 95;
            var alpha = 0;
            var tt,t,c,b,h;
            var ie = document.all ? true : false;
            return{
                show:function(v,w){
                    if(tt == null){
                        tt = document.createElement('div');
                        tt.setAttribute('id',id);
                        t = document.createElement('div');
                        t.setAttribute('id',id + 'top');
                        c = document.createElement('div');
                        c.setAttribute('id',id + 'cont');
                        b = document.createElement('div');
                        b.setAttribute('id',id + 'bot');
                        tt.appendChild(t);
                        tt.appendChild(c);
                        tt.appendChild(b);
                        document.body.appendChild(tt);
                        tt.style.opacity = 0;
                        tt.style.filter = 'alpha(opacity=0)';
                        document.onmousemove = this.pos;
                    }
                    tt.style.display = 'block';
                    c.innerHTML = v;
                    tt.style.width = w ? w + 'px' : 'auto';
                    if(!w && ie){
                        t.style.display = 'none';
                        b.style.display = 'none';
                        tt.style.width = tt.offsetWidth;
                        t.style.display = 'block';
                        b.style.display = 'block';
                    }
                    if(tt.offsetWidth > maxw){tt.style.width = maxw + 'px'}
                    h = parseInt(tt.offsetHeight) + top;
                    clearInterval(tt.timer);
                    tt.timer = setInterval(function(){tooltip.fade(1)},timer);
                },
                pos:function(e){
                    var u = ie ? event.clientY + document.documentElement.scrollTop : e.pageY;
                    var l = ie ? event.clientX + document.documentElement.scrollLeft : e.pageX;
                    tt.style.top = (u - h) + 'px';
                    tt.style.left = (l + left) + 'px';
                },
                fade:function(d){
                    var a = alpha;
                    if((a != endalpha && d == 1) || (a != 0 && d == -1)){
                        var i = speed;
                        if(endalpha - a < speed && d == 1){
                            i = endalpha - a;
                        }else if(alpha < speed && d == -1){
                            i = a;
                        }
                        alpha = a + (i * d);
                        tt.style.opacity = alpha * .01;
                        tt.style.filter = 'alpha(opacity=' + alpha + ')';
                    }else{
                        clearInterval(tt.timer);
                        if(d == -1){tt.style.display = 'none'}
                    }
                },
                hide:function(){
                    clearInterval(tt.timer);
                    tt.timer = setInterval(function(){tooltip.fade(-1)},timer);
                }
            };
        }();
    }


/*************************************************************/
