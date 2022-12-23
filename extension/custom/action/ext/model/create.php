<?php
/**
 * Create a action.
 *
 * @param string $objectType
 * @param int $objectID
 * @param string $actionType
 * @param string $comment
 * @param string $extra the extra info of this action, according to different modules and actions, can set different extra.
 * @param string $actor
 * @param bool $autoDelete
 * @access public
 * @return int
 */
public function create($objectType, $objectID, $actionType, $comment = '', $extra = '', $actor = '', $autoDelete = true)
{
    if (strtolower($actionType) == 'commented' and empty($comment)) return false;

    $actor = $actor ? $actor : $this->app->user->account;
    $actionType = strtolower($actionType);
    $actor = ($actionType == 'openedbysystem' or $actionType == 'closedbysystem') ? '' : $actor;
    if ($actor == 'guest' and $actionType == 'logout') return false;

    $objectType = str_replace('`', '', $objectType);

    $action = new stdclass();
    $action->objectType = strtolower($objectType);
    $action->objectID = $objectID;
    $action->actor = $actor;
    # get actor's ip
    $action->ip = helper::getRemoteIp();
    $action->action = $actionType;
    $action->date = helper::now();
    $action->extra = $extra;
    if (!defined('IN_UPGRADE')) $action->vision = $this->config->vision;

    if ($objectType == 'story' and strpos(',reviewpassed,reviewrejected,reviewclarified,reviewreverted,', ",$actionType,") !== false) $action->actor = $this->lang->action->system;

    /* Use purifier to process comment. Fix bug #2683. */
    $action->comment = fixer::stripDataTags($comment);

    /* Process action. */
    if ($this->post->uid) {
        $action = $this->loadModel('file')->processImgURL($action, 'comment', $this->post->uid);
        if ($autoDelete) $this->file->autoDelete($this->post->uid);
    }

    /* Get product project and execution for this object. */
    $relation = $this->getRelatedFields($action->objectType, $objectID, $actionType, $extra);
    $action->product = $relation['product'];
    $action->project = (int)$relation['project'];
    $action->execution = (int)$relation['execution'];
    $this->dao->insert(TABLE_ACTION)->data($action)->autoCheck()->exec();
    $actionID = $this->dao->lastInsertID();

    if ($this->post->uid) $this->file->updateObjectID($this->post->uid, $objectID, $objectType);

    /* Call the message notification function. */
    $this->loadModel('message')->send(strtolower($objectType), $objectID, $actionType, $actionID, $actor, $extra);

    /* Add index for global search. */
    $this->saveIndex($objectType, $objectID, $actionType);

    return $actionID;
}
