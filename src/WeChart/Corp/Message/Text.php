<?php
namespace WeChart\Corp\Message;

class Text extends Base {

    protected $_type = 'text';

    public function setContent($content)
    {
        $this->_data = [$this->_type => ['content' => $content]];
        return $this;
    }
}