<?php

class m_patrullajes extends \DB\SQL\Mapper {
	public function __construct() {
		parent::__construct( \Base::instance()->get('DB'), 'Patrullajes' );
    }
}