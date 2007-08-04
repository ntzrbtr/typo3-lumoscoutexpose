<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2006 Thomas Off, LumoNet oHG <t.off@lumonet.de>
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
 * Parser for ExposeResult of type HouseRent.
 *
 * @author	Thomas Off, LumoNet oHG <t.off@lumonet.de>
 * @package	TYPO3
 * @subpackage	tx_lumoscoutexpose
 */
class tx_lumoscoutexpose_parser_houserent extends tx_lumoscoutexpose_parser_base {

	/**
	 * Constructor for the parser class.
	 *
	 * @param	array		$lLang: Language labels used for parsing of values
	 * @return
	 */
	function tx_lumoscoutexpose_parser_houserent($lLang) {
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

		// Markers from type HouseRent
		$lMarkerArray['buildingType'] = $this->getDataString('/ExposeResult/HouseRent/buildingType');
		$lMarkerArray['netArea'] = $this->getDataFloat('/ExposeResult/HouseRent/netArea');
		$lMarkerArray['noRooms'] = $this->getDataFloat('/ExposeResult/HouseRent/noRooms');
		$lMarkerArray['netRent'] = $this->getDataCurrency('/ExposeResult/HouseRent/netRent');
		$lMarkerArray['lotSize'] = $this->getDataFloat('/ExposeResult/HouseRent/lotSize');
		$lMarkerArray['courtage'] = $this->getDataString('/ExposeResult/HouseRent/courtage');
		$lMarkerArray['additionalCosts'] = $this->getDataCurrency('/ExposeResult/HouseRent/additionalCosts');
		$lMarkerArray['heatingCosts'] = $this->getDataCurrency('/ExposeResult/HouseRent/heatingCosts');
		$lMarkerArray['heatingCostsInRent'] = $this->getDataBool('/ExposeResult/HouseRent/heatingCostsInRent');
		$lMarkerArray['kaution'] = $this->getDataString('/ExposeResult/HouseRent/kaution');
		$lMarkerArray['yearConstructed'] = $this->getDataInt('/ExposeResult/HouseRent/yearConstructed');
		$lMarkerArray['availableDate'] = $this->getDataString('/ExposeResult/HouseRent/availableDate');
		$lMarkerArray['condition'] = $this->getDataString('/ExposeResult/HouseRent/condition');
		$lMarkerArray['heating'] = $this->getDataString('/ExposeResult/HouseRent/heating');
		$lMarkerArray['totalArea'] = $this->getDataFloat('/ExposeResult/HouseRent/totalArea');
		$lMarkerArray['totalRent'] = $this->getDataCurrency('/ExposeResult/HouseRent/totalRent');
		$lMarkerArray['noStories'] = $this->getDataInt('/ExposeResult/HouseRent/noStories');
		$lMarkerArray['hasElevator'] = $this->getDataBool('/ExposeResult/HouseRent/hasElevator');
		$lMarkerArray['hasCourtage'] = $this->getDataBool('/ExposeResult/HouseRent/hasCourtage');
		$lMarkerArray['wheelchair'] = $this->getDataBool('/ExposeResult/HouseRent/wheelchair');
		$lMarkerArray['noBathrooms'] = $this->getDataInt('/ExposeResult/HouseRent/noBathrooms');
		$lMarkerArray['noBedrooms'] = $this->getDataInt('/ExposeResult/HouseRent/noBedrooms');
		$lMarkerArray['kitchenComplete'] = $this->getDataBool('/ExposeResult/HouseRent/kitchenComplete');
		$lMarkerArray['hasParking'] = $this->getDataBool('/ExposeResult/HouseRent/hasParking');
		$lMarkerArray['parkingPrice'] = $this->getDataCurrency('/ExposeResult/HouseRent/parkingPrice');
		$lMarkerArray['cared'] = $this->getDataBool('/ExposeResult/HouseRent/cared');
		$lMarkerArray['description'] = $this->getDataString('/ExposeResult/HouseRent/description');
		$lMarkerArray['interior'] = $this->getDataString('/ExposeResult/HouseRent/interior');
		$lMarkerArray['otherInfo'] = $this->getDataString('/ExposeResult/HouseRent/otherInfo');
		$lMarkerArray['position'] = $this->getDataString('/ExposeResult/HouseRent/position');

		// Add markers from type RealEstate
		$lMarkerArray = array_merge($lMarkerArray, $this->parseRealEstate());

		// Add markers from type GISRealEstate
		$lMarkerArray = array_merge($lMarkerArray, $this->parseGISRealEstate());

		// Reset parser
		$this->oXpath->reset();

		return $lMarkerArray;
	}

}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/lumoscoutexpose/parsers/class.tx_lumoscoutexpose_parser_houserent.php']) {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/lumoscoutexpose/parsers/class.tx_lumoscoutexpose_parser_houserent.php']);
}

?>