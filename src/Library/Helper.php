<?php

namespace KenCore\Library;


/**
 * 工具类
 * Class helper
 * @package app\common\library
 */
class Helper
{

    /**
     * Notes: 精确减法
     * Author: 重设人生 <573914456@qq.com>
     * DateTime: 2020/4/28 5:15
     * @param $leftOperand
     * @param $rightOperand
     * @param int $scale
     * @return string
     */
    public static function bcsub($leftOperand, $rightOperand, $scale = 2)
    {
        return \bcsub($leftOperand, $rightOperand, $scale);
    }

    /**
     * Notes:精确加法
     * Author: 重设人生 <573914456@qq.com>
     * DateTime: 2020/4/28 5:15
     * @param $leftOperand
     * @param $rightOperand
     * @param int $scale
     * @return string
     */
    public static function bcadd($leftOperand, $rightOperand, $scale = 2)
    {
        return \bcadd($leftOperand, $rightOperand, $scale);
    }

    /**
     * Notes: 精确乘法
     * Author: 重设人生 <573914456@qq.com>
     * DateTime: 2020/4/28 5:14
     * @param $leftOperand
     * @param $rightOperand
     * @param int $scale
     * @return string
     */
    public static function bcmul($leftOperand, $rightOperand, $scale = 2)
    {
        return \bcmul($leftOperand, $rightOperand, $scale);
    }

    /**
     * Notes: 精确除法
     * Author: 重设人生 <573914456@qq.com>
     * DateTime: 2020/4/28 5:14
     * @param $leftOperand
     * @param $rightOperand
     * @param int $scale
     * @return string|null
     */
    public static function bcdiv($leftOperand, $rightOperand, $scale = 2)
    {
        return \bcdiv($leftOperand, $rightOperand, $scale);
    }

    /**
     * Notes: 比较大小 [大于 返回 1 等于返回 0 小于返回 -1]
     * Author: 重设人生 <573914456@qq.com>
     * DateTime: 2020/4/28 5:16
     * @param $leftOperand
     * @param $rightOperand
     * @param int $scale
     * @return int
     */
    public static function bccomp($leftOperand, $rightOperand, $scale = 2)
    {
        return \bccomp($leftOperand, $rightOperand, $scale);// 比较到小数点位数
    }

    /**
     * Notes: 比较大小【是否等于等于返回true】
     * Author: 重设人生 <573914456@qq.com>
     * DateTime: 2020/4/28 5:16
     * @param $leftOperand
     * @param $rightOperand
     * @param int $scale
     * @return bool
     */
    public static function bcequal($leftOperand, $rightOperand, $scale = 2)
    {
        return self::bccomp($leftOperand, $rightOperand, $scale) === 0;// 比较到小数点位数
    }


    /**
     * 数组转为json
     * @param $data
     * @param int $options
     * @return string
     */
    public static function jsonEncode($data, int $options = JSON_UNESCAPED_UNICODE)
    {
        return json_encode($data, $options);
    }

    /**
     * json转义为数组
     * @param $json
     * @return array
     */
    public static function jsonDecode($json)
    {
        return json_decode($json, true);
    }

    public static function number2($number, $isMinimum = false, $minimum = 0.01)
    {
        $isMinimum && $number = max($minimum, $number);
        return sprintf('%.2f', $number);
    }
}
