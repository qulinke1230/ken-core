<?php
// +----------------------------------------------------------------------
// | QULINKE [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2020 EBACERA All rights reserved.
// +----------------------------------------------------------------------
// | Author: 重设人生 <573914456@qq.com>
// | Date:  2021/4/23 15:44
// +----------------------------------------------------------------------

namespace KenCore\Exception\Handler;


use KenCore\Constants\ErrorCodeEnum;
use Hyperf\ExceptionHandler\ExceptionHandler;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Psr\Http\Message\ResponseInterface;
use Throwable;

class ServiceExceptionHandler extends ExceptionHandler
{

    public function handle(Throwable $throwable, ResponseInterface $response)
    {
        // TODO: Implement handle() method.
        // 判断被捕获到的异常是希望被捕获的异常
        if ($throwable instanceof ServiceException) {
            // 格式化输出
            $code = $throwable->getCode() > 0 ?: ErrorCodeEnum::ERR_BUSINESS;
            $message = $throwable->getMessage();
            $data = json_encode([
                'code' => $code,
                'msg' => $message ?:  ErrorCodeEnum::getMessage($code),
            ], JSON_UNESCAPED_UNICODE);

            // 阻止异常冒泡
            $this->stopPropagation();
            return $response->withStatus(ErrorCodeEnum::SUCCESS)->withBody(new SwooleStream($data));
        }
        // 交给下一个异常处理器
        return $response;
    }


    public function isValid(Throwable $throwable): bool
    {
        // TODO: Implement isValid() method.
        return true;
    }
}
