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
 * Parser for ExposeResult of type HouseBuy.
 *
 * @author	Thomas Off, LumoNet oHG <t.off@lumonet.de>
 * @package	TYPO3
 * @subpackage	tx_lumoscoutexpose
 */
class tx_lumoscoutexpose_parser_housebuy extends tx_lumoscoutexpose_parser_base {

	/**
	 * Constructor for the parser class.
	 *
	 * @param	array		$lLang: Language labels used for parsing of values
	 * @return
	 */
	function tx_lumoscoutexpose_parser_housebuy($lLang) {
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

		// Markers from type HouseBuy
		$lMarkerArray['buildingType'] = $this->getDataString('/ExposeResult/HouseBuy/buildingType');
		$lMarkerArray['netArea'] = $this->getDataFloat('/ExposeResult/HouseBuy/netArea');
		$lMarkerArray['noRooms'] = $this->getDataFloat('/ExposeResult/HouseBuy/noRooms');
		$lMarkerArray['price'] = $this->getDataCurrency('/ExposeResult/HouseBuy/price');
		$lMarkerArray['rentalIncomeActual'] = $this->getDataCurrency('/ExposeResult/HouseBuy/rentalIncomeActual');
		$lMarkerArray['lotSize'] = $this->getDataFloat('/ExposeResult/HouseBuy/lotSize');
		$lMarkerArray['courtage'] = $this->getDataString('/ExposeResult/HouseBuy/courtage');
		$lMarkerArray['additionalCosts'] = $this->getDataCurrency('/ExposeResult/HouseBuy/additionalCosts');
		$lMarkerArray['heatingCosts'] = $this->getDataCurrency('/ExposeResult/HouseBuy/heatingCosts');
		$lMarkerArray['heatingCostsInRent'] = $this->getDataBool('/ExposeResult/HouseBuy/heatingCostsInRent');
		$lMarkerArray['yearConstructed'] = $this->getDataInt('/ExposeResult/HouseBuy/yearConstructed');
		$lMarkerArray['availableDate'] = $this->getDataString('/ExposeResult/HouseBuy/availableDate');
		$lMarkerArray['condition'] = $this->getDataString('/ExposeResult/HouseBuy/condition');
		$lMarkerArray['heating'] = $this->getDataString('/ExposeResult/HouseBuy/heating');
		$lMarkerArray['totalArea'] = $this->getDataFloat('/ExposeResult/HouseBuy/totalArea');
		$lMarkerArray['noStories'] = $this->getDataInt('/ExposeResult/HouseBuy/noStories');
		$lMarkerArray['logderFlat'] = $this->getDataBool('/ExposeResult/HouseBuy/logderFlat');
		$lMarkerArray['isRented'] = $this->getDataBool('/ExposeResult/HouseBuy/isRented');
		$lMarkerArray['hasElevator'] = $this->getDataBool('/ExposeResult/HouseBuy/hasElevator');
		$lMarkerArray['hasCourtage'] = $this->getDataBool('/ExposeResult/HouseBuy/hasCourtage');
		$lMarkerArray['wheelchair'] = $this->getDataBool('/ExposeResult/HouseBuy/wheelchair');
		$lMarkerArray['noBathrooms'] = $this->getDataInt('/ExposeResult/HouseBuy/noBathrooms');
		$lMarkerArray['noBedrooms'] = $this->getDataInt('/ExposeResult/HouseBuy/noBedrooms');
		$lMarkerArray['hasParking'] = $this->getDataBool('/ExposeResult/HouseBuy/hasParking');
		$lMarkerArray['parkingPrice'] = $this->getDataCurrency('/ExposeResult/HouseBuy/parkingPrice');
		$lMarkerArray['description'] = $this->getDataString('/ExposeResult/HouseBuy/description');
		$lMarkerArray['interior'] = $this->getDataString('/ExposeResult/HouseBuy/interior');
		$lMarkerArray['otherInfo'] = $this->getDataString('/ExposeResult/HouseBuy/otherInfo');
		$lMarkerArray['position'] = $this->getDataString('/ExposeResult/HouseBuy/position');

		// Add markers from type RealEstate
		$lMarkerArray = array_merge($lMarkerArray, $this->parseRealEstate());

		// Add markers from type GISRealEstate
		$lMarkerArray = array_merge($lMarkerArray, $this->parseGISRealEstate());

		// Reset parser
		$this->oXpath->reset();

		return $lMarkerArray;
	}

}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/lumoscoutexpose/parsers/class.tx_lumoscoutexpose_parser_housebuy.php']) {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/lumoscoutexpose/parsers/class.tx_lumoscoutexpose_parser_housebuy.php']);
}

?>