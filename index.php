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

 ?>
