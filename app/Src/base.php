<?php
namespace App\Src;
use SimpleSoftwareIO\QrCode\BaconQrCodeGenerator;

class base
{
    /*生成邀请码*/
    function code($str=null)
    {
            $code="";
            if ($str!=null&&strlen($str)>16)
             $code=substr($str,10,6);
            else
                $code=\EasyWeChat\Kernel\Support\str_random(6);
            return $code;
    }

    /*文本生成二维码*/
    function  erweima($text)
    {
        $name=\EasyWeChat\Kernel\Support\str_random(10).'.png';
        #if(is_dir(resource_path('template/qrcodes'))==false)
         #   mkdir(resource_path('template/qrcodes'));
          $qrpath=resource_path('template/qrcodes/'.$name);
        $qrcode = new BaconQrCodeGenerator;
        $qrcode->format('png')->generate($text,$qrpath);
        return $qrpath;
    }

    /*curl请求一个地址*/
    function  get_curl($url)
    {
        $headers=array("Content-type: application/json;charset='utf-8'");
        $curl=curl_init();
        curl_setopt($curl,CURLOPT_URL,$url);
        //curl_setopt($curl, CURLOPT_HEADER, 1);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);//返回结果存入$output变量
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE); // https请求 不验证证书和hosts
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        $output = curl_exec($curl);
        curl_close($curl);
        return $output;

    }


    /*生成订单号*/
    function  No_create()
    {

    }
}