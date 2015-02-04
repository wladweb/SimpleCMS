tinymce.init({
    selector: "textarea.post-field",
	height:300,
	document_base_url: "http://blog.loc",
	relative_urls: false,
    theme: "modern",
    plugins: [
        "advlist autolink lists link image charmap print preview hr anchor pagebreak",
        "searchreplace wordcount visualblocks visualchars code fullscreen",
        "insertdatetime media nonbreaking save table contextmenu directionality",
        "emoticons template paste textcolor colorpicker textpattern"
    ],
    toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
    toolbar2: "print preview media | forecolor backcolor emoticons",
    image_advtab: true,
    templates: [
        {title: 'Test template 1', content: 'Test 1'},
        {title: 'Test template 2', content: 'Test 2'}
    ]
});

 
jQuery(function(){
	var url=document.location.pathname;
	url = '/'+url.split('/')[1];
    $.each($('#admin-menu a'),function(){
		if('/'+this.pathname.split('/')[1]==url){
			$(this).parent().addClass('active');
		};
    });
	$('#user-update').click(function(){
		$('#email').parent().removeClass('has-error');
		$('#pass').parent().removeClass('has-error');
		$('#passagain').parent().removeClass('has-error');
		var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
		if($('#email').val() == ''){
			$('#email').parent().addClass('has-error');
			return false;
		}else if(reg.test($('#email').val()) == false){
			$('#email').parent().addClass('has-error');
			return false;
		}
		if(
			($('#pass').val() === '' && $('#passagain').val() !== '') ||
			($('#pass').val() !== '' && $('#passagain').val() === '') ||
			($('#pass').val() !== $('#passagain').val())
		){
			$('#pass').parent().addClass('has-error');
			$('#passagain').parent().addClass('has-error');
			return false;
		}
	});
	if($('div.info-block')){
		var w = $('div.info-block').width();
		var scrolltop = $('document').scrollTop() || $(window).scrollTop();
		var alertFromTop = 200;
		var horizont = scrolltop + alertFromTop;
		$('div.info-block').css('top', (scrolltop-80)+'px');
		$('div.info-block').css('marginLeft', '-'+w/2+'px');
		$('div.info-block').animate({'top':(horizont+10)+'px'},1200)
		.animate({'top':(horizont-30)+'px'},350)
		.animate({'top':(horizont)+'px'},700)
		.animate({'opacity':0},2000,function(){$(this).remove()});
	}
});
