<?php
// +----------------------------------------------------------------------
// | QULINKE [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2020 EBACERA All rights reserved.
// +----------------------------------------------------------------------
// | Author: 重设人生 <573914456@qq.com>
// | Date:  2023/6/18 22:08
// +----------------------------------------------------------------------


namespace KenCore\Model;
use Hyperf\Database\Model\Builder;
class BaseModel extends AbstractModel
{

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        //注册常用方法
        //$this->registerBase();
    }

}
