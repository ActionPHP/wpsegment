<?php


class WPSegmentResults
{

	public function processQuiz()
	{
		$this->answer_array = $this->getAnswerArray();
		
		$points = $this->calculate($this->answer_array);

		$this->results = $points;

		return $points;
	}

	public function calculate($answers)
	{	
		$points = 0;

		foreach($answers as $answer_id )
		{

			$wp_segment_answers = new WPSegmentAnswers;
			
			$answer = $wp_segment_answers->get($answer_id);

			$points += $answer->points;
			
		}

		return $points;

	}

	public function getAnswerArray()
	{

		$user_response = $_POST;
		
		foreach($user_response as $element_name => $answer_id )
		{

			$question_id = (int) trim(stripslashes(str_replace('answer-for-question-', '', $element_name)));
			$answers[$question_id] = (int) $answer_id;

		}

		return $answers;
	}

	public function results(){


		return $this->results;
	}

}
?>