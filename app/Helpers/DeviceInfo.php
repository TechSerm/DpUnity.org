<?php

namespace App\Helpers;

class DeviceInfo
{
    private $userAgent;
    public function __construct()
    {
        $this->userAgent = request()->server('HTTP_USER_AGENT');
    }

    public function isBibisenaApp()
    {
        return strpos($this->userAgent, "BibiSenaAndroid") !== false;
    }

    public function hasDeviceToken()
    {
        $token = $this->getDeviceToken();
        return $token != "";
    }

    public function getAppVersion()
    {
        if (!$this->isBibisenaApp()) return "";
        $agentInfo = explode(' ', $this->userAgent);
        if (isset($agentInfo[0])) {
            $agentInfo = explode('/', $agentInfo[0]);
            if (isset($agentInfo[1])) return $agentInfo[1];
        }
        return "";
    }

    public function getDeviceToken()
    {
        if (!$this->isBibisenaApp()) return "";
        $agentInfo = explode(' ', $this->userAgent);
        if (isset($agentInfo[1])) {
            $agentInfo = explode('/', $agentInfo[1]);
            if (isset($agentInfo[1])) return $agentInfo[1];
        }
        return "";
    }
}
