<?php
/**
 * @Author: laoweizhen <1149243551@qq.com>,
 * @Date: 2022/10/07 15:34,
 * @LastEditTime: 2022/10/07 15:34
 */
declare(strict_types=1);

namespace KenCore\Traits;

use Hyperf\Database\Model\Builder;

trait ModelMacroTrait
{

    /**
     * Notes: 注册常用自定义方法
     * Author: 重设人生 <573914456@qq.com>
     * DataTime: 2023/6/18 23:51
     */
    protected function registerBase()
    {
        Builder::macro('setQueryParams', function (array $where, string $tableAlias = null) {
            if (empty($where)) {
                return $this;
            }

            /**
             * $field 格式：
             *    格式一：正常筛选， 内容
             *    格式二：根据指定类型筛选；类型：内容
             *      支持的类型：like、l_like、r_like、gt（大于）、gte（大于等于）、lt（小于）、lte（小于等于）
             *          like:字段 => like %内容%
             *          l_like:字段 => like %内容
             *          r_like:字段 => liek 内容%
             *          gt:字段 => 内容
             *          其他后面补全
             */
            foreach ($where as $field => $value) {
                if ($value === '' || is_null($value)) { // 空条件不做处理
                    continue;
                }
                // 正常查询
                $field = $tableAlias ? $tableAlias . '.' . $field : $field;
                $this->{is_array($value) ? 'whereIn' : 'where'}($field, $value);
            }
            return $this;
        });
    }
}
