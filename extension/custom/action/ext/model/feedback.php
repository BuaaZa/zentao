<?php
public function printAction($action, $desc = '')
{
    return $this->loadExtension('feedback')->printAction($action, $desc);
}
