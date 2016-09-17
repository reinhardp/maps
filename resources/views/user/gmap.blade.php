@extends('layouts.app')
@section('content')
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/knockout/3.3.0/knockout-min.js"></script>
    <style>
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
      #map {
        height: 100%;
      }
      .controls {
        margin-top: 10px;
        border: 1px solid transparent;
        border-radius: 2px 0 0 2px;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
        height: 32px;
        outline: none;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
      }

      #pac-input {
        background-color: #fff;
        font-family: Roboto;
        font-size: 15px;
        font-weight: 300;
        margin-left: 12px;
        padding: 0 11px 0 13px;
        text-overflow: ellipsis;
        width: 300px;
      }

      #pac-input:focus {
        border-color: #4d90fe;
      }

      .pac-container {
        font-family: Roboto;
      }

      #type-selector {
        color: #fff;
        background-color: #4d90fe;
        padding: 5px 11px 0px 11px;
      }

      #type-selector label {
        font-family: Roboto;
        font-size: 13px;
        font-weight: 300;
      }
      #target {
        width: 345px;
      }
	  .listdata {
		border-style: solid solid solid;
		border-color: rgb(119, 224, 216);
		border-width: 1px;
		margin-left: 10px;
		margin-top: 5px;
		float: left;
		background-color: #C0C0C0;		
		  
	  }
	  .catheader {
		  margin-right: 10px;
		  margin-left: 10px;
		  margin-bottom: 5px;
		  background-color: #C0C0C0;
		  width: 380px;
	  }
	  .catheaderright {
		  margin-left: 10px;
		  margin-bottom: 5px;
		  background-color: #C0C0C0;
		  //width: 280px;
	  }
    </style>
  <body>
    <div id="map"  style="height:50%;width:100%;margin: 10px; auto;"> </div>
	<nav class="navbar navbar-bottom">
		<input id="pac-input" class="controls" type="text" placeholder="Search Box">
		<!-- <input id="clat" type="text" >
		<input id="clong" type="text"> -->
		
	</nav>
	
	<div class="viewModelmapeventscontainer container" id="viewModelmapeventscontainer">	<!-- events -->
		<div style="float: left; height: 50%; width: 50%; margin-right: 6px;"> <!-- left -->
			<div class="catheader">Cat 1</div>
			<div data-bind="foreach: cat1()"><!-- cat 1 -->
				<div class="listdata">
					<div style="width: 150px; float: left;" data-bind="text: start + ' - ' + end"></div><div style="float: left;">Cat 1</div>
					<div style="display: block">
						<div style="width: 150px;" data-bind="text: title"></div><div style="float: right;" data-bind="text: id"></div>
					</div>
					<div data-bind="text: address + ' / ' + country "></div>
					<div style="height: 20px"></div>
					<div data-bind="text: website"></div>
					<a href="#" data-bind="click: $parent.showonmap" class="btn btn-default">show on map</a>
				</div>
				<div class="spacer"></div>
			</div> 
			
			<div></div> <!-- cat 1 -->
		</div>
		<div style="float: left; height: 50%; width: 30%; margin-left: 6px;"> <!-- right -->
			<div class="catheaderright">Cat 2</div>
			<div data-bind="foreach: cat2()"><!-- cat 1 -->
				<div class="listdata">
					<div style="width: 150px; float: left;" data-bind="text: start + ' - ' + end"></div><div style="float: left;">Cat 2</div>
					<div style="display: block">
						<div style="width: 150px;" data-bind="text: title"></div><div style="float: right;" data-bind="text: id"></div>
					</div>
					<div data-bind="text: address + ' / ' + country "></div>
					<div style="height: 20px"></div>
					<div data-bind="text: website"></div>
					<a href="#" data-bind="click: $parent.showonmap" class="btn btn-default">show on map</a>
				</div>
				<div class="spacer"></div>
			</div> 
			
			<div></div> <!-- cat 2 -->
		</div>
	</div> <!-- end events -->
    <script type="text/javascript">
		sessionStorage['user'] = <?php echo Auth::User()->id; ?>;
		var map;
		var events = [];
		
		var url = "{{ url('/user/loadevents') }}";
		function addmarker(events) {
			for(i = 0; i< events.length; i++ ) {
				event = events[i];
				var lat = Number(event.lat);
				var lng = Number(event.long);
				
				var myLatLng = {lat: lat, lng: lng};
				if(event.category == "cat1") {
					category = "Cat 1";
				} else {
					category = "Cat 2";
				}
				var str = event.start + " - " + event.end + "    " + category;
				var info = str + "\n" + event.title + "\n" +	event.address + ' / ' + event.country + "\n\n\n" + event.website;
					var marker = new google.maps.Marker({
						position: myLatLng,
						map: map,
						title: info
				});
			}
		}
		function loadeavents() {
			$.ajax({
				url: url,
				type: 'get',
				success: function( data, textStatus, jQxhr ){
					var temp = jQuery.parseJSON(data);
					addmarker(temp.events);
				},
				error: function( jqXhr, textStatus, errorThrown ){
					console.log( errorThrown );
				}
			});
		}
		loadeavents();
      // This example adds a search box to a map, using the Google Place Autocomplete
      // feature. People can enter geographical searches. The search box will return a
      // pick list containing a mix of places and predicted search terms.

      // This example requires the Places library. Include the libraries=places
      // parameter when you first load the API. For example:
      // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">

      function initAutocomplete() {
        map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: 47.58393661978137, lng: 14.447021484375 },
          zoom: 3,
          mapTypeId: google.maps.MapTypeId.SATELLITE
        });
        
        // Create the search box and link it to the UI element.
        var input = document.getElementById('pac-input');
        var searchBox = new google.maps.places.SearchBox(input);
        map.controls[google.maps.ControlPosition.BOTTOM_CENTER].push(input);

        // Bias the SearchBox results towards current map's viewport.
        map.addListener('bounds_changed', function() {
          searchBox.setBounds(map.getBounds());
        });

        var markers = [];
        

        google.maps.event.addListener(map, 'click', function (e) {
                 
              var ll = {lat: e.latLng.lat(), lng: e.latLng.lng()}; 

              //alert(e.latLng.lat());  
               markers.forEach(function(marker) {
                          marker.setMap(null);
                });
              
               markers = []; 

               lastMarker = new google.maps.Marker({
                                position: ll,
                                map: map,
                                title: 'Hello World!'
                            });
                markers.push(lastMarker);

                getAddressByLatlng(ll);


         });



        // Listen for the event fired when the user selects a prediction and retrieve
        // more details for that place.
        searchBox.addListener('places_changed', function() {
          var places = searchBox.getPlaces();

          if (places.length == 0) {
            return;
          }

          // Clear out the old markers.
          markers.forEach(function(marker) {
            marker.setMap(null);
          });
          markers = [];

          // For each place, get the icon, name and location.
          var bounds = new google.maps.LatLngBounds();
          places.forEach(function(place) {
            var icon = {
              url: place.icon,
              size: new google.maps.Size(71, 71),
              origin: new google.maps.Point(0, 0),
              anchor: new google.maps.Point(17, 34),
              scaledSize: new google.maps.Size(25, 25)
            };

            // Create a marker for each place.
            markers.push(new google.maps.Marker({
              map: map,
              icon: icon,
              title: place.name,
              position: place.geometry.location
            }));

            if (place.geometry.viewport) {
              // Only geocodes have viewport.
              bounds.union(place.geometry.viewport);
            } else {
              bounds.extend(place.geometry.location);
            }
          });
          map.fitBounds(bounds);
        });
      }

    </script>

    <script type="text/javascript">

      function getAddressByLatlng(latlng){
             
                var lat =latlng.lat;
                var lng =latlng.lng;
        
                var inputSearchBox = document.getElementById('pac-input');

                var cLatValId = document.getElementById('clat');
                var cLongValId = document.getElementById('clong');

                cLatValId.value=lat+','+lng;
                cLongValId.value=lng;

                var geocoder = new google.maps.Geocoder();
                        geocoder.geocode({ 'latLng': latlng }, function (results, status) {
                             if (status == google.maps.GeocoderStatus.OK) {
                                if (results[1]) {
                                   // myHomeLocText.value =  results[1].formatted_address;
                                    inputSearchBox.value =  results[1].formatted_address;
                                }
                            }
                 });

              }


    </script>



    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCKiExGyg7oAG0FTOJ4p-1ThEWsjL_eJ4k&libraries=places&callback=initAutocomplete" async defer></script>
	<script src="{{ URL::asset('/js/app.js') }}"></script>
	<script type="text/javascript">
		viewModelmapevents.load("{{ url('/user/loadevents') }}");
	</script>

@endsection