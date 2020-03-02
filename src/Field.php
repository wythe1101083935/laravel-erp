<?php

namespace Wythe\Erp;

class Field
{
    /**
     * 字段名
     *
     * @var String
     */
    public $name;

    /**
     * 字段所属表格
     *
     * @var String
     */
    public $table;

    /**
     * 字段默认值
     *
     * @var String
     */
    public $default;

    /**
     * 字段类型
     *
     * @var String text|select|url|textarea
     */
    public $type;
    
    /**
     * relation
     * 
     * @var 
     */
    protected $relation;
    
    /**
     * 字段可选项
     * 
     * @var 
     */
    protected $opions=[];

    /**
     * 字段标题
     *
     * @var String
     */
    public $title;

    /**
     * 字段描述
     *
     * @var String
     */
    public $remarks;

    /**
     * 字段是否用于排序
     *
     * @var Bool
     */
    public $sort;

    /**
     * 字段是否用于链接
     *
     * @var Bool
     */
    public $link;

    /**
     * model
     *
     * @var
     */
    protected $model;
    /**
     * init
     *
     * @param
     * @return
     */
    public function __construct($option)
    {
        $this->name = $name = $option['name'];

        $this->table = $table = $option['table'];

        $this->width = $option['width'] ?? 120;

        $this->default = $option['default'] ?? '';

        foreach($option['options'] as $op)
        {
            $this->options[$op['name']] = trans($table.'.options.'.$name.'.'.$op['id']);
        }

        $this->type = $option['type'] ?? 'text';

        $this->title = $option['title'] ?? trans($table.'.fields.'.$name);

        $this->remarks = $option['remarks'] ?? trans($table.'.fieldsUpload.'.$name.);

        $this->sort = $option['sort'] ?? false;

        $this->link = $option['sort'] ?? false;

        $this->relation = $option['relation'] ?? false;
    }
    
    /**
     * 化数组
     *
     * @param
     * @return
     */
    public function toArray()
    {
        return
            [
                'name'=>$this->name,
                'table'=>$this->table,
                'default'=>$this->default,
                'type'=>$this->type,
                'title'=>$this->title,
                'remarks'=>$this->remarks,
                'sort'=>$this->sort,
                'link'=>$this->link,
                'options'=>$this->options
            ];
    }
}