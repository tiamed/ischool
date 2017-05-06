$(function() {

	/*
	This code use mustache.js to
	create a template of the
	custom question input

	This can then be used to,
	add/remove questions, change
	question types, and add/remove
	variations
	*/

	var questions = (function() {
		var questions = [];
		// var i = 0;
		// cache DOM
		var $el = $('.basic_form');
		var $insert = $el.find('.insert_form');
		var $addSection = $el.find('#add-section-custom');
		var template = $el.find('#question_template').html();

		// bind events
		$addSection.on('click', addQuestion.bind(this, null));
		$el.on('change', '.select select', changeType);
		$el.on('click', 'a.delete_sub', removeQuestion.bind(this));
		$el.on('click', 'a.add_variation', addVariation.bind(this, -1));
		$el.on('click', 'a.delete_variation', removeVariation.bind(this));
		$el.on('keyup', '.basic_form_inputs > .textfield input', saveQuestion);
		$el.on('keyup', '.basic_form_inputs > .variations .textfield input', saveVariation);

		function render() {
			$insert.html(Mustache.render(template, {
				questions: questions
			}));
			window.questions = questions;
			// console.log(questions);
		}

		function getQuestions() {
			return questions;
		}

		function addQuestion(data) {
			if ($.trim(data)) {
				questions.push(data);
			} else {
				questions.push({
					type: "text",
					question: "",
					option: [{
						value: 'text',
						text: '开放性',
						select: true
					}, {
						value: 'radio',
						text: '单选',
						select: false
					}, {
						value: 'checkbox',
						text: '多选',
						select: false
					}],
					variation: []
				});
			}
			render();
		}

		function removeQuestion(event) {
			var index = getQuestionIndex(event);
			questions.splice(index, 1);
			render();
		}

		function getQuestionIndex(event) {
			var $question = $(event.target).closest('.basic_form_inputs');
			return $el.find('.insert_form').find('.basic_form_inputs').index($question);
		}

		function getVariationIndex(event) {
			var $variation = $(event.target).closest('.variation').first().index();
			return $variation;
		}

		function saveQuestion(event) {
			var index = getQuestionIndex(event);
			questions[index].question = $(event.target).val();
		}

		function saveVariation(event) {
			var questionIndex = getQuestionIndex(event);
			var variableIndex = getVariationIndex(event);
			questions[questionIndex].variation[variableIndex] = $(event.target).val();
		}

		function changeType(event) {
			// get index of question changed
			var index = getQuestionIndex(event);
			// set questions[index].option with value, select to true.
			var optionValue = $(event.target).val();
			var selectedObj = questions[index].option.map(function(selected) {
				if (selected.value == optionValue) {
					selected.select = true;
					questions[index].type = selected.value;
				} else {
					selected.select = false;
				}
			});
			// change variation depending on option selected
			if (optionValue !== "开放性") {
				addVariation(index);
			} else {
				removeVariations(index);
			}
		}

		function addVariation(index,event) {
			if (index < 0) {
				index = getQuestionIndex(event);
				questions[index].variation.push("");

			} else if (questions[index].variation.length <= 0) {
				questions[index].variation.push("");
			}
			render();
		}

		function removeVariation(event) {
			questionIndex = getQuestionIndex(event);
			variableIndex = getVariationIndex(event);
			if (variableIndex != 0) {
				questions[questionIndex].variation.splice(variableIndex, 1);
				render();
			}
		}

		function removeVariations(index) {
			questions[index].variation = [];
			render();
		}

		// make puplic
		return {
			addQuestion: addQuestion
		};
	})();

	questions.addQuestion();

});
