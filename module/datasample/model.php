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

    public function getDataSampleByCasestepLevel(int $caseID, int $casestepLevel, int $version): object|bool
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

    public function  getOneResultByDataSampleIdOrderByDate(int $dataSampleID, int $version): bool|object
    {
        return $this->dao->select()->from(TABLE_DATASAMPLE_RESULT)
            ->where('`data_sample_id`')->eq($dataSampleID)
            ->andWhere('`version`')->eq($version)
            ->orderBy('id desc')
            ->limit(1)
            ->fetch();
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
    
    public function findMock($params = '', $funcName = ''){
        $response = array();
        if(!$funcName){
            $response['value'] = '';
            return $response;
        }
        if(in_array(strtolower($funcName), $this->lang->ztinterface->funcTable)){
            return $this->mockFunc($params, $funcName);
        }
        $funcName = 'mock'.ucfirst(strtolower($funcName));
        if (method_exists($this, $funcName)) {
            return $this->datasample->$funcName($params);
        }
        $response['error'] = "Mock函数不存在";
        return $response;
    }

    public function mockInteger($params = ''){
        $min = -65535;
        $max = 65535;

        if(isset($params[0]) and is_numeric($params[0])){
            $min = (int)$params[0];
            if($min != (float)$params[0]){
                $min = $min + 1;
            }
        }
        if(isset($params[1]) and is_numeric($params[1])){
            $max = (int)$params[1];
        }

        if($min > $max){
            $temp = $min;
            $min = $max;
            $max = $temp;
        }

        $faker = $this->loadModule('ztinterface')->getFaker('en_US');
        $response['value'] = $faker->numberBetween($min,$max);

        return $response;
    }

    public function mockFloat($params = ''){
        $min = NULL;
        $max = NULL;

        if(isset($params[0]) and is_numeric($params[0])){
            $min = (float)$args[0];
        }
        if(isset($params[1]) and is_numeric($params[1])){
            $max = (float)$args[1];
        }
        if($min and $max and $min > $max){
            $temp = $min;
            $min = $max;
            $max = $temp;
        }

        $faker = $this->loadModule('ztinterface')->getFaker('en_US');
        $response['value'] = $faker->randomFloat(NULL, $min, $max);

        return $response;
    }

    public function mockString($params = ''){
        $response = array();
        $args = $this->loadModule('ztinterface')->parseParams($params);
        $min = 1;
        $max = 20;
        if(isset($args[1]) and is_numeric($args[1]) and (int)$args[1]>=0){
            $min = (int)$args[1];
            if($min != (float)$args[1]){
                $min = $min + 1;
            }
        }
        if(isset($args[2]) and is_numeric($args[2]) and (int)$args[2]>=0){
            $max = (int)$args[2];
        }
        if($min > $max){
            $temp = $min;
            $min = $max;
            $max = $temp;
        }
        $regex = '[\w]';
        if(isset($args[0])){
            $chars = $this->ztinterface->parseSymbol($args[0]);
            if(!$chars){
                $response["error"] = '参数不合法,按默认字符集生成';
            }else{
                $regex = $chars;
            }
        }
        $regex = $regex.'{'.$min.','.$max.'}';
        $response['value'] = $this->ztinterface->mockStringByRegex($regex);
        return $response;
    }

    public function mockDatetime($params = ''){
        $response = array();
        $args = $this->loadModule('ztinterface')->parseParams($params);

        $format = 'Y-m-d H:i:s';
        if($args[0]){
            $format = $this->ztinterface->trimQuotation($args[0]);
        }
        
        $response['value'] = $this->ztinterface->mockDate($format);
        return $response;
    }

    public function mockRegex($params = ''){
        $response = array();
        $args = $this->loadModule('ztinterface')->parseParams($params);
        
        if(!isset($args[0])){
            $response["error"] = "需要正则表达式";
            return $response;
        }
        $regex = join(',',$args);

        if(substr($regex,-1) !== substr($regex,0,1) or substr($regex,-1) !== '/'){
            $regex = '/'.$regex.'/';
        }
        if (@preg_match($regex, '') === false) {
            $response["error"] = "非法的正则表达式";
            return $response;
        }
        $response['value'] = $this->ztinterface->mockStringByRegex($regex);
        return $response;
    }

    public function mockRegexnum($params = ''){
        $response = array();
        $n = 5;
        while($n > 0){
            $response = $this->datasample->mockRegex($params);
            if($response['value']){
                if(is_numeric($response['value']) or $response['value']=='null')
                    break;
                $n -= 1;
                continue;
            }
            if($response['error']){
                return $response;
            }
            $n -= 1;
        }
        if(isset($response['value']) and (is_numeric($response['value']) or $response['value']=='null')){
            $response['value'] = (float)$response['value'];
        }else if(!$response['error']){
            $response['error'] = '正则表达式无法产生合法的数据';
        }

        return $response;
    }

    public function mockFunc($params = '', $funcName = ''){
        $response = array();
        $args = $this->loadModule('ztinterface')->parseParams($params);
        $faker = "";
        $gen = $funcName;

        if($args[0]){
            $faker = $this->ztinterface->getFaker($this->ztinterface->trimQuotation($args[0]));
        }
        if(!$faker){
            if(in_array(strtolower($gen),$this->lang->ztinterface->fakerCN)){
                $faker = $this->ztinterface->getFaker('zh_CN');
            }else{
                $faker = $this->ztinterface->getFaker('en_US');
            }
        }
        
        if(strtolower($gen) === 'colorname')
            $gen = 'safe'.$gen;
        try{
            $response['value'] = $faker->$gen;
        }catch(Exception $e){
            $response['error'] = '生成模式不存在';
        }
        return $response;
    }
}