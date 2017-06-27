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
	$('main article textarea').change(function(){
		$(this).parent().parent().addClass( "changed" );
	});
	$('main .col-8 textarea').change(function(){
		$(this).parent().addClass( "changed" );
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
		$(".changed").each(function() {
			$("main .feedback").each(function() {
				$(this).remove();
			});
			var title = $(this).find('textarea[id*=title]').val();
			var text = $(this).find('textarea[id*=text]').val()
			var img = $(this).find('img[id*=image]').attr('src');
			var data = $(this).attr("id");
			console.log(data);
			var arr = data.split('-');
			console.log(arr);
			if(img) {
				var imgId = $(this).find('img[id*=image]').attr('id').split('-')[5];
			}
			console.log(imgId);
			$.ajax({
				type: "POST",
				url: "func/updateInfopage.php",
				dataType: 'json',
				data: {
					pagetype : arr[0],
					page : arr[1],
					locatie : arr[2],
					taal : arr[3],
					title: title, 
					text: text, 
					img: img,
					imgId : imgId
				}
			}).done(function( msg ) {
				console.log(msg );
				if(msg.status.indexOf("sucess") >= 0) {
					$( "main" ).append( $( "<p class='feedback sucess' id='"+arr[2]+"'>"+msg.status+"</p>" ) );
				} else {
					$( "main" ).append( $( "<p class='feedback fail' id='"+arr[2]+"'>"+msg.status+"</p>" ) );
				}
			}).fail(function( jqXHR, textStatus ) {
				console.log("Request failed: " + textStatus);
			});
		});
	});
}
