<?php

namespace KenCore\Repository;

use KenCore\Model\BaseModel;

abstract class AbstractRepository
{


    /**
     * 获取当前模型
     * @return string
     */
    abstract protected function setModel(): string;

    /**
     * 获取模型
     * @return BaseModel
     */
    protected function getModel()
    {
        return container()->get($this->setModel());
    }


    /**
     * 获取模型
     * @return BaseModel
     */
    public function getModelInstance()
    {
        return container()->get($this->setModel());
    }

    /**
     * Notes: 当前模型的表名全称
     * Author: 重设人生 <573914456@qq.com>
     * DataTime: 2023/6/23 15:36
     * @return string
     */
    public function getTableName(): string
    {
        return env('DB_PREFIX') . $this->getModel()->getTable();
    }

    /**
     * Notes: 获取主键
     * Author: 重设人生 <573914456@qq.com>
     * DataTime: 2023/6/23 15:37
     * @return string
     */
    protected function getPk()
    {
        return $this->getModel()->getKeyName();
    }

}