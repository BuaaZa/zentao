<?php
$i = 1;
$str = "行号\tid\t用户\t操作\t时间\n";
foreach($actions as $action)
{

    $str .= $i ."\t"
        . $action->id . "\t"
        . $action->actor . "\t"
        . $action->action . "\t"
        . $action->date . "\t"
        . "\n";
    $i++;
}
echo $str ;
?>