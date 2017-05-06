$in = $(".insert_poll");
var answer = [];
var tid = [];
var rid = [];
var cid = [];
var tAns = [];
var rAns = [];
var cAns = [];
var template = $('#poll').html();
var survey = [];
var count = 1;
var quesions = []
var options = [];
var textd = [];
var radiod = [];
var checkboxd = [];

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
	questions = q[0];
	options = q[1];
	addQ();
}

function addQ() {
		questions.forEach(function(question) {
		var kind = question.kind;
		if (kind == "text") {
			textd = {
				"title": question.content,
				"text": [{"id": question.id}],
				"count": count
			}
			tid.push(question.id);
			survey.push(textd);
			count += 1;
		} else if (kind == "radio") {
			
			var qId = question.id;
			rid.push(qId);
			var option = [];
			var radio = [];
			options.forEach(function(opt){
				if(opt.quest_id == qId){
					option.push(opt);
				}
			})
			option.forEach(function(op) {
				radio.push({
					"value": op.content,
					"id": op.quest_id
				})
			});
			radiod = {
				"title": question.content,
				"radio": radio,
				"count": count
			}
			survey.push(radiod);
			count += 1;
		} else if (kind == "checkbox") {
			
			var qId = question.id;
			cid.push(qId);
			var option = [];
			var checkbox = [];
			options.forEach(function(opt){
				if(opt.quest_id == qId){
					option.push(opt);
				}
			})
			option.forEach(function(op) {
				checkbox.push({
					"value": op.content,
					"id": op.quest_id
				})
			});
			checkboxd = {
				"title": question.content,
				"checkbox": checkbox,
				"count": count,
			}
			survey.push(checkboxd);
			count += 1;
		}

	})
	var result = Mustache.render(template, {survey: survey});
	$in.append(result);
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
	if (answer.length == count - 1 && count > 1) {
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
		alert("请填写完整！");
	}
}

