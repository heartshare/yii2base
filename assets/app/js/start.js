
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