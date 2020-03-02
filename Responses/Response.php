<?php

namespace Wythe\Erp\Responses

class Response
{

    public static function make($action)
    {
        switch($action->name)
        {
            case 'list':
                return new ListData($action);
            case 'table':
                return new Table($action);
            case 'create':
                return new Create($action);
            case 'update':
                return new Update($action);
            case 'info':
                return new Info($action);
            case 'upload':
                return new Upload($action);
        }
    }
}