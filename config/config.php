<?php

// embiente
if (isset($_SERVER['HTTP_HOST']) && substr_count($_SERVER['HTTP_HOST'], '127.0.0.1')) {
	$_ENVIRONMENT 	= 'local';
	$_DOCUMENT_ROOT = $_SERVER['DOCUMENT_ROOT'];
	$_SERVER_NAME 	= $_SERVER['SERVER_NAME'];

} elseif (isset($_SERVER['HTTP_HOST']) && substr_count($_SERVER['HTTP_HOST'], 'sisodontoonline.com')) {
	$_ENVIRONMENT = 'production';
	$_DOCUMENT_ROOT = $_SERVER['DOCUMENT_ROOT'].'/';
	$_SERVER_NAME 	= $_SERVER['SERVER_NAME'].'/';
} else {
	$_ENVIRONMENT 	= 'local';
	$_DOCUMENT_ROOT = 'C:/xampp/htdocs';
	$_SERVER_NAME 	= 'http://127.0.0.1/';
}

// Configuracao
$_CONFIG = [

	// aplicacao local
	'app' => [
		// local
		'local' => [
			'project_dir' 	=> $_DOCUMENT_ROOT,
			'file_path' 	=> '/sis-odonto/',
			'url_path'		=> $_SERVER_NAME
			],
		
		// producao
		'production' => [
			'project_dir' 	=> $_DOCUMENT_ROOT,
			'file_path' 	=> '',
			'url_path'		=> $_SERVER_NAME
			],
	],
	
	// banco de dados
	'db' => [
		// local
		'local' => [
			'db_name' 		=> 'sis_odonto',
			'db_host' 		=> '127.0.0.1',
			'db_user' 		=> 'root',
			'db_pass' 		=> '',
		],

		// producao
		'production' => [
			'db_name' 		=> 'sisod695_sisodonto_db',
			'db_host' 		=> 'localhost',
			'db_user' 		=> 'sisod695_dbadmin',
			'db_pass' 		=> 'qRSIXOQ^3i_+',
		]
	],

	'lenguage' => [
		// local
		'local' => 'pt-br',
		// producao
		'production' => 'pt-br'
	]
];