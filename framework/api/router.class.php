<?php
/**
 * 禅道API的api类。
 * The api class file of ZenTao API.
 *
 * The author disclaims copyright to this source code.  In place of
 * a legal notice, here is a blessing:
 *
 *  May you do good and not evil.
 *  May you find forgiveness for yourself and forgive others.
 *  May you share freely, never taking more than you give.
 */
include dirname(__FILE__, 2) . '/router.class.php';
class api extends router
{
    /**
     * 请求API的路径
     * The requested path of api.
     *
     * @var string
     * @access public
     */
    public string $path;

    /**
     * API版本号
     * The version of API.
     *
     * @var string
     * @access public
     */
    public string $version = '';

    /**
     * 请求API的参数，包括键值
     * The requested params of api: key and value.
     *
     * @var array
     * @access public
     */
    public $params = array();

    /**
     * 请求API的参数名
     * The requested param names of api.
     *
     * @var array
     * @access public
     */
    public array $paramNames = array();

    /**
     * 请求的资源名称
     * The requested entry point
     *
     * @var string
     * @access public
     */
    public string $entry;

    /**
     * API资源的执行方法: get post put delete
     * The action of entry point: get post put delete
     *
     * @var string
     * @access public
     */
    public string $action;

    /**
     * 构造方法, 设置请求路径，版本等
     *
     * The construct function.
     * Prepare all the paths, version and so on.
     *
     * @access public
     * @return void
     */
    public function __construct($appName = 'api', $appRoot = '')
    {
        parent::__construct($appName, $appRoot);

        $this->httpMethod  = strtolower($_SERVER['REQUEST_METHOD']);

        /*
        $documentRoot = zget($_SERVER, 'CONTEXT_DOCUMENT_ROOT', $_SERVER['DOCUMENT_ROOT']);
        $fileName     = ltrim(substr($_SERVER['SCRIPT_FILENAME'], strlen($documentRoot)), '/');
        $webRoot      = ltrim($this->config->webRoot, '/');
        $this->path   = substr(ltrim($_SERVER['REQUEST_URI'], '/'), strlen($webRoot . $fileName) + 1);

        if(strpos($this->path, '?') > 0) $this->path = strstr($this->path, '?', true);
         */

        $this->path = trim(substr($_SERVER['REQUEST_URI'], strpos($_SERVER['REQUEST_URI'], 'api.php') + 7), '/');
        if(strpos($this->path, '?') > 0) $this->path = strstr($this->path, '?', true);

        $subPos = $this->path ? strpos($this->path, '/') : false;
        $this->version = $subPos !== false ? substr($this->path, 0, $subPos) : '';
        $this->path    = $subPos !== false ? substr($this->path, $subPos) : '';

        $this->loadApiLang();
    }

    /**
     * 解析请求路径，找到处理方法
     *
     * Parse request path, find entry and action.
     *
     * @param array $routes
     * @access private
     * @return void
     */
    public function route(array $routes): void
    {
        foreach($routes as $route => $target)
        {
            $patternAsRegex = preg_replace_callback(
                '#:([\w]+)\+?#',
                array($this, 'matchesCallback'),
                str_replace(')', ')?', $route)
            );
            if(str_ends_with($route, '/')) $patternAsRegex .= '?';

            /* Cache URL params' names and values if this route matches the current HTTP request. */
            if(!preg_match('#^' . $patternAsRegex . '$#', $this->path, $paramValues)) continue;

            /* Set module and action */
            $this->entry  = $target;
            $this->action = strtolower($_SERVER['REQUEST_METHOD']);

            /* Set params */
            foreach($this->paramNames as $name)
            {
                if(!isset($paramValues[$name])) continue;

                if(isset($this->paramNamesPath[$name]))
                {
                    $this->params[$name] = explode('/', urldecode($paramValues[$name]));
                }
                else
                {
                    $this->params[$name] = urldecode($paramValues[$name]);
                }
            }
            return;
        }

        $this->entry  = 'error';
        $this->action = 'notFound';
    }

    /**
     * 将路由路径参数转化为正则
     *
     * Parse params of route to regular expression.
     *
     * @param  string $param
     * @access protected
     * @return string
     */
    protected function matchesCallback($m)
    {
        $this->paramNames[] = $m[1];
        return '(?P<' . $m[1] . '>[^/]+)';
    }

    /**
     * 解析访问请求
     *
     * Parse request.
     *
     * @access public
     * @return void
     */
    public function parseRequest()
    {
        /* If version of api don't exists, call parent method. */
        if(!$this->version)
            return parent::parseRequest();

        $this->route($this->config->routes);
    }

    /**
     * 执行对应模块
     *
     * Load the running module.
     *
     * @access public
     * @return void
     */
    public function loadModule()
    {
        /* If the version of api don't exists, call parent method. */
        if(!$this->version)
            parent::loadModule();

        $entryFile = $this->entry;
        if ($this->version == 'v1')
            $entryFile = strtolower($this->entry);

        include(dirname(__FILE__, 3) . "/api/$this->version/entries/$entryFile.php");

        $entryName = $this->entry . 'Entry';
        $entry = new $entryName();

        if($this->action == 'options')
            return $entry->send(204);
        call_user_func_array(array($entry, $this->action), array_values($this->params));
    }

    /**
     * 加载配置文件
     *
     * Load config file of api.
     *
     * @param string $configPath
     * @access public
     * @return void
     */
    public function loadApiConfig(string $configPath)
    {
        global $config;
        include($this->appRoot . "api/$this->version/config/$configPath.php");
    }

    /**
     * 加载语言文件
     *
     * Load lang file of api.
     *
     * @access public
     * @return void
     */
    public function loadApiLang()
    {
        global $lang;
        if($this->version) include($this->appRoot . "api/$this->version/lang/$this->clientLang.php");
    }

    /**
     * 格式化旧版本API响应数据
     *
     * Format old version data.
     *
     * @param  string
     * @access public
     * @return string
     */
    public function formatData($output)
    {
        /* If the version exists, return output directly. */
        if($this->version) return $output;

        $output = json_decode($output);

        $data = new stdClass();
        $data->status = $output->status ?? $output->result;
        if(isset($output->message)) $data->message = $output->message;
        if(isset($output->data))    $data->data    = json_decode($output->data);
        if(isset($output->id))      $data->id      = $output->id;
        $output = json_encode($data);

        unset($_SESSION['ENTRY_CODE']);
        unset($_SESSION['VALID_ENTRY']);

        return $output;
    }

    public function __toString(): string {
        return "action: " . $this->action . "\n"
            . "entry: " . $this->entry . "\n"
            . "paramNames: " . $this->paramNames . "\n"
            ;
    }
}
