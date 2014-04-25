<?php
namespace Monkey\Response;

/**
 * ResponseCli
 * Cli响应组件
 * @package Monkey\Response
 */
class ResponseCli
{
    private
        /**
         * @var \Monkey\App\App
         */
        $app,
        $bodys=array(),
        $statusCode;

    /**
     * @param \Monkey\App\App $app
     */
    public function __construct($app)
    {
        $this->app=$app;
    }

    /**
     * 设置响应状态
     * @param int $status
     * @return $this
     */
    public function setStatus($status=200)
    {
        if (is_numeric($status)) {
            $this->statusCode = $status;
        }
        return $this;
    }

    /**
     * 获取响应状态
     * @return mixed
     */
    public function getStatus()
    {
        return $this->statusCode;
    }

    /**
     * 向屏幕输出内容
     * @param $text
     */
    public function write($text)
    {
        echo $text;
    }

    /**
     * 向屏幕输出一行内容
     * @param $text
     */
    public function writeLine($text)
    {
        echo $text.'\n';
    }

    /**
     * 清空屏幕
     */
    public function clearScreen()
    {
        system('clear');
    }
}