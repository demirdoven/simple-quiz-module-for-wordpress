(function($) {
	$("#expiry_date").datepicker({ dateFormat: 'dd-mm-yy' });
	$('#profile_pic_select').on('click',function(){
		$(this).siblings('#profile_picture_output').hide();
		
	});
})( jQuery );