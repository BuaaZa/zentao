<?php
/**

 */
class teamAccountEntry extends Entry
{
    /**
     * GET method.
     *
     * @param  int    $teamID
     * @access public
     * @return void
     */
    

    /**
     * PUT method.
     *
     * @param  int    $teamID
     * @access public
     * @return void
     */
   

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
