<?php


	class WPSegmentAnswers
	{

		public function create($request)
		{
			$content = trim(stripslashes($request->text));
			$position = $request->position;
			$question_id = $request->question_id;
			$points = $request->points;

			$table = $this->getAnswerTable();

			$id = $table->create($content, 'content');
			$table->update($id,  $question_id, 'question_id', '%d');
			$table->update($id, $points, 'points', '%d');
			$request->id = $id;

			return $id;

		}

		public function get($answer_id)
		{
			$table = $this->getAnswerTable();

			$answer = $table->get($answer_id);

				$answer->text = trim(stripslashes($answer->content));
			
			return $answer;

		}

		public function get_by($question_id)
		{
			$table = $this->getAnswerTable();

			$response = $table->get_by($question_id, 'question_id');

			foreach ($response as $answer) {
				$answer->text = trim(stripslashes($answer->content));
			}

			return $response;

		}

		public function update($request)
		{
			$id = $request->id;

			//print_r($request); die();
			$content = $request->text;
			$position = $request->position;
			$question_id = $request->question_id;
			$points = $request->points;
			$custom_text = $request->custom_text;

			$table = $this->getAnswerTable();

			$table->update($id, $content, 'content');
			$table->update($id,  $question_id, 'question_id', '%d');
			$table->update($id,  $custom_text, 'custom_text');
			$table->update($id, $points, 'points', '%d');
		}

		public function delete($id='')
		{
			$table = $this->getAnswerTable();
			$table->delete($id);

		}

		public function getQuestionTable()
		{
			$table = new pp_action_php_builder('pp_actionphp_questions');
			return $table;
		}

		public function getAnswerTable()
		{
			$table = new pp_action_php_builder('pp_actionphp_answers');
			return $table;
			
		}
	}

?>