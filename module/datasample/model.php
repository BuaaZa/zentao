<?php
class datasampleModel extends model
{

    /**
     * @param int $caseID 测试用例编号
     * @param int $stepLevel 测试执行步骤顺序
     * @param string $object 数据样本
     * @return bool
     */
    public function save(int $caseID, int $stepLevel, string $object): bool
    {
        // 空数据样本会传''，此时不进行存储
        if ($object === '') return false;
        $data = new stdClass();
        $data->case_id = $caseID;
        $data->casestep_level = $stepLevel;
        $data->object = $object;

        $this->dao->insert(TABLE_DATASAMPLE)->data($data)->exec();
        return true;
    }

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
}