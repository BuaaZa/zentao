<?php
/**
 * Get info of uploaded files.
 *
 * @param  string $htmlTagName
 * @param  string $labelsName
 * @access public
 * @return array
 */
public function getUpload($htmlTagName = 'files', $labelsName = 'labels')
{
    $files = array();
    if(!isset($_FILES[$htmlTagName])) return $this->getUploadMultip($labelsName);

    if(!is_array($_FILES[$htmlTagName]['error']) and $_FILES[$htmlTagName]['error'] != 0) return $_FILES[$htmlTagName];

    $this->app->loadClass('purifier', true);
    $config   = HTMLPurifier_Config::createDefault();
    $config->set('Cache.DefinitionImpl', null);
    $purifier = new HTMLPurifier($config);

    /* If the file var name is an array. */
    if(is_array($_FILES[$htmlTagName]['name']))
    {
        extract($_FILES[$htmlTagName]);
        foreach($name as $id => $filename)
        {
            if(empty($filename)) continue;
            if(!validater::checkFileName($filename)) continue;

            $title             = isset($_POST[$labelsName][$id]) ? $_POST[$labelsName][$id] : '';
            $file['extension'] = $this->getExtension($filename);
            $file['pathname']  = $this->setPathName($id, $file['extension']);
            $file['title']     = (!empty($title) and $title != $filename) ? htmlSpecialString($title) : $filename;
            $file['title']     = $purifier->purify($file['title']);
            $file['size']      = $size[$id];
            $file['tmpname']   = $tmp_name[$id];
            $files[] = $file;
        }
    }
    else
    {
        if(empty($_FILES[$htmlTagName]['name'])) return $files;
        extract($_FILES[$htmlTagName]);
        if(!validater::checkFileName($name)) return array();;
        $title             = isset($_POST[$labelsName][0]) ? $_POST[$labelsName][0] : '';
        $file['extension'] = $this->getExtension($name);
        $file['pathname']  = $this->setPathName(0, $file['extension']);
        $file['title']     = (!empty($title) and $title != $name) ? htmlSpecialString($title) : $name;
        $file['title']     = $purifier->purify($file['title']);
        $file['size']      = $size;
        $file['tmpname']   = $tmp_name;
        return array($file);
    }
    return $files;
}

// 处理file1,file2,file3.....fileN的特殊需求 chenjj 221226
public function getUploadMultip($labelsName = 'labels')
{
    $files = array();
    if(empty($_FILES)) return $files;

    $this->app->loadClass('purifier', true);
    $config   = HTMLPurifier_Config::createDefault();
    $config->set('Cache.DefinitionImpl', null);
    $purifier = new HTMLPurifier($config);

    foreach($_FILES as $fileObj){
        if(!is_array($fileObj['error']) and $fileObj['error'] != 0) continue;
        if(empty($fileObj['name'])) return $files;
        extract($fileObj);
        if(!validater::checkFileName($name)) return array();;
        $title             = isset($_POST[$labelsName][0]) ? $_POST[$labelsName][0] : '';
        $file['extension'] = $this->getExtension($name);
        $file['pathname']  = $this->setPathName(0, $file['extension']);
        $file['title']     = (!empty($title) and $title != $name) ? htmlSpecialString($title) : $name;
        $file['title']     = $purifier->purify($file['title']);
        $file['size']      = $size;
        $file['tmpname']   = $tmp_name;
        array_push($files,$file);
    }
    
    return $files;
}