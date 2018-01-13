<?php

namespace Aliyuncaptcha;

require_once __DIR__ . '/../core/aliyun-php-sdk-core/Config.php';
require_once __DIR__ . '/../core/aliyun-php-sdk-jaq/Jaq/Request/V20161123/AfsCheckRequest.php';

class Client {
    protected $iClientProfile;
    protected $client;
    public function __construct ($accessKeyId = null, $accessKeySecret = null) {
        // accessKeyId、accessKeySecret
        $this->iClientProfile = \DefaultProfile::getProfile ("cn-hangzhou", $accessKeyId, $accessKeySecret);
        $this->client = new \DefaultAcsClient($this->iClientProfile);
    }
    /**
     * 功能：提交验证
     *
     * @param     $csessionid
     * @param     $token
     * @param     $sig
     * @param     $scene
     * @param int $platform
     *
     * @return   object
     *
     * @author   xiaole
     * @time     17/11/22 下午4:09
     */
    public function verify ($csessionid, $token, $sig, $scene, $platform = 3) {
        $request = new AfsCheckRequest();
        $request->setSession ($csessionid); // 必填参数，从前端获取，不可更改
        $request->setToken ($token); // 必填参数，从前端获取，不可更改
        $request->setSig ($sig); // 必填参数，从前端获取，不可更改
        $request->setScene ($scene); // 必填参数，从前端获取，不可更改
        $request->setPlatform ($platform); // 必填参数，请求来源： 1：Android端； 2：iOS端； 3：PC端及其他
        try {
            $response = $this->client->doAction ($request);
            return $response->getBody ();
        } catch (Exception $e) {
            return false;
        }
    }
}