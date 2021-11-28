<?php


namespace Xcy\Hutool;


class FileUtil
{
    /**
     * 下载远端文件到本地
     * @param string $url
     * @param string $path
     */
    public static function downloadFile(string $url, string $path)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        $file = curl_exec($ch);
        curl_close($ch);
        $resource = fopen($path, 'w');
        fwrite($resource, $file);
        fclose($resource);
    }
}
