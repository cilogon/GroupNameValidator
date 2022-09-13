<?php

App::uses('CakeEventManager', 'Event');
App::uses('GroupNameValidatorListener', 'GroupNameValidator.Lib');

CakeEventManager::instance()->attach(new GroupNameValidatorListener());

Configure::write('GroupNameValidator.co_id', 2);
Configure::write('GroupNameValidator.pattern', 'PATTERN');
Configure::write('GroupNameValidator.flash_error_text', 'SOME TEXT');
