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
 * Parser for ExposeResult of type Store.
 *
 * @author Thomas Off <typo3@retiolum.de>
 * @package TYPO3
 * @subpackage tx_lumoscoutexpose
 */
class tx_lumoscoutexpose_parser_store extends tx_lumoscoutexpose_parser_base {

    /**
     * Constructor for the parser class.
     *
     * @param array $lLang: Language labels used for parsing of values
     * @return
     */
    function tx_lumoscoutexpose_parser_store($lLang) {
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

        // Markers from type Store
        $lMarkerArray['buildingType'] = $this->getDataString('/ExposeResult/Store/buildingType');
        $lMarkerArray['netArea'] = $this->getDataFloat('/ExposeResult/Store/netArea');
        $lMarkerArray['totalArea'] = $this->getDataFloat('/ExposeResult/Store/totalArea');
        $lMarkerArray['netRent'] = $this->getDataCurrency('/ExposeResult/Store/netRent');
        $lMarkerArray['price'] = $this->getDataCurrency('/ExposeResult/Store/price');
        $lMarkerArray['rentPerSqM'] = $this->getDataCurrency('/ExposeResult/Store/rentPerSqM');
        $lMarkerArray['courtage'] = $this->getDataString('/ExposeResult/Store/courtage');
        $lMarkerArray['yearConstructed'] = $this->getDataInt('/ExposeResult/Store/yearConstructed');
        $lMarkerArray['kaution'] = $this->getDataString('/ExposeResult/Store/kaution');
        $lMarkerArray['marketing'] = $this->getDataString('/ExposeResult/Store/marketing');
        $lMarkerArray['marketingPrice'] = $this->getDataCurrency('/ExposeResult/Store/marketingPrice');
        $lMarkerArray['minDivisible'] = $this->getDataFloat('/ExposeResult/Store/minDivisible');
        $lMarkerArray['additionalCosts'] = $this->getDataCurrency('/ExposeResult/Store/additionalCosts');
        $lMarkerArray['heatingCosts'] = $this->getDataCurrency('/ExposeResult/Store/heatingCosts');
        $lMarkerArray['heatingCostsInRent'] = $this->getDataBool('/ExposeResult/Store/heatingCostsInRent');
        $lMarkerArray['additionalArea'] = $this->getDataFloat('/ExposeResult/Store/additionalArea');
        $lMarkerArray['availableDate'] = $this->getDataString('/ExposeResult/Store/availableDate');
        $lMarkerArray['condition'] = $this->getDataString('/ExposeResult/Store/condition');
        $lMarkerArray['flooring'] = $this->getDataString('/ExposeResult/Store/flooring');
        $lMarkerArray['floors'] = $this->getDataString('/ExposeResult/Store/floors');
        $lMarkerArray['hasCourtage'] = $this->getDataBool('/ExposeResult/Store/hasCourtage');
        $lMarkerArray['hasElevator'] = $this->getDataBool('/ExposeResult/Store/hasElevator');
        $lMarkerArray['noParking'] = $this->getDataInt('/ExposeResult/Store/noParking');
        $lMarkerArray['parkingPrice'] = $this->getDataCurrency('/ExposeResult/Store/parkingPrice');
        $lMarkerArray['timeAirport'] = $this->getDataInt('/ExposeResult/Store/timeAirport');
        $lMarkerArray['timeBusStop'] = $this->getDataInt('/ExposeResult/Store/timeBusStop');
        $lMarkerArray['timeMotorway'] = $this->getDataInt('/ExposeResult/Store/timeMotorway');
        $lMarkerArray['timeRailway'] = $this->getDataInt('/ExposeResult/Store/timeRailway');
        $lMarkerArray['hoist'] = $this->getDataBool('/ExposeResult/Store/hoist');
        $lMarkerArray['hoistCapacity'] = $this->getDataFloat('/ExposeResult/Store/hoistCapacity');
        $lMarkerArray['ramp'] = $this->getDataBool('/ExposeResult/Store/ramp');
        $lMarkerArray['delivery'] = $this->getDataString('/ExposeResult/Store/delivery');
        $lMarkerArray['windowLength'] = $this->getDataFloat('/ExposeResult/Store/windowLength');
        $lMarkerArray['storeLocation'] = $this->getDataString('/ExposeResult/Store/storeLocation');
        $lMarkerArray['description'] = $this->getDataString('/ExposeResult/Store/description');
        $lMarkerArray['interior'] = $this->getDataString('/ExposeResult/Store/interior');
        $lMarkerArray['otherInfo'] = $this->getDataString('/ExposeResult/Store/otherInfo');
        $lMarkerArray['position'] = $this->getDataString('/ExposeResult/Store/position');

        // Add markers from type RealEstate
        $lMarkerArray = array_merge($lMarkerArray, $this->parseRealEstate());

        // Add markers from type GISRealEstate
        $lMarkerArray = array_merge($lMarkerArray, $this->parseGISRealEstate());

        // Reset parser
        $this->oXpath->reset();

        return $lMarkerArray;
    }

}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/lumoscoutexpose/parsers/class.tx_lumoscoutexpose_parser_store.php']) {
    include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/lumoscoutexpose/parsers/class.tx_lumoscoutexpose_parser_store.php']);
}

?>