<?php


namespace Xcy\Hutool;


class StrUtil
{
    /**
     * 检查字符串是否以某些字符串结尾
     *
     * -e.g: phpunit("Str::endsWith", ["你好阿","阿"]);
     * -e.g: phpunit("Str::endsWith", ["你好阿","好阿"]);
     * -e.g: phpunit("Str::endsWith", ["你好阿","你好阿"]);
     * -e.g: phpunit("Str::endsWith", ["你好阿","你好俊阿"]);
     * -e.g: phpunit("Str::endsWith", ["你好阿","你好俊"]);
     * @param  string       $haystack
     * @param  string|array $needles
     * @return bool
     */
    static function endsWith(string $haystack, $needles): bool{
        foreach ((array) $needles as $needle) {
            if ((string) $needle === mb_substr($haystack, -mb_strlen($needle))) {
                return true;
            }
        }
        return false;
    }

    /**
     * 检查字符串是否以某些字符串开头
     *
     * -e.g: phpunit("Str::startsWith", ["你好阿","你好"]);
     * -e.g: phpunit("Str::startsWith", ["你好阿","你"]);
     * -e.g: phpunit("Str::startsWith", ["你好阿","你你你"]);
     *
     * @param  string       $haystack
     * @param  string|array $needles
     * @return bool
     */
    static function startsWith(string $haystack, $needles): bool{
        foreach ((array) $needles as $needle) {
            if ('' != $needle && mb_strpos($haystack, $needle) === 0) {
                return true;
            }
        }
        return false;
    }

    /**
     * 检查字符串中是否包含某些字符串
     *
     * -e.g: phpunit("Str::contains", ["你好阿","你阿"]);
     * -e.g: phpunit("Str::contains", ["你好阿","你你"]);
     * -e.g: phpunit("Str::contains", ["你好阿","你好"]);
     * -e.g: phpunit("Str::contains", ["你好阿",["好","你"]]);
     *
     * @param string       $haystack
     * @param string|array $needles
     *
     * @return bool
     */
    static function contains(string $haystack, $needles): bool{
        foreach ((array) $needles as $needle) {
            if ('' != $needle && mb_strpos($haystack, $needle) !== false) {
                return true;
            }
        }
        return false;
    }

    /**
     * 汉字拆分为数组
     * @param $str
     * @param int $split_length
     * @param string $charset
     * @return array|false|string[]
     */
    static function mbStrSplit($str, $split_length = 1, $charset = "UTF-8")
    {
        if (func_num_args() == 1) {
            return preg_split('/(?<!^)(?!$)/u', $str);
        }
        if ($split_length < 1) return false;
        $len = mb_strlen($str, $charset);
        $arr = array();
        for ($i = 0; $i < $len; $i += $split_length) {
            $s = mb_substr($str, $i, $split_length, $charset);
            $arr[] = $s;
        }
        return $arr;
    }

    /**
     * 往数组中某一个位置，插入一个元素
     * @param $array array 原数组
     * @param $position int 插入第几个元素后面，0为最前面，但不能大于原数组的最大元素数
     * @param $value string 要插入的值
     * @return array
     */
    static function pushArrByPosition(array $array, int $position, string $value): array
    {
        $tmp = array();
        for ($i = 0; $i <= count($array); $i++) {
            if ($i == $position) {
                $tmp[$position] = $value;
            } elseif ($i < $position) {
                $tmp[$i] = $array[$i];
            } else {
                $tmp[$i] = $array[$i - 1];
            }
        }
        return $tmp;
    }

    /**
     * 数字转汉字
     * @param $num
     * @return string
     */
    static function numToWord($num): string
    {
        $chiNum = array('零', '一', '二', '三', '四', '五', '六', '七', '八', '九');
        $chiUni = array('', '十', '百', '千', '万', '亿', '十', '百', '千');
        $num_str = (string)$num;
        $count = strlen($num_str);
        $last_flag = true; //上一个 是否为0
        $zero_flag = true; //是否第一个
        $chiStr = '';//拼接结果
        if ($count == 2) {//两位数
            $temp_num = $num_str[0];
            $chiStr = $temp_num == 1 ? $chiUni[1] : $chiNum[$temp_num] . $chiUni[1];
            $temp_num = $num_str[1];
            $chiStr .= $temp_num == 0 ? '' : $chiNum[$temp_num];
        } else if ($count > 2) {
            $index = 0;
            for ($i = $count - 1; $i >= 0; $i--) {
                $temp_num = $num_str[$i];
                if ($temp_num == 0) {
                    if (!$zero_flag && !$last_flag) {
                        $chiStr = $chiNum[$temp_num] . $chiStr;
                        $last_flag = true;
                    }
                } else {
                    $chiStr = $chiNum[$temp_num] . $chiUni[$index % 9] . $chiStr;
                    $zero_flag = false;
                    $last_flag = false;
                }
                $index++;
            }
        } else {
            $chiStr = $chiNum[$num_str[0]];
        }
        return $chiStr;
    }

    /**
     * 转换一个String字符串为byte数组
     * @param $string string 需要转换的字符
     * @return array
     */
    public static function getBytes(string $string): array
    {
        $bytes = array();

        for ($i = 0; $i < strlen($string); $i++) {
            $bytes[] = ord($string[$i]);
        }
        return $bytes;
    }

    /**
     * 将下划线命名转换为驼峰式命名
     * @param $str
     * @param bool $ucFirst
     * @return string|string[]
     */
    static function convertUnderline($str, $ucFirst = true)
    {
        $str = ucwords(str_replace('_', ' ', $str));
        $str = str_replace(' ', '', lcfirst($str));
        return $ucFirst ? ucfirst($str) : $str;
    }
}
