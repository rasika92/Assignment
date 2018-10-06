<?php

require 'Word.php';
require 'QueryWord.php';

$no_of_words_in_dictionary = $_POST['no_of_words'];
$word_length = $_POST['word_length'];
$no_of_queries = $_POST['no_of_queries'];
for($i=1;$i<=$no_of_words_in_dictionary;$i++) {
  $words[] = $_POST["word$i"];
}
for($j=1;$j<=$no_of_queries;$j++) {
  $queries[] = $_POST["query$j"];
}

foreach ($words as $wkey => $word) {
  $warray[$word] = new Word($word);
}
foreach ($queries as $qkey => $query) {
  $qarray[$query] = new QueryWord($query);
}

foreach ($qarray as $qarraykey => $eachq) {
  $matches[$qarraykey] = [];
  foreach ($warray as $warraykey => $eachw) {
    $result = $eachw->isMatch($eachq);
    if ($result) {
      $matches[$qarraykey][] = $warraykey;
    }
  }
}

foreach ($matches as $mkey => $match) {
  print'<pre>';print_r('Number of words for query "' . $mkey . '" is - ' . sizeof($match));'</pre>';
}
