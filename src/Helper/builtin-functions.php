<?php

use Hyperf\AsyncQueue\Driver\DriverFactory;
use Hyperf\AsyncQueue\JobInterface;
use Hyperf\Contract\StdoutLoggerInterface;
use Hyperf\Guzzle\ClientFactory;
use Hyperf\Logger\LoggerFactory;
use Hyperf\ExceptionHandler\Formatter\FormatterInterface;
use Hyperf\Redis\RedisFactory;
use Hyperf\Utils\ApplicationContext;
use Hyperf\Validation\Contract\ValidatorFactoryInterface;
use Psr\Http\Message\ServerRequestInterface;
use Hyperf\Server\ServerFactory;
use Qbhy\HyperfAuth\AuthManager;
use Swoole\Websocket\Frame;
use Swoole\WebSocket\Server as WebSocketServer;
use Hyperf\HttpServer\Contract\ResponseInterface;
use Psr\EventDispatcher\EventDispatcherInterface;


/**
 * 容器实例
 */
if (!function_exists('container')) {
    function container()
    {
        return ApplicationContext::getContainer();
    }
}

/**
 * redis 客户端实例
 */
if (!function_exists('redis')) {
    function redis()
    {
        return container()->get(Redis::class);
    }
}

/**
 * server 实例 基于 swoole server
 */
if (!function_exists('server')) {
    function server()
    {
        return container()->get(ServerFactory::class)->getServer()->getServer();
    }
}

/**
 * websocket frame 实例
 */
if (!function_exists('frame')) {
    function frame()
    {
        return container()->get(Frame::class);
    }
}

/**
 * websocket 实例
 */
if (!function_exists('websocket')) {
    function websocket()
    {
        return container()->get(WebSocketServer::class);
    }
}

/**
 * 缓存实例 简单的缓存
 */
if (!function_exists('cache')) {
    function cache()
    {
        return container()->get(Psr\SimpleCache\CacheInterface::class);
    }
}

/**
 * 控制台日志
 */
if (!function_exists('stdLog')) {
    function stdLog()
    {
        return container()->get(StdoutLoggerInterface::class);
    }
}

/**
 * 文件日志
 */
if (!function_exists('logger')) {
    function logger()
    {
        return container()->get(LoggerFactory::class)->make();
    }
}

/**
 *
 */
if (!function_exists('request')) {
    function request()
    {
        return container()->get(ServerRequestInterface::class);
    }
}

/**
 *
 */
if (!function_exists('response')) {
    function response()
    {
        return container()->get(ResponseInterface::class);
    }
}

/**
 *
 */
if (!function_exists('validatorFactory')) {
    function validatorFactory()
    {
        return container()->get(ValidatorFactoryInterface::class);
    }
}

/**
 * jwt
 */
if (!function_exists('jwtManager')) {
    function jwtManager()
    {
        return container()->get(AuthManager::class);
    }
}

/**
 *
 */
if (!function_exists('clientFactory')) {
    function clientFactory()
    {
        return container()->get(ClientFactory::class);
    }
}

if (! function_exists('event')) {
    /**
     * 事件调度快捷方法
     * @param object $dispatch
     * @return object
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    function event(object $dispatch): object
    {
        return container()->get(EventDispatcherInterface::class)->dispatch($dispatch);
    }
}
