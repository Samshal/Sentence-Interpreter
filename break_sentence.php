<?php
/**
 * Sentence-Interpreter
 *
 * Copyright (c) 2015, Samuel Adeshina <samueladeshina73@gmail.com>.
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions
 * are met:
 *
 *   * Redistributions of source code must retain the above copyright
 *     notice, this list of conditions and the following disclaimer.
 *
 *   * Redistributions in binary form must reproduce the above copyright
 *     notice, this list of conditions and the following disclaimer in
 *     the documentation and/or other materials provided with the
 *     distribution.
 *
 *   * Neither the name of Samuel Adeshina nor the names of his
 *     contributors may be used to endorse or promote products derived
 *     from this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDER
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS
 * FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
 * COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
 * INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING,
 * BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
 * CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT
 * LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN
 * ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * @package   sentence-interpreter
 * @author    Samuel Adeshina <samueladeshina73@gmail.com>
 * @copyright 2015 Samuel Adeshina <samueladeshina73@gmail.com>
 * @license   http://www.opensource.org/licenses/BSD-3-Clause  The BSD 3-Clause License
 * @since     File available since Release 1.0.0
 *//*
--------------Please consult the todo file for a list of feature(s) to be added---------
*/
	class break_sentence
	{
		public $_sentence;
		public $_posList;
		/*---------------------
		 *instantiation of the constructor for this class.
		 *It takes two parameters:
		 *1. The Sentence to pe processed or 'Interpreted' and
		 *2. A boolean parameter indicating whether error should
		 *	 be displayed (true, 1 or "") or not (false, 0 or "[a-zA-Z0-9]")
		---------------------*/
		function __construct($sentence, $hide_errors)
		{
			//initialization stage
			$this->_sentence = $sentence;
			if ($hide_errors == true)
			{
				error_reporting(0);
			}
			/*------------------
			 *open the file 'pos-list.txt' which contains
			 *a numerable amount of commonly used english
			 *words and their corresponding part of speech
			-------------------*/
			$handle = fopen("pos-list.txt", "r");
			if ($handle)
			{
		   	 	while (($line = fgets($handle)) !== false)
		   	 	{
		        	$this->_posList[] = $line;
		    	}
				fclose($handle);
			}
			else
			{
    			/*------------------
				 *Error opening file.
				 *Catch this error with some exception class,
				 *present a simple error message or log it
				-------------------*/
			} 
		}
		/*---------------------
		 *instantiation of the word_array() method.
		 *It takes no parameter.
		 *It is responsible for 'exploding' a sentence
		 *into an array of words. It returns the generated array
		---------------------*/
		function word_array()
		{
			$words = explode(" ", $this->_sentence);
			return $words;
		}
		/*---------------------
		 *instantiation of the delimit_words() method.
		 *It takes a single boolean parameter
		 *The boolean parameter notifies PHP that the
		 *during the delimitation of a word, case-sensitivity
		 *is paramount (should be taken into consideration)
		 *if set to 'true' while reverse is the case when
		 *set to false. It returns an array containing the
		 *delimited words.
		---------------------*/
		function delimit_words($bool)
		{
			if (!isset($bool))
			{
				$bool = true;
			}
			$words = self::word_array();
			foreach ($words as $word)
			{
				for ($i = 0; $i < strlen($word); $i++)
				{
					/*---------------
					 *The next line removes the following
					 *characters: .,!?;:()[]{}
					 *from the word
					---------------*/
					 if (strstr('.,!?;:()[]{}""\'\'',$word[$i]))
					 {
					 	if ($i == 0) //if any of these punctuations appear at the beginning of the word
					 	{
					 		$word = substr($word, $i+1);
					 	}
					 	else if ($i == strlen($word)-1) //if any punctuation appears at the end of the word
					 	{
					 		$word = substr($word, 0, strlen($word)-1);
					 	}
					 	else // it punctuations occur anywhere between a word
					 	{
					 		$word[$i] = '';
					 	}
					 }
				}

				if ($bool == true)	
				{
					//Convert the first letter of the word to capital
					$_words[] = ucfirst(strtolower($word));
				}
				else if ($bool == false)	
				{
					$_words[] = $word;
				}
				else
				{
					/*------------------
					 *A wrong parameter was supplied.
					 *The only parameters allowed is a boolean value
					 *Catch this error with some exception class,
					 *present a simple error message or log it
					-------------------*/
				}
			}
			return $_words;
		}
		/*---------------------
		 *instantiation of the count_words() method.
		 *It accepts no parameter.
		 *It is a simple class counts the total number
		 *character in a word and returns it as an integer value
		---------------------*/
		function words_count()
		{
			$words = self::word_array();
			$words_count = count($words);
			return $words_count;
		}
		/*---------------------
		 *instantiation of the group_words() method.
		 *It takes a single boolean parameter which is
		 *used for the delimit_words() method since it
		 *references it
		 *It collects an array of words and selects only distinct
		 *words from the array.
		 *It returns an associative array containing this
		 *each of this distinct words as a key and the number of
		 *times they occur as the value.
		---------------------*/
		function group_words($bool)
		{
			if (!isset($bool))
			{
				$bool = true;
			}
			$words = self::delimit_words($bool);
			$words_unique = array_unique($words);
			foreach ($words_unique as $word)
			{
				$index = array_search($word, $words);
				//echo "Word: ".$word."; Index: ".$index."<br/>";
				unset($words[$index]);
				$arrWords[$word] = 1;
			}
			if (count($words) > 0)
			{
				while(count($words) > 0)
				{
					foreach ($words_unique as $word)
					{
						if (in_array($word, $words))
						{
							$pos = array_search($word, $words);
							unset($words[$pos]);
							$arrWords[$word] = $arrWords[$word] + 1;
						}
					}		
				}
			}
			return $arrWords;
		}
		/*---------------------
		 *instantiation of the validity() method.
		 *It accepts the local address as a parameter
		 *The local address is an address of the Dictionary Folder
		 *The Dictionary Folder bundled with this class is the dict_folder Folder
		 *but you can have your dictionary files anywhere, hence you must set
		 *the location here by providing it as a parameter to this method
		 *It returns an associative array containing a word as the key and
		 *the either a true or false boolean value depending on the validity
		 *of the word supplied as a real english word
		---------------------*/
		function validity($dic_folder)
		{
			$words = self::group_words(true);
			foreach ($words as $word => $occurrance)
			{
				if (self::verify_word($word, $dic_folder))
				{
					$arrWords_valid[$word] = "VALID";
				}
				else
				{
					$arrWords_valid[$word] = "INVALID";
				}
			}
			return $arrWords_valid;
		}
		/*---------------------
		 *instantiation of the verify_word() method.
		 *It takes two parameters: 
		 *1. The word to verify and
		 *2. The location of the folder containing the dictionary files
		 *It returns 1 or 0 depending on if the supplied word is
		 *is actually english
		---------------------*/
		function verify_word($word_to_verify, $dic_folder)
		{
			if (!is_dir($dic_folder))
			{
				$dic_folder = "dict_files";
			}
			$d = opendir($dic_folder) or die($php_errormsg);
			$validity_count = 0;
			while (false !== ($f = readdir($d)))
			{
				if (preg_match('@\.(dic|txt)$@i', $f))
				{
					$dic_file = file_get_contents($dic_folder."/".$f);
					if (strpos($dic_file, $word_to_verify) !== false)
					{
						$validity_count += 1;
					}
					else if (strpos($dic_file, ucfirst($word_to_verify)) !== false)
					{
						$validity_count += 1;
					}
					else if (strpos($dic_file, strtolower($word_to_verify)) !== false)
					{
						$validity_count += 1;
					}
					else if (strpos($dic_file, strtoupper($word_to_verify)) !== false)
					{
						$validity_count += 1;
					}
				}
			}
			closedir($d);
			if ($validity_count > 0)
			{
				return 1;
			}
			else
			{
				return 0;
			}
		}
		/*---------------------
		 *instantiation of the find_pos() method.
		 *It accepts no parameter
		 *This method accepts an array of words and
		 *searches for this words in the dictionary files
		 *if at least a match is found, it checks for its
		 *Part of speech and returns an associative array
		 *of words and their parts of speech as keys and values
		 *respectively.
		---------------------*/
		function find_pos()
		{
			$poses = array("N" => "Noun", "p" => "Plural", "h" => "Noun Phrase", "V" => "Verb (us. Participle)", "t" => "Verb (us. Transitive)", "i" => "Verb (us. Intransitive)", "A" => "Adjective", "v" => "Adverb", "C" => "Conjunction", "P" => "Preposition", "!" => "interjection", "r" => "Pronoun", "D" => "Definite Article", "I" => "Indefinite Article", "o" => "Nominative");
			$words = self::group_words(true);
			foreach ($words as $word => $occurrance)
			{
				$pos = preg_grep("/^($word)(\\\\)/is", $this->_posList);
				foreach ($pos as $key => $value)
				{
					$explode = explode("\\", $pos[$key]);
					$real_pos = trim($explode[1]);
					$real_totl = strlen($real_pos);
					$counter;
					$character_str = "";
					for ($counter = 0; $counter < $real_totl; $counter++)
					{
						$character = $poses[$real_pos[$counter]];
						$character_str .= ", ".$character;
					}
					$arrWords_pos[$word] = substr($character_str, 1);
				}
			}
			return $arrWords_pos;
		}
	}
//Please consult the todo file for a list of feature(s) to be added
?>