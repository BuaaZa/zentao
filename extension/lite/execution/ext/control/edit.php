<?php
helper::importControl('execution');
class myExecution extends execution
{
    public function edit(int $executionID, string $action = 'edit', string $extra = '', $newPlans = '', $confirm = 'no')
    {
        $this->config->execution->edit->requiredFields  = 'name,code,begin,end';
        parent::edit($executionID, $action, $extra);
    }
}
