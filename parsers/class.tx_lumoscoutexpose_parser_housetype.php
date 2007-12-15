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
 * Parser for ExposeResult of type HouseType.
 *
 * @author Thomas Off <typo3@retiolum.de>
 * @package TYPO3
 * @subpackage tx_lumoscoutexpose
 */
class tx_lumoscoutexpose_parser_housetype extends tx_lumoscoutexpose_parser_base {

    /**
     * Constructor for the parser class.
     *
     * @param array $lLang: Language labels used for parsing of values
     * @return
     */
    function tx_lumoscoutexpose_parser_housetype($lLang) {
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

        // Markers from type HouseType
        $lMarkerArray['buildingType'] = $this->getDataString('/ExposeResult/HouseType/buildingType');
        $lMarkerArray['style'] = $this->getDataString('/ExposeResult/HouseType/style');
        $lMarkerArray['netArea'] = $this->getDataFloat('/ExposeResult/HouseType/netArea');
        $lMarkerArray['totalArea'] = $this->getDataFloat('/ExposeResult/HouseType/totalArea');
        $lMarkerArray['noRooms'] = $this->getDataFloat('/ExposeResult/HouseType/noRooms');
        $lMarkerArray['price'] = $this->getDataCurrency('/ExposeResult/HouseType/price');
        $lMarkerArray['baseArea'] = $this->getDataFloat('/ExposeResult/HouseType/baseArea');
        $lMarkerArray['KWValue'] = $this->getDataFloat('/ExposeResult/HouseType/KWValue');
        $lMarkerArray['modelInfo'] = $this->getDataString('/ExposeResult/HouseType/modelInfo');
        $lMarkerArray['roofInfo'] = $this->getDataString('/ExposeResult/HouseType/roofInfo');
        $lMarkerArray['storyInfo'] = $this->getDataString('/ExposeResult/HouseType/storyInfo');
        $lMarkerArray['typeInfo'] = $this->getDataString('/ExposeResult/HouseType/typeInfo');
        $lMarkerArray['workInfo'] = $this->getDataString('/ExposeResult/HouseType/workInfo');

        // Add markers from type RealEstate
        $lMarkerArray = array_merge($lMarkerArray, $this->parseRealEstate());

        // Add markers from type GISRealEstate
        $lMarkerArray = array_merge($lMarkerArray, $this->parseGISRealEstate());

        // Reset parser
        $this->oXpath->reset();

        return $lMarkerArray;
    }

}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/lumoscoutexpose/parsers/class.tx_lumoscoutexpose_parser_housetype.php']) {
    include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/lumoscoutexpose/parsers/class.tx_lumoscoutexpose_parser_housetype.php']);
}

?>