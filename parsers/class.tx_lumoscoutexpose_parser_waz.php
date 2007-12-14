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

require_once(t3lib_extMgm::extPath('lumoscoutexpose') . 'libs/XPath.class.php');

require_once(t3lib_extMgm::extPath('lumoscoutexpose') . 'parsers/class.tx_lumoscoutexpose_parser_base.php');

/**
 * Parser for ExposeResult of type Waz.
 *
 * @author	Thomas Off <typo3@retiolum.de>
 * @package	TYPO3
 * @subpackage	tx_lumoscoutexpose
 */
class tx_lumoscoutexpose_parser_waz extends tx_lumoscoutexpose_parser_base {

	/**
	 * Constructor for the parser class.
	 *
	 * @param	array		$lLang: Language labels used for parsing of values
	 * @return
	 */
	function tx_lumoscoutexpose_parser_waz($lLang) {
		$this->lLang = $lLang;
	}

	/**
	 * Parse a given exposé and return an array of markers to be replaced in the template used.
	 *
	 * @param	string		$sExpose: XML string that contains the exposé that was obtained via ImmobilienScout24.de API
	 * @return	array		An array of markers to be replaced in the template used
	 */
	function parse($sExpose) {
		// Initialize XML parser
		$this->oXpath =& new XPath();
		$this->oXpath->importFromString($sExpose);

		// Set up marker array
		$lMarkerArray = array();

		// Markers from type Waz
		$lMarkerArray['wazImmoType'] = $this->getDataString('/ExposeResult/Waz/wazImmoType');
		$lMarkerArray['netArea'] = $this->getDataFloat('/ExposeResult/Waz/netArea');
		$lMarkerArray['netRent'] = $this->getDataCurrency('/ExposeResult/Waz/netRent');
		$lMarkerArray['totalRent'] = $this->getDataCurrency('/ExposeResult/Waz/totalRent');
		$lMarkerArray['noRooms'] = $this->getDataFloat('/ExposeResult/Waz/noRooms');
		$lMarkerArray['additionalCosts'] = $this->getDataCurrency('/ExposeResult/Waz/additionalCosts');
		$lMarkerArray['kaution'] = $this->getDataString('/ExposeResult/Waz/kaution');
		$lMarkerArray['courtage'] = $this->getDataString('/ExposeResult/Waz/courtage');
		$lMarkerArray['hasCourtage'] = $this->getDataBool('/ExposeResult/Waz/hasCourtage');
		$lMarkerArray['interval'] = $this->getDataString('/ExposeResult/Waz/interval');
		$lMarkerArray['beginRent'] = $this->getDataDate('/ExposeResult/Waz/beginRent');
		$lMarkerArray['endRent'] = $this->getDataDate('/ExposeResult/Waz/endRent');
		$lMarkerArray['maxPersons'] = $this->getDataInt('/ExposeResult/Waz/maxPersons');
		$lMarkerArray['maxRentMonth'] = $this->getDataFloat('/ExposeResult/Waz/maxRentMonth');
		$lMarkerArray['minRentMonth'] = $this->getDataFloat('/ExposeResult/Waz/minRentMonth');
		$lMarkerArray['heating'] = $this->getDataString('/ExposeResult/Waz/heating');
		$lMarkerArray['condition'] = $this->getDataString('/ExposeResult/Waz/condition');
		$lMarkerArray['floor'] = $this->getDataInt('/ExposeResult/Waz/floor');
		$lMarkerArray['noStories'] = $this->getDataInt('/ExposeResult/Waz/noStories');
		$lMarkerArray['hasBalcony'] = $this->getDataBool('/ExposeResult/Waz/hasBalcony');
		$lMarkerArray['hasElevator'] = $this->getDataBool('/ExposeResult/Waz/hasElevator');
		$lMarkerArray['hasFurniture'] = $this->getDataBool('/ExposeResult/Waz/hasFurniture');
		$lMarkerArray['hasGarden'] = $this->getDataBool('/ExposeResult/Waz/hasGarden');
		$lMarkerArray['wheelchair'] = $this->getDataBool('/ExposeResult/Waz/wheelchair');
		$lMarkerArray['gender'] = $this->getDataString('/ExposeResult/Waz/gender');
		$lMarkerArray['smoker'] = $this->getDataBool('/ExposeResult/Waz/smoker');
		$lMarkerArray['petsAllowed'] = $this->getDataString('/ExposeResult/Waz/petsAllowed');
		$lMarkerArray['hasParking'] = $this->getDataBool('/ExposeResult/Waz/hasParking');
		$lMarkerArray['parkingPrice'] = $this->getDataCurrency('/ExposeResult/Waz/parkingPrice');
		$lMarkerArray['description'] = $this->getDataString('/ExposeResult/Waz/description');
		$lMarkerArray['interior'] = $this->getDataString('/ExposeResult/Waz/interior');
		$lMarkerArray['otherInfo'] = $this->getDataString('/ExposeResult/Waz/otherInfo');
		$lMarkerArray['position'] = $this->getDataString('/ExposeResult/Waz/position');

		// Add markers from type RealEstate
		$lMarkerArray = array_merge($lMarkerArray, $this->parseRealEstate());

		// Add markers from type GISRealEstate
		$lMarkerArray = array_merge($lMarkerArray, $this->parseGISRealEstate());

		// Reset parser
		$this->oXpath->reset();

		return $lMarkerArray;
	}

}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/lumoscoutexpose/parsers/class.tx_lumoscoutexpose_parser_waz.php']) {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/lumoscoutexpose/parsers/class.tx_lumoscoutexpose_parser_waz.php']);
}

?>