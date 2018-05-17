<?php
/**
 * Created by PhpStorm
 * FileName: SendMail.php
 * User: JianJia.Zhou
 * DateTime: 2018/5/14 14:23
 * @description
 */
require '../core/PHPMailer/src/PHPMailer.php';
require '../core/PHPMailer/src/SMTP.php';

class QQSendMail
{
    /**
     * PHPMailer 句柄
     * @var null|PHPMailer
     */
    private $_mail = null;

    /**
     * QQSendMail constructor.
     * @param string $account
     * @param string $password
     */
    public function __construct($account = '', $password = '')
    {
        $this->_mail = new PHPMailer(true);
        $this->_setMailOption($account, $password);
    }

    /**
     * 设置参数
     *
     * @version             v1.0
     * @author              JianJia.Zhou
     * @changeTime          dt
     * @param string $account
     * @param string $password
     */
    private function _setMailOption($account = '', $password = '')
    {
        // 是否启用smtp的debug进行调试 开发环境建议开启 生产环境注释掉即可 默认关闭debug调试模式
        $this->_mail->SMTPDebug = 1;
        // 使用smtp鉴权方式发送邮件
        $this->_mail->isSMTP();
        // smtp需要鉴权 这个必须是true
        $this->_mail->SMTPAuth = true;
        // 链接qq域名邮箱的服务器地址
        $this->_mail->Host = 'smtp.qq.com';
        // 设置使用ssl加密方式登录鉴权
        $this->_mail->SMTPSecure = 'ssl';
        // 设置ssl连接smtp服务器的远程服务器端口号
        $this->_mail->Port = 465;
        // 设置发送的邮件的编码
        $this->_mail->CharSet = 'UTF-8';
        // 设置发件人昵称 显示在收件人邮件的发件人邮箱地址前的发件人姓名
        $this->_mail->FromName = 'xiansin';
        // smtp登录的账号 QQ邮箱即可
        $this->_mail->Username = $account;
        // smtp登录的密码 使用生成的授权码
        $this->_mail->Password = $password;
        // 设置发件人邮箱地址 同登录账号
        $this->_mail->From = $account;
    }

    /**
     * 发送邮件
     *
     * @version             v1.0
     * @author              JianJia.Zhou
     * @changeTime          2018/5/14 14:46
     * @param string $address
     * @param string $title
     * @param string $content
     * @return bool
     */
    public function send($address = '', $title = '', $content = '')
    {
        // 邮件正文是否为html编码 注意此处是一个方法
        $this->_mail->isHTML(true);
        // 设置收件人邮箱地址
        if (is_array($address)) {
            foreach ($address as $val) {
                $this->_mail->addAddress($val);
            }
        } else {
            $this->_mail->addAddress($address);
        }
        // 添加该邮件的主题
        $this->_mail->Subject = $title;
        // 添加邮件正文
        $this->_mail->Body = $content;
        // 发送邮件 返回状态
        return $this->_mail->send();
    }

    /**
     * 添加附件
     *
     * @version             v1.0
     * @author              JianJia.Zhou
     * @changeTime          2018/5/14 14:46
     * @param string $path
     * @return bool
     */
    public function addFile($path = '')
    {
        if (!empty($path)) {
            return false;
        }
        return $this->_mail->addAttachment($path);
    }
}