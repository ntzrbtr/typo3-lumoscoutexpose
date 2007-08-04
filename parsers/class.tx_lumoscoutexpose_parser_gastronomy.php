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
 * Parser for ExposeResult of type Gastronomy.
 *
 * @author	Thomas Off, LumoNet oHG <t.off@lumonet.de>
 * @package	TYPO3
 * @subpackage	tx_lumoscoutexpose
 */
class tx_lumoscoutexpose_parser_gastronomy extends tx_lumoscoutexpose_parser_base {

	/**
	 * Constructor for the parser class.
	 *
	 * @param	array		$lLang: Language labels used for parsing of values
	 * @return
	 */
	function tx_lumoscoutexpose_parser_gastronomy($lLang) {
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

		// Markers from type Gastronomy
		$lMarkerArray['buildingType'] = $this->getDataString('/ExposeResult/Gastronomy/buildingType');
		$lMarkerArray['netArea'] = $this->getDataFloat('/ExposeResult/Gastronomy/netArea');
		$lMarkerArray['totalArea'] = $this->getDataFloat('/ExposeResult/Gastronomy/totalArea');
		$lMarkerArray['netRent'] = $this->getDataCurrency('/ExposeResult/Gastronomy/netRent');
		$lMarkerArray['price'] = $this->getDataCurrency('/ExposeResult/Gastronomy/price');
		$lMarkerArray['courtage'] = $this->getDataString('/ExposeResult/Gastronomy/courtage');
		$lMarkerArray['yearConstructed'] = $this->getDataInt('/ExposeResult/Gastronomy/yearConstructed');
		$lMarkerArray['kaution'] = $this->getDataString('/ExposeResult/Gastronomy/kaution');
		$lMarkerArray['marketing'] = $this->getDataString('/ExposeResult/Gastronomy/marketing');
		$lMarkerArray['marketingPrice'] = $this->getDataCurrency('/ExposeResult/Gastronomy/marketingPrice');
		$lMarkerArray['additionalCosts'] = $this->getDataCurrency('/ExposeResult/Gastronomy/additionalCosts');
		$lMarkerArray['heatingCosts'] = $this->getDataCurrency('/ExposeResult/Gastronomy/heatingCosts');
		$lMarkerArray['heatingCostsInRent'] = $this->getDataBool('/ExposeResult/Gastronomy/heatingCostsInRent');
		$lMarkerArray['additionalArea'] = $this->getDataFloat('/ExposeResult/Gastronomy/additionalArea');
		$lMarkerArray['availableDate'] = $this->getDataString('/ExposeResult/Gastronomy/availableDate');
		$lMarkerArray['condition'] = $this->getDataString('/ExposeResult/Gastronomy/condition');
		$lMarkerArray['floors'] = $this->getDataString('/ExposeResult/Gastronomy/floors');
		$lMarkerArray['hasCourtage'] = $this->getDataBool('/ExposeResult/Gastronomy/hasCourtage');
		$lMarkerArray['hasElevator'] = $this->getDataBool('/ExposeResult/Gastronomy/hasElevator');
		$lMarkerArray['hasTerrace'] = $this->getDataBool('/ExposeResult/Gastronomy/hasTerrace');
		$lMarkerArray['noBeds'] = $this->getDataInt('/ExposeResult/Gastronomy/noBeds');
		$lMarkerArray['noSeats'] = $this->getDataInt('/ExposeResult/Gastronomy/noSeats');
		$lMarkerArray['noParking'] = $this->getDataInt('/ExposeResult/Gastronomy/noParking');
		$lMarkerArray['parkingPrice'] = $this->getDataCurrency('/ExposeResult/Gastronomy/parkingPrice');
		$lMarkerArray['timeAirport'] = $this->getDataInt('/ExposeResult/Gastronomy/timeAirport');
		$lMarkerArray['timeBusStop'] = $this->getDataInt('/ExposeResult/Gastronomy/timeBusStop');
		$lMarkerArray['timeMotorway'] = $this->getDataInt('/ExposeResult/Gastronomy/timeMotorway');
		$lMarkerArray['timeRailway'] = $this->getDataInt('/ExposeResult/Gastronomy/timeRailway');
		$lMarkerArray['description'] = $this->getDataString('/ExposeResult/Gastronomy/description');
		$lMarkerArray['interior'] = $this->getDataString('/ExposeResult/Gastronomy/interior');
		$lMarkerArray['otherInfo'] = $this->getDataString('/ExposeResult/Gastronomy/otherInfo');
		$lMarkerArray['position'] = $this->getDataString('/ExposeResult/Gastronomy/position');

		// Add markers from type RealEstate
		$lMarkerArray = array_merge($lMarkerArray, $this->parseRealEstate());

		// Add markers from type GISRealEstate
		$lMarkerArray = array_merge($lMarkerArray, $this->parseGISRealEstate());

		// Reset parser
		$this->oXpath->reset();

		return $lMarkerArray;
	}

}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/lumoscoutexpose/parsers/class.tx_lumoscoutexpose_parser_gastronomy.php']) {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/lumoscoutexpose/parsers/class.tx_lumoscoutexpose_parser_gastronomy.php']);
}

?>