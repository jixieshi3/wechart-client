<?php
namespace WeChart\Corp\Message;

class Media extends Base {

    public function setMediaId($mediaId)
    {
        $this->_data = [$this->_type => ['media_id' => $mediaId]];
        return $this;
    }
}