<?php
/*
 * Copyright notice
 *
 * (c) 2006-2008 Thomas Off <typo3@retiolum.de>
 * All rights reserved
 *
 * This script is part of the TYPO3 project. The TYPO3 project is
 * free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * The GNU General Public License can be found at
 * http://www.gnu.org/copyleft/gpl.html.
 *
 * This script is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * This copyright notice MUST APPEAR in all copies of the script!
 */

require_once(t3lib_extMgm::extPath('lumoscoutexpose') . 'libs/XPath.class.php');

require_once(t3lib_extMgm::extPath('lumoscoutexpose') . 'parsers/class.tx_lumoscoutexpose_parser_base.php');

/**
 * Parser for ExposeResult of type Office.
 *
 * @author Thomas Off <typo3@retiolum.de>
 * @package TYPO3
 * @subpackage tx_lumoscoutexpose
 */
class tx_lumoscoutexpose_parser_office extends tx_lumoscoutexpose_parser_base {

    /**
     * Constructor for the parser class.
     *
     * @param array $lLang: Language labels used for parsing of values
     * @return
     */
    function tx_lumoscoutexpose_parser_office($lLang) {
        $this->lLang = $lLang;
    }

    /**
     * Parse a given exposé and return an array of markers to be replaced in the template used.
     *
     * @param string $sExpose: XML string that contains the exposé that was obtained via ImmobilienScout24.de API
     * @return array An array of markers to be replaced in the template used
     */
    function parse($sExpose) {
        // Initialize XML parser
        $this->oXpath =& new XPath();
        $this->oXpath->importFromString($sExpose);

        // Set up marker array
        $lMarkerArray = array();

        // Markers from type Office
        $lMarkerArray['buildingType'] = $this->getDataString('/ExposeResult/Office/buildingType');
        $lMarkerArray['netArea'] = $this->getDataFloat('/ExposeResult/Office/netArea');
        $lMarkerArray['totalArea'] = $this->getDataFloat('/ExposeResult/Office/totalArea');
        $lMarkerArray['netRent'] = $this->getDataCurrency('/ExposeResult/Office/netRent');
        $lMarkerArray['price'] = $this->getDataCurrency('/ExposeResult/Office/price');
        $lMarkerArray['rentPerSqM'] = $this->getDataCurrency('/ExposeResult/Office/rentPerSqM');
        $lMarkerArray['courtage'] = $this->getDataString('/ExposeResult/Office/courtage');
        $lMarkerArray['yearConstructed'] = $this->getDataInt('/ExposeResult/Office/yearConstructed');
        $lMarkerArray['kaution'] = $this->getDataString('/ExposeResult/Office/kaution');
        $lMarkerArray['marketing'] = $this->getDataString('/ExposeResult/Office/marketing');
        $lMarkerArray['marketingPrice'] = $this->getDataCurrency('/ExposeResult/Office/marketingPrice');
        $lMarkerArray['minDivisible'] = $this->getDataFloat('/ExposeResult/Office/minDivisible');
        $lMarkerArray['additionalCosts'] = $this->getDataCurrency('/ExposeResult/Office/additionalCosts');
        $lMarkerArray['heatingCosts'] = $this->getDataCurrency('/ExposeResult/Office/heatingCosts');
        $lMarkerArray['heatingCostsInRent'] = $this->getDataBool('/ExposeResult/Office/heatingCostsInRent');
        $lMarkerArray['additionalArea'] = $this->getDataFloat('/ExposeResult/Office/additionalArea');
        $lMarkerArray['availableDate'] = $this->getDataString('/ExposeResult/Office/availableDate');
        $lMarkerArray['condition'] = $this->getDataString('/ExposeResult/Office/condition');
        $lMarkerArray['flooring'] = $this->getDataString('/ExposeResult/Office/flooring');
        $lMarkerArray['floors'] = $this->getDataString('/ExposeResult/Office/floors');
        $lMarkerArray['hasCanteen'] = $this->getDataBool('/ExposeResult/Office/hasCanteen');
        $lMarkerArray['hasCourtage'] = $this->getDataBool('/ExposeResult/Office/hasCourtage');
        $lMarkerArray['hasElevator'] = $this->getDataBool('/ExposeResult/Office/hasElevator');
        $lMarkerArray['hasLanCables'] = $this->getDataBool('/ExposeResult/Office/hasLanCables');
        $lMarkerArray['noParking'] = $this->getDataInt('/ExposeResult/Office/noParking');
        $lMarkerArray['parkingPrice'] = $this->getDataCurrency('/ExposeResult/Office/parkingPrice');
        $lMarkerArray['timeAirport'] = $this->getDataInt('/ExposeResult/Office/timeAirport');
        $lMarkerArray['timeBusStop'] = $this->getDataInt('/ExposeResult/Office/timeBusStop');
        $lMarkerArray['timeMotorway'] = $this->getDataInt('/ExposeResult/Office/timeMotorway');
        $lMarkerArray['timeRailway'] = $this->getDataInt('/ExposeResult/Office/timeRailway');
        $lMarkerArray['description'] = $this->getDataString('/ExposeResult/Office/description');
        $lMarkerArray['interior'] = $this->getDataString('/ExposeResult/Office/interior');
        $lMarkerArray['otherInfo'] = $this->getDataString('/ExposeResult/Office/otherInfo');
        $lMarkerArray['position'] = $this->getDataString('/ExposeResult/Office/position');

        // Add markers from type RealEstate
        $lMarkerArray = array_merge($lMarkerArray, $this->parseRealEstate());

        // Add markers from type GISRealEstate
        $lMarkerArray = array_merge($lMarkerArray, $this->parseGISRealEstate());

        // Reset parser
        $this->oXpath->reset();

        return $lMarkerArray;
    }

}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/lumoscoutexpose/parsers/class.tx_lumoscoutexpose_parser_office.php']) {
    include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/lumoscoutexpose/parsers/class.tx_lumoscoutexpose_parser_office.php']);
}

?>