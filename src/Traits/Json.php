<?php

declare(strict_types=1);

namespace KenCore\Traits;

use KenCore\Constants\ErrorCodeEnum;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Response;

trait Json
{
    /**
     * @Inject
     * @var Response
     */
    protected $response;

    protected $data = [];

    protected $msg = 'success';

    protected $status = 1;

    public function setStatus(int $status): void
    {
        $this->status = $status;
    }

    public function setMsg(string $msg): void
    {
        $this->msg = $msg;
    }

    public function setData(array $data): void
    {
        $this->data = $data;
    }

    public function success($data = [], $msg = '', $other = [])
    {
        $this->data = is_string($data) ? [] : $data;
        $this->msg = $msg;
        $this->status = ErrorCodeEnum::SUCCESS;
        return $this->myAjaxReturn($other);
    }

    public function error($status = ErrorCodeEnum::ERR_BUSINESS, $msg = '', $data = [], $other = [])
    {
        $this->data = $data;
        $this->msg = $msg;
        $this->status = $status;
        return $this->myAjaxReturn($other);
    }

    public function myAjaxReturn($other)
    {
        $data = array_merge([
            'data' => $this->data,
            'code' => $this->status,
            'msg' => (isset($this->msg) && !empty($this->msg)) ? $this->msg : ErrorCodeEnum::getMessage($this->status)
        ], $other);
        return $this->response->json($data);
    }


    /**
     * Notes:
     * Author: 重设人生 <573914456@qq.com>
     * DateTime: 2021/4/21 13:24
     * @param int $code
     * @param array $data
     * @param string $msg
     * @return array
     */
    public function json($code = 400, $data = array(), $msg = "")
    {
        //状态错误码
        $return_arr = [
            "code" => $code,
            'msg' => (isset($msg) && !empty($msg)) ? $msg : ErrorCodeEnum::getMessage($code),
            "data" => $data
        ];
        return $return_arr;
    }
}
