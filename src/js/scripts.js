var assistidoURL= "http://localhost/cidadao/api/cidadao/assistido";

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
model_data = $("#contactForm").serializeObject();
console.log(form,thisurl,model_data);
$.ajax({
url: thisurl,
type: 'POST',
contentType: 'application/json',
data: JSON.stringify(model_data),
dataType: 'json',
success:function(e){
  console.log(form,thisurl,model_data)

    // I know, you do not want Ajax, if you callback to page, you can refresh page here
   }
});
}
