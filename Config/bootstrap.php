<?php

App::uses('CakeEventManager', 'Event');
App::uses('GroupNameValidatorListener', 'GroupNameValidator.Lib');

CakeEventManager::instance()->attach(new GroupNameValidatorListener());
