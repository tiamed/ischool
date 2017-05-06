

var template = $("#major_template").html(),
    $target = $(".insert_form"),
    $btnAdd = $(".add"),
    $btnRemove = $(".delete"),
    count = 1,
    inputRow = [];

    $btnAdd.click(function(e){
      e.preventDefault();
      addRows();
    });

    $btnRemove.click(function(e){
      e.preventDefault();
      removeRows();
    });

function addRows(){
    inputRow = {
      count : count
    }
    var html = Mustache.to_html(template, inputRow);
    $target.append(html);
    count++;
}

function removeRows(){
  $target.find('.basic_form_inputs').last().remove();
  if(count <= 1){
    count = 1;
  }else{
    count--;
  }
}

addRows();