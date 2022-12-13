<?php
/**
 * The team entry point of ZenTaoPMS.
 */
class teamsEntry extends entry
{
    /**
     * DELETE method
     *
     * @param int $teamID
     * @return int|void|null
     */
    public function delete(int $teamID)
    {
        $team = $this->dao->select()->from(TABLE_TEAM)
            ->where('root')->eq($teamID)
            ->fetch();
        if(empty($team)){
            $data["error"] = "No such team: id = " . $teamID;
            return $this->send(404, $this->format($data,""));
        }

        $this->dao->delete()->from(TABLE_TEAM)->where('root')->eq($teamID)->exec();
        $this->sendSuccess(200, "success");
    }
}