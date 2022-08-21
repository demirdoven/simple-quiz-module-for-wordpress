jQuery(function ($){
	
	var corrects = null;
	var wrongs = null;
	
	var trueIconSrc = $('.doq_container').data('true-icon');
	var wrongIconSrc = $('.doq_container').data('wrong-icon');
	
	function sortEventsByOrder(a,b) {
		var startA = parseInt($(a).attr('data-correct-order'));
		var startB = parseInt($(b).attr('data-correct-order'));	
		return startA - startB;
	}

	var ajaxurl = $('.doq_container').data('adminajax');
	var quizName = $('.doq_container').data('quiz-name');
	var countAllQuestions = $('.doq_questions_container .doq_question:not(.last_slide)').length;
	var timeLimit = $('.doq_container').data('time');
	var answerMode = $('.doq_container').data('answer-mode');
	
	$('.doq_filter_quiz_name').html(quizName);
	$('.doq_filter_count_all_questions').html(countAllQuestions);
	$('.doq_filter_total_time_limit').html(timeLimit/60);

	
	$(document).ready(function(){
		
		if( $('.doq_container').data('time-limit')==1 && $('.doq_container').data('hide-welcome')==1 ){
			$('.doq_questions_container, .doq_timer').fadeIn();
			startCountdown();
		}
		
	});
	
	$(document).on('click', '.start_quiz', function () {
		
		var katilimci_isim = $('input[name="katilimci_isim"]').val();
		if( katilimci_isim == '' ){
			
			alert('Lütfen adınızı ve soyadınızı yazın!');
			
		}else{
			
			$('.doq_welcome_screen').slideUp();
			$('.doq_questions_container').addClass('started');
			
			if( $('.doq_container').data('time-limit')==1  ){
				$('.doq_questions_container, .doq_timer').fadeIn();
				startCountdown();
			}
			$('.doq_questions_container').removeClass('doq_hidden');
			
		}
			
		
	});
	
	
	var secondsRemaining;
	var intervalHandle;

	function tick(){
		// grab the h1
		var timeDisplay = document.getElementById("doq_timer");

		// turn the seconds into mm:ss
		var min = Math.floor(secondsRemaining / 60);
		var sec = secondsRemaining - (min * 60);

		//add a leading zero (as a string value) if seconds less than 10
		if (sec < 10) {
			sec = "0" + sec;
		}

		// concatenate with colon
		var message = min.toString() + ":" + sec;

		// now change the display
		timeDisplay.innerHTML = message;

		// stop is down to zero
		if (secondsRemaining === 0){
			//alert("Süre bitti!");
			clearInterval(intervalHandle);
			
			$('.doq_questions_container, .doq_timer').slideUp();
			$('.doq_questions_container').removeClass('started');
			$('.doq_questions_container, .doq_timer').addClass('doq_hidden');
			$('.doq_analysis').fadeIn();

		}
		
		$('.finish_quiz').on('click', function(){
			
			clearInterval(intervalHandle);
			
            /*
			$('html,body').animate({
			scrollTop: $("body").offset().top},
			'slow');
			*/
			
			
			$('.doq_timer').hide();
			$('.doq_questions_container').removeClass('started');
			$('.doq_timer').addClass('doq_hidden');
			$('.doq_analysis').show();
			
			var xxx = $('#doq_timer').html();

		});

		//subtract from seconds remaining
		secondsRemaining--;

	}

		
	function startCountdown(){
		
		// how many seconds
		secondsRemaining = $('#doq_timer').data('time-limit');
		
		//every second, call the "tick" function
		// have to make it into a variable so that you can stop the interval later!!!
		intervalHandle = setInterval(tick, 1000);
	}

	$(document).on('click', '.finish_quiz', function () {
		
		$('.cvp_aciklama').show();
		
		var dogrular = [];
		var yanlislar = [];
		
		var quizId = $('.doq_container').data('quiz-id');
		
		$('.doq_question').each(function(i){
			
			var questionType = $('.doq_question').eq(i).find('.doq_answers_container').data('question-type');
			var correctType = $('.doq_question').eq(i).find('.doq_answers_container').data('count-correct');
			//var questionPoint = $('.doq_question').eq(i).find('.doq_answers_container').data('question-point');

			var singleAnswer = $('.doq_question').eq(i).find('input[type="radio"]');
			var countAnswer = singleAnswer.length;
			
			for( var k=0; k<countAnswer; k++ ){
				
				if( singleAnswer.eq(k).is(":checked") ){
					
					var isCorrect = singleAnswer.eq(k).data('correct');
					
					if( isCorrect==1 ){  // Doğru yanıt seçilmiş..
						
						dogrular.push(i);
						
					}else{
						yanlislar.push(i);
					}
					
				}
				
			}
		
		});
		//console.log('Doğrular: '+dogrular+'</br>Yanlışlar: '+yanlislar);
		
		corrects = dogrular;
		wrongs = yanlislar;
		
		
		
		var countAllQuestions = $('.doq_questions_container .doq_question').length;
		countAllQuestions = countAllQuestions-1;
		var countCorrects = dogrular.length;
		var countWrongs = yanlislar.length;
		
		var bosSayisi = countAllQuestions-(countCorrects+countWrongs);
		
		function hesapla(){
			
			$('.loaderr').show();
			
			if( $('.doq_container').data('time-limit')!=1 ){
	
				//$('.doq_questions_container, .doq_timer').hide();
				$('.doq_questions_container').removeClass('started');
				//$('.doq_questions_container, .doq_timer').addClass('doq_hidden');
				$('.doq_analysis').show();
				
			}
			
			$('.doq_all_questions span:last-child').html(countAllQuestions);
			$('.doq_corrects span:last-child').html(countCorrects);
			$('.doq_wrongs span:last-child').html(countWrongs);
			$('.doq_empty span:last-child').html(countCorrects);

			$('.doq_filter_quiz_name').html(quizName);
			$('.doq_filter_count_all_questions').html(countAllQuestions);
			$('.doq_filter_count_corrects').html(countCorrects);
			$('.doq_filter_count_wrongs').html(countWrongs);
			$('.doq_filter_total_time_limit').html(timeLimit);
			
			var checkTimeLimit = $('.doq_container').data('time-limit');
			if( checkTimeLimit == 1 ){
				var userTime = $('#doq_timer').html();
				var userTimeArray = userTime.split(':');
				var userMin = userTimeArray[0];
				var userSec = userTimeArray[1];
				
				var resultMin = (timeLimit/60)-userMin-1;
				
				$('.doq_filter_user_time').html( resultMin +' dakika '+ (60-userTimeArray[1]) +' saniye');
			}
			
			$('.doq_timer').remove();
			
			
			/*
			$('.doq_question').removeClass('active');
			$('.doq_question').hide();
			$('.doq_question:eq(0)').show();
			$('.doq_question:eq(0)').addClass('active');
			*/
			
			$('.doq_pager_element').removeClass('active');
			$('.doq_pager_element:eq(0)').addClass('active');
			
			$('.prev_question, .next_question').removeClass('disable');
			$('.prev_question').addClass('disable');
			
			$('input').attr('disabled', 'true');
			
			$('.doq_question.last_slide').remove();
			$('.doq_pager_element:last-child').remove();
			$('.new_box:last-child').remove();
			
			$('.doq_question_pager').addClass('kapalii');
			$('.doq_live_answer').hide();
				
			$('.doq_question').each(function(i){
				
				/***************** DOĞRUYSA ***************/
				
				if( (jQuery.inArray( i, corrects )) !== (-1) ){ // dogruysa
				
					$('.new_box').eq(i).css('background','#4CAF50');
					//$('.new_box').eq(i).css('border-color','transparent!important');
					$('.new_box').eq(i).css('color','#fff');
					$('.cevaplandi').css('border-color','#3f51b5');
					
					$(this).attr('data-cevaplandi','dogru');
					$(this).find('.dogru-yanlis-text').html('DOĞRU');
					$(this).find('.dogru-yanlis-text').addClass('dogru');
					
				
					$(this).find('.answer_type_0').filter(':checked').siblings('.bos').hide();
					$(this).find('.answer_type_0').filter(':checked').siblings('.dolu').attr('src',trueIconSrc);
			
					
				}
				
				/***************** // DOĞRUYSA ***************/
				
				/***************** YANLIŞSA ***************/
				
				if( (jQuery.inArray( i, wrongs )) !== (-1) ){ // yanlissa
				
						$('.new_box').eq(i).css('background','#f44336');
						//$('.new_box').eq(i).css('border-color','transparent!important');
						$('.new_box').eq(i).css('color','#fff');
						$('.cevaplandi').css('border-color','#3f51b5');
					
						$(this).attr('data-cevaplandi','yanlis');
						$(this).find('.dogru-yanlis-text').html('YANLIŞ');
						$(this).find('.dogru-yanlis-text').addClass('yanlis');
						
						
						
						$(this).find('.answer_type_0').filter(':checked').siblings('.bos').hide();
						$(this).find('.answer_type_0').filter(':checked').siblings('.dolu').attr('src',wrongIconSrc);
						$(this).find('.answer_type_0[data-correct="1"]').siblings('.bos').hide();
						$(this).find('.answer_type_0[data-correct="1"]').siblings('.dolu').show();
						$(this).find('.answer_type_0[data-correct="1"]').siblings('.dolu').attr('src',trueIconSrc);
						
				}
				
				/***************** // YANLIŞSA ***************/
				
				/***************** BOŞSA ***************/
				
				if( (jQuery.inArray( i, corrects )) == (-1) && (jQuery.inArray( i, wrongs )) == (-1) ){ // bossa
				
					$('.new_box').eq(i).css('background','#9e9e9e');
					//$('.new_box').eq(i).css('border-color','transparent!important');
					$('.new_box').eq(i).css('color','#fff');
					$('.cevaplandi').css('border-color','#3f51b5');
					
					$(this).attr('data-cevaplandi','bos');
					$(this).find('.dogru-yanlis-text').html('BOŞ');
					$(this).find('.dogru-yanlis-text').addClass('bos');
					
					
					$(this).find('.answer_type_0[data-correct="1"]').siblings('.bos').hide();
					$(this).find('.answer_type_0[data-correct="1"]').siblings('.dolu').show();
					$(this).find('.answer_type_0[data-correct="1"]').siblings('.dolu').attr('src',trueIconSrc);
					
				}
				
				/***************** // BOŞSA ***************/
				
			});
			
			
			
			var qid = $('.doq_container').data('quiz-id');
			var katilimci_isim = $('input[name="katilimci_isim"]').val();
			var katilimci_ig = $('input[name="katilimci_ig"]').val();
			
           
            
            
			var data = {
				action: 'sinav_siralama_kaydet_ve_goster',
				isim: katilimci_isim,
				ig: katilimci_ig,
				quiz_id: qid,
				puan: countCorrects,
			}
			$.post(ajaxurl, data, function(response){
				console.log(response);
				$('.doq_analysis_footer').html(response);
				
			});
			
			
		}
		
		
		/*
		if( bosSayisi > 0 ){

			if (confirm('Yanıtlanmayan sorular var. Yine de sınavı bitirmek istiyor musunuz?')){
				
				hesapla();
				
			}else{
				
			}
			
		}else{
			
			hesapla();
			
		}
		*/
		hesapla();
		
		$('.loaderr').delay(600).hide(0);
		
		
		$('html,body').animate({
				scrollTop: $(".status-publish").offset().top},
				'slow');
			
		
	});
	
	
	//$(document).on('click', '.finish_quiz', function () {
	
	
	$('.doq_question').each(function(i){
		
		var box = '<li class="doq_pager_element">'+(i+1)+'</li>';
		$('.doq_question_pager ul').append(box);
		
		var boxYeni = '<div class="new_box" data-icerik="'+(i+1)+'">'+(i+1)+'</div>';
		$('.yeni_sorulist').append(boxYeni);
		
		var questionInd = $(this).index('.doq_question');
		$(this).attr('data-question-ind',questionInd);
		$(this).find('*').attr('data-question-ind',questionInd);
		
	});
	
	$('.yeni_sorulist .new_box:last-child').html('SON');
	
	/*
	$(document).ready(function () {
		$('.doq_question').hide();
		$('.doq_question').eq(0).show();
		$('.doq_pager_element').eq(0).addClass('active');
		$('.doq_question').eq(0).addClass('active');
		$('.prev_question').addClass('disable');
	});
	*/
	
	$(document).on('click', '.doq_pager_element', function () {
		$('.prev_question, .next_question').removeClass('disable');
		
		var i = $(this).html();
		var length = $('.doq_pager_element').length;
		
		$('.doq_question').hide();
		$('.doq_pager_element').removeClass('active');
		$('.doq_question').eq(i-1).fadeIn().addClass('active');
		$('.doq_pager_element').eq(i-1).addClass('active');
		
		if( i==1 ){
			$('.prev_question').addClass('disable');
		}
		if( i==length ){
			$('.next_question').addClass('disable');
		}
	});
	
	
	
	$(document).on('click', '.next_question:not(.disable)', function () {
		
		var i = $('.doq_pager_element.active').index(); // 4
		var length = $('.doq_question').length; // 5
		
		if( (i+1)>0 ){
			$('.prev_question').removeClass('disable');
		}
		
		if( i<(length-1) ){
			$('.doq_question').hide();
			$('.doq_pager_element').removeClass('active');
			$('.doq_question').eq(i+1).fadeIn();
			$('.doq_pager_element').eq(i+1).addClass('active');
		}
		
		if( i===(length-2) ){
			$('.next_question').addClass('disable');
		}
		
	});
	
	$(document).on('click', '.prev_question:not(.disable)', function () {
		
		$('.prev_question, .next_question').removeClass('disable');
		
		var i = $('.doq_pager_element.active').index(); // 4
		var length = $('.doq_question').length; // 5
	
		//if( i+1>length ){
		//	$('.prev_question').removeClass('disable');
		//}
		
		if( i>0 ){
			$('.doq_question').hide();
			$('.doq_pager_element').removeClass('active');
			$('.doq_question').eq(i-1).fadeIn();
			$('.doq_pager_element').eq(i-1).addClass('active');
		}
		
		if( i===1 ){
			$('.prev_question').addClass('disable');
		}
	
	});
	
		
	//if( answerMode == 2 ){
		
		$(document).on('click', '.doq_check_answer', function(){
	
			var activeIndex = $('.doq_pager_element.active').index();
			var activeQuestion = $('.doq_question').eq(activeIndex);
			var questionType = activeQuestion.data('question-type');
			
			if( questionType == 0 ){
	
				var correctType = activeQuestion.find('.doq_answers_container').data('count-correct');
				
				if( correctType == 0 ){
					var correctItem = activeQuestion.find('input[type="radio"][data-correct="1"]');
					//correctItem.parent().addClass('greenbg').delay(2000).queue(function(){
					//	correctItem.parent().removeClass('greenbg');
					//});
					
					//correctItem.prop( "checked", true );
					correctItem.siblings('.shik_img').attr('src',trueIconSrc);
					
					//activeQuestion.find('input[type="radio"]:checked').attr('src',wrongIconSrc);
					var xxxc = activeQuestion.find('input[type="radio"]');
					console.log(activeQuestion);
			
				}
				if( correctType == 1 ){						
					activeQuestion.find('input[type="checkbox"]').prop( "checked", false );						
					var correctItems = activeQuestion.find('input[type="checkbox"][data-correct="1"]');						
					//correctItems.parent().addClass('greenbg').delay(2000).queue(function(){
					//	correctItems.parent().removeClass('greenbg');
					//});
					correctItems.prop( "checked", true );						
				}
			
			}
			
			if( questionType == 1 ){
				
				var answerInput = activeQuestion.find('.filling_type_input');
				var userInput = activeQuestion.find('.filling_type_input').val();
				var correct = answerInput.data('correct');
				
				/*
				if( userInput == correct ){
					alert('Doğru cevap!');
				}else{
					alert('Yanlış cevap!');
				}
				*/					
				
				answerInput.addClass('greenbg').delay(2000).queue(function(){
					answerInput.removeClass('greenbg');
				});
				answerInput.val(correct);
			}
			
			if( questionType == 2 ){
				
				var wrapperKey = activeQuestion.find('.matris_key');
				var answersKey = activeQuestion.find('.doq_answer.answer_key');
				wrapperKey.html(answersKey.sort(sortEventsByOrder));
				
				var wrapperValue = activeQuestion.find('.matris_value');
				var answersValue = activeQuestion.find('.doq_answer.answer_value');
				wrapperValue.html(answersValue.sort(sortEventsByOrder));
				
			}
			
			if( questionType == 3 ){
				var wrapper = activeQuestion.find('.doq_answers_container');
				var answers = activeQuestion.find('.doq_answer');
				wrapper.html(answers.sort(sortEventsByOrder));
			}
				
			
		});
		
	//}
		
	$('.questionss').on('click', function(){
		$('.doq_question').toggleClass('sorulari_kapat');
		$('.yeni_sorulist').toggle();
		$('.prev_question').toggle();
		$('.next_question').toggle();
		
		if( $('.sorulari_kapat').length > 0 ){
			$('.questionss').html('GERİ DÖN');
		}else{
			$('.questionss').html('SORULAR');
		}
		
	});
	
	$(document).on('click', '.new_box', function (){
		$('.prev_question, .next_question').removeClass('disable');
		
		var i = $(this).data('icerik');
		var length = $('.new_box').length;
		
		$('.doq_question').hide();
		$('.doq_pager_element').removeClass('active');
		$('.doq_question').eq(i-1).fadeIn().addClass('active');
		$('.doq_pager_element').eq(i-1).addClass('active');
		
		if( i==1 ){
			$('.prev_question').addClass('disable');
		}
		if( i==length ){
			$('.next_question').addClass('disable');
		}
		
		$('.doq_question').removeClass('sorulari_kapat');
		$('.yeni_sorulist').hide();
		$('.prev_question').show();
		$('.next_question').show();
		
		if( $('.sorulari_kapat').length > 0 ){
			$('.questionss').html('GERİ DÖN');
		}else{
			$('.questionss').html('SORULAR');
		}
	
	});
	
	/**********************/
	
	$('.doq_question').each(function(i){
		
		var input_text = $(this).find('.filling_type_input');
		if( input_text.length > 0 ){
			
			input_text.on('keyup', function(){
				if( input_text.val().length == 0 ){
					$('.new_box').eq(i).removeClass('cevaplandi');
				}else{
					$('.new_box').eq(i).addClass('cevaplandi');
				}
			});
			
		}
		
		var input_checkbox = $(this).find('input[type="checkbox"]');
		if( input_checkbox.length > 0 ){
			
			input_checkbox.on('change', function(){
				
				var checkedInputsLength = input_checkbox.filter(':checked').length;
				if( checkedInputsLength > 0 ){
					$('.new_box').eq(i).addClass('cevaplandi');
				}else{
					$('.new_box').eq(i).removeClass('cevaplandi');
				}
				
			});
			
		}
		
		
		var input_radio = $(this).find('input[type="radio"]');
		if( input_radio.length > 0 ){
			
			input_radio.on('change', function(){
				
					$('.doq_question').eq(i).find('.dolu').hide();
					$('.doq_question').eq(i).find('.bos').show();
				
					if ( input_radio.is(':checked') ){
						
						input_radio.filter(':checked').siblings('.bos').hide();
						input_radio.filter(':checked').siblings('.dolu').show();
						
						var quesInd = input_radio.data('question-ind');
						$('.new_box').eq(quesInd).addClass('cevaplandi');
						
					}
				
			});
		
		}
	
		
	});

	
	
});