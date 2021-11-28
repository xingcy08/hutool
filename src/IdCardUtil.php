<?php


namespace Xcy\Hutool;


class IdCardUtil
{
    /**
     * [is_IDCard 验证身份证号码]
     * @param string $idCard
     * @return boolean         [description]
     */
    static function IsIDCard(string $idCard): bool
    {
        return (bool)preg_match("/^[1-9]\d{5}(18|19|([23]\d))\d{2}((0[1-9])|(10|11|12))(([0-2][1-9])|10|20|30|31)\d{3}[0-9Xx]$/", $idCard);
    }

    /**
     * 根据身份证号获取年龄
     * @param string $idCard
     * @return float|int|string|null
     */
    function getAgeByIdCard(string $idCard)
    {
        try {
            if (empty($idCard)) return '';
            $date = strtotime(substr($idCard, 6, 8));
            $today = strtotime('today');
            $diff = floor(($today - $date) / 86400 / 365);
            return strtotime(substr($idCard, 6, 8) . ' +' . $diff . 'years') < $today ? ($diff + 1) : $diff;
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * 获取性别
     * @param string $idCard
     * @return string|null
     */
    function getSexByCreditCode(string $idCard): ?string
    {
        try {
            if (empty($idCard)) return null;
            $sexint = (int)substr($idCard, 16, 1);
            return $sexint % 2 === 0 ? '女' : '男';
        } catch (\Exception $e) {
            return null;
        }
    }
}
