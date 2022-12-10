<?php
class teamAccountEntry extends entry{
    public function put($teamID){
        $this->loadModel("team");
        $team = $this->team->getTeam($teamID);
        if(empty($team)){
            $data["error"] = "No such team";
            return $this->send(200, $this->format($data,""));
        }
        if(!isset($this->requestBody->account)){
            $data["error"] = "Need account";
            return $this->send(200, $this->format($data,""));
        }
        $account = $this->requestBody->account;
        $user = $this->loadModel("user")->getById($account,'account');
        if(!$user){
            $data["error"] = "No such user";
            return $this->send(200, $this->format($data,""));
        }
        $teamAccount = $this->team->getTeamAccount($teamID, $account);
        if(!$teamAccount){
            $fields = "role,position,limited,join,days,hours,estimate,consumed,left,order";
            
            $this->batchSetPost($fields);
            $now = helper::today();
            $fixData = fixer::input('post')
            ->setDefault('days,hours,estimate,consumed,left,order', 0)
            ->setDefault('role,position', "")
            ->setDefault('limited', "no")
            ->setDefault('join', $now)
            ->add('root',$teamID)
            ->add('type',$team[0]->type)
            ->add('account',$account)
            ->get(); 
            $this->team->addAccount($fixData);
            if(dao::isError()){
                return $this->sendError(400, dao::getError());
            }
            $data["message"] = "success";
            return $this->send(200, $this->format($data,""));
        }else{
            $fields = "role,position,limited,join,days,hours,estimate,consumed,left,order";
            
            $this->batchSetPost($fields, $teamAccount);
            
            $fixData = fixer::input('post')
            ->remove('id,root,type,account')
            ->get(); 
            $this->team->updateTeamAccount($teamAccount->id, $fixData);
            if(dao::isError()){
                return $this->sendError(400, dao::getError());
            }
            $data["message"] = "success";
            return $this->send(200, $this->format($data,""));       
        }
    }
}
?>