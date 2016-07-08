<?php
if (!defined ("TYPO3_MODE")) 	die ("Access denied.");

// adding Hook for prcessing order

$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['commerce/Controller/CheckoutController']['getInstanceOfTceMain'][] = 'EXT:com_ordernumber/class.com_ordernumber_orderhooks.php:tx_com_ordernumber_orderhooks';
?>