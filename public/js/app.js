
function ViewModel_mapevents() {
	var self = this;
	self.events = ko.observableArray();
	self.cat1 =  ko.observableArray();
	self.cat2 =  ko.observableArray();
	self.countries = ko.observableArray();
	self.markers = [];
	self.startdate = ko.observable('');
	self.enddate = ko.observable('');
	
	self.addusertoevent = function() {
		
	}
	
	self.showonmap = function(object) {
		var lat = Number(object.lat);
		var lng = Number(object.long);
		
		var address = object.address;
		var country = object.country;
		var myLatLng = {lat: lat, lng: lng};
		//self.addMarker(myLatLng, object);
		map.setCenter(myLatLng);

	}

	self.addMarker = function(myLatLng, object) {
		var category = "";
		
		if(object.category == "cat1") {
			category = "Cat 1";
		} else {
			category = "Cat 2";
		}
		var str = object.start + " - " + object.end + "    " + category;
		var info = str + "\n" + object.title + "\n" +	object.address + ' / ' + object.country + "\n\n\n" + object.website;
		var marker = new google.maps.Marker({
		  position: myLatLng,
		  map: map,
		  title: info
		});
		self.markers.push(marker);
		//map.setCenter(myLatLng);
		google.maps.event.addListener(marker, 'click', function(event, data) { 
		var x = 1;
		//alert('Marker has been clicked'); 
		});

	}
	
	self.update = function(data) {
		var obj = jQuery.parseJSON(data);

		self.events.removeAll();
		self.cat1.removeAll();
		self.cat2.removeAll();
		$.each(obj.events, function(index, data) {
			for(i=0;i < obj.countries.length; i++) {
				var c = obj.countries[i];
				if(c.iso3 == data.country ) {
					data.countryname = c.name;
				}
			}
			if(data.start) {
				var d = new Date(data.start);
				data.start = d.getDate() + '.' + d.getMonth();
			}
			if(data.end) {
				var dd = new Date(data.end);
				data.end = dd.getDate() + '.' + dd.getMonth() + '.' + dd.getFullYear();
			}
			if (data.category == "cat1") {
				self.cat1.push(data);
			}
			if (data.category == "cat2") {
				self.cat2.push(data);
			}
			self.events.push(data);
		});
		varx = 1;
	}
	
	self.load = function(url) {
		var x = 1;
		var request = $.ajax( {
			url: url,
			type: 'get',
			async: false,
			//contentType: 'charset=utf-8',
			// success: function(data) {
				// self.update(data);
			// },
			// error: function(e) {
				// var x = 1;
			// }
		});
		request.done(function( data ) {
			self.update(data);
		});
		request.fail(function( jqXHR, textStatus ) {
			alert( "Request failed: " + textStatus );
		});
	}
	
}

var viewModelmapevents = new ViewModel_mapevents();
ko.applyBindings(viewModelmapevents,document.getElementById("viewModelmapeventscontainer"));