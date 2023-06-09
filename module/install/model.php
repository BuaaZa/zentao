<?php
/**
 * The model file of install module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL(http://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     install
 * @version     $Id: model.php 5006 2013-07-03 08:52:21Z wyd621@gmail.com $
 * @link        http://www.zentao.net
 */

class installModel extends model
{
    public userModel $user;

    /**
     * Get license according the client lang.
     *
     * @access public
     * @return string
     */
    public function getLicense()
    {
        $clientLang = $this->app->getClientLang();

        $licenseCN = file_get_contents($this->app->getBasePath() . 'doc/LICENSE.CN');
        $licenseEN = file_get_contents($this->app->getBasePath() . 'doc/LICENSE.EN');

        if($clientLang == 'zh-cn' or $clientLang == 'zh-tw') return $licenseCN . $licenseEN;
        return $licenseEN . $licenseCN;
    }

    /**
     * get php version.
     *
     * @access public
     * @return string
     */
    public function getPhpVersion()
    {
        return PHP_VERSION;
    }

    /**
     * Get the latest release.
     *
     * @access public
     * @return string or bool
     */
    public function getLatestRelease()
    {
        if(!function_exists('json_decode')) return false;
        $result = file_get_contents('https://www.zentao.net/misc-getlatestrelease.json');
        if($result)
        {
            $result = json_decode($result);
            if(isset($result->release) and $this->config->version != $result->release->version) return $result->release;
        }
        return false;
    }

    /**
     * Check php version.
     *
     * @access public
     * @return string   ok|fail
     */
    public function checkPHP(): string
    {
        return version_compare(PHP_VERSION, '8.0.0') >= 0 ? 'ok' : 'fail';
    }

    /**
     * Check PDO.
     *
     * @access public
     * @return string   ok|fail
     */
    public function checkPDO(): string
    {
        return extension_loaded('pdo') ? 'ok' : 'fail';
    }

    /**
     * Check PDO::MySQL
     *
     * @access public
     * @return string   ok|fail
     */
    public function checkPDOMySQL(): string
    {
        return extension_loaded('pdo_mysql') ? 'ok' : 'fail';
    }

    /**
     * Check json extension.
     *
     * @access public
     * @return string   ok|fail
     */
    public function checkJSON(): string
    {
        return extension_loaded('json') ? 'ok' : 'fail';
    }

    /**
     * Check openssl extension.
     *
     * @access public
     * @return string   ok|fail
     */
    public function checkOpenssl(): string
    {
        return extension_loaded('openssl') ? 'ok' : 'fail';
    }

    /**
     * Check mbstring extension.
     *
     * @access public
     * @return string   ok|fail
     */
    public function checkMbstring(): string
    {
        return extension_loaded('mbstring') ? 'ok' : 'fail';
    }

    /**
     * Check zlib extension.
     *
     * @access public
     * @return string   ok|fail
     */
    public function checkZlib(): string
    {
        return extension_loaded('zlib') ? 'ok' : 'fail';
    }

    /**
     * Check curl extension.
     *
     * @access public
     * @return string   ok|fail
     */
    public function checkCurl(): string
    {
        return extension_loaded('curl') ? 'ok' : 'fail';
    }

    /**
     * Check filter extension.
     *
     * @access public
     * @return string   ok|fail
     */
    public function checkFilter(): string
    {
        return extension_loaded('filter') ? 'ok' : 'fail';
    }

    /**
     * Check filter extension.
     *
     * @access public
     * @return string   ok|fail
     */
    public function checkXML(): string
    {
        return extension_loaded('xml') ? 'ok' : 'fail';
    }

    /**
     * Check filter extension.
     *
     * @access public
     * @return string   ok|fail
     */
    public function checkZIP(): string
    {
        return extension_loaded('zip') ? 'ok' : 'fail';
    }

    /**
     * Check iconv extension.
     *
     * @access public
     * @return string   ok|fail
     */
    public function checkIconv(): string
    {
        return extension_loaded('iconv') ? 'ok' : 'fail';
    }

    /**
     * Get tempRoot info.
     *
     * @access public
     * @return array
     */
    public function getTmpRoot()
    {
        $result['path']     = $this->app->getTmpRoot();
        $result['exists']   = is_dir($result['path']);
        $result['writable'] = is_writable($result['path']);
        return $result;
    }

    /**
     * Check tmpRoot.
     *
     * @access public
     * @return string   ok|fail
     */
    public function checkTmpRoot()
    {
        $tmpRoot = $this->app->getTmpRoot();
        return $result = (is_dir($tmpRoot) and is_writable($tmpRoot)) ? 'ok' : 'fail';
    }

    /**
     * Get session save path.
     *
     * @access public
     * @return array
     */
    public function getSessionSavePath()
    {
        $result['path']     = preg_replace("/\d;/", '', session_save_path());
        $result['exists']   = is_dir($result['path']);
        $result['writable'] = is_writable($result['path']);
        return $result;
    }

    /**
     * Check session save path.
     *
     * @access public
     * @return string
     */
    public function checkSessionSavePath()
    {
        $sessionSavePath = preg_replace("/\d;/", '', session_save_path());
        $result = (is_dir($sessionSavePath) and is_writable($sessionSavePath)) ? 'ok' : 'fail';
        if($result == 'fail') return $result;

        /* Test session path again. Fix bug #1527. */
        file_put_contents($sessionSavePath . '/zentaotest', 'zentao');
        $sessionContent = file_get_contents($sessionSavePath . '/zentaotest');
        if($sessionContent == 'zentao')
        {
            unlink($sessionSavePath . '/zentaotest');
            return 'ok';
        }
        return 'fail';
    }

    /**
     * Get data root
     *
     * @access public
     * @return array
     */
    public function getDataRoot()
    {
        $result['path']    = $this->app->getAppRoot() . 'www' . DS . 'data';
        $result['exists']  = is_dir($result['path']);
        $result['writable']= is_writable($result['path']);
        return $result;
    }

    /**
     * Check the data root.
     *
     * @access public
     * @return string ok|fail
     */
    public function checkDataRoot()
    {
        $dataRoot = $this->app->getAppRoot() . 'www' . DS . 'data';
        return $result = (is_dir($dataRoot) and is_writable($dataRoot)) ? 'ok' : 'fail';
    }

    /**
     * Get the php.ini info.
     *
     * @access public
     * @return string
     */
    public function getIniInfo()
    {
        $iniInfo = '';
        ob_start();
        phpinfo(1);
        $lines = explode("\n", strip_tags(ob_get_contents()));
        ob_end_clean();
        foreach($lines as $line) if(strpos($line, 'ini') !== false) $iniInfo .= $line . "\n";
        return $iniInfo;
    }

    /**
     * Check config ok or not.
     *
     * @access public
     * @return stdclass
     * @throws EndResponseException
     */
    public function initDatabase(): stdclass
    {
        $return = new stdclass();
        $return->result = 'ok';

        /* Connect to database. */
        $this->setDBParam();
        $this->dbh = $this->connectDB();

        /* 检查安装前基本配置 */
        if(str_contains($this->post->dbName, '.'))
        {
            $return->result = 'fail';
            $return->error  = $this->lang->install->errorDBName;
            return $return;
        }
        if(!is_object($this->dbh))
        {
            $return->result = 'fail';
            $return->error  = $this->lang->install->errorConnectDB . $this->dbh;
            return $return;
        }

        /* 根据规则进行安装 */
        // 如果直接安装，则和之前逻辑一致
        if ($this->post->installType === 'install')
        {
            /* Get mysql version. */
            $version = $this->getMysqlVersion();

            // if database not exists, try to create it.
            if(!$this->databaseExists())
            {
                if(!$this->createDatabase())
                {
                    $return->result = 'fail';
                    $return->error  = $this->lang->install->errorCreateDB;
                    return $return;
                }
            }
            // else if database exists and table exists, judge the clear DB tag
            elseif($this->tableExists())
            {
                if ($this->post->clearDB)
                {
                    if (!$this->dropTable())
                    {
                        $return->result = 'fail';
                        $return->error  = $this->lang->install->errorCreateTable . " in createTable2";
                        return $return;
                    }
                }
                else
                {
                    $return->result = 'fail';
                    $return->error = $this->lang->install->errorTableExists;
                    return $return;
                }
            }

            // create table
            if (!$this->createTable2())
            {
                $return->result = 'fail';
                $return->error  = $this->lang->install->errorCreateTable . " in createTable2";
                return $return;
            }

            // insert the metadata
            if (!$this->initData())
            {
                $return->result = 'fail';
                $return->error  = $this->lang->install->errorCreateTable . "在初始化数据阶段";
                return $return;
            }
        }
        elseif ($this->post->installType === 'upgrade')
        {
            if (!$this->databaseExists())
            {
                $return->result = 'fail';
                $return->error  = "所迁移数据库不存在";
                return $return;
            }
            if (!$this->upgradeDatabase())
            {
                $return->result = 'fail';
                $return->error  = $this->lang->install->errorUpdateDB;
                return $return;
            }
        }
        else if ($this->post->installType === 'connect')
        {
            if (!$this->tableExists())
            {
                $return->result = 'fail';
                $return->error = "数据库中表不存在，您连接的数据库可能未配置正确";
                return $return;
            }
        }

        return $return;
    }

    /**
     * Set database params.
     *
     * @access public
     * @return void
     */
    public function setDBParam(): void
    {
        $this->config->db->host     = $this->post->dbHost;
        $this->config->db->name     = $this->post->dbName;
        $this->config->db->user     = $this->post->dbUser;
        $this->config->db->encoding = $this->post->dbEncoding;
        $this->config->db->password = $this->post->dbPassword;
        $this->config->db->port     = $this->post->dbPort;
        $this->config->db->prefix   = $this->post->dbPrefix;
    }

    /**
     * Connect to database.
     *
     * @access public
     * @return object
     */
    public function connectDB()
    {
        $dsn = "mysql:host={$this->config->db->host}; port={$this->config->db->port}";
        try
        {
            $dbh = new PDO($dsn, $this->config->db->user, $this->config->db->password);
            $dbh->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $dbh->exec("SET NAMES {$this->config->db->encoding}");
            if(isset($this->config->db->strictMode) and $this->config->db->strictMode == false) $dbh->exec("SET @@sql_mode= ''");
            return $dbh;
        }
        catch (PDOException $exception)
        {
             return $exception->getMessage();
        }
    }

    /**
     * Check db exits or not.
     *
     * @access public
     * @return bool | stdClass
     */
    public function databaseExists(): bool | stdClass
    {
        $sql = "SHOW DATABASES like '{$this->config->db->name}'";
        return $this->dbh->query($sql)->fetch();
    }

    public function createDatabase(): bool
    {
        $sql = "CREATE DATABASE `{$this->config->db->name}`";
        return $this->dbh->query($sql);
    }

    /**
     * Check table exits or not.
     *
     * @access public
     * @return bool | stdClass
     */
    public function tableExists(): bool | stdClass
    {
        $configTable = str_replace('`', "'", TABLE_CONFIG);
        $sql = "SHOW TABLES FROM {$this->config->db->name} like $configTable";
        return $this->dbh->query($sql)->fetch();
    }

    /**
     * Get mysql version.
     *
     * @access public
     * @return string
     */
    public function getMysqlVersion()
    {
        $sql = "SELECT VERSION() AS version";
        $result = $this->dbh->query($sql)->fetch();
        return substr($result->version, 0, 3);
    }

    /**
     * Create database.
     *
     * @access public
     * @return bool
     */
    public function createDB(): bool
    {
        $sql = "CREATE DATABASE `{$this->config->db->name}`";
        return $this->dbh->query($sql);
    }

    /**
     * 升级数据库
     *
     * @return bool|stdClass
     * @throws EndResponseException
     */
    public function upgradeDatabase(): bool | stdClass
    {
        try
        {
            $dbFile = $this->app->getAppRoot() . 'database' . DS . 'upgrade.sql';
            $commands = explode(';', file_get_contents($dbFile));

            $this->dbh->exec("USE {$this->config->db->name}");
            foreach($commands as $command)
                if(!empty(trim($command)) && !$this->dbh->query($command))
                    return false;
        }
        catch (PDOException $exception)
        {
            echo $exception->getMessage();
            helper::end();
        }
        return true;
    }

    public function createTable2(): bool
    {
        try
        {
            $dbFile = $this->app->getAppRoot() . 'database' . DS . 'table' . DS . 'create.sql';
            $commands = explode(';', file_get_contents($dbFile));

            $this->dbh->exec("USE {$this->config->db->name}");
            foreach($commands as $command)
                if(!empty(trim($command)) && !$this->dbh->query($command))
                    return false;
        }
        catch (PDOException $exception)
        {
            echo $exception->getMessage();
            helper::end();
        }
        return true;
    }

    public function dropTable(): bool
    {
        try
        {
            $dbFile = $this->app->getAppRoot() . 'database' . DS . 'table' . DS . 'drop.sql';
            $commands = explode(';', file_get_contents($dbFile));

            $this->dbh->exec("USE {$this->config->db->name}");
            foreach($commands as $command)
                if(!empty(trim($command)) && !$this->dbh->query($command))
                    return false;
        }
        catch (PDOException $exception)
        {
            echo $exception->getMessage();
            helper::end();
        }
        return true;
    }

    public function initData(): bool
    {
        try
        {
            $dbFile = $this->app->getAppRoot() . 'database' . DS . 'metadata.sql';
            $commands = explode(';', file_get_contents($dbFile));

            $this->dbh->exec("USE {$this->config->db->name}");
            foreach($commands as $command)
                if(!empty(trim($command)) && !$this->dbh->query($command))
                    return false;
        }
        catch (PDOException $exception)
        {
            echo $exception->getMessage();
            helper::end();
        }
        return true;
    }

    /**
     * Create tables.
     *
     * @param string $version
     * @access public
     * @return bool
     * @throws EndResponseException
     */
    public function createTable(string $version): bool
    {
        /* Add exception handling to ensure that all SQL is executed successfully. */
        try
        {
            $this->dbh->exec("USE {$this->config->db->name}");

            $dbFile = $this->app->getAppRoot() . 'db' . DS . 'zentao.sql';
            $tables = explode(';', file_get_contents($dbFile));

            foreach($tables as $table)
            {
                $table = trim($table);
                if(empty($table)) continue;

                if(str_contains($table, 'CREATE') and $version <= 4.1)
                {
                    $table = str_replace('DEFAULT CHARSET=utf8', '', $table);
                }
                elseif(str_contains($table, 'DROP') and $this->post->clearDB)
                {
                    $table = str_replace('--', '', $table);
                }

                $tableToLower = strtolower($table);
                if(str_contains($tableToLower, 'fulltext') and str_contains($tableToLower, 'innodb') and $version < 5.6)
                {
                    $this->lang->install->errorCreateTable = $this->lang->install->errorEngineInnodb;
                    return false;
                }

                $table = str_replace('__DELIMITER__', ';', $table);
                $table = str_replace('__TABLE__', $this->config->db->name, $table);

                /* Skip sql that is note. */
                if(str_starts_with($table, '--')) continue;

                $table = str_replace('`zt_', $this->config->db->name . '.`zt_', $table);
                $table = str_replace('`ztv_', $this->config->db->name . '.`ztv_', $table);
                $table = str_replace('zt_', $this->config->db->prefix, $table);
                if(!$this->dbh->query($table)) return false;
            }
            $this->executeFeedbackUpdate($version);
        }
        catch (PDOException $exception)
        {
            echo $exception->getMessage();
            helper::end();
        }
        return true;
    }
    /**
     * add by guoshuai418
     * 反馈功能点需要修改的表结构
     */
    public function executeFeedbackUpdate($version){
        $feedbackSqlFile = $this->app->getAppRoot() . 'db' . DS . 'feedback_update.sql';
        $tables = explode(';', file_get_contents($feedbackSqlFile));
        foreach($tables as $table)
        {
            $table = trim($table);
            if(empty($table))
             continue;
            $tableToLower = strtolower($table);
            if(strpos($table, '--') === 0) 
            continue;
            if(strpos($tableToLower, 'fulltext') !== false and strpos($tableToLower, 'innodb') !== false and $version < 5.6)
            {
                $this->lang->install->errorCreateTable = $this->lang->install->errorEngineInnodb;
                return false;
            }
            $table = str_replace('`zt_', $this->config->db->name . '.`zt_', $table);
            $table = str_replace('`ztv_', $this->config->db->name . '.`ztv_', $table);
            $table = str_replace('zt_', $this->config->db->prefix, $table);
            if(!$this->dbh->query($table)) return false;            
        }
        return true;
    }
    /**
     * Create a company, set admin.
     *
     * @access public
     * @return bool
     */
    public function grantPriv(): bool
    {
        $data = fixer::input('post')
            ->stripTags('company')
            ->get();

        $requiredFields = explode(',', $this->config->install->step5RequiredFields);
        foreach($requiredFields as $field)
        {
            if(empty($data->{$field}))
            {
                dao::$errors[] = $this->lang->install->errorEmpty[$field];
                return false;
            }
        }

        $this->user = $this->loadModel('user');
        $this->app->loadConfig('admin');
        /* Check password. */
        if(!validater::checkReg($this->post->password, '|(.){6,}|')) dao::$errors['password'][] = $this->lang->error->passwordrule;
        if($this->user->computePasswordStrength($this->post->password) < 1) dao::$errors['password'][] = $this->lang->user->placeholder->passwordStrengthCheck[1];
        if(!isset($this->config->safe->weak)) $this->app->loadConfig('admin');
        if(str_contains(",{$this->config->safe->weak},", ",{$this->post->password},")) dao::$errors['password'] = sprintf($this->lang->user->errorWeak, $this->config->safe->weak);
        if(dao::isError()) return false;

        /* Insert a company. */
        $company = new stdclass();
        $company->name   = $data->company;
        $company->admins = ",{$this->post->account},";
        $this->dao->insert(TABLE_COMPANY)->data($company)->autoCheck()->exec();
        if(!dao::isError())
        {
            /* Set admin. */
            $admin = new stdclass();
            $admin->account  = $this->post->account;
            $admin->realname = $this->post->account;
            $admin->password = md5($this->post->password);
            $admin->gender   = 'f';
            $admin->visions  = 'rnd,lite';
            $this->dao->replace(TABLE_USER)->data($admin)->exec();
        }
        return true;
    }

    /**
     * Update language for group and cron.
     *
     * @access public
     * @return void
     */
    public function updateLang(): void
    {
        /* Update group name and desc on dafault lang. */
        $groups = $this->dao->select('*')->from(TABLE_GROUP)->orderBy('id')->fetchAll();
        foreach($groups as $group)
        {
            $data = zget($this->lang->install->groupList, $group->name, '');
            if($data) $this->dao->update(TABLE_GROUP)->data($data)->where('id')->eq($group->id)->exec();
        }

        /* Update cron remark by lang. */
        foreach($this->lang->install->cronList as $command => $remark)
        {
            $this->dao->update(TABLE_CRON)->set('remark')->eq($remark)->where('command')->eq($command)->exec();
        }

        foreach($this->lang->install->langList as $langInfo)
        {
            $this->dao->update(TABLE_LANG)->set('value')->eq($langInfo['value'])->where('module')->eq($langInfo['module'])->andWhere('`key`')->eq($langInfo['key'])->exec();
        }

        /* Update lang,stage by lang. */
        $this->app->loadLang('stage');
        foreach($this->lang->stage->typeList as $key => $value)
        {
            $this->dao->update(TABLE_LANG)->set('value')->eq($value)->where('`key`')->eq($key)->exec();
            $this->dao->update(TABLE_STAGE)->set('name')->eq($value)->where('`type`')->eq($key)->exec();
        }
    }
}
