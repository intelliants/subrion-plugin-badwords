<?php
//##copyright##

if (in_array($value['type'], array(iaField::TEXT, iaField::TEXTAREA)))
{
	static $badWordsRegExp;

	if (is_null($badWordsRegExp))
	{
		$list = explode(',', $iaCore->get('bad_word_list'));
		$array = array();
		foreach ($list as $word)
		{
			if ($word = trim($word))
			{
				$array[] = '\b' . preg_quote($word) . '\b';
			}
		}
		empty($array) || $array = array_unique($array);
		$badWordsRegExp = $array ? '/' . implode('|', $array) . '/i' : '';
	}

	if ($badWordsRegExp)
	{
		$matches = array();
		if (preg_match_all($badWordsRegExp, $item, $matches))
		{
			$error = true;
			$msg[] = iaLanguage::getf('error_bad_words', array('field' => iaLanguage::get('field_' . $field_name), 'words' => implode(', ', $matches[0])));
		}
	}
}