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
 * Parser for ExposeResult of type AppartmentRent.
 *
 * @author	Thomas Off <typo3@retiolum.de>
 * @package	TYPO3
 * @subpackage	tx_lumoscoutexpose
 */
class tx_lumoscoutexpose_parser_appartmentrent extends tx_lumoscoutexpose_parser_base {

	/**
	 * Constructor for the parser class.
	 *
	 * @param	array		$lLang: Language labels used for parsing of values
	 * @return
	 */
	function tx_lumoscoutexpose_parser_appartmentrent($lLang) {
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

		// Markers from type AppartmentRent
		$lMarkerArray['buildingType'] = $this->getDataString('/ExposeResult/AppartmentRent/buildingType');
		$lMarkerArray['netArea'] = $this->getDataFloat('/ExposeResult/AppartmentRent/netArea');
		$lMarkerArray['noRooms'] = $this->getDataFloat('/ExposeResult/AppartmentRent/noRooms');
		$lMarkerArray['netRent'] = $this->getDataCurrency('/ExposeResult/AppartmentRent/netRent');
		$lMarkerArray['courtage'] = $this->getDataString('/ExposeResult/AppartmentRent/courtage');
		$lMarkerArray['additionalCosts'] = $this->getDataCurrency('/ExposeResult/AppartmentRent/additionalCosts');
		$lMarkerArray['heatingCosts'] = $this->getDataCurrency('/ExposeResult/AppartmentRent/heatingCosts');
		$lMarkerArray['heatingCostsInRent'] = $this->getDataBool('/ExposeResult/AppartmentRent/heatingCostsInRent');
		$lMarkerArray['kaution'] = $this->getDataString('/ExposeResult/AppartmentRent/kaution');
		$lMarkerArray['yearConstructed'] = $this->getDataInt('/ExposeResult/AppartmentRent/yearConstructed');
		$lMarkerArray['availableDate'] = $this->getDataString('/ExposeResult/AppartmentRent/availableDate');
		$lMarkerArray['condition'] = $this->getDataString('/ExposeResult/AppartmentRent/condition');
		$lMarkerArray['heating'] = $this->getDataString('/ExposeResult/AppartmentRent/heating');
		$lMarkerArray['totalArea'] = $this->getDataFloat('/ExposeResult/AppartmentRent/totalArea');
		$lMarkerArray['totalRent'] = $this->getDataCurrency('/ExposeResult/AppartmentRent/totalRent');
		$lMarkerArray['floor'] = $this->getDataInt('/ExposeResult/AppartmentRent/floor');
		$lMarkerArray['noStories'] = $this->getDataInt('/ExposeResult/AppartmentRent/noStories');
		$lMarkerArray['hasElevator'] = $this->getDataBool('/ExposeResult/AppartmentRent/hasElevator');
		$lMarkerArray['hasBalcony'] = $this->getDataBool('/ExposeResult/AppartmentRent/hasBalcony');
		$lMarkerArray['hasGarden'] = $this->getDataBool('/ExposeResult/AppartmentRent/hasGarden');
		$lMarkerArray['hasCourtage'] = $this->getDataBool('/ExposeResult/AppartmentRent/hasCourtage');
		$lMarkerArray['wheelchair'] = $this->getDataBool('/ExposeResult/AppartmentRent/wheelchair');
		$lMarkerArray['noBathrooms'] = $this->getDataInt('/ExposeResult/AppartmentRent/noBathrooms');
		$lMarkerArray['noBedrooms'] = $this->getDataInt('/ExposeResult/AppartmentRent/noBedrooms');
		$lMarkerArray['kitchenComplete'] = $this->getDataBool('/ExposeResult/AppartmentRent/kitchenComplete');
		$lMarkerArray['hasParking'] = $this->getDataBool('/ExposeResult/AppartmentRent/hasParking');
		$lMarkerArray['parkingPrice'] = $this->getDataCurrency('/ExposeResult/AppartmentRent/parkingPrice');
		$lMarkerArray['cared'] = $this->getDataBool('/ExposeResult/AppartmentRent/cared');
		$lMarkerArray['hasFoerderung'] = $this->getDataBool('/ExposeResult/AppartmentRent/hasFoerderung');
		$lMarkerArray['petsAllowed'] = $this->getDataString('/ExposeResult/AppartmentRent/petsAllowed');
		$lMarkerArray['description'] = $this->getDataString('/ExposeResult/AppartmentRent/description');
		$lMarkerArray['interior'] = $this->getDataString('/ExposeResult/AppartmentRent/interior');
		$lMarkerArray['otherInfo'] = $this->getDataString('/ExposeResult/AppartmentRent/otherInfo');
		$lMarkerArray['position'] = $this->getDataString('/ExposeResult/AppartmentRent/position');

		// Add markers from type RealEstate
		$lMarkerArray = array_merge($lMarkerArray, $this->parseRealEstate());

		// Add markers from type GISRealEstate
		$lMarkerArray = array_merge($lMarkerArray, $this->parseGISRealEstate());

		// Reset parser
		$this->oXpath->reset();

		return $lMarkerArray;
	}

}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/lumoscoutexpose/parsers/class.tx_lumoscoutexpose_parser_appartmentrent.php']) {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/lumoscoutexpose/parsers/class.tx_lumoscoutexpose_parser_appartmentrent.php']);
}

?>