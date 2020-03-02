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
        $query = $this->model->getModel()->where($this->model->where());

        if($isRelation)
        {
            $this->data = $query->select($this->model->relationSelect())->get();
        }else
        {
            $this->data = $model->select($this->model->optionSelect())->get();
        }
    }


}