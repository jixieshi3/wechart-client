<?php
namespace WeChart\Corp\Message;

use \WeChart\Common\Curl;

abstract class Base {

    const TYPE_TEXT = 'text';

    const TYPE_IMAGE = 'image';

    const TYPE_VOICE = 'voice';

    const TYPE_VIDEO = 'video';

    const TYPE_FILE = 'file';

    const TYPE_NEWS = 'news';

    const TYPE_MPNEWS = 'mpnews';

    protected $_accessToken = '';
    // touser: 成员ID列表（消息接收者，多个接收者用‘|’分隔，最多支持1000个）。特殊情况：指定为@all，则向关注该企业应用的全部成员发送
    // toparty: 部门ID列表，多个接收者用‘|’分隔，最多支持100个。当touser为@all时忽略本参数
    // totag: 标签ID列表，多个接收者用‘|’分隔，最多支持100个。当touser为@all时忽略本参数
    // msgtype(required): 消息类型，text|image|voice|video|file|news|mpnews
    // agentid(required): 企业应用的id，整型。可在应用的设置页面查看
    // safe: 表示是否是保密消息，0表示否，1表示是，默认0
    protected $_data = [];

    protected $_toUser = [];

    protected $_toParty = [];

    protected $_toTag = [];

    protected $_agentId = 0;

    protected $_safe = 0;

    protected $_type = '';

    public function __construct($accessToken, $type = null)
    {
        $this->_accessToken = $accessToken;
        if ($type !== null) {
            $this->_type = $type;
        }
    }

    public function setUsers(array $users)
    {
        $this->_toUser = $users;
        return $this;
    }

    public function setParties(array $parties)
    {
        $this->_toParty = $parties;
        return $this;
    }

    public function setTags(array $tags)
    {
        $this->_toTag = $tags;
        return $this;
    }

    public function setAgentId($agentId)
    {
        $this->_agentId = $agentId;
        return $this;
    }

    public function isSafe(boolean $isSafe)
    {
        $this->_safe = $isSafe;
        return $this;
    }

    public function send()
    {
        if (empty($this->_type)) {
            throw new Exception('缺少消息类型');
        }
        if (empty($this->_agentId)) {
            throw new Exception('缺少应用ID');
        }
        if (empty($this->_data[$this->_type])) {
            throw new Exception('缺少消息数据');
        }
        $data = [];
        $data['touser'] = !empty($this->_toUser) ? implode('|', $this->_toUser) : '@all';
        $data['toparty'] = !empty($this->_toParty) ? implode('|', $this->_toParty) : '@all';
        $data['totag'] = !empty($this->_toTag) ? implode('|', $this->_toTag) : '@all';
        $data['msgtype'] = $this->_type;
        $data['agentid'] = $this->_agentId;
        $data['safe'] = $this->_safe;
        foreach ($this->_data as $key => $values) {
            $data[$key] = $values;
        }

        $curl = new Curl;
        $path = 'message/send?access_token='.$this->_accessToken;
        return $curl->post($path, $data);
    }

}