$in = $(".insert_poll");
var answer = [];
var tid = [];
var rid = [];
var cid = [];
var tAns = [];
var rAns = [];
var cAns = [];
function json() {
	if (window.XMLHttpRequest) {
		var xhr = new XMLHttpRequest();
	} else if (window.ActiveXObject) {
		var xhr = new ActiveXObject("Microsoft.XMLHTTP");
	}

	xhr.open("GET", path, false);
	xhr.send(null);
	var q = JSON.parse(xhr.responseText);
	if(q){
		window.q = q;
	}
	window.questions = q[0];
	window.options = q[1];
	addQuestion();
}

function addQuestion() {
	var html = '';
	var text0 = '<div class="form-group row"><label class="form-control-label col-md-2">';
	var text1 = '</label><div class="col-md-4"><input type="text" autocomplete="off" class="form-control" required="required" name="';
	var radio1 = '</label><div class="col-md-4" id="radio">';
	var radio2 = '<input type="radio" name="';
	var checkbox1 = '</label><div class="col-md-4" id="checkbox">';
	var checkbox2 = '<input type="checkbox" name="';
	var div0 = '</div></div>'
	// var ques = questions.find(quesId);
	questions.forEach(function(question) {
		var kind = question.kind;
		if (kind == "text") {
			html += text0 + question.content + text1 + question.id + '" id="' + question.id +'">' +div0;
			tid.push(question.id);
		} else if (kind == "radio") {
			html += text0 + question.content + radio1;
			var qId = question.id;
			rid.push(qId);
			var option = [];
			options.forEach(function(opt){
				if(opt.quest_id == qId){
					option.push(opt);
				}
			})
			option.forEach(function(op) {
				html += radio2 + op.quest_id + '" value="' + op.content + '">' + op.content + '<br>';
			});
			html += div0;
		} else if (kind == "checkbox") {
			html += text0 + question.content + checkbox1;
			var qId = question.id;
			cid.push(qId);
			var option = [];
			options.forEach(function(opt){
				if(opt.quest_id == qId){
					option.push(opt);
				}
			})
			option.forEach(function(op) {
				html += checkbox2 + op.quest_id + '" value="' + op.content + '">' + op.content + '<br>';
			});
			html += div0;
		}

	})
	$in.append(html);
}

function getTextAnswer() {
	tid.forEach(function(id) {
		var idsel = "#" + id;
		if ($(idsel).val()){
			tAns.push([id, $(idsel).val()]);
		}
	})
}

function getRAnswer() {
	rid.forEach(function(id) {
		var radios = document.getElementsByName(id);
		for (var i = 0, length = radios.length; i < length; i++) {
		    if (radios[i].checked) {
		        rAns.push([id, radios[i].value]);
		        break;
		    }
		}
	})
}

function getCAnswer() {
	cid.forEach(function(id) {
		var checkboxes = document.getElementsByName(id);
		var values = [];
		for (var i = 0, length = checkboxes.length; i < length; i++) {
		    if (checkboxes[i].checked) {
		        values.push(checkboxes[i].value);
		    }
		}
		if (values.length > 0) {
	    	cAns.push([id, values]);
	    }
	})
}

function posta() {
	var ids = tid.concat(rid, cid);
	getTextAnswer();
	getCAnswer();
	getRAnswer();
	answer = tAns.concat(rAns, cAns);
	ajaxpost();
}

function ajaxpost() {
	if (answer.length > 0) {
		$.ajax({
	            method: "POST",
	            url: xpath,
	            dataType: "text",
	            data: {answer: answer},
	            success: function(){
	                location.href=repath
	            }
	            })
	} else {
		alert("请先填写！");
		answer = [];
	}
}