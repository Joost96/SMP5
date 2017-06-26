function onLoad() {
		
	$( "main" ).append( $( "<input class='center' id='adminSubmit' type='submit' value='save'>" ) );
	
	$( "main p" ).each(function() {
		var text = $(this).text();// get text of span 
		var textArea = $("<textarea class='pEdit' />"); // create new text area 
		textArea.val(text); // add value to text area
		textArea.attr("id",$(this).attr("id"));		
		$(this).replaceWith(textArea); // replace span with textarea 
	});
	$( "main h1" ).each(function() {
		var text = $(this).text();
		var textArea = $("<textarea class='h1Edit' />");
		textArea.val(text);
		textArea.attr("id",$(this).attr("id"));
		$(this).replaceWith(textArea);
	});
	$( "main img" ).each(function() {
		var button = $("<input class='imgUpload' type='file' name='afbeelding' id="+$(this).attr("id")+">");
		$(this).after(button);
	});
	$('main textarea').change(function(){
		$(this).parent().parent().addClass( "changed" );
	});
		
	$('main img').click(function(){
		var id = $(this).attr("id");
		$(".imgUpload#"+ id).click();
	});
	
	$("main .imgUpload").change(function(){
		var file = event.target.files[0];
		var id = $(this).attr("id")
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
					var width = image.width;
					var height = image.height;
					if(width/16 < height/9) {
						height = width/16*9;
					} else {
						width = height/9*16;
					}
					canvas.width = width;
					canvas.height = height;
					canvas.getContext('2d').drawImage(image, 0, 0,width,height,0,0, width, height);
					var dataUrl = canvas.toDataURL('image/jpeg');
					$('img#'+id).parent().parent().addClass( "changed" );
					$('img#'+id).attr('src', dataUrl);
				}
				image.src = readerEvent.target.result;
			}
			reader.readAsDataURL(file);
		}
    });
	
	$("#adminSubmit").click(function() {
		$(".checked").each(function() {
			
		});
	});
}
