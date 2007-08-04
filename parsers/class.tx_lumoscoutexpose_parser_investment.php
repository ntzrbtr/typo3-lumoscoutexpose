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
 * Parser for ExposeResult of type Investment.
 *
 * @author	Thomas Off, LumoNet oHG <t.off@lumonet.de>
 * @package	TYPO3
 * @subpackage	tx_lumoscoutexpose
 */
class tx_lumoscoutexpose_parser_investment extends tx_lumoscoutexpose_parser_base {

	/**
	 * Constructor for the parser class.
	 *
	 * @param	array		$lLang: Language labels used for parsing of values
	 * @return
	 */
	function tx_lumoscoutexpose_parser_investment($lLang) {
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

		// Markers from type Investment
		$lMarkerArray['buildingType'] = $this->getDataString('/ExposeResult/Investment/buildingType');
		$lMarkerArray['livingSpace'] = $this->getDataFloat('/ExposeResult/Investment/livingSpace');
		$lMarkerArray['netArea'] = $this->getDataFloat('/ExposeResult/Investment/netArea');
		$lMarkerArray['totalArea'] = $this->getDataFloat('/ExposeResult/Investment/totalArea');
		$lMarkerArray['price'] = $this->getDataCurrency('/ExposeResult/Investment/price');
		$lMarkerArray['priceMultiplier'] = $this->getDataFloat('/ExposeResult/Investment/priceMultiplier');
		$lMarkerArray['pricePerSqM'] = $this->getDataCurrency('/ExposeResult/Investment/pricePerSqM');
		$lMarkerArray['rentalIncomeActual'] = $this->getDataCurrency('/ExposeResult/Investment/rentalIncomeActual');
		$lMarkerArray['rentalIncomeTarget'] = $this->getDataCurrency('/ExposeResult/Investment/rentalIncomeTarget');
		$lMarkerArray['courtage'] = $this->getDataString('/ExposeResult/Investment/courtage');
		$lMarkerArray['yearConstructed'] = $this->getDataInt('/ExposeResult/Investment/yearConstructed');
		$lMarkerArray['marketing'] = $this->getDataString('/ExposeResult/Investment/marketing');
		$lMarkerArray['marketingPrice'] = $this->getDataCurrency('/ExposeResult/Investment/marketingPrice');
		$lMarkerArray['minDivisible'] = $this->getDataFloat('/ExposeResult/Investment/minDivisible');
		$lMarkerArray['additionalCosts'] = $this->getDataCurrency('/ExposeResult/Investment/additionalCosts');
		$lMarkerArray['otherCosts'] = $this->getDataCurrency('/ExposeResult/Investment/otherCosts');
		$lMarkerArray['additionalArea'] = $this->getDataFloat('/ExposeResult/Investment/additionalArea');
		$lMarkerArray['industrialArea'] = $this->getDataFloat('/ExposeResult/Investment/industrialArea');
		$lMarkerArray['siteArea'] = $this->getDataFloat('/ExposeResult/Investment/siteArea');
		$lMarkerArray['availableDate'] = $this->getDataString('/ExposeResult/Investment/availableDate');
		$lMarkerArray['condition'] = $this->getDataString('/ExposeResult/Investment/condition');
		$lMarkerArray['floors'] = $this->getDataString('/ExposeResult/Investment/floors');
		$lMarkerArray['hasCourtage'] = $this->getDataBool('/ExposeResult/Investment/hasCourtage');
		$lMarkerArray['hasElevator'] = $this->getDataBool('/ExposeResult/Investment/hasElevator');
		$lMarkerArray['noParking'] = $this->getDataInt('/ExposeResult/Investment/noParking');
		$lMarkerArray['parkingPrice'] = $this->getDataCurrency('/ExposeResult/Investment/parkingPrice');
		$lMarkerArray['timeAirport'] = $this->getDataInt('/ExposeResult/Investment/timeAirport');
		$lMarkerArray['timeBusStop'] = $this->getDataInt('/ExposeResult/Investment/timeBusStop');
		$lMarkerArray['timeMotorway'] = $this->getDataInt('/ExposeResult/Investment/timeMotorway');
		$lMarkerArray['timeRailway'] = $this->getDataInt('/ExposeResult/Investment/timeRailway');
		$lMarkerArray['description'] = $this->getDataString('/ExposeResult/Investment/description');
		$lMarkerArray['interior'] = $this->getDataString('/ExposeResult/Investment/interior');
		$lMarkerArray['otherInfo'] = $this->getDataString('/ExposeResult/Investment/otherInfo');
		$lMarkerArray['position'] = $this->getDataString('/ExposeResult/Investment/position');

		// Add markers from type RealEstate
		$lMarkerArray = array_merge($lMarkerArray, $this->parseRealEstate());

		// Add markers from type GISRealEstate
		$lMarkerArray = array_merge($lMarkerArray, $this->parseGISRealEstate());

		// Reset parser
		$this->oXpath->reset();

		return $lMarkerArray;
	}

}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/lumoscoutexpose/parsers/class.tx_lumoscoutexpose_parser_investment.php']) {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/lumoscoutexpose/parsers/class.tx_lumoscoutexpose_parser_investment.php']);
}

?>