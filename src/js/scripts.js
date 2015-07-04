
var lhost=location.host;
var assistidoURL= "http://"+lhost+"/cidadao/api/cidadao/assistido";
var causaURL ="http://"+lhost+"/cidadao/api/cidadao/causa";
var areaatendimentoURL="http://"+lhost+"/cidadao/api/cidadao/area_atendimento";

$.fn.serializeObject = function() {
	var o = {};
	var a = this.serializeArray();
	$.each(a, function() {
		if (o[this.name]) {
			if (!o[this.name].push) {
				o[this.name] = [o[this.name]];
			}
			o[this.name].push(this.value || '');
		} else {
			o[this.name] = this.value || '';
		}
	});
	return o;
};

function sendForm(form,thisurl){
model_data = $(form).serializeObject();
console.log(form,thisurl,model_data);
$.ajax({
url: thisurl,
type: 'POST',
contentType: 'application/json',
data: JSON.stringify(model_data),
dataType: 'json',
success:function(e){
  console.log(form,thisurl,model_data)
	$(form).trigger("reset");
	$("#sucessoform").show();
    // I know, you do not want Ajax, if you callback to page, you can refresh page here
   }
});
}


$(document).ready(function() {
	$.getJSON(assistidoURL,function (data){
		$.each( data, function( i, item ){
			$('#assistidoselect').append($('<option>', {
	        value: item.id,
	        text : item.nome
	    }));
	});
});

$.getJSON(areaatendimentoURL,function (data){
	$.each( data, function( i, item ){
		$('#areaatendimentoselect').append($('<option>', {
				value: item.id,
				text : item.nome
		}));
});
});
});
