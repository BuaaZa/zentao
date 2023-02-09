<?php

// 只有一层的就只是产品，两层的第一次是产品集，第二层是产品
/**
 * @param boolean $allowFeedback 是否过来可以添加反馈的产品
 */
public function getProductsTree($allowFeedback = false)
{
    $programMap  = $this->loadModel('program')->getPairs(true);
    $this->loadModel('product');
    $productList = $this->product->getList();

    // 先把产品数据按program ID分类存放
    // 按program存放的产品数据
    $productsByProgram = array();
    if (!empty($productList)) {
        foreach ($productList as $product) {
            if($allowFeedback && $product->allowFeedback == '0') {
                // 需要过滤出允许添加反馈的产品
                continue;
            }
            if (!array_key_exists($product->program, $productsByProgram)) {
                $productsByProgram[$product->program] = array();
            }
            $productEle = array('value'=>$product->id,'label'=>$product->name);
            array_push($productsByProgram[$product->program], $productEle);
        }
    }

    // 返回结果
    $ret =array();
    // 产品对应的program存在就放到对应的program数据的children下，否则与program同级
    foreach ($productsByProgram as $programID=>$products) {
        if (array_key_exists($programID, $programMap)) {
            array_push($ret, array(
                'value'=>$programID,
                'label'=>$programMap[$programID],
                'children'=>$products
            ));
        } else {
            $ret = array_merge($ret, $products);
        }
    }
    
    return $ret;
}