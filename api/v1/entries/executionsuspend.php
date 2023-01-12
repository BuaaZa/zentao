<?php
class executionSuspendEntry extends entry
{

    public execution $executionController;

    public executionModel $executionModel;

    public function post(int $executionID)
    {
        $field = 'comment';
        $this->batchSetPost($field);

        $this->setPost('status', 'suspended');

        $this->executionController = $this->loadController('execution', 'suspend');
        $this->executionController->suspend($executionID);

        $data = $this->getData();
        if(!$data)
            return $this->send400('error');
        if(isset($data->status) and $data->status == 'fail')
            return $this->sendError(zget($data, 'code', 400), $data->message);

        $this->executionModel = $this->loadModel('execution');
        $execution = $this->executionModel->getByID($executionID);

        return $this->send(200, $execution);
    }
}