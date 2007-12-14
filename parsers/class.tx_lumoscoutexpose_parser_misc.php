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
 * Parser for ExposeResult of type Misc.
 *
 * @author	Thomas Off <typo3@retiolum.de>
 * @package	TYPO3
 * @subpackage	tx_lumoscoutexpose
 */
class tx_lumoscoutexpose_parser_misc extends tx_lumoscoutexpose_parser_base {

	/**
	 * Constructor for the parser class.
	 *
	 * @param	array		$lLang: Language labels used for parsing of values
	 * @return
	 */
	function tx_lumoscoutexpose_parser_misc($lLang) {
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

		// Markers from type Misc
		$lMarkerArray['buildingType'] = $this->getDataString('/ExposeResult/Misc/buildingType');
		$lMarkerArray['netArea'] = $this->getDataFloat('/ExposeResult/Misc/netArea');
		$lMarkerArray['totalArea'] = $this->getDataFloat('/ExposeResult/Misc/totalArea');
		$lMarkerArray['netRent'] = $this->getDataCurrency('/ExposeResult/Misc/netRent');
		$lMarkerArray['price'] = $this->getDataCurrency('/ExposeResult/Misc/price');
		$lMarkerArray['rentPerSqM'] = $this->getDataCurrency('/ExposeResult/Misc/rentPerSqM');
		$lMarkerArray['siteArea'] = $this->getDataFloat('/ExposeResult/Misc/siteArea');
		$lMarkerArray['courtage'] = $this->getDataString('/ExposeResult/Misc/courtage');
		$lMarkerArray['yearConstructed'] = $this->getDataInt('/ExposeResult/Misc/yearConstructed');
		$lMarkerArray['kaution'] = $this->getDataString('/ExposeResult/Misc/kaution');
		$lMarkerArray['marketing'] = $this->getDataString('/ExposeResult/Misc/marketing');
		$lMarkerArray['marketingPrice'] = $this->getDataCurrency('/ExposeResult/Misc/marketingPrice');
		$lMarkerArray['minDivisible'] = $this->getDataFloat('/ExposeResult/Misc/minDivisible');
		$lMarkerArray['additionalCosts'] = $this->getDataCurrency('/ExposeResult/Misc/additionalCosts');
		$lMarkerArray['heatingCosts'] = $this->getDataCurrency('/ExposeResult/Misc/heatingCosts');
		$lMarkerArray['heatingCostsInRent'] = $this->getDataBool('/ExposeResult/Misc/heatingCostsInRent');
		$lMarkerArray['additionalArea'] = $this->getDataFloat('/ExposeResult/Misc/additionalArea');
		$lMarkerArray['availableDate'] = $this->getDataString('/ExposeResult/Misc/availableDate');
		$lMarkerArray['condition'] = $this->getDataString('/ExposeResult/Misc/condition');
		$lMarkerArray['flooring'] = $this->getDataString('/ExposeResult/Misc/flooring');
		$lMarkerArray['floors'] = $this->getDataString('/ExposeResult/Misc/floors');
		$lMarkerArray['hasCourtage'] = $this->getDataBool('/ExposeResult/Misc/hasCourtage');
		$lMarkerArray['hasElevator'] = $this->getDataBool('/ExposeResult/Misc/hasElevator');
		$lMarkerArray['noParking'] = $this->getDataInt('/ExposeResult/Misc/noParking');
		$lMarkerArray['parkingPrice'] = $this->getDataCurrency('/ExposeResult/Misc/parkingPrice');
		$lMarkerArray['timeAirport'] = $this->getDataInt('/ExposeResult/Misc/timeAirport');
		$lMarkerArray['timeBusStop'] = $this->getDataInt('/ExposeResult/Misc/timeBusStop');
		$lMarkerArray['timeMotorway'] = $this->getDataInt('/ExposeResult/Misc/timeMotorway');
		$lMarkerArray['timeRailway'] = $this->getDataInt('/ExposeResult/Misc/timeRailway');
		$lMarkerArray['description'] = $this->getDataString('/ExposeResult/Misc/description');
		$lMarkerArray['interior'] = $this->getDataString('/ExposeResult/Misc/interior');
		$lMarkerArray['otherInfo'] = $this->getDataString('/ExposeResult/Misc/otherInfo');
		$lMarkerArray['position'] = $this->getDataString('/ExposeResult/Misc/position');

		// Add markers from type RealEstate
		$lMarkerArray = array_merge($lMarkerArray, $this->parseRealEstate());

		// Add markers from type GISRealEstate
		$lMarkerArray = array_merge($lMarkerArray, $this->parseGISRealEstate());

		// Reset parser
		$this->oXpath->reset();

		return $lMarkerArray;
	}

}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/lumoscoutexpose/parsers/class.tx_lumoscoutexpose_parser_misc.php']) {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/lumoscoutexpose/parsers/class.tx_lumoscoutexpose_parser_misc.php']);
}

?>