<?php
class ytx_url
{
    public $username="";
    public $accessToken="";

    function _construct()
    {
        $this->username=env('ytx_username');
        $this->accessToken=env('ytx_accessToken');
    }
    function  getdata($url)
    {


    }

}