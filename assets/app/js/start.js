
jQuery(document).ready(function($){ 
	 $('.datepicker').datetimepicker();

	$('.nav-pills, .nav-tabs').tabdrop({
		'text': '<i class="fa fa-bars"></i>'
	});

	// http://www.bootstrap-switch.org/options-3.html
	$(".switch").bootstrapSwitch({
		'onColor': 'success',
		'offColor': 'danger',
	});

	// form alert auto hide
	window.setTimeout(function() {
		$(".alert-flash").fadeTo(1500, 0).slideUp(500, function(){
			$(this).remove();
		});
	}, 5000);
});
function openPopup(id) {
	$("#"+id).fadeIn(100);	 
	var h = $("#"+id+" > .popup").height();
	$("#"+id+" > .popup").css("margin-top", -h/2);
	if ($(".scroll-pane").length > 0) {
		$('.scroll-pane').jScrollPane();
	}

}

function closePopup(id) {

    $("#"+id).fadeOut(100);
    //$("#header > .closepp").remove();
}

function openInformPopup(id, timeout) {
	$("#"+id).fadeIn(100);
	var h = $("#"+id+" > .popup").height();
	$("#"+id+" > .popup").css("margin-top", -h/2);
	if ($(".scroll-pane").length > 0) {
		$('.scroll-pane').jScrollPane();
	}

	$("#"+id).fadeOut(timeout);
}

function getParameterByName(name) {
	name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
	var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
		results = regex.exec(location.search);
	return results === null ? "a" : decodeURIComponent(results[1].replace(/\+/g, " "));
}