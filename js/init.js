(function($){
  $(function(){

    $('.sidenav').sidenav();
    $('.parallax').parallax();

  }); // end of document ready
})(jQuery); // end of jQuery name space


$(document).ready(function(){
	$('select').formSelect();
});

$(".dropdown-trigger").dropdown();

$('#textarea1').val('');
M.textareaAutoResize($('#textarea1'));

$('input#input_text, textarea#textarea1').characterCounter();