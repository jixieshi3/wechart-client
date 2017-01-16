<?php
namespace WeChart\Corp;

use WeChart\Common\Curl;
use WeChart\Corp\Message\Base as Message;
use WeChart\Corp\Service\Base as Service;
use WeChart\Corp\Resource\Base as Resource;

class Corp {

    const CORP_ID = '';

    const CORP_SECRET = '';

    private static $_accessToken = '';

    private static $_expiresIn = '';

    private function _connect()
    {
        $curl = new Curl;
        $ret = $curl->query('gettoken', ['corpid' => self::CORP_ID, 'corpsecret' => self::CORP_SECRET]);
        return $ret;
    }

    public function __construct()
    {
        $ret = $this->_connect();
        if (isset($ret['errcode'])) {
            throw new Exception($ret['errmsg']);
        }
        self::$_accessToken = $ret['access_token'];
        self::$_expiresIn = $ret['expires_in'];
    }

    public function createMessage($type)
    {
        if (!in_array($type, [Message::TYPE_TEXT, Message::TYPE_IMAGE, Message::TYPE_VOICE,
                              Message::TYPE_VIDEO, Message::TYPE_FILE, Message::TYPE_NEWS,
                              Message::TYPE_MPNEWS])) {
            throw new Exception('消息类型不正确');
        }
        $class = $type;
        if (in_array($type, [Message::TYPE_IMAGE, Message::TYPE_VOICE, Message::TYPE_VIDEO, Message::TYPE_FILE])) {
            $class = 'media';
        }
        $msgClass = "\WeChart\Corp\Message\\".ucfirst($class);
        return new $msgClass(self::$_accessToken, $type);
    }

    public function createService($type)
    {
        // if (!in_array($type, [Service::TYPE_TEXT, Service::TYPE_IMAGE, Service::TYPE_VOICE])) {
        //     throw new Exception('消息类型不正确');
        // }
        // $msgClass = "\WeChart\Corp\Service\\".ucfirst($type);
        // return new $msgClass(self::$_accessToken);
    }

    public function getResource($type)
    {
        if (!in_array($type, [Resource::TYPE_APP, Resource::TYPE_CONTACTS, Resource::TYPE_MATERIAL, Resource::TYPE_MENU])) {
            throw new Exception('消息类型不正确');
        }
        $resClass = "\WeChart\Corp\Resource\\".ucfirst($type);
        return new $resClass(self::$_accessToken);
    }

}