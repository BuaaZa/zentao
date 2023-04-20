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

    public function parseStrMock($mock = ''){
        $match = preg_match('/^\$(\w+)\(.*\)$/', $mock, $matches);
        if ($match) {
            $funcName = $matches[1];

            if ($funcName) {
                $paramStr = preg_replace('/^\$\w+\(|\)$/', '', $mock);
                preg_match_all('/("[^"]*"|\'[^\']*\'|\{[^}]*\}|\[[^\]]*\]|[^,]+)+/', $paramStr, $params);
            } else {
                $match = preg_match('/^\$(\w+)$/', $mock, $matches);
                if ($match) {
                $funcName = $matches[1];
                }
            }

            $funcName = ucfirst(strtolower($funcName));
        }
        
    }

    public function mockInteger($data = '', $return = false){
        $response = array();
        $response['id'] = $data['id'];

        $args = $this->ztinterface->parseParams($data["params"]);
        $min = -65535;
        $max = 65535;

        if(isset($args[0]) and is_numeric($args[0])){
            $min = (int)$args[0];
            if($min != (float)$args[0]){
                $min = $min+1;
            }
        }
        if(isset($args[1]) and is_numeric($args[1])){
            $max = (int)$args[1];
        }

        if($min>$max){
            $temp = $min;
            $min = $max;
            $max = $temp;
        }

        $faker = $this->ztinterface->getFaker('en_US');
        $response['value'] = $faker->numberBetween($min,$max);

        if($return){
            return $response;
        }else{
            echo json_encode($response);
            return;
        }
    }

}