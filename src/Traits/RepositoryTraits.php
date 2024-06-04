<?php

// +----------------------------------------------------------------------
// | QULINKE [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2024 EBACERA All rights reserved.
// +----------------------------------------------------------------------
// | Author: 重设人生 <573914456@qq.com>
// | Date:  2024/6/5 5:26
// +----------------------------------------------------------------------

declare(strict_types=1);

namespace KenCore\Traits;

use Hyperf\DbConnection\Db;
use Hyperf\DbConnection\Model\Model;

trait RepositoryTraits
{


    /**
     * Notes: 获取实体的所有数据
     * Author: 重设人生 <573914456@qq.com>
     * DataTime: 2023/6/23 15:28
     * @param $id *条件数组
     * @param string[] $select 条件数组
     * @param array $whereIn 显示字段
     * @param array $orderBy 排序方式
     * @param bool $needToArray 是否序列化成数组
     * @return bool|mixed[]
     */
    public function getList($id, $select = ['*'], $whereIn = [], $orderBy = [], bool $needToArray = false)
    {
        $where = [];
        if (is_array($id)) {
            $where = $id;
        } else {
            $where = [$this->getPk() => $id];
        }
        $query = $this->getModel()::query()->where($where)
            ->when(!empty($whereIn), function ($query) use ($whereIn) {
                return $query->whereIn($whereIn[0], $whereIn[1]);
            })->select($select);
        //排序
        if (!empty($orderBy) && is_array($orderBy)) {
            foreach ($orderBy as $val) {
                $query->orderBy($val[0], $val[1]);
            }
        }
        $data = $query->get();
        //格式化成数组
        return $needToArray ? $data->toArray() : $data;
    }

    /**
     * Notes: 根据ID返回列表
     * Author: 重设人生 <573914456@qq.com>
     * DataTime: 2024/6/5 5:31
     * @param array $ids
     * @param array $columns
     * @return \Hyperf\Utils\Collection
     */
    public function getListById(array $ids, array $columns = ['*'])
    {
        $data = self::query()->whereIn($this->getKeyName(), $ids)
            ->select($columns)
            ->get();
        $data || $data = collect([]);
        return $data;
    }

    /**
     * Notes: 获取某些条件总数
     * Author: 重设人生 <573914456@qq.com>
     * DataTime: 2023/6/18 23:05
     * @param array $where
     * @return int
     */
    public function getCount(array $where)
    {
        return $this->getModel()::query()->where($where)->count($this->getPk());
    }

    /**
     * Notes: 通过ID查找一条记录
     * Author: 重设人生 <573914456@qq.com>
     * DataTime: 2023/6/23 15:24
     * @param $id id
     * @param array|string[] $fields 获取的字段
     * @return Model|null
     */
    public function getOneById($id, array $fields = ['*']): ?Model
    {
        return $this->getModel()::query()->select($fields)->find($id);
    }

    /**
     * Notes: 通过where查找一条记录
     * Author: 重设人生 <573914456@qq.com>
     * DataTime: 2023/8/15 20:10
     * @param array $where
     * @param array|string[] $fields
     * @return \Hyperf\Database\Model\Builder|\Hyperf\Database\Model\Model|object|null
     */
    public function getOne(array $where, array $fields = ['*'])
    {
        return $this->getModel()::query()->where($where)->select($fields)->first();
    }

    /**
     * Notes: 获取某个字段数组
     * Author: 重设人生 <573914456@qq.com>
     * DataTime: 2023/8/16 6:21
     * @param array $where
     * @param string $fieldStr
     * @param string $key
     * @return \Hyperf\Utils\Collection
     */
    public function getPluck(array $where, string $fieldStr, string $key = '')
    {
        return $this->getModel()::query()->where($where)->pluck($fieldStr, $key);
    }

    /**
     * Notes: 获得单个的值
     * Author: 重设人生 <573914456@qq.com>
     * DataTime: 2023/8/12 3:00
     * @param $where
     * @param $field
     * @param string $default
     * @return \Hyperf\Utils\HigherOrderTapProxy|mixed|void
     */
    public function value($where, $field, $default = '')
    {
        return $this->getModel()::query()->where($where)->value($field, $default);
    }

    /**
     * 新增数据（一条）.
     */
    public function save(array $data)
    {
        return $this->getModel()::create($data);
    }

    /**
     * 批量插入数据.
     */
    public function insert(array $data): bool
    {
        return Db::table($this->getModel()->getTable())->insert($data);
    }

    /**
     * 插入数据返回id
     */
    public function insertGetId(array $data): int
    {
        return Db::table($this->getModel()->getTable())->insertGetId($data);
    }

    /**
     * Notes: 更新数据
     * Author: 重设人生 <573914456@qq.com>
     * DataTime: 2023/8/12 4:16
     * @param $id
     * @param array $data
     * @param string|null $key
     * @return bool
     */
    public function update($id, array $data, ?string $key = null)
    {
        if (is_array($id)) {
            $where = $id;
        } else {
            $where = [is_null($key) ? $this->getPk() : $key => $id];
        }
        return $this->getModel()->where($where)->update($data);
    }

    /**
     * Notes:
     * Author: 重设人生 <573914456@qq.com>
     * DataTime: 2023/8/18 14:20
     * @param array $where
     * @param string $column
     * @param int $num
     * @return int
     */
    public function increment(array $where, string $column, $num = 1): int
    {
        return $this->getModel()::query()->where($where)->increment($column, $num);
    }

    /**
     * Notes:
     * Author: 重设人生 <573914456@qq.com>
     * DataTime: 2023/8/18 14:19
     * @param array $where
     * @param string $column
     * @param int $num
     * @return int
     */
    public function decrement(array $where, string $column, $num = 1): int
    {
        return $this->getModel()::query()->where($where)->decrement($column, $num);
    }


}