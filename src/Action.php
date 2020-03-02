<?php

namespace Wythe\Erp;

use Wythe\Erp\Response;

class Action
{
    /**
     * 动作名
     * 
     * @var 
     */
    public $name;
    
    /**
     * 动作标题
     * 
     * @var String
     */
    public $title;
    
    /**
     * 动作图标
     * 
     * @var String
     */
    public $icon;

    /**
     * 动作所属模型
     *
     * @var
     */
    public $model;

    /**
     * 动作触发返回层数
     *
     * @var
     */
    public $floor=1;

    /**
     * 动作触发验证(前端)
     *
     * @var
     */
    public $validate;

    /**
     * 动作触发验证(前端)层数
     *
     * @var
     */
    public $validateFloor;
    
    /**
     * 需要输入的字段(作为触发的第一阶段)
     * 
     * @var 
     */
    public $fields;

    /**
     * response内容
     * 
     * @var 
     */
    protected $response = false;
    
    /**
     * responseType
     * 
     * @var 
     */
    public $responseType='request';
    /**
     * init
     *
     * @param
     * @return
     */
    public function __construct($model,$name,$title,$response=false)
    {
        $this->model = $model;

        $this->name = $name;

        $this->title = $title;

        $this->response = $response;
    }

    /**
     * toArray
     *
     * @param
     * @return
     */
    public function toArray()
    {
        return
            [
                'name'=>$this->name,
                'title'=>$this->title,
                'icon'=>$this->icon,
                'floor'=>$this->floor,
                'validateFloor'=>$this->validateFloor,
                'fields'=>$this->fields->toArray(),
            ];
    }

    /**
     *
     *
     * @param
     * @return
     */
    public function response()
    {
        if($this->auto !== false)
        {
            return call_user_func($this->auto,$this);
        }

        return Response::make($this);
    }
}