<?php

namespace Wythe\Erp\Responses;

class ListData extends ViewDataResponse
{
    /**
     * init
     *
     * @param
     * @return
     */
    protected function createData()
    {
        list($offset,$limit) = $this->page();

        $query = $this->model->getModel()
            ->where($this->model->where())
            ->where($this->whereKeywords())
            ->where($this->whereSearch());

        $count = $query->count();

        $query = $query->offset($offset)->limit($limit)
            ->select($this->model->select());

        list($field,$order) = $this->getOrderBy();

        if($field)
        {
            $data = $query->orderBy($field,$order)->get();
        }else
        {
            $data = $data->get();
        }


        $this->data = [
            'count'=>$count,
            'data'=>$this->model->dataFilter($data),
        ];
    }

    /**
     * whereSearch
     *
     * @param  string  $varName
     * @return bool
     */
    protected function whereSearch()
    {
        $searchFields = $this->model->getSearchs();

        if(!$searchFields)
        {
            return function($query){};
        }

        $searchData = isset($this->requestData['where']) ? $this->requestData['where'] : [];

        if(empty($searchData))
        {
            return function($query){};
        }
        return function($query) use ($searchFields,$searchData)
        {
            foreach ($searchFields as $fields)
            {
                $name = $fields['table'].'.'.$fields['name'];
                if(!isset($searchData[$name]))
                {
                    continue;
                }

                $value = $searchData[$name];

                //where时间
                if($fields['type'] == 'datetime')
                {
                    list($start,$end)= explode('~',$value);

                    $query->whereBetween($name,[trim($start),trim($end)]);
                    //where普通字段
                }else
                {
                    $query->where($name,$value);
                }
            }
        };

    }

    /**
     * whereKeywords
     *
     * @param  string  $varName
     * @return bool
     */
    protected function whereKeywords()
    {
        $fields = $this->model->getKeywords();

        if(!$fields
            || !isset($this->requestData['keywordsField'])
            || !$this->requestData['keywordsField']
            || !isset($this->requestData['keywordsValues'])
            || !$this->requestData['keywordsValues']
        )
        {
            return function($query){};
        }

        $keywordsField = $this->requestData['keywordsField'];

        $arr = $this->filterKeywords($this->requestData['keywordsValues']);

        return function($query) use ($arr,$fields,$keywordsField)
        {
            foreach ($fields as  $field)
            {
                $name = $field['table'].'.'.$field['name'];

                if($name == $keywordsField)
                {
                    $query->whereIn($name,$arr);

                    if(count($arr) > 1)
                    {
                        $this->orderBy = DB::raw("INSTR(',".implode(',',$arr).",',CONCAT(',',".$name.",','))");
                    }elseif(count($arr) == 1)
                   {
                       $query->where($name,'like','%'.$arr[0].'%');
                    }
                    break;
                }
            }
        };
    }


    /**
     * page
     *
     * @param  string  $varName
     * @return bool
     */
    protected function page()
    {
        if(isset($this->requestData['page']) && isset($this->requestData['pageSize']))
        {
            $offset = ($this->requestData['page'] -1)*$this->requestData['pageSize'] ? : 0;

            $limit = $this->requestData['pageSize'] ? : 10;

            return [$offset,$limit];
        }

        return [0,1000];
    }
}