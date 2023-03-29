<?php
/**
 * ZenTaoPHP的dao和sql类。
 * The dao and sql class file of ZenTaoPHP framework.
 *
 * The author disclaims copyright to this source code.  In place of
 * a legal notice, here is a blessing:
 *
 *  May you do good and not evil.
 *  May you find forgiveness for yourself and forgive others.
 *  May you share freely, never taking more than you give.
 */

/**
 * DAO类。
 * DAO, data access object.
 *
 * @package framework
 */
class baseDAO
{
    /* Use these strong strings to avoid conflicting with these keywords in the sql body. */
    const WHERE = 'wHeRe';
    const GROUPBY = 'gRoUp bY';
    const HAVING = 'hAvInG';
    const ORDERBY = 'oRdEr bY';
    const LIMIT = 'lImiT';

    /**
     * 全局对象$app
     * The global app object.
     *
     * @var object
     * @access public
     */
    public $app;

    /**
     * 全局对象$config
     * The global config object.
     *
     * @var object
     * @access public
     */
    public $config;

    /**
     * 全局对象$lang
     * The global lang object.
     *
     * @var object
     * @access public
     */
    public object $lang;

    /**
     * 全局对象$dbh
     * The global dbh(database handler) object.
     *
     * @var object
     * @access public
     */
    public object|null $dbh;

    /**
     * 全局对象$slaveDBH。
     * The global slaveDBH(database handler) object.
     *
     * @var bool|object
     * @access public
     */
    public bool|object $slaveDBH;

    /**
     * sql对象，用于生成sql语句。
     * The sql object, used to create the query sql.
     *
     * @var object
     * @access public
     */
    public object $sqlobj;

    /**
     * 正在使用的表。
     * The table of current query.
     *
     * @var string
     * @access public
     */
    public string $table;

    /**
     * $this->table的别名。
     * The alias of $this->table.
     *
     * @var string
     * @access public
     */
    public string $alias;

    /**
     * 查询的字段。
     * The fields will be returned.
     *
     * @var string
     * @access public
     */
    public string $fields;

    /**
     * 查询模式，raw模式用于正常的select update等sql拼接操作，magic模式用于findByXXX等魔术方法。
     * The query mode, raw or magic.
     *
     * This var is used to diff dao::from() with sql::from().
     *
     * @var string
     * @access public
     */
    public string $mode;

    /**
     * 执行方式：insert, select, update, delete, replace。
     * The query method: insert, select, update, delete, replace.
     *
     * @var string
     * @access public
     */
    public string $method;

    /**
     * 是否自动增加lang条件。
     * If auto add lang statement.
     *
     * @var bool
     * @access public
     */
    public bool $autoLang;

    /**
     * 执行的请求，所有的查询都保存在该数组。
     * The queries executed. Every query will be saved in this array.
     *
     * @var array
     * @access public
     */
    static public array $querys = array();

    /**
     * 存放错误的数组。
     * The errors.
     *
     * @var array
     * @access public
     */
    static public array $errors = array();

    /**
     * 缓存。
     * The cache.
     *
     * @var array
     * @access public
     */
    static public array $cache = array();

    /**
     * 构造方法。
     * The construct method.
     *
     * @access public
     * @return void
     */
    public function __construct()
    {
        global $app, $config, $lang, $dbh, $slaveDBH;
        $this->app = $app;
        $this->config = $config;
        $this->lang = $lang;
        $this->dbh = $dbh;
        $this->slaveDBH = $slaveDBH ?: false;

        $this->reset();
    }

    /**
     * 设置$table属性。
     * Set the $table property.
     *
     * @param string $table
     * @access public
     * @return void
     */
    public function setTable(string $table): void
    {
        $this->table = $table;
    }

    /**
     * 设置$alias属性。
     * Set the $alias property.
     *
     * @param string $alias
     * @access public
     * @return void
     */
    public function setAlias(string $alias): void
    {
        $this->alias = $alias;
    }

    /**
     * 设置$fields属性。
     * Set the $fields property.
     *
     * @param string $fields
     * @access public
     * @return void
     */
    public function setFields(string $fields): void
    {
        $this->fields = $fields;
    }

    /**
     * 设置autoLang项。
     * Set autoLang item.
     *
     * @param bool $autoLang
     * @return baseDAO
     * @access public
     */
    public function setAutoLang(bool $autoLang): baseDAO
    {
        $this->autoLang = $autoLang;
        return $this;
    }

    /**
     * 重置属性。
     * Reset the vars.
     *
     * @access public
     * @return void
     */
    public function reset(): void
    {
        $this->setFields('');
        $this->setTable('');
        $this->setAlias('');
        $this->setMode();
        $this->setMethod();
        $this->setAutoLang(isset($this->config->framework->autoLang) and $this->config->framework->autoLang);
    }

    //-----根据请求的方式，调用sql类相应的方法(Call according method of sql class by query method. -----//

    /**
     * 设置请求模式。像findByXXX之类的方法，使用的是magic模式；其他方法使用的是raw模式。
     * Set the query mode. If the method like findByXXX, the mode is magic. Else, the mode is raw.
     *
     * @param string $mode magic|raw
     * @access public
     * @return void
     */
    public function setMode(string $mode = ''): void
    {
        $this->mode = $mode;
    }

    /**
     * 设置请求方法：select|update|insert|delete|replace 。
     * Set the query method: select|update|insert|delete|replace
     *
     * @param string $method
     * @access public
     * @return void
     */
    public function setMethod(string $method = ''): void
    {
        $this->method = $method;
    }

    /**
     * 开始事务。
     * Begin Transaction
     *
     * @access public
     * @return void
     */
    public function begin(): void
    {
        $this->dbh->beginTransaction();
    }

    /**
     * 事务回滚。
     * Roll back
     *
     * @access public
     * @return void
     */
    public function rollBack(): void
    {
        $this->dbh->rollBack();
    }

    /**
     * 提交事务。
     * Commits a transaction.
     *
     * @access public
     * @return void
     */
    public function commit(): void
    {
        $this->dbh->commit();
    }

    /**
     * select方法，调用sql::select()。
     * The select method, call sql::select().
     *
     * @param string $fields
     * @return baseDAO|sql the dao object self.
     * @access public
     */
    public function select(string $fields = '*'): sql|static
    {
        $this->setMode('raw');
        $this->setMethod('select');
        $this->sqlobj = sql::select($fields);
        return $this;
    }

    /**
     * 获取查询记录条数。
     * The count method, call sql::select() and from().
     * use as $this->dao->select()->from(TABLE_BUG)->where()->count();
     *
     * @param string $distinctField
     * @access public
     * @return int
     */
    public function count(string $distinctField = ''): int
    {
        /* 获得SELECT，FROM的位置，使用count(*)替换其字段。 */
        /* Get the SELECT, FROM position, thus get the fields, replace it by count(*). */
        $sql = $this->get();
        $selectPOS = strpos($sql, 'SELECT') + strlen('SELECT');
        $fromPOS = strpos($sql, 'FROM');
        $fields = substr($sql, $selectPOS, $fromPOS - $selectPOS);
        $countField = $distinctField ? 'distinct ' . $distinctField : '*';
        $sql = str_replace($fields, " COUNT($countField) AS recTotal ", substr($sql, 0, $fromPOS)) . substr($sql, $fromPOS);

        /*
         * 去掉SQL语句中order和limit之后的部分。
         * Remove the part after order and limit.
         **/
        $subLength = strlen($sql);
        $groupPOS = strripos($sql, 'group by');
        $orderPOS = strripos($sql, 'order by');
        $limitPOS = strripos($sql, 'limit');
        if ($limitPOS) $subLength = $limitPOS;
        if ($orderPOS) $subLength = $orderPOS;
        if ($groupPOS) $subLength = $groupPOS;
        $sql = substr($sql, 0, $subLength);
        self::$querys[] = $sql;

        /*
         * 获取记录数。
         * Get the records count.
         **/
        try {
            $row = $this->dbh->query($sql)->fetch(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            $this->sqlError($e);
        }

        return is_object($row) ? $row->recTotal : 0;
    }

    /**
     * update方法，调用sql::update()。
     * The update method, call sql::update().
     *
     * @param string $table
     * @return baseDAO|baseSQL the dao object self.
     * @access public
     */
    public function update(string $table): baseDAO|baseSQL
    {
        $this->setMode('raw');
        $this->setMethod('update');
        $this->sqlobj = sql::update($table);
        $this->setTable($table);
        return $this;
    }

    /**
     * delete方法，调用sql::delete()。
     * The delete method, call sql::delete().
     *
     * @access public
     * @return baseDAO the dao object self.
     */
    public function delete(): baseDAO
    {
        $this->setMode('raw');
        $this->setMethod('delete');
        $this->sqlobj = sql::delete();
        return $this;
    }

    /**
     * insert方法，调用sql::insert()。
     * The insert method, call sql::insert().
     *
     * @param string $table
     * @return baseDAO the dao object self.
     * @access public
     */
    public function insert(string $table): baseDAO
    {
        $this->setMode('raw');
        $this->setMethod('insert');
        $this->sqlobj = sql::insert($table);
        $this->setTable($table);
        return $this;
    }

    /**
     * replace方法，调用sql::replace()。
     * The replace method, call sql::replace().
     *
     * @param string $table
     * @return baseDAO the dao object self.
     * @access public
     */
    public function replace(string $table): baseDAO
    {
        $this->setMode('raw');
        $this->setMethod('replace');
        $this->sqlobj = sql::replace($table);
        $this->setTable($table);
        return $this;
    }

    /**
     * 设置要操作的表。
     * Set the 'from' table.
     *
     * @param string $table
     * @return sql|baseDAO the dao object self.
     * @access public
     */
    public function from(string $table): sql|static
    {
        $this->setTable($table);
        if ($this->mode == 'raw') $this->sqlobj->from($table);
        return $this;
    }

    /**
     * 设置字段。
     * Set the fields.
     *
     * @param string $fields
     * @return baseDAO the dao object self.
     * @access public
     */
    public function fields(string $fields): baseDAO
    {
        $this->setFields($fields);
        return $this;
    }

    /**
     * 表别名，相当于sql里的AS。（as是php的关键词，使用alias代替）
     * Alias a table, equal the AS keyword. (Don't use AS, because it's a php keyword.)
     *
     * @param string $alias
     * @return baseDAO|baseSQL the dao object self.
     * @access public
     */
    public function alias(string $alias): baseDAO|baseSQL
    {
        if (empty($this->alias)) $this->setAlias($alias);
        $this->sqlobj->alias($alias);
        return $this;
    }

    /**
     * 设置需要更新或插入的数据。
     * Set the data to update or insert.
     *
     * @param object|array $data the data object or array
     * @param string $skipFields
     * @return baseDAO the dao object self.
     * @access public
     */
    public function data(object|array $data, string $skipFields = ''): baseDAO
    {
        if ($this->autoLang and !isset($data->lang)) {
            $data->lang = $this->app->getClientLang();
            if (isset($this->app->config->cn2tw) and $this->app->config->cn2tw and $data->lang == 'zh-tw') $data->lang = 'zh-cn';
            if (defined('RUN_MODE') and RUN_MODE == 'front' and !empty($this->app->config->cn2tw)) $data->lang = str_replace('zh-tw', 'zh-cn', $data->lang);
        }

        $this->sqlobj->data($data, $skipFields);
        return $this;
    }

    //-------------------- sql相关的方法(The sql related method) --------------------//

    /**
     * 获取sql字符串。
     * Get the sql string.
     *
     * @access public
     * @return string the sql string after process.
     */
    public function get(): string
    {
        return $this->processKeywords($this->processSQL(false));
    }

    /**
     * 打印sql字符串。
     * Print the sql string.
     *
     * @access public
     * @return void
     */
    public function printSQL(): void
    {
        echo $this->processSQL();
    }

    /**
     * 查看SQL索引。
     * Explain sql.
     *
     * @param string $sql
     * @access public
     * @return void
     */
    public function explain(string $sql = ''): void
    {
        $sql = empty($sql) ? $this->processSQL() : $sql;
        $result = $this->dbh->query('explain ' . $sql)->fetch();
        a($result);
    }

    /**
     * 处理sql语句，替换表和字段。
     * Process the sql, replace the table, fields.
     *
     * @param bool $record
     * @access public
     * @return string the sql string after process.
     */
    public function processSQL(bool $record = true): string
    {
        // 应该是一个string
        $sql = $this->sqlobj->get();

        /**
         * 如果是magic模式，处理表和字段。
         * If the mode is magic, process the $fields and $table.
         **/
        if ($this->mode == 'magic') {
            if ($this->fields == '') $this->fields = '*';
            if ($this->table == '') $this->app->triggerError('Must set the table name', __FILE__, __LINE__, true);
            $sql = sprintf($this->sqlobj->get(), $this->fields, $this->table);
        }

        /* If the method if select, update or delete, set the lang condition. */
        if ($this->autoLang and $this->table != '' and $this->method != 'insert' and $this->method != 'replace') {
            $lang = $this->app->getClientLang();

            /* Get the position to insert lang = ?. */
            $wherePOS = strrpos($sql, self::WHERE);             // The position of WHERE keyword.
            $groupPOS = strrpos($sql, self::GROUPBY);           // The position of GROUP BY keyword.
            $havingPOS = strrpos($sql, self::HAVING);            // The position of HAVING keyword.
            $orderPOS = strrpos($sql, self::ORDERBY);           // The position of ORDERBY keyword.
            $limitPOS = strrpos($sql, self::LIMIT);             // The position of LIMIT keyword.
            $splitPOS = $orderPOS ?: $limitPOS;     // If $orderPOS, use it instead of $limitPOS.
            $splitPOS = $havingPOS ?: $splitPOS;     // If $havingPOS, use it instead of $orderPOS.
            $splitPOS = $groupPOS ?: $splitPOS;     // If $groupPOS, use it instead of $havingPOS.

            /* Set the condition to be appended. */
            $tableName = !empty($this->alias) ? $this->alias : $this->table;

            if (!empty($this->app->config->cn2tw))
                $lang = str_replace('zh-tw', 'zh-cn', $lang);

            $langCondition = " $tableName.lang in('{$lang}', 'all') ";

            /* If $splitPOS > 0, split the sql at $splitPOS. */
            if ($splitPOS) {
                $firstPart = substr($sql, 0, $splitPOS);
                $lastPart = substr($sql, $splitPOS);
                if ($wherePOS) {
                    $sql = $firstPart . " AND $langCondition " . $lastPart;
                } else {
                    $sql = $firstPart . " WHERE $langCondition " . $lastPart;
                }
            } else {
                $sql .= $wherePOS ? " AND $langCondition" : " WHERE $langCondition";
            }
        }

        if ($record) self::$querys[] = $this->processKeywords($sql);
//        对MySQL执行情况进行debug，解注释这条语句即可
//        ChromePhp::log("[MySQL]: " . $sql);
        return $sql;
    }

    /**
     * 替换sql常量关键字。
     * Process the sql keywords, replace the constants to normal.
     *
     * @param string $sql
     * @access public
     * @return string the sql string.
     */
    public function processKeywords(string $sql): string
    {
        return str_replace(array(self::WHERE, self::GROUPBY, self::HAVING, self::ORDERBY, self::LIMIT), array('WHERE', 'GROUP BY', 'HAVING', 'ORDER BY', 'LIMIT'), $sql);
    }

    //-------------------- 查询相关方法(Query related methods) --------------------//

    /**
     * 设置$dbh，数据库连接句柄。
     * Set the dbh.
     *
     * You can use like this: $this->dao->dbh($dbh), thus you can handle two database.
     *
     * @param object $dbh
     * @return baseDAO the dao object self.
     * @access public
     */
    public function dbh(object $dbh): baseDAO
    {
        $this->dbh = $dbh;
        return $this;
    }

    /**
     * 执行SQL语句，返回PDOStatement结果集。
     * Query the sql, return the statement object.
     *
     * @access public
     * @param string $sql
     * @return PDOStatement|null the PDOStatement object.
     */
    public function query(string $sql = ''): PDOStatement|null
    {
        /* 如果有错误，返回一个空的PDOStatement对象，确保后续方法能够执行。*/
        /* If any error, return an empty statement object to make sure the remain method to execute. */
        if (!empty(dao::$errors))
            return new PDOStatement();

        if ($sql) {
            $sql = trim($sql);
            $sqlMethod = strtolower(substr($sql, 0, strpos($sql, ' ')));
            $this->setMethod($sqlMethod);
            $this->sqlobj = new sql();
            $this->sqlobj->sql = $sql;
        } else {
            $sql = $this->processSQL();
        }

        try {
            $method = $this->method;
            $this->reset();

            if ($this->slaveDBH and $method == 'select') {
                return $this->slaveDBH->query($sql);
            } else {
                return $this->dbh->query($sql);
            }
        } catch (PDOException $e) {
            $this->sqlError($e);
        }
        return null;
    }

    /**
     * 将记录进行分页，自动设置limit语句。
     * Page the records, set the limit part auto.
     *
     * @param object|string|null $pager
     * @param string $distinctField
     * @return baseDAO the dao object self.
     * @access public
     */
    public function page(object|string|null $pager, string $distinctField = ''): baseDAO
    {
        if (!is_object($pager))
            return $this;

        /*
         * 重新计算分页数据，并判断是否需要返回上一页。
         * Calculate pagination to determine whether to return to the previous page.
         */
        $originalPageID = $pager->pageID;
        $recTotal = $this->count($distinctField);

        $pager->setRecTotal($recTotal);
        $pager->setPageTotal();
        if ($originalPageID > $pager->pageTotal) $pager->setPageID($pager->pageTotal);

        $this->sqlobj->limit($pager->limit());
        return $this;
    }

    /**
     * 执行SQL。query()会返回stmt对象，该方法只返回更改或删除的记录数。
     * Execute the sql. It's different with query(), which return the stmt object. But this not.
     *
     * @param string $sql
     * @access public
     * @return int|PDOStatement|null the modified or deleted records. 更改或删除的记录数。
     */
    public function exec(string $sql = ''): int|PDOStatement|null
    {
        if (!empty(dao::$errors))
            return new PDOStatement();   // If any error, return an empty statement object to make sure the remain method to execute.

        if ($sql) {
            $this->sqlobj = new sql();
            $this->sqlobj->sql = $sql;
        } else {
            $sql = $this->processSQL();
        }

        try {
            if ($this->table) unset(dao::$cache[$this->table]);
            $this->reset();
            return $this->dbh->exec($sql);
        } catch (PDOException $e) {
            $this->sqlError($e);
        }
        return null;
    }

    //-------------------- Fetch相关方法(Fetch related methods) -------------------//

    /**
     * 获取一个记录。
     * Fetch one record.
     *
     * @param string $field 如果已经设置获取的字段，则只返回这个字段的值，否则返回这个记录。
     *                              if the field is set, only return the value of this field, else return this record
     * @access public
     * @return object|mixed
     */
    public function fetch(string $field = ''): mixed
    {
        $sql = $this->processSQL();
        $table = $this->table;
        $key = 'fetch-' . md5($sql . $field);
        if (isset(dao::$cache[$table][$key])) {
            if (empty($field)) return $this->getRow(dao::$cache[$table][$key]);

            $result = dao::$cache[$table][$key];
            return $result ? $result->$field : '';
        }

        if (empty($field)) {
            $data = $this->query($sql)->fetch();
            dao::$cache[$table][$key] = $data;
            return $this->getRow($data);
        }

        $this->setFields($field);
        $result = $this->query($sql)->fetch(PDO::FETCH_OBJ);
        dao::$cache[$table][$key] = $this->getRow($result);
        return $result ? $result->$field : '';
    }

    /**
     * 获取所有记录。
     * Fetch all records.
     *
     * @param string $keyField 返回以该字段做键的记录
     *                              the key field, thus the return records is keyed by this field
     * @access public
     * @return array the records
     */
    public function fetchAll(string $keyField = ''): array
    {
        $sql = $this->processSQL();
        $table = $this->table;
        $key = 'fetchAll-' . md5($sql . $keyField);
        if (isset(dao::$cache[$table][$key])) {
            $rows = dao::$cache[$table][$key];
            $result = array();
            foreach ($rows as $i => $row) $result[$i] = $this->getRow($row);
            return $result;
        }

        $stmt = $this->query($sql);
        dao::$cache[$table][$key] = array();
        if (empty($keyField)) {
            $rows = $stmt->fetchAll();
            $result = array();
            dao::$cache[$table][$key] = $rows;
            foreach ($rows as $i => $row) $result[$i] = $this->getRow($row);
            return $result;
        }

        $rows = array();
        while ($row = $stmt->fetch()) {
            dao::$cache[$table][$key][$row->$keyField] = $row;
            $rows[$row->$keyField] = $this->getRow($row);
        }

        return $rows;
    }

    /**
     * 获取所有记录并将按照字段分组。
     * Fetch all records and group them by one field.
     *
     * @param string $groupField 分组的字段   the field to group by
     * @param string $keyField 键字段       the field of key
     * @access public
     * @return array the records.
     */
    public function fetchGroup($groupField, $keyField = '')
    {
        $sql = $this->processSQL();
        $table = $this->table;
        $key = 'fetchGroup-' . md5($sql . $groupField . $keyField);
        if (isset(dao::$cache[$table][$key])) {
            $result = array();
            $groupRows = dao::$cache[$table][$key];
            foreach ($groupRows as $groupField => $rows) {
                foreach ($rows as $keyField => $row) $result[$groupField][$keyField] = $this->getRow($row);
            }
            return $result;
        }

        $stmt = $this->query($sql);
        $rows = array();
        while ($row = $stmt->fetch()) {
            empty($keyField) ? $rows[$row->$groupField][] = $row : $rows[$row->$groupField][$row->$keyField] = $this->getRow($row);
        }
        dao::$cache[$table][$key] = $rows;
        return $rows;
    }

    /**
     * 获取的记录是以关联数组的形式
     * Fetch array like key=>value.
     *
     * 如果没有设置参数，用首末两键作为参数。
     * If the keyFiled and valueField not set, use the first and last in the record.
     *
     * @param string $keyField
     * @param string $valueField
     * @access public
     * @return array
     */
    public function fetchPairs($keyField = '', $valueField = '')
    {
        $keyField = trim($keyField, '`');
        $valueField = trim($valueField, '`');

        $sql = $this->processSQL();
        $table = $this->table;
        $key = 'fetchPairs-' . md5($sql . $keyField . $valueField);
        if (isset(dao::$cache[$table][$key])) return dao::$cache[$table][$key];

        $pairs = array();
        $ready = false;
        $stmt = $this->query($sql);
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if (!$ready) {
                if (empty($keyField)) $keyField = key($row);
                if (empty($valueField)) {
                    end($row);
                    $valueField = key($row);
                }
                $ready = true;
            }

            $pairs[$row[$keyField]] = $row[$valueField];
        }

        dao::$cache[$table][$key] = $pairs;
        return $pairs;
    }

    /**
     * 返回最后插入的ID。
     * Return the last insert ID.
     *
     * @access public
     * @return int
     */
    public function lastInsertID(): int
    {
        return $this->dbh->lastInsertID();
    }

    /**
     * 重新生成数据。
     * Get row by data.
     *
     * @param mixed $data
     * @access public
     * @return mixed
     */
    public function getRow(mixed $data): mixed
    {
        if (!is_object($data)) return $data;
        return clone $data;
    }

    //-------------------- 魔术方法(Magic methods) --------------------//

    /**
     * 解析dao的方法名，处理魔术方法。
     * Use it to do some convenient queries.
     *
     * @param string $funcName the function name to be called
     * @param array $funcArgs the params
     * @access public
     * @return array|static the dao object self.
     */
    public function __call(string $funcName, array $funcArgs): array|static
    {
        $funcName = strtolower($funcName);

        /*
         * 如果是findByxxx，转换为where条件语句。
         * findByxxx, xxx as will be in the where.
         **/
        if (str_contains($funcName, 'findby')) {
            $this->setMode('magic');
            $this->setFields('');
            $field = str_replace('findby', '', $funcName);
            if (count($funcArgs) == 1) {
                $operator = '=';
                $value = $funcArgs[0];
            } else {
                $operator = $funcArgs[0];
                $value = $funcArgs[1];
            }
            $this->sqlobj = sql::select('%s')->from('%s')->where($field, $operator, $value);
            return $this;
        } /*
         * 获取指定个数的记录：fetch10 获取10条记录。
         * Fetch10.
         **/
        elseif (str_contains($funcName, 'fetch')) {
            $max = str_replace('fetch', '', $funcName);
            $stmt = $this->query();

            $rows = array();
            $key = $funcArgs[0] ?? '';
            $i = 0;
            while ($row = $stmt->fetch()) {
                $key ? $rows[$row->$key] = $row : $rows[] = $row;
                $i++;
                if ($i == $max) break;
            }
            return $rows;
        } /*
         * 其他的方法，转到sqlobj对象执行。
         * Others, call the method in sql class.
         **/
        else {
            /*
             * 使用$arg0, $arg1... 生成调用的参数。
             * Create the max counts of sql class methods, and then create $arg0, $arg1...
             **/
            for ($i = 0; $i < baseSQL::MAX_ARGS; $i++) {
                ${"arg$i"} = $funcArgs[$i] ?? null;
            }
            $this->sqlobj->$funcName($arg0, $arg1, $arg2);
            return $this;
        }
    }

    //-------------------- 条件检查( Data Checking)--------------------//

    /**
     * 检查字段是否满足条件。
     * Check a filed is satisfied with the check rule.
     *
     * @param string $fieldName the field to check
     * @param string $funcName the check rule
     * @param string|null $condition the condition
     * @return static the dao object self.
     * @access public
     */
    public function check(string $fieldName, string $funcName, string|null $condition = ''): static
    {
        /*
         * 如果没数据中没有该字段，直接返回。
         * If no this field in the data, return.
         **/
        if (!isset($this->sqlobj->data->$fieldName)) return $this;

        /* 设置字段值。 */
        /* Set the field label and value. */
        global $lang, $config, $app;
        if (isset($config->db->prefix)) {
            $table = strtolower(str_replace(array($config->db->prefix, '`'), '', $this->table));
        } elseif (str_contains($this->table, '_')) {
            $table = strtolower(substr($this->table, strpos($this->table, '_') + 1));
            $table = str_replace('`', '', $table);
        } else {
            $table = strtolower($this->table);
        }
        $fieldLabel = $lang->$table->$fieldName ?? $fieldName;
        $value = $this->sqlobj->data->$fieldName ?? null;

        /*
         * 检查唯一性。
         * Check unique.
         **/
        if ($funcName == 'unique') {
            $args = func_get_args();
            $sql = "SELECT COUNT(*) AS count FROM $this->table WHERE `$fieldName` = " . $this->sqlobj->quote($value);
            if ($condition) $sql .= ' AND ' . $condition;
            try {
                $row = $this->dbh->query($sql)->fetch();
                if ($row->count != 0) $this->logError($funcName, $fieldName, $fieldLabel, array($value));
            } catch (PDOException $e) {
                $this->sqlError($e);
            }
        } else {
            /*
             * 创建参数。
             * Create the params.
             **/
            $funcArgs = func_get_args();
            unset($funcArgs[0]);
            unset($funcArgs[1]);

            for ($i = 0; $i < baseValidater::MAX_ARGS; $i++) {
                ${"arg$i"} = $funcArgs[$i + 2] ?? null;
            }

            $checkFunc = 'check' . $funcName;
            if (validater::$checkFunc($value, $arg0, $arg1, $arg2) === false) {
                $this->logError($funcName, $fieldName, $fieldLabel, $funcArgs);
            }
        }

        return $this;
    }

    /**
     * 检查一个字段是否满足条件。
     * Check a field, if satisfied with the condition.
     *
     * @param string $condition
     * @param string $fieldName
     * @param string $funcName
     * @access public
     * @return static|sql the dao object self.
     */
    public function checkIF(string $condition, string $fieldName, string $funcName): sql|static
    {
        if (!$condition) return $this;
        $funcArgs = func_get_args();
        for ($i = 0; $i < baseValidater::MAX_ARGS; $i++) {
            ${"arg$i"} = $funcArgs[$i + 3] ?? null;
        }
        $this->check($fieldName, $funcName, $arg0, $arg1, $arg2);
        return $this;
    }

    /**
     * 批量检查字段。
     * Batch check some filed.
     *
     * @param string $fields the fields to check, join with ,
     * @param string $funcName
     * @access public
     * @return static|sql the dao object self.
     */
    public function batchCheck($fields, $funcName)
    {
        $fields = explode(',', str_replace(' ', '', $fields));
        $funcArgs = func_get_args();
        for ($i = 0; $i < VALIDATER::MAX_ARGS; $i++) {
            ${"arg$i"} = $funcArgs[$i + 2] ?? null;
        }
        foreach ($fields as $fieldName) $this->check($fieldName, $funcName, $arg0, $arg1, $arg2);
        return $this;
    }

    /**
     * 批量检查字段是否满足条件。
     * Batch check fields on the condition is true.
     *
     * @param string $condition
     * @param string $fields
     * @param string $funcName
     * @access public
     * @return static|sql the dao object self.
     */
    public function batchCheckIF(string $condition, string $fields, string $funcName): sql|static
    {
        if (!$condition) return $this;
        $fields = explode(',', str_replace(' ', '', $fields));
        $funcArgs = func_get_args();
        for ($i = 0; $i < baseValidater::MAX_ARGS; $i++) {
            ${"arg$i"} = $funcArgs[$i + 3] ?? null;
        }
        foreach ($fields as $fieldName) $this->check($fieldName, $funcName, $arg0, $arg1, $arg2);
        return $this;
    }

    /**
     * 根据数据库结构检查字段。
     * Check the fields according the database schema.
     *
     * @param string $skipFields fields to skip checking
     * @access public
     * @return static|sql the dao object self.
     */
    public function autoCheck($skipFields = '')
    {
        $fields = $this->getFieldsType();
        $skipFields = ",$skipFields,";

        foreach ($fields as $fieldName => $validater) {
            if (str_contains($skipFields, $fieldName)) continue; // skip it.
            if (!isset($this->sqlobj->data->$fieldName)) continue;
            if ($validater['rule'] == 'skip') continue;
            $options = array();
            if (isset($validater['options'])) $options = array_values($validater['options']);
            for ($i = 0; $i < VALIDATER::MAX_ARGS; $i++) {
                ${"arg$i"} = $options[$i] ?? null;
            }
            $this->check($fieldName, $validater['rule'], $arg0, $arg1, $arg2);
        }
        return $this;
    }

    /**
     * 记录错误到日志。
     * Log the error.
     *
     * module/common/lang中定义了错误提示信息。
     * For the error notice, see module/common/lang.
     *
     * @param string $checkType the check rule
     * @param string $fieldName the field name
     * @param string $fieldLabel the field label
     * @param array $funcArgs the args
     * @access public
     * @return void
     */
    public function logError($checkType, $fieldName, $fieldLabel, $funcArgs = array())
    {
        global $lang;
        $error = $lang->error->$checkType;
        $replaces = array_merge(array($fieldLabel), $funcArgs);     // the replace values.

        /*
         * 如果$error错误信息是一个字符串，进行替换。
         * Just a string, cycle the $replaces.
         **/
        if (!is_array($error)) {
            foreach ($replaces as $replace) {
                $pos = strpos($error, '%s');
                if ($pos === false) break;
                $error = substr($error, 0, $pos) . $replace . substr($error, $pos + 2);
            }
        } /*
         * 如果error错误信息是一个数组，选择一个%s满足替换个数的进行替换。
         * If the error define is an array, select the one which %s counts match the $replaces.
         **/
        else {
            /*
             * 去掉空值项。
             * Remove the empty items.
             **/
            foreach ($replaces as $key => $value) if (is_null($value)) unset($replaces[$key]);
            $replacesCount = count($replaces);
            foreach ($error as $errorString) {
                if (substr_count($errorString, '%s') == $replacesCount) {
                    $error = vsprintf($errorString, $replaces);
                }
            }
        }
        dao::$errors[$fieldName][] = $error;
    }

    /**
     * 判断是否有错误。
     * Judge any error or not.
     *
     * @access public
     * @return bool
     */
    public static function isError(): bool
    {
        return !empty(dao::$errors);
    }

    /**
     * 获取错误。
     * Get the errors.
     *
     * @access public
     * @return array
     */
    public static function getError($join = false)
    {
        $errors = dao::$errors;
        dao::$errors = array();     // 清除dao的错误信息(Must clear errors)

        if (!$join) return $errors;

        if (is_array($errors)) {
            $message = '';
            foreach ($errors as $item) {
                is_array($item) ? $message .= join('\n', $item) . '\n' : $message .= $item . '\n';
            }
            return $message;
        }
    }

    /**
     * 获取表的字段类型。
     * Get the definition of fields of the table.
     *
     * @access public
     * @return array
     */
    public function getFieldsType()
    {
        try {
            $this->dbh->setAttribute(PDO::ATTR_CASE, PDO::CASE_LOWER);
            $sql = "DESC $this->table";
            $rawFields = $this->dbh->query($sql)->fetchAll();
            $this->dbh->setAttribute(PDO::ATTR_CASE, PDO::CASE_NATURAL);
        } catch (PDOException $e) {
            $this->sqlError($e);
        }

        foreach ($rawFields as $rawField) {
            $firstPOS = strpos($rawField->type, '(');
            $type = substr($rawField->type, 0, $firstPOS > 0 ? $firstPOS : strlen($rawField->type));
            $type = str_replace(array('big', 'small', 'medium', 'tiny', 'var'), '', $type);
            $field = array();

            if ($type == 'enum' or $type == 'set') {
                $rangeBegin = $firstPOS + 2;                       // 移除开始的引用符  Remove the first quote.
                $rangeEnd = strrpos($rawField->type, ')') - 1;   // 移除结束的引用符  Remove the last quote.
                $range = substr($rawField->type, $rangeBegin, $rangeEnd - $rangeBegin);
                $field['rule'] = 'reg';
                $field['options']['reg'] = '/' . str_replace("','", '|', $range) . '/';
            } elseif ($type == 'char') {
                $begin = $firstPOS + 1;
                $end = strpos($rawField->type, ')', $begin);
                $length = substr($rawField->type, $begin, $end - $begin);
                $field['rule'] = 'length';
                $field['options']['max'] = $length;
                $field['options']['min'] = 0;
            } elseif ($type == 'int') {
                $field['rule'] = 'int';
            } elseif ($type == 'float' or $type == 'double') {
                $field['rule'] = 'float';
            } elseif ($type == 'date') {
                $field['rule'] = 'date';
            } elseif ($type == 'datetime') {
                $field['rule'] = 'datetime';
            } else {
                $field['rule'] = 'skip';
            }
            $fields[$rawField->field] = $field;
        }
        return $fields;
    }

    /**
     * Process SQL error by code.
     *
     * @param object $exception
     * @access public
     * @return void
     */
    public function sqlError($exception)
    {
        $message = $exception->getMessage();
        $message .= ' ' . helper::checkDB2Repair($exception);

        $sql = $this->sqlobj->get();
        $this->app->triggerError($message . "<p>The sql is: $sql</p>", __FILE__, __LINE__, $exit = true);
    }
}

/**
 * SQL类。
 * The SQL class.
 *
 * @package framework
 */
class baseSQL
{
    /**
     * 所有方法的最大参数个数。
     * The max count of params of all methods.
     *
     */
    const MAX_ARGS = 3;

    /**
     * SQL字符串。
     * The sql string.
     *
     * @var string
     * @access public
     */
    public string $sql = '';

    /**
     * 全局变量$dbh。
     * The global $dbh.
     *
     * @var object
     * @access public
     */
    public object $dbh;

    /**
     * 更新或插入日期。
     * The data to update or insert.
     *
     * @var mixed
     * @access public
     */
    public mixed $data;

    /**
     * 是否是第一次设置。
     * Is the first time to call set.
     *
     * @var bool
     * @access public;
     */
    public bool $isFirstSet = true;

    /**
     * 是否是在条件语句中。
     * If in the logic of judge condition or not.
     *
     * @var bool
     * @access public;
     */
    public bool $inCondition = false;

    /**
     * 条件是否为真。
     * The condition is true or not.
     *
     * @var bool
     * @access public;
     */
    public bool|array|null $conditionIsTrue = false;

    /**
     * WHERE条件嵌套小括号标记。
     * If in mark or not.
     *
     * @var bool
     * @access public;
     */
    public bool $inMark = false;


    /**
     * 是否开启特殊字符转义。
     * Magic quote or not.
     *
     * @var bool
     * @access public
     */
    public bool $magicQuote;

    /**
     * 构造方法。
     * The construct function.
     *
     * @access public
     * @return void
     */
    public function __construct(string $table = '')
    {
        global $dbh;
        $this->dbh = $dbh;
        $this->magicQuote = (version_compare(phpversion(), '5.4', '<') and function_exists('get_magic_quotes_gpc') and get_magic_quotes_gpc());
    }

    /**
     * 工厂方法。
     * The factory method.
     *
     * @param string $table
     * @return sql the sql object.
     * @access public
     */
    public static function factory(string $table = ''): sql
    {
        return new sql($table);
    }

    /**
     * select语句。
     * The sql is select.
     *
     * @param string $field
     * @return sql the sql object.
     * @access public
     */
    public static function select(string $field = '*'): sql
    {
        $sqlobj = self::factory();
        $sqlobj->sql = "SELECT $field ";
        return $sqlobj;
    }

    /**
     * update语句。
     * The sql is update.
     *
     * @param string $table
     * @return sql the sql object.
     * @access public
     */
    public static function update(string $table): sql
    {
        $sqlobj = self::factory();
        $sqlobj->sql = "UPDATE $table SET ";
        return $sqlobj;
    }

    /**
     * insert语句。
     * The sql is insert.
     *
     * @param string $table
     * @return sql the sql object.
     * @access public
     */
    public static function insert(string $table): sql
    {
        $sqlobj = self::factory();
        $sqlobj->sql = "INSERT INTO $table SET ";
        return $sqlobj;
    }

    /**
     * replace语句。
     * The sql is replace.
     *
     * @param string $table
     * @return sql the sql object.
     * @access public
     */
    public static function replace(string $table): sql
    {
        $sqlobj = self::factory();
        $sqlobj->sql = "REPLACE $table SET ";
        return $sqlobj;
    }

    /**
     * delete语句。
     * The sql is delete.
     *
     * @access public
     * @return sql the sql object.
     */
    public static function delete(): sql
    {
        $sqlobj = self::factory();
        $sqlobj->sql = "DELETE ";
        return $sqlobj;
    }

    /**
     * 将关联数组转换为sql语句中 `key` = value 的形式。
     * Join the data items by key = value.
     *
     * @param object|array $data
     * @param string $skipFields the fields to skip.
     * @return object the sql object.
     * @access public
     */
    public function data(object|array $data, string $skipFields = ''): object
    {
        if ($skipFields) $skipFields = ',' . str_replace(' ', '', $skipFields) . ',';

        foreach ($data as $field => $value) {
            if (!preg_match('|^\w+$|', $field)) {
                unset($data->$field);
                continue;
            }
            if (str_contains($skipFields, ",$field,")) continue;
            $this->sql .= "`$field` = " . $this->quote($value) . ',';
        }

        $this->data = $data;
        $this->sql = rtrim($this->sql, ',');    // Remove the last ','.
        return $this;
    }

    /**
     * 在左边添加'('。
     * Add an '(' at left.
     *
     * @param int $count
     * @access public
     * @return static|sql the sql object.
     */
    public function markLeft(int $count = 1): sql|static
    {
        if ($this->inCondition and !$this->conditionIsTrue) return $this;
        $this->sql .= str_repeat('(', $count);
        $this->inMark = true;
        return $this;
    }

    /**
     * 在右边增加')'。
     * Add an ')' at right.
     *
     * @param int $count
     * @access public
     * @return static|sql the sql object.
     */
    public function markRight(int $count = 1): sql|static
    {
        if ($this->inCondition and !$this->conditionIsTrue) return $this;
        $this->sql .= str_repeat(')', $count);
        $this->inMark = false;
        return $this;
    }

    /**
     * SET部分。
     * The set part.
     *
     * @param string $set
     * @access public
     * @return static|sql the sql object.
     */
    public function set(string $set): sql|static
    {
        if ($this->inCondition and !$this->conditionIsTrue) return $this;

        /* Add ` to avoid keywords of mysql. */
        if (!str_contains($set, '=')) {
            $set = str_replace(',', '', $set);
            $set = '`' . str_replace('`', '', $set) . '`';
        }

        $this->sql .= $this->isFirstSet ? " $set" : ", $set";
        if ($this->isFirstSet) $this->isFirstSet = false;
        return $this;
    }

    /**
     * 创建From部分。
     * Create the from part.
     *
     * @param string $table
     * @access public
     * @return static|sql the sql object.
     */
    public function from(string $table): sql|static
    {
        $this->sql .= "FROM $table";
        return $this;
    }

    /**
     * 创建Alias部分，Alias转为AS。
     * Create the Alias part.
     *
     * @param string $alias
     * @return baseSQL the sql object.
     * @access public
     */
    public function alias(string $alias): baseSQL
    {
        if ($this->inCondition and !$this->conditionIsTrue) return $this;
        $this->sql .= " AS $alias ";
        return $this;
    }

    /**
     * 创建LEFT JOIN部分。
     * Create the left join part.
     *
     * @param string $table
     * @return baseSQL the sql object.
     * @access public
     */
    public function leftJoin(string $table): baseSQL
    {
        if ($this->inCondition and !$this->conditionIsTrue) return $this;
        $this->sql .= " LEFT JOIN $table";
        return $this;
    }

    /**
     * 创建ON部分。
     * Create the on part.
     *
     * @param string $condition
     * @return baseSQL|sql the sql object.
     * @access public
     */
    public function on(string $condition): baseSQL|sql
    {
        if ($this->inCondition and !$this->conditionIsTrue) return $this;
        $this->sql .= " ON $condition ";
        return $this;
    }

    /**
     * 开始条件判断。
     * Begin condition judge.
     *
     * @param bool $condition
     * @return baseSQL the sql object.
     * @access public
     */
    public function beginIF(bool|array|null $condition): baseSQL
    {
        $this->inCondition = true;
        $this->conditionIsTrue = $condition;
        return $this;
    }

    /**
     * 结束条件判断。
     * End the condition judge.
     *
     * @access public
     * @return sql|baseSQL the sql object.
     */
    public function fi(): sql|static
    {
        $this->inCondition = false;
        $this->conditionIsTrue = false;
        return $this;
    }

    /**
     * 创建WHERE部分。
     * Create the where part.
     *
     * @param string|null $arg1 the field name
     * @param string|null $arg2 the operator
     * @param string|null $arg3 the value
     * @return static|sql the sql object.
     * @access public
     */
    public function where(string $arg1 = null,
                          string $arg2 = null,
                          string $arg3 = null): sql|static
    {
        if ($this->inCondition and !$this->conditionIsTrue) return $this;
        if ($arg3 !== null) {
            $value = $this->quote($arg3);
            $condition = "`$arg1` $arg2 " . $this->quote($arg3);
        } else {
            $condition = $arg1;
        }

        if (!$this->inMark) $this->sql .= ' ' . baseDAO::WHERE . " $condition ";
        if ($this->inMark) $this->sql .= " $condition ";
        return $this;
    }

    /**
     * 创建AND部分。
     * Create the AND part.
     *
     * @param string|null $condition
     * @param bool $addMark
     * @return static|sql the sql object.
     * @access public
     */
    public function andWhere(string $condition = null, bool|null $addMark = false): sql|static
    {
        if ($this->inCondition and !$this->conditionIsTrue) return $this;
        $mark = $addMark ? '(' : '';
        $this->sql .= " AND {$mark} $condition ";
        return $this;
    }

    /**
     * 创建OR部分。
     * Create the OR part.
     *
     * @param string|null $condition
     * @access public
     * @return static|sql the sql object.
     */
    public function orWhere(string $condition = null): sql|static
    {
        if ($this->inCondition and !$this->conditionIsTrue) return $this;
        $this->sql .= " OR $condition ";
        return $this;
    }

    /**
     * 创建'='部分。
     * Create the '='.
     *
     * @param string|null $value
     * @return static|sql the sql object.
     * @access public
     */
    public function eq(string $value = null): sql|static
    {
        if ($this->inCondition and !$this->conditionIsTrue) return $this;
        $this->sql .= " = " . $this->quote($value);
        return $this;
    }

    /**
     * 创建'!='。
     * Create '!='.
     *
     * @param string|null $value
     * @return static|sql the sql object.
     * @access public
     */
    public function ne(string $value = null): sql|static
    {
        if ($this->inCondition and !$this->conditionIsTrue) return $this;
        $this->sql .= " != " . $this->quote($value);
        return $this;
    }

    /**
     * 创建'>'。
     * Create '>'.
     *
     * @param string|null $value
     * @return static|sql the sql object.
     * @access public
     */
    public function gt(string $value = null): sql|static
    {
        if ($this->inCondition and !$this->conditionIsTrue) return $this;
        $this->sql .= " > " . $this->quote($value);
        return $this;
    }

    /**
     * 创建'>='
     * Create '>='.
     *
     * @param string $value
     * @access public
     * @return static|sql the sql object.
     */
    public function ge(string $value): sql|static
    {
        if ($this->inCondition and !$this->conditionIsTrue) return $this;
        $this->sql .= " >= " . $this->quote($value);
        return $this;
    }

    /**
     * 创建'<'。
     * Create '<'.
     *
     * @param mixed $value
     * @access public
     * @return static|sql the sql object.
     */
    public function lt(mixed $value = null): sql|static
    {
        if ($this->inCondition and !$this->conditionIsTrue) return $this;
        $this->sql .= " < " . $this->quote($value);
        return $this;
    }

    /**
     * 创建 '<='。
     * Create '<='.
     *
     * @param mixed $value
     * @access public
     * @return static|sql the sql object.
     */
    public function le(mixed $value): sql|static
    {
        if ($this->inCondition and !$this->conditionIsTrue) return $this;
        $this->sql .= " <= " . $this->quote($value);
        return $this;
    }

    /**
     * 创建"between and"。
     * Create "between and"
     *
     * @param string $min
     * @param string $max
     * @access public
     * @return static|sql the sql object.
     */
    public function between(string $min, string $max): sql|static
    {
        if ($this->inCondition and !$this->conditionIsTrue) return $this;
        $min = $this->quote($min);
        $max = $this->quote($max);
        $this->sql .= " BETWEEN $min AND $max ";
        return $this;
    }

    /**
     * 创建IN部分。
     * Create in part.
     *
     * @param array|string|null $ids ','分割的字符串或者数组  list string by ',' or an array
     * @return baseSQL the sql object.
     * @access public
     */
    public function in(array|string|null $ids): baseSQL
    {
        if ($this->inCondition and !$this->conditionIsTrue) return $this;
        $this->sql .= helper::dbIN($ids);
        return $this;
    }

    /**
     * 创建'NOT IN'部分。
     * Create not in part.
     *
     * @param array|string $ids list string by ',' or an array
     * @access public
     * @return static|sql the sql object.
     */
    public function notin(array|string $ids): sql|baseSQL
    {
        if ($this->inCondition and !$this->conditionIsTrue) return $this;
        $this->sql .= ' NOT ' . helper::dbIN($ids);
        return $this;
    }

    /**
     * 创建LIKE部分。
     * Create the like by part.
     *
     * @param string $string
     * @access public
     * @return static|sql the sql object.
     */
    public function like(string $string): sql|baseSQL
    {
        if ($this->inCondition and !$this->conditionIsTrue) return $this;
        $this->sql .= " LIKE " . $this->quote($string);
        return $this;
    }

    /**
     * 创建NOT LIKE部分。
     * Create the not like by part.
     *
     * @param string $string
     * @access public
     * @return static|sql the sql object.
     */
    public function notLike($string)
    {
        if ($this->inCondition and !$this->conditionIsTrue) return $this;
        $this->sql .= "NOT LIKE " . $this->quote($string);
        return $this;
    }

    /**
     * 创建ORDER BY部分。
     * Create the order by part.
     *
     * @param string $order
     * @return sql|baseSQL the sql object.
     * @access public
     */
    public function orderBy(string $order): sql|static
    {
        if ($this->inCondition and !$this->conditionIsTrue) return $this;

        $order = str_replace(array('|', '', '_'), ' ', $order);

        /* Add "`" in order string. */
        /* When order has limit string. */
        $pos = stripos($order, 'limit');
        $orders = $pos ? substr($order, 0, $pos) : $order;
        $limit = $pos ? substr($order, $pos) : '';
        if (!empty($limit)) {
            $trimmedLimit = trim(str_replace('limit', '', $limit));
            if (!preg_match('/^[0-9]+ *(, *[0-9]+)?$/', $trimmedLimit)) die("Limit is bad query, The limit is " . htmlspecialchars($limit));
        }

        $orders = trim($orders);
        if (empty($orders)) return $this;
        if (!preg_match('/^(\w+\.)?(`\w+`|\w+)( +(desc|asc))?( *(, *(\w+\.)?(`\w+`|\w+)( +(desc|asc))?)?)*$/i', $orders)) die("Order is bad request, The order is " . htmlspecialchars($orders));

        $orders = explode(',', $orders);
        foreach ($orders as $i => $order) {
            $orderParse = explode(' ', trim($order));
            foreach ($orderParse as $key => $value) {
                $value = trim($value);
                if (empty($value) or strtolower($value) == 'desc' or strtolower($value) == 'asc') continue;

                $field = $value;
                /* such as t1.id field. */
                if (str_contains($value, '.')) list($table, $field) = explode('.', $field);
                if (!str_contains($field, '`')) $field = "`$field`";

                $orderParse[$key] = isset($table) ? $table . '.' . $field : $field;
                unset($table);
            }
            $orders[$i] = join(' ', $orderParse);
            if (empty($orders[$i])) unset($orders[$i]);
        }
        $order = join(',', $orders) . ' ' . $limit;

        $this->sql .= ' ' . baseDAO::ORDERBY . " $order";
        return $this;
    }

    /**
     * 创建LIMIT部分。
     * Create the limit part.
     *
     * @param string $limit
     * @access public
     * @return static|sql the sql object.
     */
    public function limit(string $limit): sql|static|dao|baseDAO
    {
        if ($this->inCondition and !$this->conditionIsTrue) return $this;
        if (empty($limit)) return $this;

        /* filter limit. */
        $limit = trim(str_ireplace('limit', '', $limit));
        if (!preg_match('/^[0-9]+ *(, *[0-9]+)?$/', $limit)) {
            $limit = htmlspecialchars($limit);
            die("Limit is bad query, The limit is $limit");
        }
        $this->sql .= ' ' . baseDAO::LIMIT . " $limit ";
        return $this;
    }

    /**
     * 创建GROUP BY部分。
     * Create the 'groupby' part.
     *
     * @param string $groupBy
     * @return baseSQL the sql object.
     * @access public
     */
    public function groupBy(string $groupBy): baseSQL
    {
        if ($this->inCondition and !$this->conditionIsTrue) return $this;
        if (!preg_match('/^\w+[a-zA-Z0-9_`.]+$/', $groupBy)) {
            $groupBy = htmlspecialchars($groupBy);
            die("Group is bad query, The group is $groupBy");
        }
        $this->sql .= ' ' . baseDAO::GROUPBY . " $groupBy";
        return $this;
    }

    /**
     * 创建HAVING部分。
     * Create the having part.
     *
     * @param string $having
     * @access public
     * @return static|sql the sql object.
     */
    public function having(string $having): sql|static
    {
        if ($this->inCondition and !$this->conditionIsTrue) return $this;
        $this->sql .= ' ' . baseDAO::HAVING . " $having";
        return $this;
    }

    /**
     * 获取SQL字符串。
     * Get the sql string.
     *
     * @access public
     * @return string|sql|baseSQL
     */
    public function get(): string|sql|static
    {
        return $this->sql;
    }

    /**
     * 对字段加转义。
     * Quote a var.
     *
     * @param mixed $value
     * @access public
     * @return mixed
     */
    public function quote(mixed $value): mixed
    {
        if ($this->magicQuote) $value = stripslashes($value);
        return $this->dbh->quote((string)$value);
    }
}
