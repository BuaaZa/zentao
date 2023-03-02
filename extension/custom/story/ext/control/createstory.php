<?php

class story extends control
{
    public function createStory($productID = 0, $branch = 0, $moduleID = 0, $storyID = 0, $objectID = 0, $bugID = 0, $planID = 0, $todoID = 0, $extra = '', $storyType = 'story')
    {
        /* Whether there is a object to transfer story, for example feedback. */
        $extra = str_replace(array(',', ' '), array('&', ''), $extra);
        parse_str($extra, $output);

        if ($productID == 0 and $objectID == 0) {
            $this->locate($this->createLink('product', 'create'));
        }

        /* Get product id according to the project id when lite vision todo transfer story */
        if ($this->config->vision == 'lite' and $productID == 0) {
            $product = $this->loadModel('product')->getProductPairsByProject($objectID);
            if (!empty($project)) {
                $productID = key($product);
            }
        }

        $this->view->fromExecution = -1;
        $this->story->replaceURLang($storyType);
        $feedbackID = '';
        if ($this->app->tab == 'feedback') {
            if (isset($output["fromID"])) {
                $feedbackID = (int)$output["fromID"];
                $output["feedback"] = $feedbackID;
            }
        } elseif ($this->app->tab == 'product') {
            $this->product->setMenu($productID);
        } elseif ($this->app->tab == 'project') {
            $objectID = empty($objectID) ? $this->session->project : $objectID;
            $this->loadModel('project');
            $objects  = $this->project->getPairsByProgram();
            $objectID = $this->project->saveState($objectID, $objects);
            $this->project->setMenu($objectID);
        } elseif ($this->app->tab == 'execution') {
            $objectID = empty($objectID) ? $this->session->execution : $objectID;
            $this->execution->setMenu($objectID);
            $execution = $this->dao->findById((int)$objectID)->from(TABLE_EXECUTION)->fetch();
            $this->view->fromExecution = $execution->id;
            if ($execution->type == 'kanban') {
                $this->loadModel('kanban');
                $regionPairs = $this->kanban->getRegionPairs($execution->id, 0, 'execution');
                $regionID    = !empty($output['regionID']) ? $output['regionID'] : key($regionPairs);
                $lanePairs   = $this->kanban->getLanePairsByRegion($regionID, 'story');
                $laneID      = !empty($output['laneID']) ? $output['laneID'] : key($lanePairs);

                $this->view->executionType = $execution->type;
                $this->view->regionID      = $regionID;
                $this->view->laneID        = $laneID;
                $this->view->regionPairs   = $regionPairs;
                $this->view->lanePairs     = $lanePairs;
            }
        }

        foreach ($output as $paramKey => $paramValue) {
            if (isset($this->config->story->fromObjects[$paramKey])) {
                $fromObjectIDKey  = $paramKey;
                $fromObjectID     = $paramValue;
                $fromObjectName   = $this->config->story->fromObjects[$fromObjectIDKey]['name'];
                $fromObjectAction = $this->config->story->fromObjects[$fromObjectIDKey]['action'];
                break;
            }
        }

        /* If there is a object to transfer story, get it by getById function and set objectID,object in views. */
        if (isset($fromObjectID)) {
            $fromObject = $this->loadModel($fromObjectName)->getById($fromObjectID);
            if (!$fromObject) {
                return print(js::error($this->lang->notFound) . js::locate('back', 'parent'));
            }

            $this->view->$fromObjectIDKey = $fromObjectID;
            $this->view->$fromObjectName  = $fromObject;
        }

        $copyStoryID = $storyID;

        if (!empty($_POST)) {
            $response['result'] = 'success';

            setcookie('lastStoryModule', (int)$this->post->module, $this->config->cookieLife, $this->config->webRoot, '', $this->config->cookieSecure, false);
            $storyResult = $this->story->create($objectID, $bugID, $from = isset($fromObjectIDKey) ? $fromObjectIDKey : '', $extra);
            if (!$storyResult or dao::isError()) {
                $response['result']  = 'fail';
                $response['message'] = dao::getError();
                return $this->send($response);
            }

            $storyID   = $storyResult['id'];
            $productID = $this->post->product ? $this->post->product : $productID;

            if ($storyResult['status'] == 'exists') {
                $response['message'] = sprintf($this->lang->duplicate, $this->lang->story->common);
                if ($objectID == 0) {
                    $response['locate'] = $this->createLink('story', 'view', "storyID={$storyID}&version=0&param=0&storyType=$storyType");
                } else {
                    $execution          = $this->dao->findById((int)$objectID)->from(TABLE_EXECUTION)->fetch();
                    $moduleName         = $execution->type == 'project' ? 'projectstory' : 'execution';
                    $param              = $execution->type == 'project' ? "projectID=$objectID&productID=$productID" : "executionID=$objectID";
                    $response['locate'] = $this->createLink($moduleName, 'story', $param);
                }
                return $this->send($response);
            }

            $this->loadModel('action');
            $action = $bugID == 0 ? 'Opened' : 'Frombug';
            $extra  = $bugID == 0 ? '' : $bugID;
            /* Record related action, for example FromFeedback. */
            if (isset($fromObjectID)) {
                $action = $fromObjectAction;
                $extra  = $fromObjectID;
            }
            $actionID = $this->action->create('story', $storyID, $action, '', $extra);

            if ($objectID != 0) {
                $object = $this->dao->findById((int)$objectID)->from(TABLE_PROJECT)->fetch();
                if ($object->type != 'project') {
                    if ($this->config->systemMode == 'new') {
                        $this->action->create('story', $storyID, 'linked2project', '', $object->project);
                    }

                    $actionType = $object->type == 'kanban' ? 'linked2kanban' : 'linked2execution';
                    $this->action->create('story', $storyID, $actionType, '', $objectID);
                } else {
                    $this->action->create('story', $storyID, 'linked2project', '', $objectID);
                }
            }

            if ($todoID > 0) {
                $this->dao->update(TABLE_TODO)->set('status')->eq('done')->where('id')->eq($todoID)->exec();
                $this->action->create('todo', $todoID, 'finished', '', "STORY:$storyID");

                // if增加 $this->config->edition == 'open' chenjj 230115
                if ($this->config->edition == 'biz' || $this->config->edition == 'max' || $this->config->edition == 'open') {
                    $todo = $this->dao->select('type, idvalue')->from(TABLE_TODO)->where('id')->eq($todoID)->fetch();
                    if ($todo->type == 'feedback' && $todo->idvalue) {
                        $this->loadModel('feedback')->updateStatus('todo', $todo->idvalue, 'done');
                    }
                }
            }

            if ($feedbackID > 0) {
                // 反馈转需求后的属性更新修改 chenjj 230115
                $this->dao->update(TABLE_FEEDBACK)
                ->set('status')->eq('commenting')
                ->set('solution')->eq('tostory')
                ->set('result')->eq($storyID)
                ->where('id')->eq($feedbackID)->exec();
                // feedback的action
                $this->action->create('feedback', $feedbackID, 'tostory', '', $storyID);
            }

            $message = $this->executeHooks($storyID);
            if ($message) {
                $this->lang->saveSuccess = $message;
            }
            $response['message'] = $this->post->status == 'draft' ? $this->lang->story->saveDraftSuccess : $this->lang->saveSuccess;

            if ($this->viewType == 'json') {
                return $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'id' => $storyID));
            }

            /* If link from no head then reload. */
            if (isonlybody()) {
                $execution = $this->execution->getByID($this->session->execution);
                if ($this->app->tab == 'execution') {
                    $execLaneType = $this->session->execLaneType ? $this->session->execLaneType : 'all';
                    $execGroupBy  = $this->session->execGroupBy ? $this->session->execGroupBy : 'default';

                    if ($execution->type == 'kanban') {
                        $rdSearchValue = $this->session->rdSearchValue ? $this->session->rdSearchValue : '';
                        $kanbanData    = $this->loadModel('kanban')->getRDKanban($this->session->execution, $execLaneType, 'id_desc', 0, $execGroupBy, $rdSearchValue);
                        $kanbanData    = json_encode($kanbanData);

                        return $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'closeModal' => true, 'callback' => "parent.updateKanban($kanbanData, 0)"));
                    } else {
                        $taskSearchValue = $this->session->taskSearchValue ? $this->session->taskSearchValue : '';
                        $kanbanData      = $this->loadModel('kanban')->getExecutionKanban($execution->id, $execLaneType, $execGroupBy, $taskSearchValue);
                        $kanbanType      = $execLaneType == 'all' ? 'story' : key($kanbanData);
                        $kanbanData      = $kanbanData[$kanbanType];
                        $kanbanData      = json_encode($kanbanData);
                        return $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'closeModal' => true, 'callback' => "parent.updateKanban(\"story\", $kanbanData)"));
                    }
                } else {
                    return $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => 'parent'));
                }
            }

            if ($this->post->newStory) {
                $response['message'] = $this->lang->story->successSaved . $this->lang->story->newStory;
                $response['locate']  = $this->createLink('story', 'create', "productID=$productID&branch=$branch&moduleID=$moduleID&story=0&objectID=$objectID&bugID=$bugID");
                return $this->send($response);
            }

            $moduleID = $this->post->module ? $this->post->module : 0;
            if ($objectID == 0) {
                setcookie('storyModule', 0, 0, $this->config->webRoot, '', $this->config->cookieSecure, false);
                $branchID  = $this->post->branch ? $this->post->branch : $branch;
                $response['locate'] = $this->createLink('product', 'browse', "productID=$productID&branch=$branchID&browseType=&param=0&storyType=$storyType&orderBy=id_desc");
                if ($this->session->storyList) {
                    /* When copying story in the product plan, return to different pages for story#32949. */
                    if ($copyStoryID and strpos($this->session->storyList, 'productplan') !== false) {
                        $storyInfo = $this->story->getByList(array($storyID, $copyStoryID));
                        if ($storyInfo[$storyID]->plan == $storyInfo[$copyStoryID]->plan or $storyInfo[$storyID]->product != $storyInfo[$copyStoryID]->product) {
                            $response['locate'] = $this->session->storyList;
                        }
                    } else {
                        $response['locate'] = $this->session->storyList;
                    }
                }
            } else {
                setcookie('storyModuleParam', 0, 0, $this->config->webRoot, '', $this->config->cookieSecure, true);
                $execution          = $this->dao->findById((int)$objectID)->from(TABLE_EXECUTION)->fetch();
                $moduleName         = $execution->type == 'project' ? 'projectstory' : 'execution';
                $param              = $execution->type == 'project' ? "projectID=$objectID&productID=$productID" : "executionID=$objectID&orderBy=order_desc&browseType=unclosed";
                $response['locate'] = $this->createLink($moduleName, 'story', $param);
            }
            if ($this->app->getViewType() == 'xhtml') {
                $response['locate'] = $this->createLink('story', 'view', "storyID=$storyID", 'html');
            }
            if ($this->app->tab == 'feedback') {
                $response['message'] = $this->lang->saveSuccess;
                $response['locate'] = $this->createLink('feedback', 'adminView', "feedbackID=$feedbackID", 'html');
            }
            return $this->send($response);
        }

        $this->loadModel('product');
        /* Set products, users and module. */
        if ($objectID != 0) {
            $onlyNoClosed    = empty($this->config->CRProduct) ? 'noclosed' : '';
            $products        = $this->product->getProductPairsByProject($objectID, $onlyNoClosed);
            $productID       = empty($productID) ? key($products) : $productID;
            $product         = $this->product->getById(($productID and array_key_exists($productID, $products)) ? $productID : key($products));
            $productBranches = $product->type != 'normal' ? $this->loadModel('execution')->getBranchByProduct($productID, $objectID, 'noclosed|withMain') : array();
            $branches        = isset($productBranches[$productID]) ? $productBranches[$productID] : array();
            $branch          = key($branches);
        } else {
            $products = array();
            $productList = $this->product->getOrderedProducts('noclosed');
            foreach ($productList as $product) {
                $products[$product->id] = $product->name;
            }
            $product = $this->product->getById($productID ? $productID : key($products));
            if (!isset($products[$product->id])) {
                $products[$product->id] = $product->name;
            }
            $branches = $product->type != 'normal' ? $this->loadModel('branch')->getPairs($productID, 'active') : array();
        }

        $this->loadModel('user');
        $this->loadModel('tree');
        $users = $this->user->getPairs('pdfirst|noclosed|nodeleted');
        $moduleOptionMenu = $this->tree->getOptionMenu($productID, $viewType = 'story', 0, $branch === 'all' ? 0 : $branch);
        if (empty($moduleOptionMenu)) {
            return print(js::locate(helper::createLink('tree', 'browse', "productID=$productID&view=story")));
        }

        /* Init vars. */
        $source     = '';
        $sourceNote = '';
        $pri        = 3;
        $estimate   = '';
        $title      = '';
        $spec       = '';
        $verify     = '';
        $keywords   = '';
        $mailto     = '';
        $color      = '';

        if ($storyID > 0) {
            $story      = $this->story->getByID($storyID);
            $planID     = $story->plan;
            $source     = $story->source;
            $sourceNote = $story->sourceNote;
            $color      = $story->color;
            $pri        = $story->pri;
            $productID  = $story->product;
            $moduleID   = $story->module;
            $estimate   = $story->estimate;
            $title      = $story->title;
            $spec       = htmlSpecialString($story->spec);
            $verify     = htmlSpecialString($story->verify);
            $keywords   = $story->keywords;
            $mailto     = $story->mailto;
        }

        if ($bugID > 0) {
            $oldBug    = $this->loadModel('bug')->getById($bugID);
            $productID = $oldBug->product;
            $source    = 'bug';
            $title     = $oldBug->title;
            $keywords  = $oldBug->keywords;
            $spec      = $oldBug->steps;
            $pri       = !empty($oldBug->pri) ? $oldBug->pri : '3';
            if ($oldBug->mailto and strpos($oldBug->mailto, $oldBug->openedBy) === false) {
                $mailto = $oldBug->mailto . $oldBug->openedBy . ',';
            } else {
                $mailto = $oldBug->mailto;
            }
        }

        if ($todoID > 0) {
            $todo   = $this->loadModel('todo')->getById($todoID);
            $source = 'todo';
            $title  = $todo->name;
            $spec   = $todo->desc;
            $pri    = $todo->pri;
        }

        if ($feedbackID > 0) {
            $feedback = $this->dao->findById($feedbackID)->from(TABLE_FEEDBACK)->fetch();
            if ($feedback) {
                $this->view->feedback         =$feedbackID;
                $this->view->feedbackBy       =$feedback->feedbackBy;
                $this->view->notifyEmail      =$feedback->notifyEmail;
                $title                        =$feedback->title;
                $spec                         =$feedback->desc;
                // 查找评审意见，如果又就教导desc后面组成$spec
                $action = $this->dao->select('comment')->from(TABLE_ACTION)
                ->where('objectType')->eq('feedback')
                ->andWhere('objectID')->eq($feedbackID)
                ->andWhere('action')->eq('reviewed')
                ->orderBy('id_desc')
                ->fetch();
                if ($action && isset($action->comment)) {
                    $spec.='\n'.$this->lang->feedback->reviewOpinion.'：'.$action->comment;
                }
            }
        }

        /* Replace the value of story that needs to be replaced with the value of the object that is transferred to story. */
        if (isset($fromObject)) {
            if (isset($this->config->story->fromObjects[$fromObjectIDKey]['source'])) {
                $sourceField = $this->config->story->fromObjects[$fromObjectIDKey]['source'];
                $sourceUser  = $this->loadModel('user')->getById($fromObject->{$sourceField});
                $source      = $sourceUser->role;
                $sourceNote  = $sourceUser->realname;
            } else {
                $source      = $fromObjectName;
                $sourceNote  = $fromObjectID;
            }

            foreach ($this->config->story->fromObjects[$fromObjectIDKey]['fields'] as $storyField => $fromObjectField) {
                $$storyField = $fromObject->{$fromObjectField};
            }
        }

        /* Get block id of assinge to me. */
        $blockID = 0;
        if (isonlybody()) {
            $blockID = $this->dao->select('id')->from(TABLE_BLOCK)
                ->where('block')->eq('assingtome')
                ->andWhere('module')->eq('my')
                ->andWhere('account')->eq($this->app->user->account)
                ->orderBy('order_desc')
                ->fetch('id');
        }

        /* Get reviewers. */
        $reviewers = $product->reviewer;
        if (!$reviewers and $product->acl != 'open') {
            $reviewers = $this->loadModel('user')->getProductViewListUsers($product, '', '', '', '');
        }

        /* Get the module's children id list. */
        $moduleID     = $moduleID ? $moduleID : (int)$this->cookie->lastStoryModule;
        $moduleID     = isset($moduleOptionMenu[$moduleID]) ? $moduleID : 0;
        $moduleIdList = $this->tree->getAllChildId($moduleID);

        /* Set Custom. */
        foreach (explode(',', $this->config->story->list->customCreateFields) as $field) {
            $customFields[$field] = $this->lang->story->$field;
        }
        $this->view->customFields = $customFields;
        $this->view->showFields   = $this->config->story->custom->createFields;
        $this->view->storyID = $storyID;

        $this->view->title            = $product->name . $this->lang->colon . $this->lang->story->create;
        $this->view->position[]       = html::a($this->createLink('product', 'browse', "product=$productID&branch=$branch"), $product->name);
        $this->view->position[]       = $this->lang->story->common;
        $this->view->position[]       = $this->lang->story->create;
        $this->view->gobackLink       = (isset($output['from']) and $output['from'] == 'global') ? $this->createLink('product', 'browse', "productID=$productID") : '';
        $this->view->products         = $products;
        $this->view->users            = $users;
        $this->view->moduleID         = $moduleID;
        $this->view->moduleOptionMenu = $moduleOptionMenu;
        $this->view->plans            = str_replace('2030-01-01', $this->lang->story->undetermined, $this->loadModel('productplan')->getPairsForStory($productID, $branch, 'skipParent|unexpired|noclosed'));
        $this->view->planID           = $planID;
        $this->view->source           = $source;
        $this->view->sourceNote       = $sourceNote;
        $this->view->color            = $color;
        $this->view->pri              = $pri;
        $this->view->branch           = $branch;
        $this->view->branches         = $branches;
        $this->view->stories          = $this->story->getParentStoryPairs($productID);
        $this->view->productID        = $productID;
        $this->view->product          = $product;
        $this->view->reviewers        = $this->user->getPairs('noclosed|nodeleted', '', 0, $reviewers);
        $this->view->objectID         = $objectID;
        $this->view->estimate         = $estimate;
        $this->view->storyTitle       = $title;
        $this->view->spec             = $spec;
        $this->view->verify           = $verify;
        $this->view->keywords         = $keywords;
        $this->view->mailto           = $mailto;
        $this->view->blockID          = $blockID;
        $this->view->URS              = $storyType == 'story' ? $this->story->getProductStoryPairs($productID, $branch, $moduleIdList, 'changing,active,reviewing', 'id_desc', 0, '', 'requirement') : '';
        $this->view->needReview       = ($this->app->user->account == $product->PO or $objectID > 0 or $this->config->story->needReview == 0 or !$this->story->checkForceReview()) ? "checked='checked'" : "";
        $this->view->type             = $storyType;

        $this->display();
    }
}
