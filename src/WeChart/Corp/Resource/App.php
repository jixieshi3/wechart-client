<?php
namespace WeChart\Corp\Resource;

use \WeChart\Common\Curl;

class App extends Base {

    const REPORT_LOCATION_NEVER = 0;

    const REPORT_LOCATION_SESSION = 1;

    const REPORT_LOCATION_ALWAYS = 2;

    private $_data = [];

    public function get($agentId)
    {
        $curl = new Curl;
        return $curl->query('agent/get', ['access_token' => $this->_accessToken, 'agentid' => $agentId]);
    }

    public function list()
    {
        $curl = new Curl;
        return $curl->query('agent/list', ['access_token' => $this->_accessToken]);
    }
    /**
    * 企业应用是否打开地理位置上报
    *
    */
    public function reportLocation($agentId, $flag)
    {
        if (!in_array($flag, [self::REPORT_LOCATION_NEVER, self::REPORT_LOCATION_SESSION, self::REPORT_LOCATION_ALWAYS])) {
            throw new Exception("");
        }
        $this->_data['agentid'] = $agentId;
        $this->_data['report_location_flag'] = $flag;
        $ret = $this->update($agentId);
        unset($this->_data['agentid']);
        unset($this->_data['report_location_flag']);
        return $ret;
    }
    /**
    * 是否接收用户变更通知
    *
    */
    public function reportUser($agentId, $bool)
    {
        $this->_data['agentid'] = $agentId;
        $this->_data['isreportuser'] = $bool;
        $ret = $this->update($agentId);
        unset($this->_data['agentid']);
        unset($this->_data['isreportuser']);
        return $ret;
    }
    /**
    * 是否上报用户进入应用事件
    *
    */
    public function reportEnter($agentId, $bool)
    {
        $this->_data['agentid'] = $agentId;
        $this->_data['isreportenter'] = $bool;
        $ret = $this->update($agentId);
        unset($this->_data['agentid']);
        unset($this->_data['isreportenter']);
        return $ret;
    }
    /**
    * 主页型应用url。url必须以http或者https开头。消息型应用无需该参数
    *
    */
    public function setHomeUrl($url)
    {
        $this->_data['home_url'] = $url;
        return $this;
    }
    /**
    * 关联会话url。设置该字段后，企业会话"+"号将出现该应用，
    * 点击应用可直接跳转到此url，支持jsapi向当前会话发送消息。
    *
    */
    public function setChatExtensionUrl($url)
    {
        $this->_data['chat_extension_url'] = $url;
        return $this;
    }
    /**
    * 企业应用头像的mediaid，通过多媒体接口上传图片获得mediaid
    * 上传后会自动裁剪成方形和圆形两个头像
    *
    */
    public function setLogo($mediaId)
    {
        $this->_data['logo_mediaid'] = $mediaId;
        return $this;
    }
    /**
    * 企业应用名称
    *
    */
    public function setName($name)
    {
        $this->_data['name'] = $name;
        return $this;
    }
    /**
    * 企业应用详情
    *
    */
    public function setDescription($description)
    {
        $this->_data['description'] = $description;
        return $this;
    }
    /**
    * 企业应用可信域名
    *
    */
    public function setRedirectDomain($redirectDomain)
    {
        $this->_data['redirect_domain'] = $description;
        return $this;
    }

    public function update($agentId)
    {
        $curl = new Curl;
        return $curl->post('agent/set?access_token?'.$this->_accessToken, $this->_data);
    }
}