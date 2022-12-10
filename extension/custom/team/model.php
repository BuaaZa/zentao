<?php
class teamModel extends model
{
    public function getTeamAccount($root, $account)
    {
        $teamAccount = $this->dao->select("*")->from(TABLE_TEAM)
                                ->where('root')->eq($root)
                                ->andWhere('account')->eq($account)
                                ->fetch();
        return $teamAccount;
    }

    public function getTeam($root){
        $team = $this->dao->select("*")->from(TABLE_TEAM)
                    ->where('root')->eq($root)
                    ->fetchAll();
        return $team;
    }
    
    public function updateTeamAccount($id, $fixData){
        $this->dao->update(TABLE_TEAM)->data($fixData)->where('id')->eq($id)
            ->autoCheck()
            ->exec();
    }

    public function addAccount($fixData){
        $this->dao->insert(TABLE_TEAM)->data($fixData)
            ->autoCheck()
            ->exec();
    }
}