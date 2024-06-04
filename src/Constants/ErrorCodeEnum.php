<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */
namespace KenCore\Constants;

use Hyperf\Constants\AbstractConstants;
use Hyperf\Constants\Annotation\Constants;

/**
 * @Constants
 */
class ErrorCodeEnum extends AbstractConstants
{

    /**
     * @Message("请求成功")
     */
    const SUCCESS = 200;

    /**
     * @Message("操作错误")
     */
    const ERR_BUSINESS = 400;

    /**
     * @Message("参数错误")
     */
    const ERR_PARAMETER = 404;


    /**
     * @Message("系统异常！")
     */
    const ERR_SERVER = 500;


    /**
     * @Message("无权限访问！")
     */
    const ERR_NOT_ACCESS = 1001;

    /**
     * @Message("令牌过期！")
     */
    const ERR_EXPIRE_TOKEN = 1002;

    /**
     * @Message("登录过期！")
     */
    const ERR_INVALID_TOKEN = 1003;

    /**
     * @Message("令牌不存在！")
     */
    const ERR_NOT_EXIST_TOKEN = 1004;


    /**
     * @Message("请登录！")
     */
    const ERR_NOT_LOGIN = 2001;

    /**
     * @Message("用户信息错误！")
     */
    const ERR_USER_INFO = 2002;

    /**
     * @Message("用户不存在！")
     */
    const ERR_USER_ABSENT = 2003;


    /**
     * @Message("业务逻辑异常！")
     */
    const ERR_EXCEPTION = 3001;

    /**
     * 用户相关逻辑异常
     * @Message("用户或密码不正确！")
     */
    const ERR_EXCEPTION_USER = 3002;

    /**
     * 文件上传
     * @Message("文件上传异常！")
     */
    const ERR_EXCEPTION_UPLOAD = 3003;

    /**
     * 表单验证不通过
     * @Message("验证失败！")
     */
    const ERR_VALIDATION = 3004;


    /**
     * @Message("内容不存在")
     */
    const ERR_EMPTY_DATA = 3005;
}
