<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2006 Thomas Off <typo3@retiolum.de>
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
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

require_once(t3lib_extMgm::extPath('lumoscoutexpose') . 'parsers/class.tx_lumoscoutexpose_parser_appartmentrent.php');
require_once(t3lib_extMgm::extPath('lumoscoutexpose') . 'parsers/class.tx_lumoscoutexpose_parser_appartmentbuy.php');
require_once(t3lib_extMgm::extPath('lumoscoutexpose') . 'parsers/class.tx_lumoscoutexpose_parser_houserent.php');
require_once(t3lib_extMgm::extPath('lumoscoutexpose') . 'parsers/class.tx_lumoscoutexpose_parser_housebuy.php');
require_once(t3lib_extMgm::extPath('lumoscoutexpose') . 'parsers/class.tx_lumoscoutexpose_parser_office.php');
require_once(t3lib_extMgm::extPath('lumoscoutexpose') . 'parsers/class.tx_lumoscoutexpose_parser_site.php');
require_once(t3lib_extMgm::extPath('lumoscoutexpose') . 'parsers/class.tx_lumoscoutexpose_parser_gastronomy.php');
require_once(t3lib_extMgm::extPath('lumoscoutexpose') . 'parsers/class.tx_lumoscoutexpose_parser_store.php');
require_once(t3lib_extMgm::extPath('lumoscoutexpose') . 'parsers/class.tx_lumoscoutexpose_parser_industry.php');
require_once(t3lib_extMgm::extPath('lumoscoutexpose') . 'parsers/class.tx_lumoscoutexpose_parser_misc.php');
require_once(t3lib_extMgm::extPath('lumoscoutexpose') . 'parsers/class.tx_lumoscoutexpose_parser_investment.php');
require_once(t3lib_extMgm::extPath('lumoscoutexpose') . 'parsers/class.tx_lumoscoutexpose_parser_housetype.php');
require_once(t3lib_extMgm::extPath('lumoscoutexpose') . 'parsers/class.tx_lumoscoutexpose_parser_waz.php');

/**
 * Common parser class for XML ExposeResult(s) that is used by the plugin.
 *
 * @author	Thomas Off <typo3@retiolum.de>
 * @package	TYPO3
 * @subpackage	tx_lumoscoutexpose
 */
class tx_lumoscoutexpose_parser {
	var $sExposeType;
	var $lLang;
	var $oParserClass;

	/**
	 * Constructor of the general parser.
	 * The constructor instantiates an object of the class responsible for the given exposé type.
	 *
	 * @param	string		$sExposeType: The type of exposé that will be handled by the parser
	 * @param	array		$lLang: Language labels used for parsing of values
	 * @return
	 */
	function tx_lumoscoutexpose_parser($sExposeType, $lLang) {
		$this->sExposeType = $sExposeType;
		$this->lLang = $lLang;

		// Instantiate class for parsing
		switch ($this->sExposeType) {
			case 'AppartmentRent':
				$this->oParserClass =& new tx_lumoscoutexpose_parser_appartmentrent($this->lLang);
				break;
			case 'AppartmentBuy':
				$this->oParserClass =& new tx_lumoscoutexpose_parser_appartmentbuy($this->lLang);
				break;
			case 'HouseRent':
				$this->oParserClass =& new tx_lumoscoutexpose_parser_houserent($this->lLang);
				break;
			case 'HouseBuy':
				$this->oParserClass =& new tx_lumoscoutexpose_parser_housebuy($this->lLang);
				break;
			case 'Site':
				$this->oParserClass =& new tx_lumoscoutexpose_parser_site($this->lLang);
				break;
			case 'Office':
				$this->oParserClass =& new tx_lumoscoutexpose_parser_office($this->lLang);
				break;
			case 'Gastronomy':
				$this->oParserClass =& new tx_lumoscoutexpose_parser_gastronomy($this->lLang);
				break;
			case 'Store':
				$this->oParserClass =& new tx_lumoscoutexpose_parser_store($this->lLang);
				break;
			case 'Industry':
				$this->oParserClass =& new tx_lumoscoutexpose_parser_industry($this->lLang);
				break;
			case 'Misc':
				$this->oParserClass =& new tx_lumoscoutexpose_parser_misc($this->lLang);
				break;
			case 'Investment':
				$this->oParserClass =& new tx_lumoscoutexpose_parser_investment($this->lLang);
				break;
			case 'HouseType':
				$this->oParserClass =& new tx_lumoscoutexpose_parser_housetype($this->lLang);
				break;
			case 'Waz':
				$this->oParserClass =& new tx_lumoscoutexpose_parser_waz($this->lLang);
				break;
			default:
				$this->oParserClass = 0;
				break;
		}
	}

	/**
	 * Parse a given exposé and return an array of markers to be replaced in the template used.
	 * This function is called by the plugin class and calls the parse function of the class that is responsible for parsing the given type of exposé.
	 *
	 * @param	array		$sExpose: XML string that contains the exposé that was obtained via ImmobilienScout24.de API
	 * @return	array		An array of markers to be replaced in the template used
	 */
	function parse($sExpose) {
		return $this->oParserClass->parse($sExpose);
	}

}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/lumoscoutexpose/parsers/class.tx_lumoscoutexpose_parser.php']) {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/lumoscoutexpose/parsers/class.tx_lumoscoutexpose_parser.php']);
}

?>