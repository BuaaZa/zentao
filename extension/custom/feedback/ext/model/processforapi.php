<?php

/**
 * API处理将值翻译成对应的人能看懂的
 * status -> statusName
 * type -> typeName
 */
public function processForApi($feedbacks=array())
{
  if(empty($feedbacks)){
    return $feedbacks;
  }
  
  $solutions = $this->lang->feedback->solutionList;
  $types = $this->lang->feedback->typeList;
  $status = $this->lang->feedback->statusList;
  $this->loadModel('product');
  $products = $this->product->getPairs('', 0, 'program_asc');

  foreach ($feedbacks as $fb) {
      if (!empty($fb->solution)&&isset($solutions[$fb->solution])) {
          $fb->solutionName=$solutions[$fb->solution];
      }
      if (!empty($fb->type)&&isset($types[$fb->type])) {
          $fb->typeName=$types[$fb->type];
      }
      if (!empty($fb->status)&&isset($status[$fb->status])) {
          $fb->statusName=$status[$fb->status];
      }
      if (!empty($fb->product)&&isset($products[$fb->product])) {
          $fb->productName=$products[$fb->product];
      }
      $this->processPropertity($fb);
  }


  return $feedbacks;
}