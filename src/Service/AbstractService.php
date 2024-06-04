<?php
// +----------------------------------------------------------------------
// | QULINKE [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2020 EBACERA All rights reserved.
// +----------------------------------------------------------------------
// | Author: 重设人生 <573914456@qq.com>
// | Date:  2021/7/11 1:39
// +----------------------------------------------------------------------


namespace KenCore\Service;

use KenCore\Traits\Error;
use Hyperf\Contract\LengthAwarePaginatorInterface;
use Hyperf\DbConnection\Model\Model as BaseModel;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Contract\RequestInterface;

/**
 * 服务基类
 * Class BaseService
 * @package App\Service
 */
abstract class AbstractService
{

    //
    use Error;

    /**
     * @Inject()
     * @var RequestInterface
     */
    protected $request;

    /**
     * 默认显示条数
     * @var int
     */
    protected $pageSize = 15;

    /**
     * 模型注入
     * @var object
     */
    protected $repository;

    /**
     * Notes: 方法不存在时调用dao的方法
     * Author: 重设人生 <573914456@qq.com>
     * DataTime: 2023/6/19 0:07
     * @param $name
     * @param $arguments
     * @return false|mixed
     */
    public function __call($name, $arguments)
    {
        return call_user_func_array([$this->repository, $name], $arguments);
    }

}
