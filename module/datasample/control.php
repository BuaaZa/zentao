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

    public function view(int $casestepID): int
    {
        $sample = $this->datasampleModel->getDataSamplesByCaseStep($casestepID);

//        $sample->object

        $this->display();
        return 0;
    }

}