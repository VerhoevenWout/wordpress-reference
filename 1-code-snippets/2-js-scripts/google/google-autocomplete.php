<style>
	input {
		padding: 5px 10px;
		margin-bottom: 15px;
	}
</style>

<input type="text" data-type="google-autocomplete" />
<div id="output"></div>

<script>
	function initAutocomplete() {
		const input = document.querySelector('[data-type=google-autocomplete]');
		const autocomplete = new google.maps.places.Autocomplete(
	      input, {
						types: ['geocode'],
						componentRestrictions: {country: ['be','nl','fr','de','it']}
					}
		);
		
		autocomplete.addListener('place_changed', () => {
			const selectedPlace = autocomplete.getPlace();
			console.log(selectedPlace);
			document.getElementById('output').innerHTML = selectedPlace.adr_address;
		});
	}

	// Add google places script
	const script = document.createElement('script');
	script.src = 'https://maps.googleapis.com/maps/api/js?libraries=places&callback=initAutocomplete';

	document.body.appendChild(script);	
</script>