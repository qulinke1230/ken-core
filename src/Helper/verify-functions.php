<?php
// +----------------------------------------------------------------------
// | QULINKE [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2020 EBACERA All rights reserved.
// +----------------------------------------------------------------------
// | Author: 重设人生 <573914456@qq.com>
// | Date:  2021/6/26 3:11
// +----------------------------------------------------------------------


if (!function_exists('checkMobile')) {
    /**
     * Notes:验证手机号
     * Author: 重设人生 <573914456@qq.com>
     * DataTime: 2021/6/26 3:14
     * @param $value
     * @return false|int
     */
    function checkMobile($value)
    {
        return preg_match("/^1[3-9]\d{9}$/", $value);
    }
}


if (!function_exists('checkEmail')) {
    /**
     * Notes:验证码邮箱
     * Author: 重设人生 <573914456@qq.com>
     * DataTime: 2021/6/26 3:17
     * @param $str
     * @return false|int
     */
    function checkEmail($str)
    {
        $pattern = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/";
        return preg_match($pattern, $str);
    }
}


if (!function_exists('checkCoinAddress')) {
    /**
     * Notes:验证提币地址
     * Author: 重设人生 <573914456@qq.com>
     * DataTime: 2021/6/26 3:15
     * @param $address
     * @param string $type
     * @return bool
     */
    function checkCoinAddress($address, $type = "eth")
    {
        if (strtolower($type) == 'eth') {
            // ETH地址合法校验
            if (!(preg_match('/^(0x)?[0-9a-fA-F]{40}$/', $address))) {
                return false;//满足if代表地址不合法
            }
        } elseif (strtolower($type) == 'btc') {
            // BTC地址合法校验
            if (!(preg_match('/^(1|3)[a-zA-Z\d]{24,33}$/', $address) && preg_match('/^[^0OlI]{25,34}$/', $address))) {
                return false; //满足if代表地址不合法
            }
        } elseif (strtolower($type) == 'utit') {
            // UTIT地址合法校验
            if (!(preg_match('/^(uti)?[0-9a-fA-F]{40}$/', $address))) {
                return false; //满足if代表地址不合法
            }
        } elseif (strtolower($type) == 'trx') {
            // TRC地址合法校验
            if (!(preg_match('/^[T][0-9a-zA-Z]{33}$/', $address))) {
                /*if (!(preg_match('/^(T)?[0-9a-zA-Z]{34}$/', $address))) {*/
                return false; //满足if代表地址不合法
            }
        } else {
            return false;
        }
        return true;
    }
}


if (!function_exists('checkLink')) {
    /**
     * 地址验证
     * @param string $link
     * @return false|int
     */
    function checkLink(string $link)
    {
        return preg_match("/^(http|https|ftp):\/\/[A-Za-z0-9]+\.[A-Za-z0-9]+[\/=\?%\-&_~`@[\]\’:+!]*([^<>\”])*$/",
            $link);
    }
}



if (!function_exists('checkMd5')) {
    /**
     * @param $value
     * @return bool
     */
    function checkMd5($value)
    {
        return (bool)preg_match("/^[a-z0-9]{32}$/", $value);
    }

}


if (!function_exists('checkChineseName')) {
    /**
     * @param $value
     * @return bool
     */
    function checkChineseName($value)
    {
        return (bool)preg_match('/^(?:[\u4e00-\u9fa5·]{2,16})$/', $value);
    }

}


if (!function_exists('checkIdCard')) {
    /**
     * @param $value
     * @return bool
     */
    function checkIdCard($value)
    {
        return (bool)preg_match('/(^\d{8}(0\d|10|11|12)([0-2]\d|30|31)\d{3}$)|(^\d{6}(18|19|20)\d{2}(0\d|10|11|12)([0-2]\d|30|31)\d{3}(\d|X|x)$)/', $value);
    }

}

if (!function_exists('checkBankNumber')) {
    /**
     * @param $value
     * @return bool
     */
    function checkBankNumber($value)
    {
        return (bool)preg_match('/^[1-9]\d{9,29}$/', $value);
    }

}

if (!function_exists('checkCard')) {
    /**
     * Notes:身份证验证
     * Author: 重设人生 <573914456@qq.com>
     * DataTime: 2021/6/26 3:22
     * @param $card
     * @return bool
     */
    function checkCard($card)
    {
        $city = [
            11 => "北京",
            12 => "天津",
            13 => "河北",
            14 => "山西",
            15 => "内蒙古",
            21 => "辽宁",
            22 => "吉林",
            23 => "黑龙江 ",
            31 => "上海",
            32 => "江苏",
            33 => "浙江",
            34 => "安徽",
            35 => "福建",
            36 => "江西",
            37 => "山东",
            41 => "河南",
            42 => "湖北 ",
            43 => "湖南",
            44 => "广东",
            45 => "广西",
            46 => "海南",
            50 => "重庆",
            51 => "四川",
            52 => "贵州",
            53 => "云南",
            54 => "西藏 ",
            61 => "陕西",
            62 => "甘肃",
            63 => "青海",
            64 => "宁夏",
            65 => "新疆",
            71 => "台湾",
            81 => "香港",
            82 => "澳门",
            91 => "国外 "
        ];
        $tip = "";
        $match = "/^\d{6}(18|19|20)?\d{2}(0[1-9]|1[012])(0[1-9]|[12]\d|3[01])\d{3}(\d|X)$/";
        $pass = true;
        if (!$card || !preg_match($match, $card)) {
            //身份证格式错误
            $pass = false;
        } else {
            if (!$city[substr($card, 0, 2)]) {
                //地址错误
                $pass = false;
            } else {
                //18位身份证需要验证最后一位校验位
                if (strlen($card) == 18) {
                    $card = str_split($card);
                    //∑(ai×Wi)(mod 11)
                    //加权因子
                    $factor = [7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2];
                    //校验位
                    $parity = [1, 0, 'X', 9, 8, 7, 6, 5, 4, 3, 2];
                    $sum = 0;
                    $ai = 0;
                    $wi = 0;
                    for ($i = 0; $i < 17; $i++) {
                        $ai = $card[$i];
                        $wi = $factor[$i];
                        $sum += $ai * $wi;
                    }
                    $last = $parity[$sum % 11];
                    if ($parity[$sum % 11] != $card[17]) {
                        //                        $tip = "校验位错误";
                        $pass = false;
                    }
                } else {
                    $pass = false;
                }
            }
        }
        if (!$pass) {
            /* 身份证格式错误*/
            return false;
        }
        /* 身份证格式正确*/
        return true;
    }
}

    if (!function_exists('checkExistEmpty')) {
        /**
         * Notes: 验证是否存在空
         * Author: 重设人生 <573914456@qq.com>
         * DataTime: 2022/4/13 11:56
         * @param $str
         * @return bool
         */
        function checkExistEmpty($str){
            return (bool)preg_match("/\s/", $str);
        }
    }
