<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
function mailTo($to,$title,$content){
    $mail = new PHPMailer(true);
    try {
        //Server settings
        //开启之后会返回多余的数据导致ajax响应异常
        $mail->SMTPDebug = 0;                                       // Enable verbose debug output
        $mail->isSMTP();                                            // Send using SMTP
        $mail->Host       = 'smtp.qq.com';                          // Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
        $mail->Username   = '1790286512@qq.com';                    // SMTP username
        $mail->Password   = 'vduqosltsxprfaba';                     // SMTP password
        $mail->SMTPSecure = 'ssl';                                  // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
        $mail->Port       = 465;                                    // TCP port to connect to
        $mail->CharSet    = 'UTF-8';

        //Recipients
        $mail->setFrom('1790286512@qq.com', 'TAHUN');
        $mail->addAddress($to);     // Add a recipient

        // Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = $title;
        $mail->Body    = $content;

        return $mail->send();
    } catch (Exception $e) {
        exception($mail->ErrorInfo,1001);
    }
}

//将span标签字符串替换成a
function replace($data){
    return str_replace('span','a',$data);
}
