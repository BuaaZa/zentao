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
        return $this->dao->select()->from(TABLE_DATASAMPLE)
            ->where('`case_id`')->eq($caseID)
            ->andWhere('`delete`')->eq('0')
            ->fetchAll();
    }

    public function getDataSampleByCasestepLevel(int $caseID, int $casestepLevel): object
    {
        return $this->dao->select()->from(TABLE_DATASAMPLE)
            ->where('`case_id`')->eq($caseID)
            ->andWhere('`casestep_level`')->eq($casestepLevel)
            ->andWhere('`delete`')->eq('0')
            ->fetch();
    }

    // 数据样本结果

    public function saveDataSampleResult(int $dataSampleID, string $object): bool
    {
        if ($object === '') return false;
        $data = new stdClass();
        $data->data_sample_id = $dataSampleID;
        $data->object = $object;

        $this->dao->insert(TABLE_DATASAMPLE_RESULT)->data($data)->exec();
        return true;
    }

    public function  getResultsByDataSampleId(int $data_sample_id): array
    {
        return $this->dao->select()->from(TABLE_DATASAMPLE_RESULT)
            ->where('`data_sample_id`')->eq($data_sample_id)
            ->andWhere('`delete`')->eq('0')
            ->fetchAll();
    }

    public function  getOneResultByDataSampleIdOrderByDate(int $data_sample_id)
    {
        return $this->dao->select()->from(TABLE_DATASAMPLE_RESULT)
            ->where('`data_sample_id`')->eq($data_sample_id)
            ->andWhere('`delete`')->eq('0')
            ->orderBy('id desc')
            ->limit(1)
            ->fetch();
    }
}