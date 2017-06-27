function onLoad(){	
	slideShow();	
}

var index = 0;	
function slideShow() {
	
	var i;
	var buttons = document.getElementsByClassName("button");
	var j = document.getElementsByClassName("slide");
		for (i =0; i < j.length; i++)
		{
			j[i].style.display = "none";
		}
		index++;
		if (index > j.length)
		{
			index = 1;
		}
		for (i = 0; i < buttons.length; i++) 
		{
			buttons[i].className = buttons[i].className.replace(" active", "");
		}			
	j[index-1].style.display = "block";
	buttons[index-1].className += " active";	
	setTimeout(slideShow, 8000);
}