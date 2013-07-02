<?php

	class WPSegmentQuiz
	{

		public function render($medium='desktop-php')
		{
			
			switch ($medium) {
				case 'desktop-php':
					$this->renderDesktopPHP();
					break;

				case 'desktop-js':
					$this->renderDesktopJS();
					break;

				case 'mobile-php':
					$this->renderMobilePHP();
					break;

				case 'mobile-js':
					$this->renderMobileJS();
					break;
				
				default:
					$this->renderDesktopPHP();
					break;
			}
		}

		public function renderDesktopPHP()
		{
			

			$this->getHeader();
			$this->getViewPortPHP();
			$this->getSubmitButton();
			$this->getFooter();

			#Templates

			$this->getEmailForm();

			
		}

		public function renderMobilePHP()
		{
			# code...
		}
		public function renderMobileJS()
		{
			# code...
			
		}
		public function renderDesktopJS()
		{
			# code...
		}

		public function getFullQuiz()
		{
			
			$questions = $this->getQuestions();

			foreach($questions as $question){

				$question->answers = $this->getAnswers($question->id);

			}

			$quiz = $questions;

			return $quiz;
		}

		public function getViewPortPHP($return = false)
		{
			session_start();

			$quiz = $this->getFullQuiz();
			
			$quiz_view_port = '<div id="quiz-view-port" >';
			$question_view = '';

			foreach ($quiz as $question) {
				$position++;

				$question_view .= '<div class="wp-segment-quiz-question">'."\n".'<form id="segment-quiz-form" >'."\n";
				$question_view .= '<p id="segment-quiz-question-'.$question->id.'" >'. $position . '. ' .$question->text.'</p>'."\n";
				$question_view .= $this->getAnswersHTML($question->answers);
				$question_view .= '</div>'."\n";
			}

			$quiz_view_port .= $question_view;
			$quiz_view_port .= '</form> </div>';

			if($return){

				return $quiz_view_port;
			} else {

				echo $quiz_view_port;

			}

		}

		public function getQuestions()
		{
			$wp_segment_questions = new WPSegmentQuestions;
			$questions = $wp_segment_questions->get();

			$questions = $this->reorderByPosition($questions);

			return $questions;

		}

		public function getAnswers($question_id)
		{
			$wp_segment_answers = new WPSegmentAnswers;
			$answers = $wp_segment_answers->get_by($question_id);

			return $answers;
		}

		public function reorderByPosition($array)
		{
			usort($array, array($this, "cmp"));

			return $array;

		}

		function cmp($a, $b)
		{
			return strcmp($a->position, $b->position);
		}

		public function getAnswersHTML($answers)
		{	
			$answers_view = '';
			foreach($answers as $answer){

				$answers_view .= '<label>'."\n";
				
				$answers_view .= '<input type="radio" name="answer-for-question-'.$answer->question_id.'" value="'.$answer->id.'" />'."\n";
				$answers_view .= ' <span class="quiz-answer-text" >'."\n";
				$answers_view .= $answer->text;
				$answers_view .= '</span>'."\n";

				$answers_view .= '</label>'."\n";


			}

			return $answers_view;
		}

		public function getHeader($header=''){

			include(AP_PATH. 'templates/default/header.php');


		}

		public function getFooter($footer=''){

			include(AP_PATH. 'templates/default/footer.php');


		}

		public function getTitle($title='Is this for you?'){


			return $title;
		}

		public function getEmailForm()
		{
	
			include(AP_PATH. 'templates/default/email-form.php');


		}

		public function getSubmitButton($return = false){

			$button = '<button id="submit-segment-quiz" class="btn btn-large btn-warning" type="button">Find out now!</button>';

			if($return){

				return $button;

			} else {

				echo $button;
			}

		}
	}

?>