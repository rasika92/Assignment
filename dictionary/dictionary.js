$(document).ready(function () {
  var wcount = 1;
  var qcount = 1;

  $('.add-more-words').on('click', function () {
    // Remove the error div.
    $('.add-more-words-error').remove();
    // Get the number of words from the input.
    var no_of_words = $('input[name=no_of_words]').val();
    // Get the word length from the input.
    var word_length = $('input[name=word_length]').val();
    // Create an object to add new field.
    var data = {labeltext: 'Enter Word', no_of_words: no_of_words, word_length: word_length, operation_type: 'add_word', div_class: 'words-input-wrapper', wrapper_id: 'word-wrapper'};
    // Call function to add new field.
    add('text', 'word', data);
    // If the user clicks on Add more words after the limit is reached, show error.
    if (wcount > no_of_words) {
      $(this).after('<div class="add-more-words-error">You can add only ' + no_of_words + ' words as per the given input.</div>');
    }
  });

  $('input[name=no_of_words]').on('keyup', function () {
    // On entering the no of words, show the fields to add words.
    var no_of_words = $(this).val();
    if (no_of_words.length > 0) {
      $('#add-words').show();
    }
    else {
      // If the field is made empty, hide the fields to add words except first field.
      $('#add-words').hide();
      $('.words-input-wrapper').slice(1).remove();
      // Reset the counter which maintains the limit count on Add more.
      wcount = 1;
    }
  });

  $('input[name=word_length]').on('keyup', function () {
    var word_length = $(this).val();
    // On entering the word length, set all the word and query input fields max length to the entered input.
    $('#word-wrapper input').each(function () {
      $(this).attr("maxlength", word_length);
    });

    $('#query-wrapper input').each(function () {
      $(this).attr("maxlength", word_length);
    });
  });

  // Function to add new field.
  function add(type, name, data) {
    // Set theword and query flag to false.
    var wflag = false;
    var qflag = false;
    var counter;
    // Switch case to decide whether word or query field needs to be added.
    switch (data.operation_type) {
      case 'add_word':
        wcount++;
        // If the limit to add words is not reached, increment the counter and set flag to true.
        if (wcount <= data.no_of_words) {
          counter = wcount;
          wflag = true;
        }
        break;

      case 'add_query':
        qcount++;
        // If the limit to add query is not reached, increment the counter and set flag to true.
        if (qcount <= data.no_of_queries) {
          counter = qcount;
          qflag = true;
        }
        break;
    }

    // If either of the flag is set, then create new field.
    if (wflag || qflag) {
      // Create new div element.
      var newDiv = document.createElement("div");
      // Set div class.
      newDiv.setAttribute("class", data.div_class);
      // Get the wrapper to which the new div needs to be attached.
      var foo = document.getElementById(data.wrapper_id);
      // Append the element in page.
      foo.appendChild(newDiv);

      // Create an input type dynamically.
      var element = document.createElement("input");
      // Assign different attributes to the element.
      element.setAttribute("type", type);
      element.setAttribute("name", name + counter);
      element.setAttribute("maxlength", data.word_length);
      element.setAttribute("required", '');
      newDiv.appendChild(element);

      // Create a linebreak.
      var linebreak = document.createElement("br");
      // Create linebreak after new div.
      newDiv.appendChild(linebreak);

      // Create label element.
      var label = document.createElement("label");
      // Set the label text.
      label.innerHTML = data.labeltext + ' ' + counter;
      // Insert the label before the input.
      newDiv.insertBefore(label, element);
      // Add mandatory field sign to label.
      $('<sup>*</sup><br/>').insertAfter(label);
    }
  }

  $('input[name=no_of_queries]').on('keyup', function () {
    // On entering the no of queries, show the fields to add queries.
    var no_of_queries = $(this).val();
    if (no_of_queries.length > 0) {
      $('#add-queries').show();
    }
    else {
      // If the field is made empty, hide the fields to add queries except first field.
      $('#add-queries').hide();
      $('.query-input-wrapper').slice(1).remove();
      // Reset the counter which maintains the limit count on Add more.
      qcount = 1;
    }
  });

  $('.add-more-queries').on('click', function () {
    // Remove the error div.
    $('.add-more-queries-error').remove();
    // Get the number of queries from the input.
    var no_of_queries = $('input[name=no_of_queries]').val();
    // Get the word length from the input.
    var word_length = $('input[name=word_length]').val();
    // Create an object to add new field.
    var data = {labeltext: 'Enter Query', no_of_queries: no_of_queries, word_length: word_length, operation_type: 'add_query', div_class: 'query-input-wrapper', wrapper_id: 'query-wrapper'};
    // Call function to add new field.
    add('text', 'query', data);
    // If the user clicks on Add more words after the limit is reached, show error.
    if (qcount > no_of_queries) {
      $(this).after('<div class="add-more-queries-error">You can add only ' + no_of_queries + ' queries as per the given input.</div>');
    }
  });
});
