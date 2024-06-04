<?php

declare(strict_types=1);

use KenCore\Library\Helper;
use KenCore\Library\Snowflake;
use KenCore\Constants\ErrorCodeEnum;
use KenCore\Exception\ServiceException;
use Hyperf\Snowflake\IdGeneratorInterface;
use Hyperf\Utils\ApplicationContext;
use Hyperf\HttpServer\Contract\RequestInterface;

use Hyperf\AsyncQueue\Driver\DriverFactory;
use Hyperf\AsyncQueue\JobInterface;
use Hyperf\ExceptionHandler\Formatter\FormatterInterface;
use Hyperf\Utils\Context;
use Psr\Http\Message\ServerRequestInterface;
use Ramsey\Uuid\Uuid;

// +----------------------------------------------------------------------
// | QULINKE [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2020 EBACERA All rights reserved.
// +----------------------------------------------------------------------
// | Author: 重设人生 <573914456@qq.com>
// | Date:  2020/12/17 0:44
// +----------------------------------------------------------------------


if (!function_exists('getArrayColumn')) {
    /**
     * 获取数组中指定的列
     * @param $source
     * @param $column
     * @return array
     */
    function getArrayColumn($source, $column)
    {
        $columnArr = [];
        foreach ($source as $item) {
            $columnArr[] = $item[$column];
        }
        return $columnArr;
    }
}

if (!function_exists('getArrayColumns')) {
    /**
     * 获取数组中指定的列
     * @param $source
     * @param $columns
     * @return array
     */
    function getArrayColumns($source, $columns)
    {
        $columnArr = [];
        foreach ($source as $item) {
            $temp = [];
            foreach ($columns as $index) {
                $temp[$index] = $item[$index];
            }
            $columnArr[] = $temp;
        }
        return $columnArr;
    }
}

if (!function_exists('getArrayColumn2Key')) {
    /**
     * 把二维数组中某列设置为key返回
     * @param $source
     * @param $index
     * @return array
     */
    function getArrayColumn2Key($source, $index)
    {
        $data = [];
        foreach ($source as $item) {
            $data[$item[$index]] = $item;
        }
        return $data;
    }
}

if (!function_exists('number2')) {
    function number2($number, $isMinimum = false, $minimum = 0.01)
    {
        $isMinimum && $number = max($minimum, $number);
        return sprintf('%.2f', $number);
    }
}

if (!function_exists('getArrayItemByColumn')) {
    /**
     * Notes:
     * Author: 重设人生 <573914456@qq.com>
     * DataTime: 2021/6/26 4:15
     * @param $array
     * @param $column
     * @param $value
     * @return false|mixed
     */
    function getArrayItemByColumn($array, $column, $value)
    {
        foreach ($array as $item) {
            if ($item[$column] == $value) {
                return $item;
            }
        }
        return false;
    }
}

if (!function_exists('getArrayColumnSum')) {
    function getArrayColumnSum($array, $column)
    {
        $sum = 0;
        foreach ($array as $item) {
            $sum += $item[$column] * 100;
        }
        return $sum / 100;
    }
}


if (!function_exists('setDataAttribute')) {

    function setDataAttribute(&$source, $defaultData, $isArray = false)
    {
        if (!$isArray) {
            $dataSource = [&$source];
        } else {
            $dataSource = &$source;
        }
        foreach ($dataSource as &$item) {
            foreach ($defaultData as $key => $value) {
                $item[$key] = $value;
            }
        }
        return $source;
    }
}


if (!function_exists('verifyIp')) {
    /**
     * Notes:验证ip
     * Author: 重设人生 <573914456@qq.com>
     * DataTime: 2021/6/26 3:18
     * @param $realip
     * @return mixed
     */
    function verifyIp($realip)
    {
        return filter_var($realip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4);
    }
}


if (!function_exists('getClientIp')) {
    /**
     * Notes:获取客户端ip地址
     * Author: 重设人生 <573914456@qq.com>
     * DataTime: 2021/6/26 3:20
     * @return string
     */
    function getClientIp(): string
    {
        try {

            $ip_addr = request()->getHeaderLine('x-forwarded-for');
            if (verifyIp($ip_addr)) {
                return $ip_addr;
            }
            $ip_addr = request()->getHeaderLine('remote-host');
            if (verifyIp($ip_addr)) {
                return $ip_addr;
            }
            $ip_addr = request()->getHeaderLine('x-real-ip');
            if (verifyIp($ip_addr)) {
                return $ip_addr;
            }
            $ip_addr = request()->getServerParams()['remote_addr'] ?? '0.0.0.0';
            if (verifyIp($ip_addr)) {
                return $ip_addr;
            }
        } catch (Throwable $e) {
            return '0.0.0.0';
        }
        return '0.0.0.0';
    }
}


if (!function_exists('DePrice')) {
    /**
     * Notes: 去除多余的0
     * Author: 重设人生 <573914456@qq.com>
     * DateTime: 2020/4/28 5:22
     */
    function DePrice($price, $num = 0)
    {
        if ($num > 0) {
            $p = Helper::bcmul($price, 1, $num);
        } else {
            $p = floatval($price);
        }
        return $p;
    }
}


if (!function_exists('getOrderSn')) {
    /**
     * Notes: 获得订单号
     * Author: 重设人生 <573914456@qq.com>
     * DateTime: 2020/5/18 2:08
     */
    function getOrderSn($unique = "")
    {
        //window下生成订单
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            $orderNo = date('YmdHis') . substr(microtime(), 2, 5) . mt_rand(10000, 99999);
            $orderSn = $orderNo . $unique;
        } else {
            //分布式id
            /*$generator = container()->get(IdGeneratorInterface::class);
            $orderSn = $generator->generate();*/
            //linux下生成订单
            $orderSn = Snowflake::getInstance()->setWorkId(round(1, 1023))->nextId();
        }
        return $orderSn;
    }
}

if (!function_exists('msectime')) {
    /**
     * Notes: 返回当前的毫秒时间戳
     * @return string
     */
    function msectime()
    {
        list($tmp1, $tmp2) = explode(' ', microtime());
        return sprintf('%.0f', (floatval($tmp1) + floatval($tmp2)) * 1000);
    }
}


if (!function_exists('phoneFormat')) {
    /**
     * Notes: 格式化手机号码
     * @param $mobile
     * @return string
     */
    function phoneFormat($mobile)
    {
        return substr($mobile, 0, 3) . "****" . substr($mobile, 7, 4);
    }
}


if (!function_exists('formatPrice')) {
    /**
     * Notes:格式化显示金额保留几位数
     * Author: 重设人生 <573914456@qq.com>
     * DateTime: 2020/7/3 2:27
     */
    function formatPrice($price, $num = 4)
    {
        return number_format($price, $num, '.', '');
    }
}


if (!function_exists('checkArr')) {
    /**
     * Notes: 统一验证
     * Author: 重设人生 <573914456@qq.com>
     * DateTime: 2020/6/4 18:28
     * @param $rs
     * @return bool
     */
    function checkArr($rs)
    {
        foreach ($rs as $v) {
            if (!$v) {
                return false;
            }
        }
        return true;
    }
}


if (!function_exists('listToTree2')) {
    /**
     * Notes:
     * Author: 重设人生 <573914456@qq.com>
     * DataTime: 2020/12/19 2:20
     * @param $cate
     * @param string $field
     * @param string $child
     * @param int $pid
     * @param false $callback
     * @return array
     */
    function list_to_tree2($cate, $field = 'pid', $child = 'child', $pid = 0, $callback = false)
    {
        if (!is_array($cate)) {
            return [];
        }
        $arr = [];
        foreach ($cate as $v) {
            $extra = true;
            if (is_callable($callback)) {
                $extra = $callback($v);
            }
            if ($v[$field] == $pid && $extra) {
                $childList = list_to_tree2($cate, $field, $child, $v['id'], $callback);
                count($childList) > 0 && $v[$child] = $childList;
                $arr[] = $v;
            }
        }
        return $arr;
    }
}


if (!function_exists('getServerLocalIp')) {
    /**
     * getServerLocalIp
     * 获取服务端内网ip地址
     * User：YM
     * Date：2019/12/19
     * Time：下午5:48
     * @return string
     */
    function getServerLocalIp()
    {
        $ip = '127.0.0.1';
        $ips = array_values(swoole_get_local_ip());
        foreach ($ips as $v) {
            if ($v && $v != $ip) {
                $ip = $v;
                break;
            }
        }

        return $ip;
    }
}


if (!function_exists('getOs')) {
    /**
     * @param $agent
     * @return string
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    function getOs($agent): string
    {
        if (false !== stripos($agent, 'win') && preg_match('/nt 6.1/i', $agent)) {
            return 'Windows 7';
        }
        if (false !== stripos($agent, 'win') && preg_match('/nt 6.2/i', $agent)) {
            return 'Windows 8';
        }
        if (false !== stripos($agent, 'win') && preg_match('/nt 10.0/i', $agent)) {
            return 'Windows 10';
        }
        if (false !== stripos($agent, 'win') && preg_match('/nt 11.0/i', $agent)) {
            return 'Windows 11';
        }
        if (false !== stripos($agent, 'win') && preg_match('/nt 5.1/i', $agent)) {
            return 'Windows XP';
        }
        if (false !== stripos($agent, 'linux')) {
            return 'Linux';
        }
        if (false !== stripos($agent, 'mac')) {
            return 'Mac';
        }
        return '未知';
    }
}

if (!function_exists('getBrowser')) {
    /**
     * @param $agent
     * @return string
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    function getBrowser($agent): string
    {
        if (false !== stripos($agent, "MSIE")) {
            return 'MSIE';
        }
        if (false !== stripos($agent, "Edg")) {
            return 'Edge';
        }
        if (false !== stripos($agent, "Chrome")) {
            return 'Chrome';
        }
        if (false !== stripos($agent, "Firefox")) {
            return 'Firefox';
        }
        if (false !== stripos($agent, "Safari")) {
            return 'Safari';
        }
        if (false !== stripos($agent, "Opera")) {
            return 'Opera';
        }
        return '未知';
    }
}

if (!function_exists('ipToRegion')) {
    /**
     * 获取IP的区域地址
     * @param string $ip
     * @return string
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    function ipToRegion(string $ip): string
    {
        $ip2Region = make(\Ip2Region::class);
        if (empty($ip2Region->btreeSearch($ip)['region'])) {
            return '未知';
        }
        $region = $ip2Region->btreeSearch($ip)['region'];
        list($country, $number, $province, $city, $network) = explode('|', $region);
        if ($country == '中国') {
            return $province . '-' . $city . ':' . $network;
        } else {
            if ($country == '0') {
                return '未知';
            } else {
                return $country;
            }
        }
    }
}


if (!function_exists('uuid')) {
    /**
     * Notes:生成uuid
     * Author: 重设人生 <573914456@qq.com>
     * DateTime: 2021/4/29 1:35
     * @param string $prefix
     * @param bool $slash 是否有-
     * @return string
     */
    function getUUID($slash = true, $prefix = '')
    {
        $uuid = $prefix . Uuid::uuid4()->toString();
        return $slash ? $uuid : str_replace('-', '', $uuid);
    }
}

if (!function_exists('handleTreeList')) {
    /**
     * Notes:
     * Author: 重设人生 <573914456@qq.com>
     * DataTime: 2020/12/26 6:03
     * @param array $arr 数组
     * @param int $pid 父级id
     * @param int $depth 增加深度标识
     * @param string $p_sub 父级别名
     * @param string $d_sub 深度别名
     * @param string $c_sub 子集别名
     * @return array
     */
    function handleTreeList($arr, $pid = 0, $depth = 0, $p_sub = 'parent_id', $c_sub = 'children', $d_sub = 'depth')
    {
        $returnArray = [];
        if (is_array($arr) && $arr) {
            foreach ($arr as $k => $v) {
                if ($v[$p_sub] == $pid) {
                    $v[$d_sub] = $depth;
                    $tempInfo = $v;
                    unset($arr[$k]); // 减少数组长度，提高递归的效率，否则数组很大时肯定会变慢
                    $temp = handleTreeList($arr, $v['id'], $depth + 1, $p_sub, $c_sub, $d_sub);
                    if ($temp) {
                        $tempInfo[$c_sub] = $temp;
                    }
                    $returnArray[] = $tempInfo;
                }
            }
        }
        return $returnArray;
    }
}


if (!function_exists('baseUrl')) {

    /**
     * 获取当前域名及根路径
     * @return string
     */
    function baseUrl()
    {
        static $baseUrl = '';
        if (empty($baseUrl)) {
            $request = container()->get(RequestInterface::class);
            $hose = $request->hasHeader('host') ? $request->getHeader('host') : '';
            $baseUrl = scheme() . '://' . $hose;
        }
        return $baseUrl;
    }
}


if (!function_exists('scheme')) {
    /**
     * 当前URL地址中的scheme参数
     * @access public
     * @return string
     */
    function scheme()
    {
        return isSsl() ? 'https' : 'http';
    }
}


if (!function_exists('isSsl')) {
    /**
     * 当前是否ssl
     * @access public
     * @return bool
     */
    function isSsl()
    {

        $server = $_SERVER;
        if (isset($server['HTTPS']) && ('1' == $server['HTTPS'] || 'on' == strtolower($server['HTTPS']))) {
            return true;
        } elseif (isset($server['REQUEST_SCHEME']) && 'https' == $server['REQUEST_SCHEME']) {
            return true;
        } elseif (isset($server['SERVER_PORT']) && ('443' == $server['SERVER_PORT'])) {
            return true;
        } elseif (isset($server['HTTP_X_FORWARDED_PROTO']) && 'https' == $server['HTTP_X_FORWARDED_PROTO']) {
            return true;
        }
        return false;
    }
}


if (!function_exists('formatTreeData')) {
    /**
     * Notes:获取权限列表
     * Author: 重设人生 <573914456@qq.com>
     * DataTime: 2020/12/28 8:12
     * @param $all
     * @param int $parent_id
     * @param int $level
     * @return array
     */
    function formatTreeData(&$all, $parent_id = 0, $level = 1)
    {
        static $tempTreeArr = [];
        //清空静态数组
        if ($parent_id <= 0) {
            $tempTreeArr = [];
        }
        foreach ($all as $key => $val) {
            if ($val['parent_id'] == $parent_id) {
                // 记录深度
                $val['level'] = $level;
                // 根据角色深度处理名称前缀
                $val['title'] = htmlPrefix($level) . $val['title'];
                $tempTreeArr[] = $val;
                formatTreeData($all, $val['id'], $level + 1);
            }
        }
        return $tempTreeArr;
    }
}


if (!function_exists('htmlPrefix')) {
    /**
     * Notes:
     * Author: 重设人生 <573914456@qq.com>
     * DataTime: 2020/12/28 8:12
     * @param $deep
     * @return string
     */
    function htmlPrefix($deep)
    {
        // 根据角色深度处理名称前缀
        $prefix = '';
        if ($deep > 1) {
            for ($i = 1; $i <= $deep - 1; $i++) {
                $prefix .= '&nbsp;&nbsp;&nbsp;├ ';
            }
            $prefix .= '&nbsp;';
        }
        return $prefix;
    }
}


/**
 * 13返回13位时间戳
 */
if (!function_exists('getMillisecond')) {

    function getMillisecond()
    {
        list($t1, $t2) = explode(' ', microtime());
        return (float)sprintf('%.0f', (floatval($t1) + floatval($t2)) * 1000);
    }
}


if (!function_exists('getPhpMillisecond')) {

    /**
     * Notes:13位时间戳（java时间戳）
     * Author: 重设人生 <573914456@qq.com>
     * DataTime: 2021/6/26 4:03
     * @param $time
     * @return float
     */
    function getPhpMillisecond($time)
    {
        return (float)substr($time, 0, 10);
    }
}


if (!function_exists('format_datetime')) {

    /**
     * Notes:格式化多少天前
     * Author: 重设人生 <573914456@qq.com>
     * DateTime: 2021/4/22 19:34
     * @param $date_time
     * @param int $type 1、'Y-m-d H:i:s' 2、时间戳
     * @param string $format
     * @return false|string
     */
    function format_datetime($date_time, $type = 2, $format = '')
    {
        {
            if ($type == 1) {
                $timestamp = strtotime($date_time);
            } elseif ($type == 2) {
                $timestamp = $date_time;
                $date_time = date('Y-m-d H:i:s', $date_time);
            }
            if (!empty($format)) {
                return date($format, $timestamp);
            }
            $difference = time() - $timestamp;
            if ($difference <= 180) {
                return '刚刚';
            } elseif ($difference <= 3600) {
                return ceil($difference / 60) . '分钟前';
            } elseif ($difference <= 86400) {
                return ceil($difference / 3600) . '小时前';
            } elseif ($difference <= 2592000) {
                return ceil($difference / 86400) . '天前';
            } elseif ($difference <= 31536000) {
                return ceil($difference / 2592000) . '个月前';
            } else {
                return ceil($difference / 31536000) . '年前';
                //return $date_time;
            }
        }
    }
}


if (!function_exists('getImgBase64Prefix')) {
    /**
     * Notes:获取base64图片头部前缀
     * Author: 重设人生 <573914456@qq.com>
     * DateTime: 2021/4/29 1:31
     * @return string
     */
    function getImgBase64Prefix()
    {
        return 'data:image/png;base64,';
    }
}


if (!function_exists('getImgToBase64')) {

    /**
     * 获取网络图片的Base64编码
     * $img_url 网络图片地址
     * $hasPre  是否有前缀
     * @return string
     */
    function getImgToBase64($img_url, $hasPre = true)
    {
        $img_base64 = '';
        $imageInfo = getimagesize($img_url);
        if (!$imageInfo) {
            return false;
        }
        $img_base64 = "" . chunk_split(base64_encode(file_get_contents($img_url)));
        if ($hasPre) {
            $img_base64 = 'data:' . $imageInfo['mime'] . ';base64,' . $img_base64;
        }
        return $img_base64;
    }
}


if (!function_exists('bigNumber')) {
    /**
     * Notes:默认的精度为小数点后两位
     * Author: 重设人生 <573914456@qq.com>
     * DataTime: 2021/6/26 4:05
     * @param $number
     * @param int $scale
     * @return// \Moontoast\Math\BigNumber
     */
    /*function bigNumber($number, $scale = 2)
    {
        return new \Moontoast\Math\BigNumber($number, $scale);
    }*/
}


if (!function_exists('getImageUrl')) {

    /**
     * 获取图片的真实地址
     */
    function getImageUrl($image)
    {
        return env('API_URL') . '/storage/' . $image;
    }
}


//获取控制器和方法
/*$action = $this->request->getAttribute(Dispatched::class)->handler->callback;
list($class, $method) = explode('@', $action);
$class = substr(strrchr($class,'\\'),1);*/


if (!function_exists('getMenuTreeList')) {
    /**
     * Notes:获取菜单树列表
     * Author: 重设人生 <573914456@qq.com>
     * DataTime: 2021/7/3 17:06
     * @param $arr
     * @param int $pid
     * @param int $depth
     * @param string $p_sub
     * @param string $c_sub
     * @param string $d_sub
     * @return array
     */
    function getMenuTreeList(
        $arr,
        $pid = 0,
        $depth = 0,
        $p_sub = 'parent_id',
        $c_sub = 'children',
        $d_sub = 'depth'
    ) {
        $returnArray = [];
        if (is_array($arr) && $arr) {
            foreach ($arr as $k => $v) {
                if ($v[$p_sub] == $pid) {
                    $v[$d_sub] = $depth;
                    $tempInfo = $v;
                    unset($arr[$k]); // 减少数组长度，提高递归的效率，否则数组很大时肯定会变慢
                    $temp = getMenuTreeList($arr, $v['id'], $depth + 1, $p_sub, $c_sub, $d_sub);
                    //如果是二级以上路由就添加特殊路由
                    //($tempInfo['menu_type'] == 'M' && $depth>=1 && !empty($temp)) && $tempInfo['component'] = 'ParentView';
                    if ($temp) {
                        //如果是二级以上路由就添加特殊路由
                        //$temp['component'] = 'ParentView';
                        $tempInfo[$c_sub] = $temp;
                    }
                    $returnArray[] = $tempInfo;
                }
            }
        }
        return $returnArray;
    }
}


if (!function_exists('passwordHash')) {
    /**
     * 密码hash加密
     * @param string $password
     * @return false|string|null
     */
    function passwordHash(string $password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }
}


if (!function_exists('getShareCode')) {
    /**
     * Notes: 获得用户推荐码
     * Author: 重设人生 <573914456@qq.com>
     * DataTime: 2021/9/4 6:35
     * @return string
     */
    function getShareCode()
    {
        //return strtoupper(sprintf('%x', crc32(microtime())));
        $code = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $rand = $code[rand(0, 25)] . strtoupper(dechex((int)date('m'))) . date('d') . substr((string)time(),
                -5) . substr(microtime(), 2, 5) . sprintf('%02d', rand(0, 99));
        for (
            $a = md5($rand, true),
            $s = '0123456789ABCDEFGHIJKLMNOPQRSTUV',
            $d = '',
            $f = 0;
            $f < 8;
            $g = ord($a[$f]),
            $d .= $s[($g ^ ord($a[$f + 8])) - $g & 0x1F],
            $f++
        ) {
            ;
        }
        return $d;
    }
}


if (!function_exists('getApiSign')) {
    /**
     *
     * https://www.jb51.net/article/187421.htm
     * Notes: 获取sign
     * Author: 重设人生 <573914456@qq.com>
     * DataTime: 2021/8/31 18:54
     * @param $secret
     * @param $data
     * @return string
     */
    function getApiSign($secret, $data)
    {

        /*$key = "c4ca4238a0b923820dcc509a6f75849b";
        $secret = "28c8edde3d61a0411511d3b1866f0636";
        // 待发送的数据包
        $data = array(
            'username' => 'abc@qq.com',
            'sex' => '1',
            'age' => '16',
            'addr' => 'guangzhou',
            'key' => $key,
            'timestamp' => time(),
        );
        // 发送的数据加上sign
        $data['sign'] = getApiSign($secret, $data);
        $res = verifyApiSign($secret,$data);*/
        // 对数组的值按key排序
        ksort($data);
        // 生成url的形式
        $params = http_build_query($data);
        // 生成sign
        $sign = md5($params . $secret);
        return $sign;
    }

}


if (!function_exists('verifyApiSign')) {

    /**
     * Notes: 后台验证sign是否合法
     * Author: 重设人生 <573914456@qq.com>
     * DataTime: 2023/6/18 16:02
     * @param $secret
     * @param $data
     * @return bool
     * @throws ServiceException
     */
    function verifyApiSign($secret, $data)
    {
        // 验证参数中是否有签名
        if (!isset($data['sign']) || !$data['sign']) {
            throw new ServiceException('发送的数据签名不存在');
        }
        if (!isset($data['timestamp']) || !$data['timestamp']) {
            throw new ServiceException('发送的数据参数不合法');
        }
        // 验证请求， 10分钟失效
        if (time() - $data['timestamp'] > 600) {
            throw new ServiceException('签名失效， 请重新发送请求');
        }
        $sign = $data['sign'];
        unset($data['sign']);
        ksort($data);
        //特殊字符转义
        $params = urldecode(http_build_query($data));
        // $secret是通过key在api的数据库中查询得到
        $sign2 = md5($params . $secret);
        if ($sign == $sign2) {
            return true;
        } else {
            throw new ServiceException('请求不合法');
        }
    }
}


if (!function_exists('dataAuthCodeEncryption')) {

    /**
     * Notes: 数据加密解密
     * Author: 重设人生 <573914456@qq.com>
     * DataTime: 2021/9/4 6:35
     * @param $string
     * @param string $operation
     * @param int $expiry
     * @return false|string
     */
    function dataAuthCodeEncryption($string, $operation = 'DECODE', $expiry = 0)
    {
        //数据加密秘钥
        $key = env('ENCRYPTION_KEY', '');
        $ckey_length = 4;
        $key = md5($key);
        $keya = md5(substr($key, 0, 16));
        $keyb = md5(substr($key, 16, 16));
        $keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length) : substr(md5(microtime()),
            -$ckey_length)) : '';
        $cryptkey = $keya . md5($keya . $keyc);
        $key_length = strlen($cryptkey);
        $string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d',
                $expiry ? $expiry + time() : 0) . substr(md5($string . $keyb), 0, 16) . $string;
        $string_length = strlen($string);
        $result = '';
        $box = range(0, 255);
        $rndkey = array();
        for ($i = 0; $i <= 255; $i++) {
            $rndkey[$i] = ord($cryptkey[$i % $key_length]);
        }
        for ($j = $i = 0; $i < 256; $i++) {
            $j = ($j + $box[$i] + $rndkey[$i]) % 256;
            $tmp = $box[$i];
            $box[$i] = $box[$j];
            $box[$j] = $tmp;
        }
        for ($a = $j = $i = 0; $i < $string_length; $i++) {
            $a = ($a + 1) % 256;
            $j = ($j + $box[$a]) % 256;
            $tmp = $box[$a];
            $box[$a] = $box[$j];
            $box[$j] = $tmp;
            $result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
        }
        if ($operation == 'DECODE') {
            if ((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10,
                    16) == substr(md5(substr($result, 26) . $keyb), 0, 16)) {
                return substr($result, 26);
            } else {
                return '';
            }
        } else {
            return $keyc . str_replace('=', '', base64_encode($result));
        }

        /*//以下是调用示例：
        $key= '123456';  //加密密钥
        $a01 =  base64_encode(authcode("cube uniform injury unaware distance drift budget excuse retreat tourist misery afraid",'ENCODE',$key,0)); //加密
        echo "php版本加密：".$a01."<br>";  //输出的是加密文件
        $url =  authcode(base64_decode("M2ZiY0dzaFNOclN1RmsrOWxPT3R4VlhUYVl0eC83THh0ZTJUWXMrQkdyUnF3aTBFNTdtQVFvRi9EQWFVQjVHQ3ZkVERadk8wcGpadFRBRlczdUhsWXJjNEN0SndUY2oxZnpWbGUzd1crb1ZDcXcwTit0cXB2NnZ2dnd1SWphcS9VY0ZOTUVSR2tZdWZZM09ZekIzbnVGQVdvZw=="),'DECODE',$key,0); //解密
        echo "php版本解密：".$url ;  //输出的解密文件*/
    }
}


if (!function_exists('formatAddress')) {
    /**
     * 格式化地址
     * @param $mobile
     * @return string
     */
    function formatAddress($address)
    {
        return substr($address, 0, 6) . "****" . substr($address, -6);
    }
}


if (!function_exists('diffBetweenTwoDays')) {

    /**
     * 求两个日期之间相差的天数
     * (针对1970年1月1日之后，求之前可以采用泰勒公式)
     * @param string $day1
     * @param string $day2
     * @return number
     */
    function diffBetweenTwoDays($second1, $second2)
    {
        if ($second1 < $second2) {
            $tmp = $second2;
            $second2 = $second1;
            $second1 = $tmp;
        }
        return round(abs($second1 - $second2) / 86400);
    }
}


if (!function_exists('camelize')) {
    /**
     * 下划线转驼峰
     * 思路:
     * step1.原字符串转小写,原字符串中的分隔符用空格替换,在字符串开头加上分隔符
     * step2.将字符串中每个单词的首字母转换为大写,再去空格,去字符串首部附加的分隔符.
     * Author: 重设人生 <573914456@qq.com>
     * DataTime: 2021/9/23 9:45
     * @param $uncamelized_words
     * @param string $separator
     * @return string
     */
    function camelize($uncamelized_words, $separator = '_')
    {
        $uncamelized_words = $separator . str_replace($separator, " ", strtolower($uncamelized_words));
        return ltrim(str_replace(" ", "", ucwords($uncamelized_words)), $separator);
    }
}


if (!function_exists('unCamelize')) {
    /**
     * 驼峰命名转下划线命名
     * 思路:
     * 小写和大写紧挨一起的地方,加上分隔符,然后全部转小写
     * Author: 重设人生 <573914456@qq.com>
     * DataTime: 2021/9/23 9:46
     * @param $camelCaps
     * @param string $separator
     * @return string
     */
    function unCamelize($camelCaps, $separator = '_')
    {
        return strtolower(preg_replace('/([a-z])([A-Z])/', "$1" . $separator . "$2", $camelCaps));
    }
}


if (!function_exists('getPlatform')) {
    /**
     * Notes: 获取来源
     * Author: 重设人生 <573914456@qq.com>
     * DataTime: 2021/9/24 15:44
     * @return string
     */
    function getPlatform()
    {
        return request()->getHeader('platform')[0] ?? '';
    }
}


if (!function_exists('getAgent')) {
    /**
     * Notes: 获取浏览器类型
     * Author: 重设人生 <573914456@qq.com>
     * DataTime: 2021/12/13 16:25
     * @return bool
     */
    function getAgent()
    {
        return request()->getHeader('user-agent')[0] ?? '';
    }
}


if (!function_exists('isWeixin')) {
    /**
     * Notes: 是否微信浏览器
     * Author: 重设人生 <573914456@qq.com>
     * DataTime: 2021/12/13 16:25
     * @return bool
     */
    function isWeixin()
    {
        $userAgent = getAgent();
        if (strpos($userAgent, 'MicroMessenger') !== false) {
            return true;
        }
        return false;
    }
}


//mac docker手动加点时间
if (!function_exists('getCurrentTime')) {

    /**
     * 当前时间
     * @return bool
     */
    function getCurrentTime()
    {
        $time = time();
        return $time;
    }
}

if (!function_exists('getFormatTime')) {
    /**
     * Notes: 格式化时间戳
     * Author: 重设人生 <573914456@qq.com>
     * DataTime: 2021/10/2 15:03
     * @param $time
     * @return false|string
     */
    function getFormatTime($time)
    {
        return (!empty($time) && intval($time) > 0) ? date('Y/m/d H:i:s', $time) : '--';
    }
}


if (!function_exists('getFirstUserId')) {
    /**
     * Notes: 顶级用户id
     * Author: 重设人生 <573914456@qq.com>
     * DataTime: 2022/6/30 1:35
     * @param $time
     * @return false|string
     */
    function getFirstUserId()
    {
        //return 1;
        return 10000;
    }
}

if (!function_exists('encryptData')) {

    /*$text = 'a=1&b=2&c=3';            // 参数串
    $key = 'abcd1234';                // 密钥
    echo encryptData($text, $key);    // 加密*/

    /**
     * 字符串加密（加密方法：DES-ECB）
     * @param string $input 待加密字符串
     * @param string $key 对称加密密钥
     * @return string
     */
    function encryptData($input, $key)
    {
        $ivlen = openssl_cipher_iv_length('DES-ECB');    // 获取密码iv长度
        $iv = openssl_random_pseudo_bytes($ivlen);        // 生成一个伪随机字节串
        $data = openssl_encrypt($input, 'DES-ECB', $key, $options = OPENSSL_RAW_DATA, $iv);    // 加密
        return bin2hex($data);
    }
}


if (!function_exists('getDefCoinId')) {

    /**
     * Notes: 默认币种id【CSJ】
     * Author: 重设人生 <573914456@qq.com>
     * DataTime: 2022/9/9 21:52
     * @param $input
     * @param $key
     */
    function getDefCoinId()
    {
        $coinId = 1;
        return $coinId;
    }
}


if (!function_exists('getUsdtCoinId')) {
    /**
     * Notes: usdt币id
     * Author: 重设人生 <573914456@qq.com>
     * DataTime: 2021/12/13 16:25
     * @return bool
     */
    function getUsdtCoinId()
    {
        $coinId = 2;
        return $coinId;
    }
}


if (!function_exists('NumToStr')) {

    //出现科学计数法，还原成字符串
    function NumToStr($num)
    {
        $parts = explode('E', (string)$num);
        if (count($parts) != 2) {
            return $num;
        }
        $exp = abs(end($parts)) + 3;
        $decimal = number_format($num, $exp);
        $decimal = rtrim($decimal, '0');
        return rtrim($decimal, '.');
    }
}


if (!function_exists('ethToWei')) {
    /**
     * Notes: 金额放大
     * Author: 重设人生 <573914456@qq.com>
     * DataTime: 2021/9/7 17:10
     * @param $balanceAmount
     * @param int $scale
     * @return string|null
     */
    function ethToWei($balanceAmount)
    {
        //return Helper::bcmul($balanceAmount, '1000000000000000000', $scale);
        $bnq = \Web3\Utils::toWei((string)$balanceAmount, 'ether');
        return Web3\Utils::toString($bnq);
    }
}

if (!function_exists('weiToEth')) {
    /**
     * Notes: 金额缩小
     * Author: 重设人生 <573914456@qq.com>
     * DataTime: 2021/9/7 17:10
     * @param $balanceAmount
     * @param int $scale
     * @return string|null
     */
    function weiToEth($balanceAmount, $scale = 18)
    {
        return Helper::bcdiv($balanceAmount, '1000000000000000000', $scale);
        /*list($bnq, $bnr) = \Web3\Utils::fromWei((string)$balanceAmount, 'ether');
        return \Web3\Utils::toString($bnq);*/
    }
}


if (!function_exists('object_to_array')) {
    /**
     * 对象 转 数组
     *
     * @param object $obj 对象
     * @return array
     */
    function object_to_array($obj)
    {
        $obj = (array)$obj;
        foreach ($obj as $k => $v) {
            if (gettype($v) == 'resource') {
                return;
            }
            if (gettype($v) == 'object' || gettype($v) == 'array') {
                $obj[$k] = (array)object_to_array($v);
            }
        }

        return $obj;
    }
}

if (!function_exists('array_to_object')) {
    /**
     * 数组 转 对象
     *
     * @param array $arr 数组
     * @return object
     */
    function array_to_object($arr)
    {
        if (gettype($arr) != 'array') {
            return;
        }
        foreach ($arr as $k => $v) {
            if (gettype($v) == 'array' || getType($v) == 'object') {
                $arr[$k] = (object)array_to_object($v);
            }
        }

        return (object)$arr;
    }
}


if (!function_exists('getParam')) {

    /**
     * Notes: 获取数组的下标值
     * Author: 重设人生 <573914456@qq.com>
     * DataTime: 2022/10/9 12:56
     * @param $data
     * @param $field
     * @param string $default
     * @return mixed|string
     */
    function getParam($data, $field, $default = '')
    {
        $result = $default;
        if (isset($data[$field])) {
            $result = $data[$field];
        }
        return $result;
    }
}

if (!function_exists('getArrayPick')) {
    /**
     * 从object中选取属性
     * @param $source
     * @param array $columns
     * @return array
     */
    function getArrayPick($source, array $columns)
    {
        $dataset = [];
        foreach ($source as $key => $item) {
            in_array($key, $columns) && $dataset[$key] = $item;
        }
        return $dataset;
    }
}


if (!function_exists('ethToWei')) {
    /**
     * Notes: 金额放大
     * Author: 重设人生 <573914456@qq.com>
     * DataTime: 2021/9/7 17:10
     * @param $balanceAmount
     * @param int $scale
     * @return string|null
     */
    function ethToWei($balanceAmount)
    {
        //return Helper::bcmul($balanceAmount, '1000000000000000000', $scale);
        $bnq = \Web3\Utils::toWei((string)$balanceAmount, 'ether');
        return Web3\Utils::toString($bnq);
    }
}

if (!function_exists('weiToEth')) {
    /**
     * Notes: 金额缩小
     * Author: 重设人生 <573914456@qq.com>
     * DataTime: 2021/9/7 17:10
     * @param $balanceAmount
     * @param int $scale
     * @return string|null
     */
    function weiToEth($balanceAmount, $scale = 18)
    {
        return Helper::bcdiv($balanceAmount, '1000000000000000000', $scale);
        /*list($bnq, $bnr) = \Web3\Utils::fromWei((string)$balanceAmount, 'ether');
        return \Web3\Utils::toString($bnq);*/
    }
}

if (!function_exists('isSuperAdmin')) {
    /**
     * 是否为超级管理员
     * @return bool
     */
    function isSuperAdmin($adminId): bool
    {
        return env('SUPER_ADMIN_ID') == $adminId;
    }
}


if (!function_exists('user')) {
    /**
     * Notes: 获取当前登录的用户
     * Author: 重设人生 <573914456@qq.com>
     * DataTime: 2023/3/26 0:41
     * @param string|null $field
     * @return array|mixed|\Qbhy\HyperfAuth\Authenticatable|null
     */
    function user(?string $field = null)
    {
        $jwtData = [];
        $token = getUserToken();
        try {
            $jwtData = jwtManager()->user($token);
        } catch (\Exception $exception) {
            logger()->info('jwt获取登录用户数据失败：' . $exception->getMessage());
        }
        // () && $jwtData = $jwtData[$field];
        !empty($field) && $jwtData = $jwtData[$field] ?? '';
        return $jwtData;
    }
}

if (!function_exists('getUserToken')) {
    /**
     * Notes: 获取当前用户token
     * Author: 重设人生 <573914456@qq.com>
     * DataTime: 2023/3/26 0:24
     * @return mixed|string
     */
    function getUserToken()
    {
        $prefix = 'Bearer';
        $token = request()->getHeader('Authorization')[0] ?? '';
        if (strlen($token) > 0) {
            $token = ucfirst($token);
            $arr = explode($prefix . ' ', $token);
            $token = $arr[1] ?? '';
        }
        try {
            if (strlen($token) > 0 && jwtManager()->check($token)) {
                return $token;
            }
        } catch (\Exception $e) {
            logger()->info($e->getMessage());
            throw new ServiceException(
                ErrorCodeEnum::getMessage(ErrorCodeEnum::ERR_INVALID_TOKEN),
                ErrorCodeEnum::ERR_INVALID_TOKEN
            );
        }
        return '';
    }
}


if (!function_exists('lang')) {
    /**
     * 获取国际化语言
     * @return bool
     */
    function lang($key, $lang = '')
    {
        if (empty($lang)) {
            $lang = request()->getHeader('lang')[0] ?? 'cn';
        }
        return trans("messages.$key", [], $lang);
    }
}


if (!function_exists('getUsdtCoinId')) {
    /**
     * Notes: usdt币id
     * Author: 重设人生 <573914456@qq.com>
     * DataTime: 2021/12/13 16:25
     * @return bool
     */
    function getUsdtCoinId()
    {
        $coinId = 2;
        return $coinId;
    }
}


if (!function_exists('getBnbCoinId')) {
    /**
     * Notes: bnb币id
     * Author: 重设人生 <573914456@qq.com>
     * DataTime: 2021/12/13 16:25
     * @return bool
     */
    function getBnbCoinId()
    {
        $coinId = 1;
        return $coinId;
    }
}

if (!function_exists('getSpdCoinId')) {
    /**
     * Notes: SPD币id
     * Author: 重设人生 <573914456@qq.com>
     * DataTime: 2021/12/13 16:25
     * @return bool
     */
    function getSpdCoinId()
    {
        $coinId = 3;
        return $coinId;
    }
}