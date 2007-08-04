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
 * Parser for ExposeResult of type Industry.
 *
 * @author	Thomas Off, LumoNet oHG <t.off@lumonet.de>
 * @package	TYPO3
 * @subpackage	tx_lumoscoutexpose
 */
class tx_lumoscoutexpose_parser_industry extends tx_lumoscoutexpose_parser_base {

	/**
	 * Constructor for the parser class.
	 *
	 * @param	array		$lLang: Language labels used for parsing of values
	 * @return
	 */
	function tx_lumoscoutexpose_parser_industry($lLang) {
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

		// Markers from type Industry
		$lMarkerArray['buildingType'] = $this->getDataString('/ExposeResult/Industry/buildingType');
		$lMarkerArray['netArea'] = $this->getDataFloat('/ExposeResult/Industry/netArea');
		$lMarkerArray['totalArea'] = $this->getDataFloat('/ExposeResult/Industry/totalArea');
		$lMarkerArray['netRent'] = $this->getDataCurrency('/ExposeResult/Industry/netRent');
		$lMarkerArray['price'] = $this->getDataCurrency('/ExposeResult/Industry/price');
		$lMarkerArray['rentPerSqM'] = $this->getDataCurrency('/ExposeResult/Industry/rentPerSqM');
		$lMarkerArray['siteArea'] = $this->getDataFloat('/ExposeResult/Industry/siteArea');
		$lMarkerArray['courtage'] = $this->getDataString('/ExposeResult/Industry/courtage');
		$lMarkerArray['yearConstructed'] = $this->getDataInt('/ExposeResult/Industry/yearConstructed');
		$lMarkerArray['kaution'] = $this->getDataString('/ExposeResult/Industry/kaution');
		$lMarkerArray['marketing'] = $this->getDataString('/ExposeResult/Industry/marketing');
		$lMarkerArray['marketingPrice'] = $this->getDataCurrency('/ExposeResult/Industry/marketingPrice');
		$lMarkerArray['minDivisible'] = $this->getDataFloat('/ExposeResult/Industry/minDivisible');
		$lMarkerArray['additionalCosts'] = $this->getDataCurrency('/ExposeResult/Industry/additionalCosts');
		$lMarkerArray['heatingCosts'] = $this->getDataCurrency('/ExposeResult/Industry/heatingCosts');
		$lMarkerArray['heatingCostsInRent'] = $this->getDataBool('/ExposeResult/Industry/heatingCostsInRent');
		$lMarkerArray['additionalArea'] = $this->getDataFloat('/ExposeResult/Industry/additionalArea');
		$lMarkerArray['availableDate'] = $this->getDataString('/ExposeResult/Industry/availableDate');
		$lMarkerArray['condition'] = $this->getDataString('/ExposeResult/Industry/condition');
		$lMarkerArray['craneRails'] = $this->getDataBool('/ExposeResult/Industry/craneRails');
		$lMarkerArray['craneRailsLoad'] = $this->getDataFloat('/ExposeResult/Industry/craneRailsLoad');
		$lMarkerArray['electricalPointValue'] = $this->getDataInt('/ExposeResult/Industry/electricalPointValue');
		$lMarkerArray['floorHeight'] = $this->getDataFloat('/ExposeResult/Industry/floorHeight');
		$lMarkerArray['flooring'] = $this->getDataString('/ExposeResult/Industry/flooring');
		$lMarkerArray['floorLoad'] = $this->getDataFloat('/ExposeResult/Industry/floorLoad');
		$lMarkerArray['floors'] = $this->getDataString('/ExposeResult/Industry/floors');
		$lMarkerArray['hoist'] = $this->getDataBool('/ExposeResult/Industry/hoist');
		$lMarkerArray['hoistCapacity'] = $this->getDataFloat('/ExposeResult/Industry/hoistCapacity');
		$lMarkerArray['liftingPlatform'] = $this->getDataBool('/ExposeResult/Industry/liftingPlatform');
		$lMarkerArray['ramp'] = $this->getDataBool('/ExposeResult/Industry/ramp');
		$lMarkerArray['hasCourtage'] = $this->getDataBool('/ExposeResult/Industry/hasCourtage');
		$lMarkerArray['hasElevator'] = $this->getDataBool('/ExposeResult/Industry/hasElevator');
		$lMarkerArray['noParking'] = $this->getDataInt('/ExposeResult/Industry/noParking');
		$lMarkerArray['parkingPrice'] = $this->getDataCurrency('/ExposeResult/Industry/parkingPrice');
		$lMarkerArray['timeAirport'] = $this->getDataInt('/ExposeResult/Industry/timeAirport');
		$lMarkerArray['timeBusStop'] = $this->getDataInt('/ExposeResult/Industry/timeBusStop');
		$lMarkerArray['timeMotorway'] = $this->getDataInt('/ExposeResult/Industry/timeMotorway');
		$lMarkerArray['timeRailway'] = $this->getDataInt('/ExposeResult/Industry/timeRailway');
		$lMarkerArray['description'] = $this->getDataString('/ExposeResult/Industry/description');
		$lMarkerArray['interior'] = $this->getDataString('/ExposeResult/Industry/interior');
		$lMarkerArray['otherInfo'] = $this->getDataString('/ExposeResult/Industry/otherInfo');
		$lMarkerArray['position'] = $this->getDataString('/ExposeResult/Industry/position');

		// Add markers from type RealEstate
		$lMarkerArray = array_merge($lMarkerArray, $this->parseRealEstate());

		// Add markers from type GISRealEstate
		$lMarkerArray = array_merge($lMarkerArray, $this->parseGISRealEstate());

		// Reset parser
		$this->oXpath->reset();

		return $lMarkerArray;
	}

}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/lumoscoutexpose/parsers/class.tx_lumoscoutexpose_parser_industry.php']) {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/lumoscoutexpose/parsers/class.tx_lumoscoutexpose_parser_industry.php']);
}

?>