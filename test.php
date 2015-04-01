<?php
/*--------------------------------
 * @Description   sentence-interpreter test file. This file tests all methods and the entire class for full functionality
 * @author    	  Samuel Adeshina <samueladeshina73@gmail.com>
 * @copyright     2015 Samuel Adeshina <samueladeshina73@gmail.com>
 * @license       http://www.opensource.org/licenses/BSD-3-Clause  The BSD 3-Clause License
 * @requires      This PHP file requires the break_sentence.php file bunlded & distributed together to function
 -------------------------------*/
 require_once("break_sentence.php");
 class use_break_sentence extends break_sentence
 {
 	function use_method($method_to_test, $optional_parameter)
 	{
 		if (isset($method_to_test) && ($method_to_test != ''))
 		{
 			$method_to_test = strtolower($method_to_test);
 			switch($method_to_test)
 			{
 				case "word_array":
 				case "word array":
 					return self::word_array();
 					break;
 				case "delimit_word":
 				case "delimit word":
 					return self::delimit_word($optional_parameter);
 					break;
 				case "words_count":
 				case "words count":
 					return self::words_count();
 					break;
 				case "group_words":
 				case "group words":
 					return self::group_words($optional_parameter);
 					break;
 				case "validity":
 					return self::validity($optional_parameter);
 				case "find_pos":
 				case "find pos":
 					return self::find_pos();
 				default:
 					return "You have entered an invalid parameter";
 			}
 		}
 	}
 }

 //begin test
 $sentence_array = array("1"=>"My name is Samuel Adeshina. I am 16 Years Old",
 						"2"=>"Life is fair only to fair peoplem, that is one big fair lie from somebody who has never told a lie",
 						"3"=>"English Language is a LANGUAGE a language of languages",
 						"4"=>"I dont know what else to write, but i know one thing this class has a lot of promise for the english fanatics",
 						"5"=>"Alright! Lets begin the long journey to testing this program");
 $random = rand(1, 5);
 $sentence_to_use = $sentence_array[$random];
 $sentence = new use_break_sentence($sentence_to_use, true);
 $numberOfWords = $sentence->use_method("words count", 0);
 $arrayOfWords = $sentence->use_method("word array", 0);
 $delimitedWords = $sentence->use_method("delimit words", false);
 $isValidWord = $sentence->use_method("validity", "dict_files");
 $partOfSpeech = $sentence->use_method("find pos", 0);
 $distinctWords = $sentence->use_method("group_words", true);
 echo "<center><h1>EXAMPLES (Sentence-Interpreter)</h1></center><br/>SUPPLIED SENTENCE: <h2>".$sentence_to_use."</h2><br/>";
 echo <<<_END
 	<table border="1">
 		<tr style = "background-color: #333; color: #fff">
 			<th>Number of Words</th>
 			<th>Array Words</th>
 			<th>Array of Distinct Words In Sentence</th>
 			<th>Array of Words + their Validity</th>
 			<th>Array of words + their part of speech</th>
 		</tr>
 		<tr>
 			<th>$numberOfWords</th>
 			<th>
_END;
			print_r($arrayOfWords);
			echo "</th><th>";
			print_r($distinctWords);
			echo "</th><th>";
			print_r($isValidWord);
			echo "</th><th>";
			print_r($partOfSpeech);
			echo "</th></tr></table>";
 ?>
