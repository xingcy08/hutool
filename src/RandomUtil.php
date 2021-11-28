<?php


namespace Xcy\Hutool;


use Xcy\Hutool\Libs\RandomNameUtil;

class RandomUtil
{
    /**
     * 生成随机字符(验证码)
     *
     * @param integer $len
     * @param boolean $onlyDigit <false> 是否纯数字，默认包含字母
     * @return string
     */
    static function randomCode(int $len = 6, bool $onlyDigit = false): string
    {
        $char = '1234567890';
        if ($onlyDigit === false) {
            $char .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        }
        return substr(str_shuffle(str_repeat($char, $len)), 0, $len);
    }

    /**
     * mt_rand增强版（兼容js版Math.random)
     *
     * @param integer $min
     * @param integer $max
     * @param boolean $decimal <false> 是否包含小数
     * @return float|int
     * @throws \Exception
     */
    static function mathRandom(int $min = 0, int $max = 1, bool $decimal = false)
    {
        if ($max < $min) {
            throw new \Exception("mathRandom(): max({$max}) is smaller than min({$min}).");
        }
        $range = mt_rand($min, $max);
        if ($decimal && $min < $max) {
            $_ = lcg_value();
            while ($_ < 0.1) {
                $_ *= 10;
            }
            $range += $_;
            if ($range > $max) {
                $range -= 1;
            }
        }
        return $range;
    }

    /**
     * 随机生成马甲昵称
     *
     * @return string
     */
    static function randomNickName():string{
        return RandomNameUtil::getNickName();
    }

    /**
     * 随机生成女名
     *
     * @param boolean $surName <true> 是不包含复姓，如“上官” “司马”
     * @return string
     * @throws \Exception
     */
    static function randomFemaleName(bool $surName = true):string{
        return RandomNameUtil::getFemaleName($surName);
    }

    /**
     * 随机生成男名
     *
     * @param boolean $surName <true> 是不包含复姓，如“上官” “司马”
     * @return string
     * @throws \Exception
     */
    static function randomMaleName(bool $surName = true):string{
        return RandomNameUtil::getMaleName($surName);
    }

    /**
     * 随机生成汉字
     * @param $num
     * @return string
     */
    static function randomChar($num): string
    {
        $b = '';
        for ($i = 0; $i < $num; $i++) {
            // 使用chr()函数拼接双字节汉字，前一个chr()为高位字节，后一个为低位字节
            $a = chr(mt_rand(0xB0, 0xD0)) . chr(mt_rand(0xA1, 0xF0));
            // 转码
            $b .= iconv('GB2312', 'UTF-8', $a);
        }
        return $b;
    }
}
