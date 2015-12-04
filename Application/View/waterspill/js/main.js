$(document).ready(function(){
	$('#reg-open-button').click(function(){
		$('.register-block').slideToggle(300);
	});
	$('#reg-button').click(function(){
		var needs = [$('#rlogin'),$('#rpass'),$('#remail')];
		var error = 0;
		var c = 0;
		for(var i = 0, c = needs.length; i < c; i++){
			needs[i].removeClass('err');
			if(needs[i].val() == ''){
				needs[i].addClass('err');
				error++;
			}
		}
		if(error > 0)return false;
	});
});