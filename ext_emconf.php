<?php

/***************************************************************
 * Extension Manager/Repository config file for ext "com_ordernumber".
 *
 * Auto generated 06-07-2016 13:58
 *
 * Manual updates:
 * Only the data in the array - everything else is removed by next
 * writing. "version" and "dependencies" must not be touched!
 ***************************************************************/

$EM_CONF[$_EXTKEY] = array (
	'title' => 'Commerce Ordernumber',
	'description' => 'Replaces the order number genaration',
	'category' => 'fe',
	'version' => '0.1.1',
	'state' => 'beta',
	'uploadfolder' => 0,
	'createDirs' => '',
	'clearcacheonload' => 0,
	'author' => 'Ingo Schmitt',
	'author_email' => 'typo3@marketing-factory.de',
	'author_company' => 'Marketing Factory Consulting GmbH',
	'constraints' => 
	array (
		'depends' => 
		array (
			'commerce' => '',
			'php' => '5.0.0-8.0.0',
			'typo3' => '6.2.0-6.2.99',
		),
		'conflicts' => 
		array (
		),
		'suggests' => 
		array (
		),
	),
);

