<?php
if (!defined ("TYPO3_MODE")) 	die ("Access denied.");

// adding Hook for prcessing order

$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['commerce/pi3/class.tx_commerce_pi3.php']['finishIt'][] = 'EXT:com_ordernumber/class.com_ordernumber_orderhooks.php:tx_com_ordernumber_orderhooks';
?>