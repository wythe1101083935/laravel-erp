<?php

namespace Wythe\Erp\Responses;

class OptionList extends ListData
{
    /**
     * createData
     *
     * @param
     * @return
     */
    protected function createData()
    {
        $model = $this->model->getModel()->where($this->model->where());

        if($isRelation)
        {
            return $model->select($this->model->relationSelect())->get();
        }else
        {
            return $model->select($this->model->optionSelect())->get();
        }

         $this->data = [
             'data'=>$this->get(),
         ];
    }


}