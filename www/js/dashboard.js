
$(function () {
	TabSystem.init();

	var urlHash = window.location.hash;
	if (urlHash) {
		$('#tabmenu li a.'+urlHash.substr(1)).click();
	} else {
		$('#tabmenu li.active a').click();
	}

	var geocoder = new google.maps.Geocoder();
	var latlng = new google.maps.LatLng(52.141391, 4.469245);
	var myOptions = {
		zoom: 8,
		center: latlng,
		mapTypeId: google.maps.MapTypeId.ROADMAP
	};
	var map = new google.maps.Map(document.getElementById("map"), myOptions);


	$('#adres').change(function (e) {

		var searchAddress = {
			address: this.value,
			language: 'NL'
		}
		
		geocoder.geocode(searchAddress, function(results, status) {
			if (status == google.maps.GeocoderStatus.OK) {
				map.setCenter(results[0].geometry.location);
			var str = '';
			for (var i = 0; i < results[0].address_components.length; i++) {
				str += results[0].address_components[i].short_name+' - '+results[0].address_components[i].long_name+' _ ';

				str += results[0].address_components[i].types.length+', ';

				for (var j = 0; j < results[0].address_components[i].types.length; j++) {
					str += results[0].address_components[i].types[j]+' :: ';
				}
				str += "\n";

			}
			alert(str);

				var marker = new google.maps.Marker({
					map: map,
					position: results[0].geometry.location
				});
			} else {
				alert("Geocode was not successful for the following reason: " + status);
			}
		});
	})

	
})
