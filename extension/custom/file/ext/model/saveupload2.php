<?php
// 可以处理enternalId的文件上传方法
public function saveUpload2($objectType = '', $objectID = '', $extra = '', $filesName = 'files', $labelsName = 'labels', $enternalIds=array())
{
    $this->loadModel('file');
    $fileTitles = array();
    $now        = helper::today();
    $files      = $this->file->getUpload($filesName, $labelsName);

    $enternalIdLen = count($enternalIds);
    if ($enternalIdLen>0 && $enternalIdLen!=count($files)) {
        // 对不上，没法处理
        return 'wrong';
    }

    $idx = 0;
    foreach ($files as $id => $file) {
        if ($file['size'] == 0) {
            continue;
        }
        if (!move_uploaded_file($file['tmpname'], $this->file->savePath . $this->file->getSaveName($file['pathname']))) {
            return false;
        }

        $file = $this->file->compressImage($file);

        $file['objectType'] = $objectType;
        $file['objectID']   = $objectID;
        $file['addedBy']    = $this->app->user->account;
        $file['addedDate']  = $now;
        $file['extra']      = $extra;
        if (isset($enternalIds[$idx])) {
            $file['enternalId']      = $enternalIds[$idx];
        } else {
            $file['enternalId']      = '';
        }
        $idx++;
        unset($file['tmpname']);
        $this->dao->insert(TABLE_FILE)->data($file)->exec();
        $fileTitles[$this->dao->lastInsertId()] = $file['title'];
    }
    return $fileTitles;
}