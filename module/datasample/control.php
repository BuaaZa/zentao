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
    public function viewrule(int $caseID, int $casestepLevel, int $version): int
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
        $data = $this->datasample->parseStrMock($_POST['mock']);
        if(!empty($_POST['mock']) and empty($data['funcName'])){
            $response['error'] = 'Mock格式有误';
            $response['message'] = 'error';
            echo json_encode($response);
            return;
        }
        $notNull = true;
        if($_POST['notNull'] === '0'){
            $notNull = false;
        }
        if(!empty($data['error'])) {
            echo json_encode($data);
            return;
        }
        $response = $this->datasample->findMock($data['params'], $data['funcName'],$notNull,false);
        if(!$response['error']){
            $res = $this->datasample->findMock($data['params'], $data['funcName'],$notNull,true);
            $response['exception'] = $res['exception'];
            $response['message'] = 'success';
        }else{
            $response['message'] = 'error';
        }
        echo json_encode($response);
        return;
    }

    public function batchGenerate(){
        $response = array();
        $response['error'] = array();
        $response['samples'] = array();
        $trueSample = array(); 
        foreach($_POST['list'] as $item){
            $data = $this->datasample->parseStrMock($item['mock']);
            $notNull = true;
            if($item['notNull'] === '0'){
                $notNull = false;
            }
            $res = $this->datasample->findMock($data['params'], $data['funcName'],$notNull,false);
            if(!empty($res['error'])){
                $response['error'][] = array("id"=>$item['id'], "message"=>$res['error']);
            }else{
                $trueSample[] = array("id"=>$item['id'], "value"=>$res['value']);
            }
        }
        if(!empty($response['error'])){
            echo json_encode($response);
            return;
        }
        $response['samples'][] = array("type"=>"正例", "content"=>$trueSample);
        foreach($_POST['list'] as $item){
            $data = $this->datasample->parseStrMock($item['mock']);
            $notNull = true;
            if($item['notNull'] === '0'){
                $notNull = false;
            }
            $res = $this->datasample->findMock($data['params'], $data['funcName'],$notNull,true);
            foreach($res['exception'] as $e){
                $sample = array('type'=>$item['id'].'::'.$e['type'], 'content'=>array());
                $sample['content'][] = array("id"=>$item['id'], "value"=>$e['value']);
                foreach($_POST['list'] as $it){
                    if($it['id'] === $item['id'])
                        continue;
                    $data = $this->datasample->parseStrMock($it['mock']);
                    $notNull = true;
                    if($it['notNull'] === '0'){
                        $notNull = false;
                    }
                    $res = $this->datasample->findMock($data['params'], $data['funcName'],$notNull,false);
                    $sample['content'][] = array("id"=>$it['id'], "value"=>$res['value']);
                }
                $response['samples'][] = $sample;
            }
        }
        echo json_encode($response);
        return;
    }
}