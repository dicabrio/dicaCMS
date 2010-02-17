<?php

class LoginMapper extends FormMapper {

	public function defineFormElementToDomainEntityMapping() {
		$this->addFormElementToDomainEntityMapping('username', 'Username');
		$this->addFormElementToDomainEntityMapping('password', 'Password');
	}

}