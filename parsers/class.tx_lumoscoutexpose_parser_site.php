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
 * Parser for ExposeResult of type Site.
 *
 * @author	Thomas Off, LumoNet oHG <t.off@lumonet.de>
 * @package	TYPO3
 * @subpackage	tx_lumoscoutexpose
 */
class tx_lumoscoutexpose_parser_site extends tx_lumoscoutexpose_parser_base {

	/**
	 * Constructor for the parser class.
	 *
	 * @param	array		$lLang: Language labels used for parsing of values
	 * @return
	 */
	function tx_lumoscoutexpose_parser_site($lLang) {
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

		// Markers from type Site
		$lMarkerArray['buildingType'] = $this->getDataString('/ExposeResult/Site/buildingType');
		$lMarkerArray['areaSize'] = $this->getDataFloat('/ExposeResult/Site/areaSize');
		$lMarkerArray['courtage'] = $this->getDataString('/ExposeResult/Site/courtage');
		$lMarkerArray['availableDate'] = $this->getDataString('/ExposeResult/Site/availableDate');
		$lMarkerArray['buildGuidelines'] = $this->getDataString('/ExposeResult/Site/buildGuidelines');
		$lMarkerArray['buildObject'] = $this->getDataString('/ExposeResult/Site/buildObject');
		$lMarkerArray['development'] = $this->getDataString('/ExposeResult/Site/development');
		$lMarkerArray['leaseDuration'] = $this->getDataInt('/ExposeResult/Site/leaseDuration');
		$lMarkerArray['leaseInterval'] = $this->getDataString('/ExposeResult/Site/leaseInterval');
		$lMarkerArray['marketing'] = $this->getDataString('/ExposeResult/Site/marketing');
		$lMarkerArray['marketingPrice'] = $this->getDataCurrency('/ExposeResult/Site/marketingPrice');
		$lMarkerArray['minDivisible'] = $this->getDataFloat('/ExposeResult/Site/minDivisible');
		$lMarkerArray['demolition'] = $this->getDataBool('/ExposeResult/Site/demolition');
		$lMarkerArray['planingPermission'] = $this->getDataBool('/ExposeResult/Site/planingPermission');
		$lMarkerArray['shortTermBuild'] = $this->getDataBool('/ExposeResult/Site/shortTermBuild');
		$lMarkerArray['hasCourtage'] = $this->getDataBool('/ExposeResult/Site/hasCourtage');
		$lMarkerArray['GRZ'] = $this->getDataFloat('/ExposeResult/Site/GRZ');
		$lMarkerArray['GFZ'] = $this->getDataFloat('/ExposeResult/Site/GFZ');
		$lMarkerArray['description'] = $this->getDataString('/ExposeResult/Site/description');
		$lMarkerArray['otherInfo'] = $this->getDataString('/ExposeResult/Site/otherInfo');
		$lMarkerArray['position'] = $this->getDataString('/ExposeResult/Site/position');

		// Add markers from type RealEstate
		$lMarkerArray = array_merge($lMarkerArray, $this->parseRealEstate());

		// Add markers from type GISRealEstate
		$lMarkerArray = array_merge($lMarkerArray, $this->parseGISRealEstate());

		// Reset parser
		$this->oXpath->reset();

		return $lMarkerArray;
	}

}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/lumoscoutexpose/parsers/class.tx_lumoscoutexpose_parser_site.php']) {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/lumoscoutexpose/parsers/class.tx_lumoscoutexpose_parser_site.php']);
}

?>