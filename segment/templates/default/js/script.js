$(document).ready(function () {

	$('#submit-segment-quiz').click(validateQuiz);
	$(':radio').change(function(e){

		var question_id = getQuestionIDFromAnswer( $(this).attr('name') );
		
		changeQuestionColor(question_id, true);
		

	})

});

function validateQuiz(){

	if(totalQuestionsAnswered()){

		submitSegmentQuizForm();

	} else {



	}

}

function totalQuestionsAnswered(){
	
	var answers = {};
	var total = 0;
	
	$(':radio').each(function (idx, value) {

		answers[$(value).attr('name')] = true;
		
	});

	$.each(answers, function (name) {

		var question_id = name.replace('answer-for-question-', '');

		if(!$('input[name='+ name + ']:checked').length){

			
			changeQuestionColor(question_id, false);
			

		} 

		total++;
	})
	
	var totalChecked = $(':radio:checked').length;

	if( total != totalChecked){
		
		console.log('There are still unanswered questions.');

		return false;


	} else {

		return true;
	}

	
	
}

function getAnsweredQuestions(){

	var checkedRadio= $(':radio:checked');
	var answeredQuestions = Array();
	
	$.each(checkedRadio, function(idx, element){

		var name = $(element).attr('name');
		var question_id = getQuestionIDFromAnswer (name);
		answeredQuestions.push(question_id);
	});

	return answeredQuestions();
}

function changeQuestionColor(question_id, answered){

	var el = '#segment-quiz-question-' + question_id;

	switch(answered){

		case true:
			
			$(el).css('color', '#000000');

		break;

		case false:

			$(el).css('color', '#cc0000');

		break;
	}

}

function getQuestionIDFromAnswer (name) {
	return name.replace('answer-for-question-', '');
}

function submitSegmentQuizForm(){

	$.post(

			ajaxurl + '?action=actionphp_process_quiz',

			$('form#segment-quiz-form').serialize(),

			function(response)
			{
				showResult();
				console.log(response);

			}

		)


}

function showResult(){

	var emailForm = $('#wp-segment-email-form-template').html();
	$('#main-view-port').html(emailForm);
	$('#submit-contact-details').click(submitContactDetails);



}

function submitContactDetails(){

	var formData = $('#wp-segment-email-form').serialize();
	
	console.log('Submitting...');
	
	$.post(

			ajaxurl + '?action=actionphp_store_contact',

			formData,

			function(response){

				console.log(response);

			}


		);

}