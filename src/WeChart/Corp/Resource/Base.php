<?php
namespace WeChart\Corp\Resource;

abstract class Base {

    const TYPE_APP = 'app';

    const TYPE_CONTACTS = 'contacts';

    const TYPE_MATERIAL = 'material';

    const TYPE_MENU = 'menu';

    protected $_accessToken = '';

    public function __construct($accessToken)
    {
        $this->_accessToken = $accessToken;
    }
}