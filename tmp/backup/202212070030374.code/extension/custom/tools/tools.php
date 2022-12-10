<?php
class tools{
    static public function desabledSelect($name = '', $options = array(), $selectedItems = "", $attrib = "", $append = false)
    {
        $options = (array)($options);
        if($append and !isset($options[$selectedItems])) $options[$selectedItems] = $selectedItems;

        /* The begin. */
        $id = $name;
        if(strpos($name, '[') !== false) $id = trim(str_replace(']', '', str_replace('[', '', $name)));
        $id = "id='{$id}'";
        if(strpos($attrib, 'id=') !== false) $id = '';

        global $config;
        $convertedPinYin = (empty($config->isINT) and class_exists('common')) ? common::convert2Pinyin($options) : array();
        if(count($options) >= $config->maxCount or isset($config->moreLinks[$name]))
        {
            if(strpos($attrib, 'chosen') !== false) $attrib = str_replace('chosen', 'picker-select', $attrib);
            if(isset($config->moreLinks[$name]))
            {
                $link = $config->moreLinks[$name];
                $attrib .= " data-pickertype='remote' data-pickerremote='" . $link . "'";
            }
        }

        $string = "<select name='$name' {$id} $attrib disabled='disabled'>\n";

        /* The options. */
        if(is_array($selectedItems)) $selectedItems = implode(',', $selectedItems);
        $selectedItems   = ",$selectedItems,";
        foreach($options as $key => $value)
        {
            $optionPinyin = zget($convertedPinYin, $value, '');
            $selected = strpos($selectedItems, ",$key,") !== false ? " selected='selected'" : '';
            $string  .= "<option value='$key'$selected title='{$value}' data-keys='{$optionPinyin}'>$value</option>\n";
        }

        /* End. */
        return $string .= "</select>\n";
    }
}
?>