<?php
class datasample extends control
{
    public datasampleModel $datasampleModel;
    public testcaseModel $testcaseModel;

    public function __construct(string $moduleName = '',
                                string $methodName = '',
                                string $appName = '')
    {
        parent::__construct($moduleName, $methodName, $appName);

        $this->datasampleModel = $this->loadModel('datasample');
        $this->testcaseModel = $this->loadModel('testcase');
    }

    public function view(int $caseID, int $casestepLevel, int $version = -1): int
    {
        $testcase = $this->testcaseModel->getById($caseID);
        $sample = $this->datasampleModel->getDataSampleByCasestepLevel($caseID, $casestepLevel, $version);

        $this->view->case = new stdClass();
        $this->view->case->id = $caseID;
        $this->view->case->title = $testcase->title;
        $this->view->sample = new stdClass();
        $this->view->sample->casestep_level = $sample->casestep_level;
        $this->view->table = json_decode($sample->object);

        $this->display();
        return 0;
    }

}