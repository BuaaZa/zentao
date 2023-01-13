<?php
/**
 * 热门产品的接口（反馈评论最多的前10个为热门产品接口）
 */
class extFeedbackHotProductsEntry extends Entry
{
    /**
     * GET method.
     *
     * @access public
     * @return void
     */
    public function get()
    {
        // SELECT
        //     ztp.id AS productID,
        //     ztp.`name` AS productName,
        //     --ztf.title AS feedbackTitle,
        //     zta.objectID AS feedbacId,
        //     count( zta.objectID ) AS count
        // FROM
        //     `zt_product` AS ztp
        //     LEFT JOIN `zt_feedback` AS ztf ON ztp.id = ztf.product
        //     LEFT JOIN `zt_action` AS zta ON zta.objectID = ztf.id
        // WHERE
        //     zta.objectType = 'feedback'
        //     AND zta.action = 'commented'
        // GROUP BY
        //     ztp.id
        // ORDER BY count DESC;

        $queryRet=$this->dao->select('ztp.id AS productID,ztp.`name` AS productName,zta.objectID AS feedbacId,count( zta.objectID ) AS count')
        ->from(TABLE_PRODUCT)->alias('ztp')
        ->leftJoin(TABLE_FEEDBACK)->alias('ztf')->on('ztp.id = ztf.product')
        ->leftJoin(TABLE_ACTION)->alias('zta')->on('zta.objectID = ztf.id')
        ->where('zta.objectType')->eq('feedback')
        ->andWhere('zta.action')->eq('commented')
        ->groupBy('ztp.id')
        ->orderBy('count_desc')
        ->fetchAll();

        $ret = array();
        if (!empty($queryRet)) {
            foreach ($queryRet as $r) {
                unset($r->feedbacId);
                array_push($ret, $r);
                if (count($ret)>=10) {
                    break;
                }
            }
        }

        $this->send(200, $ret);
    }
}
