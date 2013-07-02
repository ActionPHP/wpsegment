(function () {
	
	window.App = {

		Models: {},
		Views: {},
		Collections: {},
		Router: {}

	}
	
	var vent = _.extend({}, Backbone.Events);

	App.Models.Quiz = Backbone.Model.extend({});
	App.Models.Question = Backbone.Model.extend({});
	App.Models.Answer = Backbone.Model.extend({});

	App.Views.Quiz = Backbone.View.extend({

		el: '#view-port',

		initialize: function(){
			
			this.collection = new App.Collections.Questions;
			this.collection.comparator = function (question) {
				return question.get('position');
			}
			
			this.render();
		},

		render: function(){

			var template = jQuery('#quiz-template').html();
			this.$el.html(template);
			
			this.renderQuizQuestions();

		},

		events: {

			'click #add-question-button' : 'addQuestion'

		},

		renderQuizQuestions: function() {
			
			var that = this;
			this.collection.fetch({

				success: function(questions) {
										
					_.each(questions.models, function (question) {
						
						that.renderQuestion(question);

					});

				}


			});
			
		},

		addQuestion: function () {

			var question = new App.Models.Question({ text: null});
			this.renderQuestion(question);
			that.collection.add(question);



		},

		renderQuestion: function (question) {
			var questionView = new App.Views.Question({ model: question});

			var view = questionView.render();
			var viewEl = view.el;
			var $el = view.$el;
			
			jQuery('#question-list').append(viewEl);
			question.set('position', $el.index());

		}

	});

	App.Views.Question = Backbone.View.extend({

		initialize: function (e) {
			vent.on('question-order:change', function(){

				this.saveQuestion();

			}, this )
		},

		tagName: 'li',

		render: function () {

			var template = _.template(jQuery('#question-template').html());
			var view = template(this.model.toJSON());
			this.$el.html(view);
			this.messageEl = this.$el.find('.question-messages');


			var question = this.model;
			var question_id = question.id;

			this.renderAnswers(question_id);

			return this;
		},

		renderAnswers: function (question_id) {

			var that = this;

			var answers = new App.Collections.Answers;
			answers.url = ajaxurl + '?action=actionphp_get_answers&question_id=' + question_id;

			answers.fetch({

				success: function (answers) {
					_.each(answers.models, function (answer) {
						that.renderOneAnswer(answer);
					})
				}

			});

			
			
		},

		events: {

			'click .add-answer' : 'addAnswer',
			'click .question-text' : 'editQuestion',
			'click .save-question'	: 'saveQuestionClose',
			'click .cancel-question'	: 'closeQuestionEdit',
			'click .remove-question' : 'removeQuestion',
			'keypress .edit-question-input' : 'keyPress'
		},

		keyPress: function (key) {
			var code = (key.keyCode ? key.keyCode : key.which);
            if (code == 13) this.saveQuestionClose();
		},

		addAnswer: function () {

			var answer = new App.Models.Answer({ text: null , points: 0, question_id: this.model.id });
			this.renderOneAnswer(answer);
			
		},

		renderOneAnswer: function (answer) {
			var answerView = new App.Views.Answer({ model: answer });
			var view = answerView.render().el;
			
			//If we don't have an id for the question, then we shouldn't create the answers.
			// That's because the question hasn't been saved yet, and we can't assign the question_id to the answer.
			if(this.model.id){

				this.$el.find('.answer-space').append(view);

			} else {

					showQuizMessage(this.messageEl, '⚠ Please create the question first!', 'error');
				
				}

		},

		editQuestion: function (e) {

			var value = this.model.get('text');
			value = (value == null ) ? '' : value;
			var element = e.currentTarget;
			this.$element = jQuery(element);

			this.$element.html('<textarea type = "text" class="edit-question-input" style="width: 300px; height: 100px;">' + value + '</textarea> <input type="button" value="Save" class="save-question" /> <input type="button" value="Cancel" class="cancel-question" />');
			this.$element.attr("class", 'question-text-editing');

			this.$questionInput = jQuery(element).find('.edit-question-input');
			this.$questionInput.focus();
			
		},

		saveQuestionClose: function (e) {

			var value = '';
			value = this.model.get('text');

			var newValue = jQuery.trim(this.$questionInput.val());

			if(newValue != ''){
				
				this.model.set('text', newValue);
				this.saveQuestion();

			}  

			this.closeQuestionEdit(); //If the value is empty we simply cancel the question edit
			

		},

		closeQuestionEdit: function (e) {
			var value = '';

			value = this.model.get('text');
			value = ( value == null ) ? 'Click here to edit question.' : value;
			this.$element.text(value);
			this.$element.attr("class", 'question-text');

		},

		saveQuestion: function () {

			showQuizMessage(this.messageEl, 'Saving...', 'process');

			var that = this;
			var position = this.$el.index();
			
			this.model.set('position', position);

			var question = this.model;
			
			
			console.log(question.get('text') + question.get( 'position'));

			question.url = ajaxurl + '?action=actionphp_save_question';
			question.save({},{

				success: function () {
					
					showQuizMessage(that.messageEl, 'Saved', 'success');
				}

			});

		},

		removeQuestion: function (e) {
			var question = this.model;

			if(question.id){

				if(confirm("Are you sure you want to delete this question and all it's answers? \n This cannot be undone!")){
					
					var that = this;

					showQuizMessage(this.messageEl, 'Deleting question...', 'process');

					question.url = ajaxurl + '?action=actionphp_delete_question&question_id=' + question.id;
					question.destroy({

						success: function (response) {
							
							that.$el.fadeOut('fast');
							that.remove();
						}

					});


				}

			} else {

				this.remove();

			}
		}

	});
	App.Views.QuestionList = Backbone.View.extend({});
	App.Views.QuestionItem = Backbone.View.extend({});


	App.Views.Answer = Backbone.View.extend({

		tagName: 'li',

		render: function () {
			
			var template = _.template(jQuery('#answer-template').html());
			var view = template(this.model.toJSON());

			this.$el.html(view);
			this.messageEl = this.$el.find('.answer-messages');


			return this;
		},

		events: {

			'click .answer-text' : 'editAnswer',
			'click .save-answer'	: 'saveAnswerClose',
			'click .cancel-answer'	: 'closeAnswerEdit',

			'click .points-text' : 'editPoints',
			'click .save-points'	: 'savePointsClose',
			'click .cancel-points'	: 'closePointsEdit',

			'click .remove-answer' : 'removeAnswer',

			'keypress .edit-answer-input' : 'keyPress',
			'keypress .edit-points-input' : 'keyPressPoints',

			'click .custom-response': 'customResponse',
			'click .save-custom-response' : 'saveCustomResponse'

		},

		customResponse: function (e) {

			e.preventDefault();
			//console.log(this.model.toJSON());
			var _model = this.model;

			var _modal = jQuery(this.$el).find('.modal-area'); 
			_modal.html(jQuery('#modal-template').html());

			_modal.find('#modal-header').html(_model.get('text'));
			_modal.find('#modal-textarea').html(_model.get('custom_text'));
			
			this.modal = _modal; //Let's pass this thing to main object so other functions can use it.

			jQuery('.modal').modal();
			jQuery('.modal').on('hidden', function () {

				_modal.html('');

			})

			_modal.find('#modal-textarea').focus();
			return false;
		},

		saveCustomResponse:function (e) {

			var custom_response = this.modal.find('#modal-textarea').val();
			this.model.set('custom_text', custom_response);
			
			this.saveAnswer();

			jQuery('.modal').modal('hide');
			
		},

		keyPress: function (key) {
			var code = (key.keyCode ? key.keyCode : key.which);
            if (code == 13) this.saveAnswerClose();	
		},

		keyPressPoints: function (key) {
			var code = (key.keyCode ? key.keyCode : key.which);
            if (code == 13) this.savePointsClose();	
		},

		editAnswer: function (e) {
			
			var value = this.model.get('text');
			value = (value == null ) ? '' : value;
			var element = e.currentTarget;
			this.$element = jQuery(element);

			this.$element.html('<input type = "text" value="'+ value + '" class="edit-answer-input regular-text" /> <input type="button" value="Save" class="save-answer" /> <input type="button" value="Cancel" class="cancel-answer" />');
			this.$element.attr("class", 'answer-text-editing');

			this.$answerInput = jQuery(element).find('.edit-answer-input');
			this.$answerInput.focus();
/**/		},

		saveAnswerClose: function () {
			

			var value = '';
			value = this.model.get('text');

			var newValue = jQuery.trim(this.$answerInput.val());

			if(newValue != ''){

				this.model.set('text', newValue);
				this.saveAnswer();

			}  

			this.closeAnswerEdit(); //If the value is empty we simply cancel the question edit
			

		},

		closeAnswerEdit: function () {
			
			var value = '';

			value = this.model.get('text');
			value = ( value == null ) ? 'Click here to edit answer.' : value;
			this.$element.text(value);
			this.$element.attr("class", 'answer-text');
		},

		saveAnswer: function () {
			var that = this;
			var answer = this.model;
			answer.url = ajaxurl + "?action=actionphp_save_answer";
			answer.save({}, {

				success: function (response) {
					that.render();
				}
			});
		},

		editPoints: function (e) {
			
				if(this.model.id){

					this.editPointsBox(e);
				} else {

					showQuizMessage(this.messageEl, ' ⚠ Please create an answer first.', 'error');

				}

/**/		},

		editPointsBox: function (e) {
			
			var value = this.model.get('points');
			value = (value == null || isNaN(value) ) ? 0 : value;
			
			var element = e.currentTarget;
			this.$element = jQuery(element);

			this.$element.html('<input type = "text" value="'+ value + '" class="edit-points-input small-text" /> <input type="button" value="Save" class="save-points" /> <input type="button" value="Cancel" class="cancel-points" />');
			this.$element.attr("class", 'points-text-editing');

			this.$pointsInput = jQuery(element).find('.edit-points-input');
			this.$pointsInput.focus();
		},

		savePointsClose: function () {
			

			var value = '';
			value = this.model.get('points');
			

			var newValue = jQuery.trim(this.$pointsInput.val());
			newValue = (newValue == null || isNaN(newValue) ) ? 0 : newValue;

			if(newValue != ''){

				this.model.set('points', newValue);
				this.saveAnswer();

			}  

			this.closePointsEdit();

		},

		closePointsEdit: function () {
			
			var value = '';

			value = this.model.get('points');
			value = ( value == null ) ? 0 : value;
			this.$element.text(value);
			this.$element.attr("class", 'points-text');
		},

		removeAnswer: function (e) {
			
			var answer = this.model;

			if(answer.toJSON().id){

				if(confirm("Are you sure you want to remove this answer?")){
					var that = this;

					showQuizMessage(this.messageEl, 'Deleting...', 'process');

					answer.url = ajaxurl + '?action=actionphp_delete_answer&answer_id=' + answer.id;

					answer.destroy({

						success: function (model, response) {

								that.$el.fadeOut('fast', function () {
							
								that.remove();

							})
							
						}
					});
				}

			} else {

				this.remove();
			}
			
		}
		

	});
	App.Views.AnswerList = Backbone.View.extend({});
	App.Views.AnswerItem = Backbone.View.extend({});

	App.Collections.Questions = Backbone.Collection.extend({

		url: ajaxurl + '?action=actionphp_get_question'

	});

	App.Collections.Answers = Backbone.Collection.extend({});

	jQuery(document).ready(function(){

	var mainQuizView = new App.Views.Quiz;
	jQuery('#question-list').sortable({

		update: function (event, ui) {
			console.log('New Quiz Order');
			vent.trigger('question-order:change');
		}

	});

	

	});

})();


function showQuizMessage(el, message, type){
	el.text('');
	el.show();
	
	var color = '#333333';
	switch(type){

		case 'process':

			color = '#003366';

		break;

		case 'success':

			color = '#008C00'
				
		break;

		case 'error':

			color = '#B02B2C';

		break;

		default:

			color = '#333333';

		break;

	}

	el.css('color', color).text(message);
	if( type != 'process'){
		el.fadeOut(3000);
	}
	
}