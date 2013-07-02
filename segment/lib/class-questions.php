<?php


	class WPSegmentQuestions
	{

		public function create($request)
		{
			$content = trim(stripslashes($request->text));
			$position = $request->position;

			$table = $this->getQuestionTable();

			$id = $table->create($content, 'content');

			$request->id = $id;

			return $id;

		}

		public function get($id='')
		{
			$table = $this->getQuestionTable();

			if($id){

				$response = $table->get($id);
				$response->text = trim(stripslashes($response->content));

			} else {

				$response = $table->get();

				foreach ($response as $question) {
					
					$question->text = trim(stripslashes($question->content));

				}
			}

			return $response;
		}

		public function update($request)
		{
			$id = $request->id;

			//print_r($request); die();
			$content = $request->text;
			$position = trim(stripslashes($request->position));

			$table = $this->getQuestionTable();

			$table->update($id, $content, 'content');
			$table->update($id, $position, 'position');

		}

		public function delete($id='')
		{
			$table = $this->getQuestionTable();
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