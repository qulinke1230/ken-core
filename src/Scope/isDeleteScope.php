<?php
// +----------------------------------------------------------------------
// | QULINKE [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2020 EBACERA All rights reserved.
// +----------------------------------------------------------------------
// | Author: 重设人生 <573914456@qq.com>
// | Date:  2022/10/9 16:45
// +----------------------------------------------------------------------


namespace KenCore\Scope;

use Hyperf\Database\Model\Builder;
use Hyperf\Database\Model\Model;
use Hyperf\Database\Model\Scope;

/**
 * 过滤软删除 is_delete
 */
class isDeleteScope implements Scope
{

    public function apply(Builder $builder, Model $model)
    {
        // TODO: Implement apply() method.
        $builder->where('is_delete', '=', 0);
    }
}
