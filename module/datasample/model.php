<?php
class datasampleModel extends model
{
    public function getDataSamplesByCase(int $caseID): array
    {
        $datasamples = $this->dao->select()->from(TABLE_DATASAMPLE)
            ->where('case_id')->eq($caseID)
            ->andWhere('delete')->ne('0')
            ->fetchAll();
        foreach ($datasamples as $sample)
        {
            ChromePhp::log($sample);
        }
        return $datasamples;
    }


    public function getDataSamplesByCaseStep(int $casestepID): object
    {
        return $this->dao->select()->from(TABLE_DATASAMPLE)
            ->where('casestep_id')->eq($casestepID)
            ->andWhere('delete')->ne('0')
            ->fetch();
    }
}