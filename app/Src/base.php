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

    /*生成订单号*/
    function  No_create()
    {

    }
}