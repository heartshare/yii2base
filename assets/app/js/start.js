jQuery(document).ready(function($) { 
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
function openPopup(id)
{
	$("#"+id).fadeIn(100);	 
	var h = $("#"+id+" > .popup").height();
	$("#"+id+" > .popup").css("margin-top", -h/2);
	if ($(".scroll-pane").length > 0) {
		$('.scroll-pane').jScrollPane();
	}
}

function closePopup(id)
{
    $("#"+id).fadeOut(100);
    //$("#header > .closepp").remove();
}

function openInformPopup(id, timeout)
{
	$("#"+id).fadeIn(100);
	var h = $("#"+id+" > .popup").height();
	$("#"+id+" > .popup").css("margin-top", -h/2);
	if ($(".scroll-pane").length > 0) {
		$('.scroll-pane').jScrollPane();
	}

	$("#"+id).fadeOut(timeout);
}

function getParameterByName(name)
{
	name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
	var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
		results = regex.exec(location.search);
	return results === null ? "a" : decodeURIComponent(results[1].replace(/\+/g, " "));
}

// Timezone
var Timezone = {
    init : function(cities, formatName){
		this.cities = [];
		this.formatName = formatName;

		for(var key in cities) {
			this.cities.push({
				name: cities[key],
				offset: moment.tz(cities[key]).format('Z')
			});
		}

		this.cities.sort(function(a, b){
			return parseInt(a.offset.replace(":", ""), 10) - parseInt(b.offset.replace(":", ""), 10);
		});

		this.html = this.getHTMLOptions();
		this.currentTimezone = this.getCurrentTimezoneKey();
	},
	getHTMLOptions : function(){
		var html = '';
		var offset = 0;
		var i, c = this.cities.length, city;

		for(i = 0; i < c; i++) {
			city = this.cities[i];
			html += '<option data-offset="' + city.offset + '" value="'+ city.name +'">(GMT ' + city.offset + ') ' + this.formatName(city.name) +'</option>';
		}

		return html;
	},
	addNames : function(select){
		return $(select).empty().append($(this.html));
	},
	selectValue : function(select, value){
		value = value || this.currentTimezone;

		var match = $(select).find('option[data-offset="' + value + '"]');

		if (match.length){
			$(select).val(match.val());
		}

		return $(select);
	},
};

$.fn.timezones = function() {
	var formatName = function(str) {
		return str;
	};

	Timezone.init(moment.tz.names(), formatName);

	return this.each(function(){
		Timezone.addNames(this);
		Timezone.selectValue(this);
		return this;
	});
};