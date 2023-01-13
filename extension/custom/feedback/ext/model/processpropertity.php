<?php

/**
 * 敏感字段处理
 */
public function processPropertity($feedback)
{
    // public是敏感字段，不能用
    if($feedback->public==true){
        $feedback->publicType = '1';
    }elseif($feedback->public==false){
        $feedback->publicType = '0';
    }else{
        $feedback->publicType = $feedback->public;
    }
    unset($feedback->public);
    return $feedback;
}