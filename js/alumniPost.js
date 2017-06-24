window.onload = function() {
	$("#afbeelding").change(function(){
		console.log("change");
		var file = event.target.files[0];

		// Ensure it's an image
		if(file.type.match(/image.*/)) {
			console.log('An image has been loaded');

			// Load the image
			var reader = new FileReader();
			reader.onload = function (readerEvent) {
				var image = new Image();
				image.onload = function (imageEvent) {

					// Resize the image
					var canvas = document.createElement('canvas');
					var width = 400;
					var height = 400;
					canvas.width = width;
					canvas.height = height;
					canvas.getContext('2d').drawImage(image, 0, 0,width,height,0,0, width, height);
					var dataUrl = canvas.toDataURL('image/jpeg');
					$('#imgPreview').attr('src', dataUrl);
					/**var resizedImage = dataURLToBlob(dataUrl);
					$.event.trigger({
						type: "imageResized",
						blob: resizedImage,
						url: dataUrl
					});**/
				}
				image.src = readerEvent.target.result;
			}
			reader.readAsDataURL(file);
		}
    });
	
	$('.new-post').submit(function()
	{
		console.log("got here");
		var functie = $('.new-post input[name=functie]').val();
		var omschrijving = $('.new-post textarea[name=omschrijving]').val();
		var link = $('.new-post input[name=link]').val();
		var img = $('.new-post #imgPreview').attr('src');
		$.ajax({
			type: "POST",
			url: "func/makeAlumniPost.php",
			data: { functie: functie, omschrijving: omschrijving, link: link, img: img },
			//dataType: "json",
			success: function(data) {
				console.log(data);
				if (data.redirect) {
					// data.redirect contains the string URL to redirect to
					window.location.href = data.redirect;
				}
				else {
					// data.form contains the HTML for the replacement form
					$("#myform").replaceWith(data.form);
				}
			}
		});
		event.preventDefault();
	});
	
	
	function dataURLToBlob(dataURL) {
		var BASE64_MARKER = ';base64,';
		if (dataURL.indexOf(BASE64_MARKER) == -1) {
			var parts = dataURL.split(',');
			var contentType = parts[0].split(':')[1];
			var raw = parts[1];

			return new Blob([raw], {type: contentType});
		}

		var parts = dataURL.split(BASE64_MARKER);
		var contentType = parts[0].split(':')[1];
		var raw = window.atob(parts[1]);
		var rawLength = raw.length;

		var uInt8Array = new Uint8Array(rawLength);

		for (var i = 0; i < rawLength; ++i) {
			uInt8Array[i] = raw.charCodeAt(i);
		}

		return new Blob([uInt8Array], {type: contentType});
	}
} 