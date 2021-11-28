<?php


namespace Xcy\Hutool;


class JSONUtil
{
    /**
     * 校验是否是json格式
     * @param string $jsonStr
     * @return bool
     */
    static function isJson(string $jsonStr): bool
    {
        if (!is_string($jsonStr)) {
            return false;
        }
        $arr = json_decode($jsonStr, true);
        return is_array($arr);
    }
}
