<?php


namespace Xcy\Hutool;

/**
 * 信息脱敏工具
 * 在数据处理或清洗中，可能涉及到很多隐私信息的脱敏工作，因此Hutool针对常用的信息封装了一些脱敏方法。
 * Class DesensitizedUtil
 * @package Xcy\Hutool
 */
class DesensitizedUtil
{
    /**
     * 保密手机号码
     *
     * @param string $mobile
     * @return string
     */
    static function mobilePhone(string $mobile): string
    {
        return preg_replace('/(\d{3})\d{4}(\d{4})/', '$1****$2', $mobile);
    }
}
