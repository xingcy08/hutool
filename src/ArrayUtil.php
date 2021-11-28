<?php


namespace Xcy\Hutool;


class ArrayUtil
{
    /**
     * 数组转XML
     *
     * -e.g: $arr=[];
     * -e.g: $arr[]=["name"=>"张叁","roomId"=> "2-2-301", "carPlace"=> ["C109","C110"] ];
     * -e.g: $arr[]=["name"=>"李思","roomId"=> "9-1-806", "carPlace"=> ["H109"] ];
     * -e.g: $arr[]=["name"=>"王武","roomId"=> "9-1-807", "carPlace"=> [] ];
     * -e.g: phpunit("Tools::arrayToXml", [$arr]);
     *
     * @param array $input 数组
     * @param bool $root
     *
     * @return string
     */
    static public function toXml(array $input, bool $root = true): string
    {
        $str = "";
        if ($root) $str .= "<xml>";
        foreach ($input as $key => $val) {
            if (is_array($val)) {
                $child = self::toXml($val, false);
                $str .= "<$key>$child</$key>";
            } else {
                $str .= "<$key><![CDATA[$val]]></$key>";
            }
        }
        if ($root) $str .= "</xml>";
        return $str;
    }

    /**
     * 数组转无限级分类
     *
     * -e.g: $list=[];
     * -e.g: $list[]=["id"=>1,    "pid"=>0,   "name"=>"中国大陆"];
     * -e.g: $list[]=["id"=>2,    "pid"=>1,   "name"=>"北京"];
     * -e.g: $list[]=["id"=>22,   "pid"=>1,   "name"=>"广东省"];
     * -e.g: $list[]=["id"=>54,   "pid"=>2,   "name"=>"北京市"];
     * -e.g: $list[]=["id"=>196,  "pid"=>22,  "name"=>"广州市"];
     * -e.g: $list[]=["id"=>1200, "pid"=>54,  "name"=>"海淀区"];
     * -e.g: $list[]=["id"=>3907, "pid"=>196, "name"=>"黄浦区"];
     * -e.g: phpunit("Tools::arrayToTree", [$list, "id", "pid", "child", 0]);
     *
     * @param array $list 归类的数组
     * @param string $pk <"id"> 父级ID
     * @param string $pid <"pid"> 父级PID
     * @param string $child <"child"> 子节点容器名称
     * @param int $rootPid <0> 顶级ID(pid)
     *
     * @return array
     */
    static function arrayToTree(array $list, string $pk = 'id', string $pid = 'pid', string $child = 'child', int $rootPid = 0): array
    {
        $tree = [];
        if (is_array($list)) {
            $refer = [];
            //基于数组的指针(引用) 并 同步改变数组
            foreach ($list as $key => $val) {
                $list[$key][$child] = [];
                $refer[$val[$pk]] = &$list[$key];
            }
            foreach ($list as $key => $val) {
                //是否存在parent
                $parentId = $val[$pid] ?? $rootPid;

                if ($rootPid == $parentId) {
                    $tree[$val[$pk]] = &$val;
                } else {
                    if (isset($refer[$parentId])) {
                        $refer[$parentId][$child][] = &$list[$key];
                    }
                }
            }
        }
        return array_values($tree);
    }

    /**
     * 二维数组去重
     *
     * -e.g: $arr=[["id"=>1,"sex"=>"female"],["id"=>1,"sex"=>"male"],["id"=>2,"age"=>18]];
     * -e.g: phpunit("Tools::arrayUnique",[$arr, "id"]);
     * -e.g: phpunit("Tools::arrayUnique",[$arr, "id", false]);
     *
     * @param array $arr 数组
     * @param string $filterKey <"id"> 字段
     * @param boolean $cover <true> 是否覆盖（遇相同 “filterKey” 时，仅保留最后一个值）
     *
     * @return array
     */
    static function arrayUnique(array $arr, string $filterKey = 'id', bool $cover = true): array
    {
        $res = [];
        foreach ($arr as $value) {
            ($cover || (!$cover && !isset($res[($value[$filterKey])]))) && $res[($value[$filterKey])] = $value;
        }
        return array_values($res);
    }

    /**
     * 二维数组排序
     *
     * -e.g: $arr=[["age"=>19,"name"=>"A"],["age"=>20,"name"=>"B"],["age"=>18,"name"=>"C"],["age"=>16,"name"=>"D"]];
     * -e.g: phpunit("Tools::arraySort", [$arr, "age", "asc"]);
     *
     * @param array $array 排序的数组
     * @param string $orderKey 要排序的key
     * @param string $orderBy <"desc"> 排序类型 ASC、DESC
     *
     * @return array
     */
    static public function arraySort(array $array, string $orderKey, string $orderBy = 'desc'): array
    {
        $kv = [];
        foreach ($array as $k => $v) {
            $kv[$k] = $v[$orderKey];
        }
        array_multisort($kv, ($orderBy == "desc" ? SORT_DESC : SORT_ASC), $array);
        return $array;
    }
}
