<?php
namespace WeChart\Corp\Message;

class Video extends Media {

    protected $_type = 'video';

    public function setVideo($mediaId, $title = null, $description = null)
    {
        $this->setMediaId($this->_type, $mediaId);
        if ($title !== null) {
            $this->_data[$this->_type]['title'] = $title;
        }
        if ($description !== null) {
            $this->_data[$this->_type]['description'] = $description;
        }
        return $this;
    }
}