<?php
    function buildOperateMenu(object $bug, string $type = 'view'): string
    {
        $menu          = '';
        $params        = "bugID=$bug->id";
        $extraParams   = "extras=bugID=$bug->id";
        if($this->app->tab == 'project')   $extraParams .= ",projectID={$bug->project}";
        if($this->app->tab == 'execution') $extraParams .= ",executionID={$bug->execution}";
        $copyParams    = "productID=$bug->product&branch=$bug->branch&$extraParams";
        $convertParams = "productID=$bug->product&branch=$bug->branch&moduleID=0&from=bug&bugID=$bug->id";
        $toStoryParams = "product=$bug->product&branch=$bug->branch&module=0&story=0&execution=0&bugID=$bug->id";

        $menu .= $this->buildMenu('bug', 'confirmBug', $params, $bug, $type, 'ok', '', "iframe", true);
        if($type == 'view' and $bug->status != 'closed') $menu .= $this->buildMenu('bug', 'assignTo', $params, $bug, $type, '', '', "iframe", true);
        $menu .= $this->buildMenu('bug', 'resolve', $params, $bug, $type, 'checked', '', "iframe showinonlybody", true);
        $menu .= $this->buildMenu('bug', 'close', $params, $bug, $type, '', '', "text-danger iframe showinonlybody", true);
        if($type == 'view'){
            if($bug->activatedCount <1){
                $menu .= $this->buildMenu('bug', 'activate', $params, $bug, $type, '', '', "text-success iframe showinonlybody", true);
            }else if($bug->status == "resolved"){
                $menu .= $this->buildMenu('bug', 'launchdeliberation', $params, $bug, $type, '', '', "text-success iframe showinonlybody", true);
            }
            if($bug->status == "tobedeliberated"){
                $menu .= $this->buildMenu('bug', 'recorddeliberation', $params, $bug, $type, '', '', "text-success iframe showinonlybody", true);
            }
        }
        if($type == 'view' && $this->app->tab != 'product')
        {
            $menu .= $this->buildMenu('bug', 'toStory', $toStoryParams, $bug, $type, $this->lang->icons['story'], '', '', '', "data-app='product' id='tostory'", $this->lang->bug->toStory);
            if(common::hasPriv('task', 'create') and !isonlybody()) $menu .= html::a('#toTask', "<i class='icon icon-check'></i><span class='text'>{$this->lang->bug->toTask}</span>", '', "data-app='qa' data-toggle='modal' class='btn btn-link'");
            $menu .= $this->buildMenu('bug', 'createCase', $convertParams, $bug, $type, 'sitemap');
        }
        if($type == 'view')
        {
            $menu .= "<div class='divider'></div>";
            $menu .= $this->buildFlowMenu('bug', $bug, $type, 'direct');
            $menu .= "<div class='divider'></div>";
        }
        $menu .= $this->buildMenu('bug', 'edit', $params, $bug, $type);
        if($this->app->tab != 'product') $menu .= $this->buildMenu('bug', 'create', $copyParams, $bug, $type, 'copy');
        if($type == 'view') $menu .= $this->buildMenu('bug', 'delete', $params, $bug, $type, 'trash', 'hiddenwin', "showinonlybody");

        return $menu;
    }
