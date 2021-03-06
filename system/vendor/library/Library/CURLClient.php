<?php
namespace Library;

/**
 * CURLClient
 * curl客户端类
 * @package Library
 */
final class CURLClient {

    private $cookieFile; //cookie保存路径
    private $proxy; //代理
    private $expire; //超时限额
    /**
     * 用CURL模拟http、https、ftp、gopher、telnet、dict、file
     * 和ldap协议同其他网站通信
     * @param null|string $cookiePath cookie保存路径
     * @param null|string $proxy 代理设置
     * @param int $expire 时间限制
     */
    public function __construct($cookiePath = NULL, $proxy = null, $expire = 30) {
        if (is_null($cookiePath)) {
            $this->cookieFile = APP_PATH . '/temp/curl/curl.txt';
        }
        else {
            $cookiePath = dir_format($cookiePath);
            dir_check($cookiePath);
            $this->cookieFile = $cookiePath . '/curl.txt';
        }
        $this->proxy = $proxy;
        $this->expire = $expire;
    }

    /**
     * 模拟get方法提交请求
     * @param $url
     * @return bool|string
     */
    public function get($url) {
        //参数分析
        if (!$url) {
            return false;
        }
        $proxy = $this->proxy;
        $expire = $this->expire;
        $cookieFile = $this->cookieFile;
        //分析是否开启SSL加密
        $ssl = substr($url, 0, 8) == 'https://' ? true : false;
        //读取网址内容
        $ch = curl_init();
        //设置代理
        if (!is_null($proxy)) {
            curl_setopt($ch, CURLOPT_PROXY, $proxy);
        }
        curl_setopt($ch, CURLOPT_URL, $url);
        if ($ssl) {
            // 对认证证书来源的检查
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            // 从证书中检查SSL加密算法是否存在
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 1);
        }
        //cookie设置
        curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieFile);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile);
        //设置浏览器
        curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        //使用自动跳转
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, $expire);
        $content = curl_exec($ch);
        curl_close($ch);
        return $content;
    }

    /**
     * 用CURL模拟post方法提交请求
     * @param string $url post所要提交的网址
     * @param array $postData 所要提交的数据
     * @return string
     */
    public function post($url, array $postData) {
        //参数分析
        if (!$url) {
            return false;
        }
        $proxy = $this->proxy;
        $expire = $this->expire;
        $cookieFile = $this->cookieFile;
        //分析是否开启SSL加密
        $ssl = substr($url, 0, 8) == 'https://' ? true : false;
        //读取网址内容
        $ch = curl_init();
        //设置代理
        if (!is_null($proxy)) {
            curl_setopt($ch, CURLOPT_PROXY, $proxy);
        }
        curl_setopt($ch, CURLOPT_URL, $url);
        if ($ssl) {
            // 对认证证书来源的检查
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            // 从证书中检查SSL加密算法是否存在
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 1);
        }
        //cookie设置
        curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieFile);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile);
        //设置浏览器
        curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        //发送一个常规的Post请求
        curl_setopt($ch, CURLOPT_POST, true);
        //Post提交的数据包
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        //使用自动跳转
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, $expire);
        $content = curl_exec($ch);
        curl_close($ch);
        return $content;
    }
}