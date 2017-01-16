<?php
namespace WeChart\Corp\Resource;

use \WeChart\Common\Curl;

class Material extends Base {

    const TYPE_IMAGE = 'image';

    const TYPE_VOICE = 'voice';

    const TYPE_VIDEO = 'video';

    const TYPE_FILE = 'file';

    protected function _upload($apiPath, $filePath, $type = null) 
    {
        if ($type && !in_array($type, [self::TYPE_IMAGE, self::TYPE_VOICE, self::TYPE_VIDEO, self::TYPE_FILE])) {
            throw new \WeChart\Corp\Exception('文件类型不正确');
        }

        $data = ['media' => $filePath];
        $curl = new Curl;
        $path = $apiPath.'?access_token='.$this->_accessToken;
        if ($type) {
            $path .= '&type='.$type;
        }
        return $curl->upload($path, $data);
    }

    public function uploadTemp($type, $filePath)
    {
        return $this->_upload('media/upload', $filePath, $type);
    }

    public function uploadPermanence($type, $filePath)
    {
        return $this->_upload('material/add_material', $filePath, $type);
    }

    public function uploadToCdn($filePath)
    {
        return $this->_upload('media/uploadimg', $filePath);
    }

    public function getTemp($mediaId)
    {
        $curl = new Curl;
        return $curl->query('media/get', ['access_token' => $this->_accessToken, 'media_id' => $mediaId]);
    }

    public function getPermanence($mediaId)
    {
        $curl = new Curl;
        return $curl->query('material/get', ['access_token' => $this->_accessToken, 'media_id' => $mediaId]);
    }

    public function delPermanence($mediaId)
    {
        $curl = new Curl;
        return $curl->query('material/del', ['access_token' => $this->_accessToken, 'media_id' => $mediaId]);
    }

    public function modifyNews()
    {

    }

    public function countPermanence()
    {
        $curl = new Curl;
        return $curl->query('material/get_count', ['access_token' => $this->_accessToken]);
    }

    public function listPermanence($type, $offset, $count)
    {
        $data = [];
        $curl = new Curl;
        $data['type'] = $type;
        $data['offset'] = $offset;
        $data['count'] = $count;
        return $curl->post('material/batchget?access_token='.$this->_accessToken, $data);
    }
}