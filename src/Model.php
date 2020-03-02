<?php

namespace Wythe\Erp;

class Model
{
    /**
     * 名称
     * 
     * @var 
     */
    protected $name;
    
    /**
     * option
     * 
     * @var 
     */
    protected $option;

    /**
     * 表格页面信息
     *
     * @var
     */
    protected $tableQuotes;

    /**
     * 创建页面信息
     *
     * @var
     */
    protected $createQuotes;

    /**
     * 更新页面信息
     *
     * @var
     */
    protected $updateQuotes;

    /**
     * 单个信息页面
     *
     * @var
     */
    protected $infoQuotes;

    /**
     * actions
     *
     * @var
     */
    protected $actions = [];

    /**
     * cacheInfo
     * 
     * @var 
     */
    protected $cacheInfo;
    
    /**
     * request
     * 
     * @var 
     */
    public $request;

    /**
     * init
     *
     * @param
     * @return
     */
    public function __construct($option,$request)
    {
        $this->name = $option->name;

        $this->option = $option;
        
        $this->request = $request;

        $this->cacheInfo = Cache::get('wythe_table_fields');

        $this->initActions();
    }

    /**
     * 初始化动作列表
     *
     * @param
     * @return
     */
    protected function initActions()
    {
        foreach($this->option->actions as $actionName)
        {
            $this->actions[$actionName] = new Action($this,$actionName,trans('action.'.$actionName.'.title'));
        }

        foreach($this->option->table->actions as $actionName)
        {
            $this->actions[$actionName] = new Action($this,$actionName,trans('action.'.$actionName.'.title'));
        }

    }

    
    /**
     * formatTableQuote
     *
     * @param 
     * @return 
     */
    protected function formatTableQuote()
    {
        $this->tableQuotes['fields'] = $this->explainFieldsListOption($this->option->tableFieldsSet);

        $this->tableQuotes['action'] = $this->explainActionListOption($this->option->actionSet);

        $this->tableQuotes['keywords'] = $this->explainFieldsListOption($this->option->keywordsSet);

        $this->tableQuotes['advanceSet'] = $this->explainFieldsListOption($this->option->advancedSet);
    }

    /**
     * getTableQuote
     *
     * @param
     * @return
     */
    public function getTableQuote()
    {
        if(is_null($this->tableQuotes))
        {
            $this->formatTableQuote();
        }

        return $this->tableQuotes;
    }

    /**
     * formatCreateQuote
     *
     * @param
     * @return
     */
    protected function formatCreateQuote()
    {
        if(isset($this->option['create']))
    }


    /**
     * __call
     *
     * @param
     * @return
     */
    public function __call($func,$params)
    {
        if(isset($this->actions[$func]))
        {
            return $this->actions[$func]->response(...$params);
        }
    }

}