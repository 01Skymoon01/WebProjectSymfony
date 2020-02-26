$(document).ready(function(){

function ImageSwitcher(choices, i) {
	i = 0;
	
	this.Next = function() {
		hide_current_image();
		show_next_image();
	}
	
	var hide_current_image = function() {
		if(choices){
			choices[i].style.visibility = "hidden";
			i += 1;
		}
	}
	var show_next_image = function() {
		if(choices){
			if(i == (choices.length)) {
				i = 0;
			}
			choices[i].style.visibility = "visible";
		}
	}
}
  
    var pants = $(".pant");
	var shirts = $(".shirt");
	var hand = $(".hand");
	var wheel = $(".wheel");
	var wheel2 = $(".wheel2");
	var crankset = $(".crankset");
	var backgrounds = $(".bg");

	var shirt_picker = new ImageSwitcher(shirts);
	document.getElementById("shirt_button").onclick = function() { shirt_picker.Next(); };
	
	var pants_picker = new ImageSwitcher(pants);
	document.getElementById("pant_button").onclick = function() {pants_picker.Next(); };

	var hands_picker = new ImageSwitcher(hand);
	document.getElementById("hand_button").onclick = function() {hands_picker.Next(); };

	var wheel_picker = new ImageSwitcher(wheel);
	var wheel2_picker = new ImageSwitcher(wheel2);
	document.getElementById("wheel_button").onclick = function() {wheel_picker.Next(); wheel2_picker.Next(); };

	var crankset_picker = new ImageSwitcher(crankset);
	document.getElementById("crankset_button").onclick = function() {crankset_picker.Next(); };

	var bg_picker = new ImageSwitcher(backgrounds);
	document.getElementById("bg_button").onclick = function() {bg_picker.Next(); };

});

  $("#shirt_button").click(function(){
  $("#shirt-menu").css("visibility", "visible"); });