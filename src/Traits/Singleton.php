<?php
declare(strict_types=1);

namespace KenCore\Traits;


use Hyperf\Context\Context;

trait Singleton
{
    /**
     * 为避免多次实例化，允许单例模式
     * 队列等常驻进程，请直接new
     * @return static
     */
    public static function getInstance()
    {
        $param = func_get_args();
        $calledClass = get_called_class();
        $keyArray = $param;
        foreach ($keyArray as $k => $key) {
            $keyArray[$k] = (string)$key;
        }
        $key = empty($keyArray) ? 0 : implode('_', $keyArray);
        $instanceKey = $calledClass . '_' . $key;
        if ($res = Context::get($instanceKey)) {
            return $res;
        }
        $instance = new $calledClass(...$param);
        Context::set($instanceKey, $instance);

        return $instance;
    }
}
