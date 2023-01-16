<?php
public function assignTo(stdClass $fb, string $assignedTo='', string $mailto=''):array
{
    $oldfb = clone $fb;
    $now = helper::now();
    $fb->assignedTo = $assignedTo;
    $fb->mailto = $mailto;
    $fb->assignedDate =  $now;    
    $fb->updateDate = $now;
    $this->dao->update(TABLE_FEEDBACK)->data($fb)->autoCheck()->checkFlow()->where('id')->eq((int)$fb->id)->exec();
    return common::createChanges($oldfb, $fb);
    // $this->dao->update(TABLE_FEEDBACK)
    // ->set('assignedTo')->eq($assignedTo)
    // ->set('mailto')->eq($mailto)
    // ->set('assignedDate')->eq(helper::now())
    // ->where('id')->eq((int)$fbID)
    // ->exec();
}