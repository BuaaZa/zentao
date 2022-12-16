<?php
class getparenthtmlEntry extends baseEntry{
    public function get($id)
    {
        $this->loadModel("story");
        $stories = $this->story->getParentStoryHTML($id, $_GET['execution']);
        echo html::select('parent', $stories, '', "class='form-control chosen'");
    }
}
?>