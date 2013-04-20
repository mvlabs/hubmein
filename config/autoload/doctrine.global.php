<?php
return array(
    'doctrine' => array(
        'connection' => array(
            // default connection name
            'orm_default' => array(
                'driverClass' => 'Doctrine\DBAL\Driver\PDOPgSql\Driver',
                'params' => array(
                    'host'     => '',
                    'port'     => '5432',
                    'user'     => '',
                    'password' => '',
                    'dbname'   => '',
                )
            )
        )
    ),
);