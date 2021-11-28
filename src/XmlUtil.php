<?php


namespace Xcy\Hutool;


class XmlUtil
{
    /**
     * XML转数组
     *
     * @param string $xml xml
     *
     * @return array
     */
    static public function toArray(string $xml): array
    {
        //禁止引用外部xml实体
        libxml_disable_entity_loader(true);
        $xmlString = simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA);
        return json_decode(json_encode($xmlString), true);
    }
}
