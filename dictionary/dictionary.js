$(document).ready(function () {
  var wcount = 1;
  var qcount = 1;

  $('.add-more-words').on('click', function () {
    var no_of_words = $('input[name=no_of_words]').val();
    var word_length = $('input[name=word_length]').val();
    var data = {labeltext: 'Enter Word', no_of_words: no_of_words, word_length: word_length, operation_type: 'add_word', div_class: 'words-input-wrapper', wrapper_id: 'word-wrapper'};
    add('text', 'word', data);
  });

  $('input[name=no_of_words]').on('keyup', function () {
    var no_of_words = $(this).val();
    if (no_of_words.length > 0) {
      $('#add-words').show();
    }
    else {
      $('#add-words').hide();
      $('.words-input-wrapper').slice(1).remove();
      wcount = 1;
    }
  });

  $('input[name=word_length]').on('keyup', function () {
    var word_length = $(this).val();
    $('#word-wrapper input').each(function () {
      $(this).attr("maxlength", word_length);
    });

    $('#query-wrapper input').each(function () {
      $(this).attr("maxlength", word_length);
    });
  });

  function add(type, name, data) {
    var wflag = false;
    var qflag = false;
    var counter;
    switch (data.operation_type) {
      case 'add_word':
        wcount++;
        if (wcount <= data.no_of_words) {
          counter = wcount;
          wflag = true;
        }
        break;

      case 'add_query':
        qcount++;
        if (qcount <= data.no_of_queries) {
          counter = qcount;
          qflag = true;
        }
        break;
    }

    if (wflag || qflag) {
      var newDiv = document.createElement("div");
      newDiv.setAttribute("class", data.div_class);
      var foo = document.getElementById(data.wrapper_id);
      // Append the element in page.
      foo.appendChild(newDiv);

      // Create an input type dynamically.
      var element = document.createElement("input");
      // Assign different attributes to the element.
      element.setAttribute("type", type);
      element.setAttribute("name", name + counter);
      element.setAttribute("maxlength", data.word_length);
      newDiv.appendChild(element);

      var linebreak = document.createElement("br");
      newDiv.appendChild(linebreak);

      var label = document.createElement("label");
      label.innerHTML = data.labeltext + ' ' + counter;
      newDiv.insertBefore(label, element);
      label.after(linebreak);
    }
  }

  $('input[name=no_of_queries]').on('keyup', function () {
    var no_of_queries = $(this).val();
    if (no_of_queries.length > 0) {
      $('#add-queries').show();
    }
    else {
      $('#add-queries').hide();
      $('.query-input-wrapper').slice(1).remove();
      qcount = 1;
    }
  });

  $('.add-more-queries').on('click', function () {
    var no_of_queries = $('input[name=no_of_queries]').val();
    var word_length = $('input[name=word_length]').val();
    var data = {labeltext: 'Enter Query', no_of_queries: no_of_queries, word_length: word_length, operation_type: 'add_query', div_class: 'query-input-wrapper', wrapper_id: 'query-wrapper'};
    add('text', 'query', data);
  });
});
