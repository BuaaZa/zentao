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

    public function view(int $caseID, int $casestepLevel, int $version): int
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

    public function singleMock(){
        $response = array();
        $data = $this->datasample->parseStrMock($_POST);
        if($data['error']) {
            echo json_encode($data);
            return;
        }
        if(in_array(strtolower($data['funcName']),$this->lang->ztinterface->funcTable)){
            echo json_encode($this->datasample->mockFunc($data['params'], $data['funcName']));
            return;
        }
        $funcName = 'mock'.ucfirst(strtolower($data['funcName']));
        if (method_exists($this, $funcName)) {
            $response = $this->datasample->$funcName($params);
            if($response['error']) {
                echo json_encode($response);
                return;
            }
            $response['exception'] = $this->datasample->$funcName($params, true)['exception'];
            echo json_encode($response);
            return;
        }
        $response['error'] = "Mock函数不存在";
        echo json_encode($response);
        return;
    }

}