<?php
$serviceContainer = \Propel\Runtime\Propel::getServiceContainer();
$serviceContainer->checkVersion('2.0.0-dev');
$serviceContainer->setAdapterClass('fscatalog2', 'mysql');
$manager = new \Propel\Runtime\Connection\ConnectionManagerSingle();
$manager->setConfiguration(array (
  'dsn' => 'mysql:host=localhost;dbname=fscatalog2',
  'user' => 'root',
  'password' => 'aecolomjerice1024!',
));
$manager->setName('fscatalog2');
$serviceContainer->setConnectionManager('fscatalog2', $manager);
$serviceContainer->setDefaultDatasource('fscatalog2');
$serviceContainer->setLoggerConfiguration('defaultLogger', array (
  'type' => 'stream',
  'path' => '/var/log/propel.log',
  'level' => '300',
));