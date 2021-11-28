<?php


namespace Xcy\Hutool;

/**
 * 日期时间处理类
 * Class Date
 * @package Xcy\Hutool
 */
class DateUtil
{
    //时间默认返回格式
    public $date_format = 'Y-m-d H:i:s';

    //分、时、天、周、月、年
    protected $data_type = [
        'm' => 'minute',//分钟
        'minute' => 'minute',//分钟
        'h' => 'hour',//小时
        'hour' => 'hour',//小时
        'd' => 'day',//天
        'day' => 'day',//天
        'w' => 'week',//周
        'week' => 'week',//周
        'M' => 'month',//月
        'month' => 'month',//月
        'y' => 'year',//年
        'year' => 'year',//年
    ];

    //秒、分、时、天
    protected $time_type = [
        's' => 1,//秒
        'second' => 1,//秒
        'm' => 60,//分钟
        'minute' => 60,//分钟
        'h' => 3600,//小时
        'hour' => 3600,//小时
        'd' => 86400,//天
        'day' => 86400,//天
    ];

    /**
     * desc：日期时间加N
     * author：wh
     * @param int $times 相加的时间数量 整型
     * @param string $date_type 要相加的时间类型 可选值：m 分钟；h 小时；d 天；w 周；M 月；y 年
     * @param int $default_time 时间戳，默认当前时间
     * @return false|string 返回$this->date_format格式，可根据需要设定格式
     */
    function addTime(int $times, string $date_type, int $default_time = 0)
    {
        return date($this->date_format, strtotime("+{$times} {$this->data_type[$date_type]}",
            $default_time ?: time()));
    }

    /**
     * desc：日期时间减N
     * author：wh
     * @param int $times 减去的时间数量 整型
     * @param string $date_type 要相减的时间类型 可选值：m 分钟；h 小时；d 天；w 周；M 月；y 年
     * @param int $default_time 时间戳，默认当前时间
     * @return false|string 返回$this->date_format格式，可根据需要设定格式
     */
    function reduceTime(int $times, string $date_type, int $default_time = 0)
    {
        return date($this->date_format, strtotime("-{$times} {$this->data_type[$date_type]}", $default_time ? $default_time : time()));
    }

    /**
     * desc：日期时间相减，通常结束时间大于开始时间
     * author：wh
     * @param string $end_time 结束时间
     * @param string $start_time 开始时间
     * @param string $return_type 日期时间相减后得到的时间类型，可能是小数。可选值：s 秒；m 分钟；h 小时；d；天
     * @return float|int 返回计算后的天、时、分、秒数
     */
    function timeReduceTime(string $end_time, string $start_time, string $return_type = 's')
    {
        return (strtotime($end_time) - strtotime($start_time)) / $this->time_type[$return_type];
    }

    /**
     * desc：日期减日期, 返回月数或年数
     *
     * author：wh
     * @param string $start_time 开始时间
     * @param string $end_time 结束时间
     * @param string $return_type M 返回一共有多少个月，y 返回有多少个年
     * @return float|int
     */
    function dateCutDate(string $start_time, string $end_time, string $return_type = 'M')
    {
        $e = date_create($end_time);

        $s = date_create($start_time);

        $diff = date_diff($e, $s);

        //计算月份
        if ($diff->y > 0) {
            $m = $diff->y * 12 + $diff->m;
        } else {
            $m = $diff->m;
        }
        return $return_type == 'M' ? $m : $diff->y;
    }

    /**
     * desc：日期相减得到月数
     * 注意：不是计算的时间戳，而是计算的月份差值
     * author：wh
     * @param string $start_time
     * @param string $end_time
     * @return false|float|int|string
     */
    function dateCutMonth(string $start_time, string $end_time)
    {
        $start_y = date('Y', strtotime($start_time));
        $end_y = date('Y', strtotime($end_time));
        $start_m = date('m', strtotime($start_time));
        $end_m = date('m', strtotime($end_time));
        $ym = ($end_y - $start_y) * 12;
        return $ym - $start_m + $end_m;
    }

    /**
     * desc：日期相减得到年数
     * 注意：不是计算的时间戳，而是计算的年份差值
     * author：wh
     * @param string $start_time
     * @param string $end_time
     * @return float|int
     */
    function dateCutYear(string $start_time, string $end_time)
    {
        $start_y = date('Y', strtotime($start_time));
        $end_y = date('Y', strtotime($end_time));
        return ($end_y - $start_y) * 12;
    }

    /**
     * desc：返回年中第几天
     * author：wh
     * @param string $month 指定月份
     * @param string $day 指定日
     * @param string $year 指定年份
     * @return false|string
     */
    function getDayYear(string $month, string $day, string $year)
    {
        return date('z', mktime(0, 0, 0, $month, $day, $year));
    }

    /**
     * desc：今天的开始时间
     * author：wh
     * @return false|string
     */
    function beginToday()
    {
        return date('Y-m-d') . ' 00:00:00';
    }

    /**
     * desc：今天的结束时间
     * author：wh
     * @return false|string
     */
    function endToday()
    {
        return date('Y-m-d') . ' 23:59:59';
    }

    /**
     * desc：昨天的开始时间
     * author：wh
     * @return string
     */
    function beginYesterday()
    {
        return date('Y-m-d', strtotime('-1 day')) . ' 00:00:00';
    }

    /**
     * desc：昨天的结束时间
     * author：wh
     * @return string
     */
    function endYesterday()
    {
        return date('Y-m-d', strtotime('-1 day')) . ' 23:59:59';
    }

    /**
     * desc：前天的开始时间
     * author：wh
     * @return string
     */
    function beginBeforeYesterday()
    {
        return date('Y-m-d', strtotime('-2 day')) . ' 00:00:00';
    }

    /**
     * desc：前天的结束时间
     * author：wh
     * @return string
     */
    function endBeforeYesterday()
    {
        return date('Y-m-d', strtotime('-2 day')) . ' 23:59:59';
    }

    /**
     * 本周的开始日期
     *
     * @param bool $His 是否展示时分秒 默认true
     *
     * @return false|string
     */
    function beginWeek($His = true)
    {
        $timestamp = mktime(0, 0, 0, date('m'), date('d') - date('w') + 1, date('Y'));
        return $His ? date('Y-m-d H:i:s', $timestamp) : date('Y-m-d', $timestamp);
    }

    /**
     * 本周的结束日期
     *
     * @param bool $His 是否展示时分秒 默认true
     *
     * @return false|string
     */
    function endWeek($His = true)
    {
        $timestamp = mktime(23, 59, 59, date('m'), date('d') - date('w') + 7, date('Y'));
        return $His ? date('Y-m-d H:i:s', $timestamp) : date('Y-m-d', $timestamp);
    }

    /**
     * desc：上周开始
     * author：wh
     * @return false|string
     */
    function beginBeforeWeek()
    {

        return date('Y-m-d', strtotime('-1 monday', time())) . ' 00:00:00';//上周一，无论今天几号,-1 monday为上一个有效周未
    }

    /**
     * desc：上周结束
     * author：wh
     * @return false|string
     */
    function endBeforeWeek()
    {
        return date('Y-m-d', strtotime('-1 sunday', time())) . ' 23:59:59'; //上一个有效周日,同样适用于其它星期
    }

    /**
     * 本月的开始日期
     *
     * @param bool $His 是否展示时分秒 默认true
     *
     * @return false|string
     */
    function beginMonth($His = true)
    {
        return $His ? date('Y-m-') . '01 00:00:00' : date('Y-m-') . '01';
    }

    /**
     * 本月的结束日期
     *
     * @param bool $His 是否展示时分秒 默认true
     *
     * @return false|string
     */
    function endMonth($His = true)
    {
        $timestamp = mktime(23, 59, 59, date('m'), date('t'), date('Y'));
        return $His ? date('Y-m-d H:i:s', $timestamp) : date('Y-m-d', $timestamp);
    }

    /**
     * desc：上月开始时间（上月一日）
     * author：wh
     * @return false|string
     */
    function beginBeforeMonth()
    {
        return date('Y-m-d', strtotime('-1 month', strtotime(date('Y-m', time()) . '-01 00:00:00'))) . ' 00:00:00'; //本月一日直接strtotime上减一个月
    }

    /**
     * desc：上月结束时间（上月最后一日）
     * author：wh
     * @return false|string
     */
    function endBeforeMonth()
    {
        return date('Y-m-d', strtotime(date('Y-m', time()) . '-01 00:00:00') - 86400) . ' 23:59:59'; //本月一日减一天即是上月最后一日
    }

    /**
     * desc：七天(一周)以内
     * author：wh
     * @return false|string
     */
    function innerWeekDay()
    {
        $time = time();
        //当前时间减去30天
        $second = $time - 7 * 86400;
        return date('Y-m-d', $second);
    }

    /**
     * desc：一月以内
     * author：wh
     * @return false|string
     */
    function innerMonth()
    {
        $time = time();
        //当前时间减去30天
        $second = $time - 30 * 86400;
        return date('Y-m-d', $second);
    }

    /**
     * desc：一年以内
     * author：wh
     * @return false|string
     */
    function innerYear()
    {
        $time = time();
        //当前时间减去30天
        $second = $time - 365 * 86400;
        return date('Y-m-d', $second);
    }

    /**
     * 几年的开始日期
     *
     * @param bool $His 是否展示时分秒 默认true
     *
     * @return false|string
     */
    function beginYear($His = true)
    {
        $timestamp = date('Y');
        return $His ? $timestamp . '-01-01 00:00:00' : $timestamp . '-01-01';
    }

    /**
     * 几年的结束日期
     *
     * @param bool $His 是否展示时分秒 默认true
     *
     * @return false|string
     */
    function endYear($His = true)
    {
        $timestamp = date('Y');
        return $His ? $timestamp . '-12-31 23:59:59' : $timestamp . '-12-31';
    }

    /**
     * 获取毫秒时间戳
     * @return float
     */
    public static function getMillisecondTime(): float
    {
        list($msec, $sec) = explode(' ', microtime());
        return (float)sprintf('%.0f', (floatval($msec) + floatval($sec)) * 1000);
    }
}
