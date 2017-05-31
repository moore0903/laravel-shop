<?php
/**
 * Created by PhpStorm.
 * User: yk
 * Date: 2017/4/25
 * Time: 14:45
 */

function NewSms($id,$pwd,$phone,$msg)
{
    $url="http://service.winic.org:8009/sys_port/gateway/index.asp?";
    $data = "id=%s&pwd=%s&to=%s&content=%s&time=";
    $to = $phone;
    $content = iconv("UTF-8","GB2312",$msg);
    $rdata = sprintf($data, $id, $pwd, $to, $content);



    $ch = curl_init();
    curl_setopt($ch, CURLOPT_POST,1);
    curl_setopt($ch, CURLOPT_POSTFIELDS,$rdata);
    curl_setopt($ch, CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    $result = curl_exec($ch);
    curl_close($ch);
    $result = substr($result,0,3);
    return $result;
}