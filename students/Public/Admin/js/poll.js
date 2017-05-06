function json() {
  $.getJSON("{$Think.const.HOME_JS_URL}poll.json", function(data) {
    $.each(data,function(key, value) {
      console.log(key + "," + value);
    });
  });
}
