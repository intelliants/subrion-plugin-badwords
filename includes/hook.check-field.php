<?php
/******************************************************************************
 *
 * Subrion - open source content management system
 * Copyright (C) 2016 Intelliants, LLC <http://www.intelliants.com>
 *
 * This file is part of Subrion.
 *
 * Subrion is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Subrion is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Subrion. If not, see <http://www.gnu.org/licenses/>.
 *
 *
 * @link http://www.subrion.org/
 *
 ******************************************************************************/

if (in_array($field['type'], [iaField::TEXT, iaField::TEXTAREA])) {

    static $badWordsRegExp;

    if (is_null($badWordsRegExp)) {
        $list = explode(',', $iaCore->get('bad_word_list'));
        $array = [];
        foreach ($list as $word) {
            if ($word = trim($word)) {
                $array[] = '\b' . preg_quote($word) . '\b';
            }
        }
        empty($array) || $array = array_unique($array);
        $badWordsRegExp = $array ? '/' . implode('|', $array) . '/i' : '';
    }


    if ($badWordsRegExp) {
        $matches = array();

        if (preg_match_all($badWordsRegExp, $value, $matches)) {
            $errors[] = iaLanguage::getf('error_bad_words', array('field' => iaLanguage::get('field_' . $field['item'] . '_' . $field['name']), 'words' => implode(', ', $matches[0])));
        }
    }
}