<?php
/**
 * The tokens entry point of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2021 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL(http://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     entries
 * @version     1
 * @link        http://www.zentao.net
 */
class tokensNewEntry extends baseEntry
{

    public function http_post_json($url, $jsonStr)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonStr);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        //         'Content-Type: application/json; charset=utf-8',
        //         'Content-Length: ' . strlen($jsonStr)
        //     )
        // );
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return array($httpCode, $response);
    }
    /**
     * POST method.
     *
     * @access public
     * @return void
     */
    public function post()
    {
      $tjToken   = $this->request('access_token');
      $tjDomain = $this->request('domain');
      $loginParam = array('access_token'=>$tjToken,'ident_domineid'=>$tjDomain);
      $ret = $this->http_post_json('https://tianji-sapi.lhzw.com.cn/admin_api/api/org/orguser_current_userinfo',$loginParam);
      if(count($ret)<2)
      {
        return $this->sendError(400, $this->lang->user->loginFailed+" 登录天唧异常");
      }
      $retInfo = json_decode($ret[1]);
      if($retInfo->code!='000000')
      {
        $msgInfo = array('msg'=>$this->lang->user->loginFailed,'tjinfo'=>$retInfo);
        return $this->sendError(400, $msgInfo);
      }
      if(!isset($retInfo->userEntry) || !isset($retInfo->userEntry->mobile))
      {
        $msgInfo = array('msg'=>'没有手机号或者用户信息');
        return $this->sendError(400, $msgInfo);
      }

      $account   = $retInfo->userEntry->mobile;
      $password  = '123456Abcd@#';
      $addAction = $this->request('addAction', false);

      if($this->loadModel('user')->checkLocked($account)) return $this->sendError(400, sprintf($this->lang->user->loginLocked, $this->config->user->lockMinutes));

      $user = $this->user->identify($account, $password);
      if($user)
      {
          $this->user->login($user, $addAction);
          $this->send(201, array('token' => session_id(),'tjret'=>$retInfo));
      }
      else
      {
          $fails = $this->user->failPlus($account);
          $remainTimes = $this->config->user->failTimes - $fails;
          if($remainTimes <= 0)
          {
              return $this->sendError(400,  sprintf("%s %s",$account,sprintf($this->lang->user->loginLocked, $this->config->user->lockMinutes)));
          }
          else if($remainTimes <= 3)
          {
              return $this->sendError(400, sprintf("%s %s",sprintf($this->lang->user->lockWarning, $remainTimes)));
          }

          return $this->sendError(400, sprintf("%s %s",$account,$this->lang->user->loginFailed));
      }

      $this->sendError(400, $this->app->lang->user->loginFailed);
    }


}
