<?php

namespace Wythe\Erp\Responses;

class Table extends ViewDataResponse
{
    /**
     * init
     *
     * @param
     * @return
     */
    public function createData()
    {
        $actions = [];

        foreach($this->model->option->tableQuotes['actions']  as $actionName)
        {
            if(isset($this->model->actions[$actionName]))
            {
                $actions[$actionName] = $this->model->actions[$actionName];
            }
        }

        $this->data =
            [
                'action'=>$actions,
                'head'=>$this->explainFieldsListOption($this->model->option->tableQuotes['head']),
                'body'=>$this->model->name.'/'.'list',
                'search'=>$this->explainFieldsListOption($this->model->option->tableQuotes['search']),
                'keywords'=>$this->explainFieldsListOption($this->model->option->tableQuotes['keywords']),
                'export'=>$this->model->name.'/'.'export',
                'defaultSort'=>$this->model->option->tableQuotes['defaultSort'],
                'lang'=>
                    ['export'=>
                            [
                                'title'=>trans('index.export.title'),
                                'all'=>trans('index.export.all'),
                                'select'=>trans('index.export.select'),
                                'page'=>trans('index.export.page'),
                            ],
                        'search'=>trans('index.search'),
                        'advanced'=>trans('index.advanced-search'),
                        'confirm'=>trans('index.confirm'),
                        'reset'=>trans('index.reset'),
                        'leastOne'=>trans('index.select_least_one'),
                        'selectOne'=>trans('index.select_one'),
                        'actionList'=>trans('index.action_list'),
                        'confirmPrompt'=>trans('index.confirm_prompt'),
                    ]
            ];
    }
}