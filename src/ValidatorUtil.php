<?php

namespace Xcy\Hutool;

class ValidatorUtil
{
    /**
     * desc：验证手机号是否正确
     * @param $m
     * @return bool
     */
    static function isMobile($m): bool
    {
        return (bool)preg_match('/^1[3,4,5,6,7,8,9]{1}\d{9}$/', $m);
    }

    /**
     * 验证邮箱
     * @param string $email
     * @return bool
     */
    static function isEmail(string $email): bool
    {
        return (bool)preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/", $email);
    }

    /**
     * [is_money_times 验证金额是否是100的整数倍]
     * @Author
     * @Date   2019-12-12
     * @param  [type]     $money [金额]
     * @return boolean           [description]
     */
    static function isMoneyTimes($money): bool
    {
        if (!is_numeric($money) || $money <= 0) {
            return false;
        }
        return $money % 100 === 0;
    }

    /**
     * desc：是否是金额
     * author：wh
     * @param $money
     * @return bool
     */
    static function isMoney($money): bool
    {
        return preg_match('/^[0-9]+.[0-9]+$/', $money) || preg_match('/^\d+$/', $money);
    }

    /**
     * desc：是否是小数格式
     * author：wh
     * @param string $num
     * @return bool
     */
    static function isFloatNumber(string $num): bool
    {
        return (bool)preg_match('/^[0-9]+.[0-9]+$/', $num);
    }

    /**
     * desc：是否是数字
     * author：wh
     * @param string $num
     * @return bool
     */
    static function isNumber(string $num): bool
    {
        return (bool)preg_match('/^\d+$/', $num);
    }

    /**
     * desc：是否是字母
     * author： wh
     * @param string $str
     * @return bool
     */
    static function isLetter(string $str): bool
    {
        return (bool)preg_match('/^[a-zA-Z]+$/', $str);
    }

    /**
     * desc：是否字母或数字
     * author：wh
     * @param string $str
     * @return bool
     */
    static function isLetterOrNumber(string $str): bool
    {
        return (bool)preg_match('/^[a-zA-Z|0-9]+$/', $str);
    }

    /**
     * desc：验证数组是否存在空值
     * 仅针对基本数据类型
     * 仅针对一维数组
     * author：wh
     * @param $array
     * @return bool
     */
    static function checkArrayValEmpty($array): bool
    {
        $is_empty = false;
        foreach ($array as $value) {
            if (($value !== 0 && $value !== '0') && empty($value)) {
                $is_empty = true;
                break;
            }
            if (is_int($value) && empty(1 * $value)) {
                $is_empty = true;
                break;
            }
        }
        return $is_empty;
    }

    /**
     * desc：是否是url
     * author：wh
     * @param $v
     * @return bool
     */
    static function isUrl($v): bool
    {
        $pattern = "#(http|https)://(.*\.)?.*\..*#i";
        return (bool)preg_match($pattern, $v);
    }


    /**
     * [是否全部大写]
     *
     * @param $str
     * @return bool
     * @example
     * @see
     * @link
     */
    static function isUpper($str): bool
    {
        return (bool)preg_match('/^[A-Z]+$/', $str);
    }

    /**
     * [是否全部小写]
     *
     * @param $str
     * @return bool
     * @example
     * @see
     * @link
     */
    static function isLower($str): bool
    {
        return (bool)preg_match('/^[a-z]+$/', $str);
    }


    /**
     * desc：验证是微信内还是微信外
     *
     * 是否在微信内，是否在微信中
     *
     * author：wh
     * @return bool
     */
    static function isWechat(): bool
    {
        return strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false;
    }

    /**
     * desc：是否包含特殊字符
     * author：wh
     * @param string $str
     * @return bool
     */
    static function isSpecialCharacter(string $str): bool
    {
        $res = preg_match('/[\Q~!@#$%^&*()+-_=.:?<>\E]/', $str);
        return (bool)$res;
    }

    /**
     * desc：验证字符串是否全部是中文
     *
     * 返回 true表示全部是中文，false表示部分是中文或没有中文
     *
     * author：wh
     * @param string $str
     * @return bool
     */
    static function isAllChinese(string $str): bool
    {
        return (bool)preg_match("/^[\x{4e00}-\x{9fa5}]+$/u", $str);
    }

    /**
     * desc：验证两个浮点数值是否相等
     *
     * 例如：
     *  $num1 = 0.1;
     * $num2 = 0.7;
     *
     * $res = $num1 + $num2;
     *
     * var_dump($res);
     *
     * var_dump($res == 0.8);//false 不相等
     *
     * var_dump(intval(strval($res)) == intval(strval(0.8)));//true 相等
     *
     * author：wh
     * @param $float_num1
     * @param $float_num2
     * @return bool
     */
    static function isEqualNumVal($float_num1, $float_num2): bool
    {

        return intval(strval($float_num1)) == intval(strval($float_num2));
    }

    /**
     * 判断是否为手机端
     *
     * @return boolean
     */
    static function isMobileDevice(): bool
    {
        $result = false;
        if (isset($_SERVER['HTTP_USER_AGENT'])) {
            $clientKeywords = array('nokia', 'sony', 'ericsson', 'mot', 'samsung', 'htc', 'sgh', 'lg', 'sharp',
                'sie-', 'philips', 'panasonic', 'alcatel', 'meizu', 'android', 'netfront', 'symbian',
                'ucweb', 'windowsce', 'palm', 'operamini', 'operamobi', 'openwave', 'nexusone', 'cldc', 'midp', 'wap', 'mobile'
            );
            if (preg_match("/(" . implode('|', $clientKeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT']))) {
                $result = true;
            }
        }
        return $result;
    }
}
