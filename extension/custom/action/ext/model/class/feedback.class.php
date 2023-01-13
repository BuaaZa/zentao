<?php
class feedbackAction extends actionModel
{
      /**
     * Print actions of an object.
     *
     * @param  object    $action
     * @param  string   $desc
     * @access public
     * @return void
     */
    public function printAction($action, $desc = '')
    {
      $objectType = $action->objectType;
      $actionType = strtolower($action->action);
      if($objectType == 'feedback' && $actionType == 'commented'){
        $desc = $this->lang->feedback->$actionType;
        /* Cycle actions, replace vars. */
        foreach($action as $key => $value)
        {
            // 修改此处让评论可以返回更多用户信息 -> chenjj 221225
            if($key == 'history' || $key == 'openedBy') continue;

            /* Desc can be an array or string. */
            if(is_array($desc))
            {
                if($key == 'extra') continue;
                if($action->objectType == 'story' and $action->action == 'reviewed' and strpos($action->extra, '|') !== false and $key == 'actor')
                {
                    $desc['main'] = str_replace('$actor', $this->lang->action->superReviewer . ' ' . $value, $desc['main']);
                }
                else
                {
                    $desc['main'] = str_replace('$' . $key, $value, $desc['main']);
                }
            }
            else
            {
                $desc = str_replace('$' . $key, $value, $desc);
            }
        }
        echo $desc;
        return;
      }
      return $this->printAction2($action,$desc);
    }

    public function printAction2($action, $desc = ''){
        if(!isset($action->objectType) or !isset($action->action)) return false;

        $objectType = $action->objectType;
        $actionType = strtolower($action->action);

        /**
         * Set the desc string of this action.
         *
         * 1. If the module of this action has defined desc of this actionType, use it.
         * 2. If no defined in the module language, search the common action define.
         * 3. If not found in the lang->action->desc, use the $lang->action->desc->common or $lang->action->desc->extra as the default.
         */
        if(empty($desc))
        {
            if($action->objectType == 'story' and $action->action == 'reviewed' and strpos($action->extra, ',') !== false)
            {
                $desc = $this->lang->$objectType->action->rejectreviewed;
            }
            elseif($action->objectType == 'productplan' and in_array($action->action, array('startedbychild','finishedbychild','closedbychild','activatedbychild', 'createchild')))
            {
                $desc = $this->lang->$objectType->action->changebychild;
            }
            elseif($action->objectType == 'module' and in_array($action->action, array('created', 'moved', 'deleted')))
            {
                $desc = $this->lang->$objectType->action->{$action->action};
            }
            elseif($action->action == 'createmr' and strpos($action->extra, '::') !== false)
            {
                list($mrCreatedDate, $mrActor, $mrLink) = explode('::', $action->extra);
                if(isonlybody()) $mrLink .= ($this->config->requestType == 'GET' ? '&onlybody=yes' : '?onlybody=yes');
                $this->app->loadLang('mr');
                $desc = sprintf($this->lang->mr->createAction, $mrCreatedDate, $mrActor, $mrLink);
            }
            elseif($this->config->edition == 'max' and strpos($this->config->action->assetType, ",{$action->objectType},") !== false and $action->action == 'approved')
            {
                $desc = empty($this->lang->action->approve->{$action->extra}) ? '' : $this->lang->action->approve->{$action->extra};
            }
            elseif(isset($this->lang->$objectType) && isset($this->lang->$objectType->action->$actionType))
            {
                $desc = $this->lang->$objectType->action->$actionType;
            }
            elseif(isset($this->lang->action->desc->$actionType))
            {
                $desc = $this->lang->action->desc->$actionType;
            }
            elseif($action->objectType == 'feedback' and $action->action == 'tostory')
            {
                $desc = $action->extra ? $this->lang->feedback->action->tostory.$this->lang->action->desc->extra : $this->lang->action->desc->common;
            }
            elseif($action->action == 'fromfeedback')
            {
                if($action->objectType == 'story'){
                    $desc = $action->extra ? $this->lang->story->action->fromfeedback.$this->lang->action->desc->extra : $this->lang->action->desc->common;
                }elseif($action->objectType == 'bug'){
                    $desc = $action->extra ? $this->lang->bug->action->fromfeedback.$this->lang->action->desc->extra : $this->lang->action->desc->common;
                }elseif($action->objectType == 'task'){
                    $desc = $action->extra ? $this->lang->task->action->fromfeedback.$this->lang->action->desc->extra : $this->lang->action->desc->common;
                }
            }
            else
            {
                $desc = $action->extra ? $this->lang->action->desc->extra : $this->lang->action->desc->common;
            }
        }

        if($this->app->getViewType() == 'mhtml') $action->date = date('m-d H:i', strtotime($action->date));

        /* Cycle actions, replace vars. */
        foreach($action as $key => $value)
        {
            // 修改此处让评论可以返回更多用户信息 -> chenjj 221225
            if($key == 'history' || $key == 'openedBy') continue;

            /* Desc can be an array or string. */
            if(is_array($desc))
            {
                if($key == 'extra') continue;
                if($action->objectType == 'story' and $action->action == 'reviewed' and strpos($action->extra, '|') !== false and $key == 'actor')
                {
                    $desc['main'] = str_replace('$actor', $this->lang->action->superReviewer . ' ' . $value, $desc['main']);
                }
                else
                {
                    $desc['main'] = str_replace('$' . $key, $value, $desc['main']);
                }
            }
            else
            {
                $desc = str_replace('$' . $key, $value, $desc);
            }
        }

        /* If the desc is an array, process extra. Please bug/lang. */
        if(is_array($desc))
        {
            $extra = strtolower($action->extra);

            /* Fix bug #741. */
            if(isset($desc['extra'])) $desc['extra'] = $this->lang->$objectType->{$desc['extra']};

            $actionDesc = '';
            if(isset($desc['extra'][$extra]))
            {
                $actionDesc = str_replace('$extra', $desc['extra'][$extra], $desc['main']);
            }
            else
            {
                $actionDesc = str_replace('$extra', $action->extra, $desc['main']);
            }

            if($action->objectType == 'story' and $action->action == 'reviewed')
            {
                if(strpos($action->extra, ',') !== false)
                {
                    list($extra, $reason) = explode(',', $extra);
                    $desc['reason'] = $this->lang->$objectType->{$desc['reason']};
                    $actionDesc = str_replace(array('$extra', '$reason'), array($desc['extra'][$extra], $desc['reason'][$reason]), $desc['main']);
                }

                if(strpos($action->extra, '|') !== false)
                {
                    list($extra, $isSuperReviewer) = explode('|', $extra);
                    $actionDesc = str_replace('$extra', $desc['extra'][$extra], $desc['main']);
                }
            }

            if($action->objectType == 'module' and strpos(',created,moved,', $action->action) !== false)
            {
                $moduleNames = $this->loadModel('tree')->getOptionMenu($action->objectID, 'story', 0, 'all', '');
                $modules     = explode(',', $action->extra);
                $moduleNames = array_intersect_key($moduleNames, array_combine($modules, $modules));
                $moduleNames = implode(', ', $moduleNames);
                $actionDesc  = str_replace('$extra', $moduleNames, $desc['main']);
            }
            elseif($action->objectType == 'module' and $action->action == 'deleted')
            {
                $module      = $this->dao->select('*')->from(TABLE_MODULE)->where('id')->eq($action->objectID)->fetch();
                $moduleNames = $this->loadModel('tree')->getOptionMenu($module->root, 'story', 0, 'all', '');
                $actionDesc  = str_replace('$extra', zget($moduleNames, $action->objectID), $desc['main']);
            }
            echo $actionDesc;
        }
        else
        {
            echo $desc;
        }
    }
    
}