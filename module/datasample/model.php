<?php
class datasampleModel extends model
{

    /**
     * 保存一个数据样本
     *
     * @param int $caseID 测试用例编号
     * @param int $stepID 测试执行步骤编号
     * @param int $stepLevel 测试执行步骤顺序
     * @param string $object 数据样本
     * @param int $version 测试执行步骤版本
     * @return bool
     */
    public function saveDataSample(int $caseID, int $stepID, int $stepLevel, string $object, int $version): bool
    {
        // 空数据样本会传''，此时不进行存储
        if ($object === '') return false;
        $data = new stdClass();
        $data->case_id = $caseID;
        $data->casestep_id = $stepID;
        $data->casestep_level = $stepLevel;
        $data->object = $object;
        $data->version = $version;

        $this->dao->insert(TABLE_DATASAMPLE)->data($data)->exec();
        return true;
    }

    /**
     * @param int $caseID
     * @param int $version
     * @return array
     */
    public function getDataSamplesByCase(int $caseID, int $version): array
    {
        return $this->dao->select()->from(TABLE_DATASAMPLE)
            ->where('`case_id`')->eq($caseID)
            ->andWhere('`version`')->eq($version)
            ->fetchAll();
    }

    public function getDataSampleByCasestepID(int $caseID, int $stepID, int $version): object
    {
        return $this->dao->select()->from(TABLE_DATASAMPLE)
            ->where('`case_id`')->eq($caseID)
            ->andWhere('`casestep_id`')->eq($stepID)
            ->andWhere('`version`')->eq($version)
            ->fetch();
    }

    public function getDataSampleByCasestepLevel(int $caseID, int $casestepLevel, int $version): object
    {
        return $this->dao->select()->from(TABLE_DATASAMPLE)
            ->where('`case_id`')->eq($caseID)
            ->andWhere('`casestep_level`')->eq($casestepLevel)
            ->andWhere('`version`')->eq($version)
            ->fetch();
    }

    // 数据样本结果

    public function saveDataSampleResult(int $dataSampleID, string $object, int $version): bool
    {
        if ($object === '') return false;
        $data = new stdClass();
        $data->data_sample_id = $dataSampleID;
        $data->object = $object;
        $data->version = $version;

        $this->dao->insert(TABLE_DATASAMPLE_RESULT)->data($data)->exec();
        return true;
    }

    public function  getResultsByDataSampleID(int $data_sample_id, int $version): array
    {
        return $this->dao->select()->from(TABLE_DATASAMPLE_RESULT)
            ->where('`data_sample_id`')->eq($data_sample_id)
            ->andWhere('`version`')->eq($version)
            ->fetchAll();
    }

    public function  getOneResultByDataSampleIdOrderByDate(int $dataSampleID, int $version): mixed
    {
        return $this->dao->select()->from(TABLE_DATASAMPLE_RESULT)
            ->where('`data_sample_id`')->eq($dataSampleID)
            ->andWhere('`version`')->eq($version)
            ->orderBy('id desc')
            ->limit(1)
            ->fetch();
    }
}