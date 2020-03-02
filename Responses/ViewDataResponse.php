<?php

namespace Wythe\Erp\Responses;

class ViewDataResponse
{

    /**
     * model
     *
     * @var
     */
    protected $model;

    /**
     * action
     *
     * @var
     */
    protected $action;

    /**
     * data
     *
     * @var
     */
    protected $data;
    /**
     * init
     *
     * @param
     * @return
     */
    public function __construct($action)
    {
        $this->action = $action;

        $this->model = $action->model;
        
        $this->createData();
    }
    
    /**
     * createData
     *
     * @param 
     * @return 
     */
    protected function createData()
    {
        $this->data = []; 
    }
    
    /**
     * 解析表+多个字段这种设置格式
     *
     * @param
     * @return
     */
    protected function explainFieldsListOption()
    {
        $list = collect([]);

        foreach($this->option['table']['fields'] as $table => $fieldsList)
        {
            foreach($fieldsList as $key => $value)
            {
                if(is_array($value))
                {
                    $list->push($this->resolveField($table,$key,$value));
                }else
                {
                    $list->push($this->resolveField($table,$value));
                }
            }
        }

        return $list;
    }

    /**
     * getField
     *
     * @param
     * @return
     */
    protected function resolveField($table,$name,$option=[])
    {
        $fields = $this->cacheInfo->where('table',$table)->where('name',$name)->first();

        $option = array_merge($option,$fields);

        return new Field($this,$option);
    }
}