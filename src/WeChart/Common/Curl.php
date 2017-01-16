<?php
namespace WeChart\Common;

class Curl {

    const BASE_URL = 'https://qyapi.weixin.qq.com/cgi-bin/';

    private $_handle = null;

    public function __construct()
    {
        $ch = $this->_handle = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0); // 从证书中检查SSL加密算法是否存在
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30); // 设置超时限制防止死循环
        //curl_setopt($ch, CURLOPT_HEADER, 0); // 显示返回的Header区域内容
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    }

    public function query($path, $data)
    {
        $url = self::BASE_URL.$path.'?'.http_build_query($data);
        curl_setopt($this->_handle, CURLOPT_URL, $url);
        curl_setopt($this->_handle, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($this->_handle, CURLOPT_HTTPGET, 1);
        $ret = curl_exec($this->_handle);
        $info = $this->getInfo();
        if ($info['http_code'] == 200) {
            return json_decode($ret, true) ? json_decode($ret, true) : $ret;
        }
        return false;
    }

    public function post($path, $data)
    {
        $url = self::BASE_URL.$path;
        curl_setopt($this->_handle, CURLOPT_URL, $url);
        curl_setopt($this->_handle, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($this->_handle, CURLOPT_POST, 1); // 发送一个常规的Post请求
        curl_setopt($this->_handle, CURLOPT_POSTFIELDS, json_encode($data, JSON_UNESCAPED_UNICODE)); // Post提交的数据包
        $ret = curl_exec($this->_handle);
        if (!$ret) {
            return false;
        }
        return json_decode($ret, true);
    }

    public function upload($path, $file)
    {
        foreach ($file as $key => &$value) {
            $value = new \CURLFile($value);
        }
        $url = self::BASE_URL.$path;
        curl_setopt($this->_handle, CURLOPT_URL, $url);
        curl_setopt($this->_handle, CURLOPT_POST, 1); // 发送一个常规的Post请求
        curl_setopt($this->_handle, CURLOPT_POSTFIELDS, $file); // Post提交的数据包
        $ret = curl_exec($this->_handle);
        if (!$ret) {
            return false;
        }
        return json_decode($ret, true);
    }

    public function getInfo()
    {
        return curl_getinfo($this->_handle);
    }

}