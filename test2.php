<?php
	require_once('index.php');

	$words = "Notepad++ is a free (as in \"free speech\" and also as in \"free beer\") source code editor and Notepad replacement that supports several programming languages and natural languages. Running in the MS Windows environment, its use is governed by GPL License.";
	$sentence = new use_break_sentence($words, true);
	$wordsArray = $sentence->use_method("word array", 0);
	foreach ($wordsArray as $key=>$value)
	{
		echo "Key = $key &nbsp; &nbsp; &nbsp; Word = $value<br/>";
	}
	echo "<hr/>";
	$wordsCount = $sentence->use_method("words count", 0);
	echo "Total Number of word: $wordsCount<hr/>";
	$wordsPos = $sentence->use_method("find pos", 0);
	foreach ($wordsPos as $key=>$value)
	{
		echo "Key = $key &nbsp; &nbsp; &nbsp; Word = $value<br/>";
	}
	echo "<hr/>";
?>