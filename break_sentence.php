<?php
	class break_sentence
	{
		public $_sentence;
		public $_posList;
		function __construct($sentence, $hide_errors)
		{
			//initialization stage
			$this->_sentence = $sentence;
			if ($hide_errors == true)
			{
				error_reporting(0);
			}
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
    			// error opening the file.
			} 
		}
		function word_array()
		{
			$words = explode(" ", $this->_sentence);
			return $words;
		}
		function delimit_words($bool)
		{
			if (!isset($bool))
			{
				$bool = true;
			}
			$words = self::word_array();
			foreach ($words as $word)
			{
				//echo $word."<br/>";			
				$i;
				for ($i = 0; $i < strlen($word); $i++)
				{
					 if (strstr('.,!?;:()[]{}',$word[$i]))
					 {
					 	$word[$i] = "";
					 }
				}
				//echo $word."<br/>";	
				if ($bool == true)	
				{
					$_words[] = ucfirst(strtolower($word));
				}
				else if ($bool == false)	
				{
					$_words[] = $word;
				}
				else
				{
					//throw an error
				}
			}
			return $_words;
		}
		function words_count()
		{
			$words = self::word_array();
			$words_count = count($words);
			return $words_count;
		}
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
		function validity($dic_folder)
		{
			$words = self::group_words(true);
			foreach ($words as $word => $occurrance)
			{
				if (self::verify_word($word, $dic_folder))
				{
					$arrWords_valid[$word] = "Valid";
				}
				else
				{
					$arrWords_valid[$word] = "Invalid";
				}
			}
			return $arrWords_valid;
		}
		function verify_word($word_to_verify, $dic_folder)
		{
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
		function find_pos()
		{
			//return $this->_posList;
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
?>
