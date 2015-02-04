 $(document).ready(function(){
	 if($('div.info-block')){
		 var w = $('div.info-block').width();
		 var scrolltop = $('document').scrollTop();
		 var alertFromTop = 200;
		 var horizont = scrolltop + alertFromTop;
		 $('div.info-block').css('top', (scrolltop-80)+'px');
		 $('div.info-block').css('marginLeft', '-'+w/2+'px');
		 $('div.info-block').animate({'top':(horizont+10)+'px'},1200)
		 .animate({'top':(horizont-30)+'px'},350)
		 .animate({'top':(horizont)+'px'},700)
		 .animate({'opacity':0},2000,function(){$(this).remove()});
	 }
	 if($('a.add-to-answer') && $('textarea.answer')){
		$('a.add-to-answer').click(function(){
			var uname = $(this).text();
			$('textarea.answer').val(uname);
			return false;
		}); 
	 }
 });