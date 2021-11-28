<?php


namespace Xcy\Hutool;


class ObjectUtil
{
    /**
     * 对象转数组
     *
     * -e.g: $data=[ "a"=>50, "b"=>true, "c"=>null ];
     * -e.g: phpunit("Tools::toArray", [$data]);
     *
     * @param object|array $object 对象
     *
     * @return array
     */
    static function toArray($object)
    {
        if (is_object($object)) {
            $arr = (array)$object;
        } else if (is_array($object)) {
            $arr = [];
            foreach ($object as $k => $v) {
                $arr[$k] = self::toArray($v);
            }
        } else {
            return $object;
        }
        unset($object);
        return $arr;
    }
}
