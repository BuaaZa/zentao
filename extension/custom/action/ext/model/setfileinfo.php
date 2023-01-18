<?php
public function setfileinfo($actions, $commentIDs)
{
    if (empty($actions)) {
        return;
    }
    if (empty($commentIDs)) {
        $commentIDs = array();
        foreach ($actions as $action) {
            array_push($commentIDs, $action->id);
        }
    }
    $files = $this->getFileByObjectIDs('comment', $commentIDs, '');
    if (empty($files)) {
        foreach ($actions as $action) {
            $action->files = array();
        }
        return;
    }
    foreach ($actions as $action) {
        if (array_key_exists($action->id, $files)) {
            $action->files = $files[$action->id];
        } else {
            $action->files = array();
        }
    }
}

private function getFileByObjectIDs($objectType, $objectIDs)
{
    $files = $this->dao->select('*')->from(TABLE_FILE)
        ->where('objectType')->eq($objectType)
        ->andWhere('objectID')->in($objectIDs)
        ->andWhere('deleted')->eq('0')
        ->fetchAll('id');

    $this->loadModel('file');
    $filesByobjectID = array();
    foreach ($files as $file) {
        if ($objectType == 'traincourse' or  $objectType == 'traincontents') {
            $file->realPath = $this->app->getWwwRoot() . 'data/course/' . $file->pathname;
            $file->webPath  = 'data/course/' . $file->pathname;
            continue;
        }

        $realPathName   = $this->file->getRealPathName($file->pathname);
        $file->realPath = $this->file->savePath . $realPathName;
        $file->webPath  = $this->file->webPath . $realPathName;
        if (!array_key_exists($file->objectID, $filesByobjectID)) {
            $filesByobjectID[$file->objectID] = array();
        }
        array_push($filesByobjectID[$file->objectID], $file);
    }

    return $filesByobjectID;
}