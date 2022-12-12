<?php
/**
 * The team entry point of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2021 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL(http://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     entries
 * @version     1
 * @link        http://www.zentao.net
 */
class teamAccountuserEntry extends Entry
{
    
    public function put($teamID){
        $this->loadModel("team");
        // $team = $this->team->getTeam($teamID);
        // if(empty($team)){
        //     $data["error"] = "No such team";
        //     return $this->send(200, $this->format($data,""));
        // }
        // if(!isset($this->requestBody->account)){
        //     $data["error"] = "Need account";
        //     return $this->send(200, $this->format($data,""));
        // }
        // $account = $this->requestBody->account;
        // $user = $this->loadModel("user")->getById($account,'account');
        // if(!$user){
        //     $data["error"] = "No such user";
        //     return $this->send(200, $this->format($data,""));
        // }
        // $teamAccount = $this->team->getTeamAccount($teamID, $account);
        $teamAccount = $this->team->getById($teamID);
        if(!$teamAccount){
            // $fields = "role,position,limited,join,days,hours,estimate,consumed,left,order";
            
            // $this->batchSetPost($fields);
            // $now = helper::today();
            // $fixData = fixer::input('post')
            // ->setDefault('days,hours,estimate,consumed,left,order', 0)
            // ->setDefault('role,position', "")
            // ->setDefault('limited', "no")
            // ->setDefault('join', $now)
            // ->add('root',$teamID)
            // ->add('type',$team[0]->type)
            // ->add('account',$account)
            // ->get(); 
            // $this->team->addAccount($fixData);
            // if(dao::isError()){
            //     return $this->sendError(400, dao::getError());
            // }
            // $data["message"] = "success";
            // return $this->send(200, $this->format($data,""));
            return $this->sendError(400, "No such record");
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

    /**
     * DELETE method.
     *
     * @param  int    $teamID
     * @access public
     * @return void
     */
    public function delete($teamID)
    {
        //$control = $this->loadController('team', 'delete');
        //$control->delete($teamID, 'true');
        $team = $this->dao->select("*")->from(TABLE_TEAM)
                          ->where('id')->eq($teamID)
                          ->fetchALL();
        if(empty($team)){
            $data["error"] = "No such team member";
            return $this->send(200,$this->format($data,""));
        }
       
        //delete id,account
        //$this->getData();
        $this->dao->delete()->from(TABLE_TEAM)->where('id')->eq($teamID)->exec();
        $this->sendSuccess(200, 'success');
    }
}
