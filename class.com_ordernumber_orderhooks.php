<?php
/***************************************************************
*  Copyright notice
*
*  (c)  2006-2009 Ingo Schmitt <is@marketing-factory.de>
*  All   rights reserved
*
*  This script is part of the Typo3 project. The Typo3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/
/**
 * Part of the COMMERCE (Advanced Shopping System) extension.
 *
 * @author      Ingo Schmitt <is@marketing-factory.de>
 * @internal 	Maintainer Ingo Schmitt
 * @package 	TYPO3
 * @subpackage 	tx_commerce
 *
 * Implementation of an upcounting Odernumber
*/

 class tx_com_ordernumber_orderhooks{


 	/**
 	 * Define variables with default values, should be set via
 	 * TypoSCRIPT
 	 * @abstract
 	 * new TS Object
 	 * plugin.tx_commerce_pi3 {
 	 *   tx_com_ordernumber.startingAt = 21000000
 	 *   tx_com_ordernumber.endingAt   = 21999999
 	 *   tx_com_ordernumber.interval = 1
 	 * }
 	 */
 	/**
 	 * @var	integer	minimum value for ordernumber
 	 * @acces	private
 	 */

 	var $minNumber = 1;
 	/**
 	 * @var	integer	maximum value for ordernumber
 	 * @acces	private
 	 */
 	var $maxNumber = 99999;
 	/**
 	 * @var	integer	incementor for ordernumber
 	 * @acces	private
 	 */
 	var $interval=1;

 	/**
 	 * @var	string	tmp Filename for saving the actual number, currently only linux
 	 * @acces	private
 	 */
 	var $tmpFilename='.tx_com_ordernumber_orderhooks.counter';
 	/**
 	 * @var	string	tmp Filename prefix to have it unique per installation
 	 * @acces	private
 	 */
 	var $tmpFileprefix=TYPO3_db;
 	/**
 	 * @var	string	tmp Filename path
 	 * @acces	private
 	 */
 	var $tmpPath='typo3temp/';

 	/**
 	 * @var	string	tmp Filename for saving the actual number, currently only linux
 	 * @see $this->tmpAbsFilename=$this->tmpPath.$this->tmpFileprefix.$this->tmpFilename;
 	 * @acces	private
 	 */
 	var $tmpAbsFilename='';

 	/**
 	 * Generates one OrderID ascending from a staring number
 	 * @param	integer	orderid	Defined OrderId from the calling Method
 	 * @param	Object	$basket	tx_commerce Basket Object
 	 * @param	Object	$pobj	ParentObject, in this case tx_commerce_pi3, inhertited from pibase
 	 * @return	integer	Ordernumber
 	 */
 	function generateOrderId($orderId,$basket,$pobj){

 		$this->minNumber=$pobj->conf['tx_com_ordernumber.']['startingAt'];
 		$this->maxNumber=$pobj->conf['tx_com_ordernumber.']['endingAt'];
 		$this->interval=$pobj->conf['tx_com_ordernumber.']['interval'];

 		$return_value=$this->getNewID();
		return $return_value;
 	}

 	/**
 	 * Returns a new id from File, if availiable, otherwise generate a new id from database
 	 * @return 	integer	Oredrnumer
 	 */
 	function getNewId()	{
 		$newid = false;
 		$this->tmpAbsFilename=t3lib_div::getFileAbsFileName($this->tmpPath.$this->tmpFileprefix.$this->tmpFilename);
 		if (@file_exists($this->tmpAbsFilename))	{

 			$fl = @fopen($this->tmpAbsFilename,'r+');
 			if ($fl) {
 				$latestNumer = intval(fgets($fl,4096));
 				$newid = $latestNumer + $this->interval;
 				rewind($fl);
 				fwrite($fl,$newid);
 				fclose($fl);
 			}
 			if ($newid < $this->minNumber){
 				$newid=false;
 			}
 		}
 		if ($newid==false)	{
 			$fl = @fopen($this->tmpAbsFilename,'w');
 			if ($fl) {
 				$newid = $this->getNewIdFromDB();
 				fwrite($fl,$newid);
 				fclose($fl);
 			}
 		}
 		return $newid;
 	}

 	/**
 	 * Returns a new ID from the database
 	 * Used if no retrival form file was possible
 	 * @return 	integer	Oredrnumer
 	 */
 	function getNewIdFromDB() 	{
 		$res_max=$GLOBALS['TYPO3_DB']->exec_SELECTQuery("max(order_id) as maxOrderId",
					'tx_commerce_orders',
					'order_id > '.$this->minNumber.' AND order_id < '.$this->maxNumber);
 		if ($GLOBALS['TYPO3_DB']->sql_num_rows($res_max) == 1){
 			list($latestNumer) = $GLOBALS['TYPO3_DB']->sql_fetch_row($res_max);
 			if ($latestNumer >= $this->minNumber){
 				$latestNumer = $latestNumer + $this->interval;
 			}else{
 				$latestNumer=$this->minNumber;
 			}
 		}else{
 			$latestNumer=$this->minNumber;
 		}
 		return $latestNumer;
 	}

 }

?>