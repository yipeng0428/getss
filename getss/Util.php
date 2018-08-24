<?php

class Util
{

    private static $ssFile = "abc.txt";
    private static $ssURL = "http://mof.trade/intro/abc.txt";
    public $ipUtil;

    public function __construct()
    {
        $this->ipUtil = new ipLocation();
    }

    static function urlsafe_b64decode($string)
    {
        $data = str_replace(array('-', '_'), array('+', '/'), $string);
        $mod4 = strlen($data) % 4;
        if ($mod4) {
            $data .= substr('====', $mod4);
        }
        return base64_decode($data);
    }


    static function urlsafe_b64encode($str)
    {
        $data = base64_encode($str);
        $data = str_replace(array('+', '/', '='), array('-', '_', ''), $data);
        return $data;
    }

    static function getUtil()
    {
        return new self();
    }

    function getSSLink()
    {
        $fileContent = base64_decode(self::getContent());
        $p = '~ss://((?!").)*~';
        preg_match_all($p, $fileContent, $match);
        $link = array();
        foreach ($match[0] as $item) {
            array_push($link, $item);
        }
        return $link;
    }

    static function getContent()
    {

        if (!file_exists(self::$ssFile)) self::updateFile();
        return file_get_contents(self::$ssFile);
    }

    static function updateFile()
    {
        self::copy_stream(self::$ssURL, self::$ssFile);
    }

    static function copy_stream($src, $dest)
    {
        $fsrc = fopen($src, 'r');
        $fdest = fopen($dest, 'w+');
        $len = stream_copy_to_stream($fsrc, $fdest);    //  流的复制
        fclose($fsrc);
        fclose($fdest);
        return $len;
    }

    function generateSSNode($SSLink, $is_SSR)
    {
        $link = str_replace("ss://", "", $SSLink);
        $ss = explode("@", $link);
        $url = explode(":", $ss[1]);
        $encrypt = explode(":", $ss[0]);
        $ip = $url[0];
        $port = $url[1];
        $method = $encrypt[0];
        $pwd = $encrypt[1];
        $remark = iconv('GB2312', 'UTF-8', $this->ipUtil->getaddress($ip)['area1'] . $this->ipUtil->getaddress($ip)['area2']);
        return $is_SSR ? new SSR_Node($ip, $port, $method, $pwd, $remark) : new SS_Node($ip, $port, $method, $pwd, $remark);
    }

}