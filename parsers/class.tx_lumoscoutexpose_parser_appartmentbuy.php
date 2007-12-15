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
 * Parser for ExposeResult of type AppartmentBuy.
 *
 * @author Thomas Off <typo3@retiolum.de>
 * @package TYPO3
 * @subpackage tx_lumoscoutexpose
 */
class tx_lumoscoutexpose_parser_appartmentbuy extends tx_lumoscoutexpose_parser_base {

    /**
     * Constructor for the parser class.
     *
     * @param array $lLang: Language labels used for parsing of values
     * @return
     */
    function tx_lumoscoutexpose_parser_appartmentbuy($lLang) {
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

        // Markers from type AppartmentBuy
        $lMarkerArray['buildingType'] = $this->getDataString('/ExposeResult/AppartmentBuy/buildingType');
        $lMarkerArray['netArea'] = $this->getDataFloat('/ExposeResult/AppartmentBuy/netArea');
        $lMarkerArray['noRooms'] = $this->getDataFloat('/ExposeResult/AppartmentBuy/noRooms');
        $lMarkerArray['price'] = $this->getDataCurrency('/ExposeResult/AppartmentBuy/price');
        $lMarkerArray['rentalIncomeActual'] = $this->getDataCurrency('/ExposeResult/AppartmentBuy/rentalIncomeActual');
        $lMarkerArray['rentSubsidy'] = $this->getDataCurrency('/ExposeResult/AppartmentBuy/rentSubsidy');
        $lMarkerArray['courtage'] = $this->getDataString('/ExposeResult/AppartmentBuy/courtage');
        $lMarkerArray['additionalCosts'] = $this->getDataCurrency('/ExposeResult/AppartmentBuy/additionalCosts');
        $lMarkerArray['heatingCosts'] = $this->getDataCurrency('/ExposeResult/AppartmentBuy/heatingCosts');
        $lMarkerArray['heatingCostsInRent'] = $this->getDataBool('/ExposeResult/AppartmentBuy/heatingCostsInRent');
        $lMarkerArray['yearConstructed'] = $this->getDataInt('/ExposeResult/AppartmentBuy/yearConstructed');
        $lMarkerArray['availableDate'] = $this->getDataString('/ExposeResult/AppartmentBuy/availableDate');
        $lMarkerArray['condition'] = $this->getDataString('/ExposeResult/AppartmentBuy/condition');
        $lMarkerArray['heating'] = $this->getDataString('/ExposeResult/AppartmentBuy/heating');
        $lMarkerArray['totalArea'] = $this->getDataFloat('/ExposeResult/AppartmentBuy/totalArea');
        $lMarkerArray['floor'] = $this->getDataInt('/ExposeResult/AppartmentBuy/floor');
        $lMarkerArray['noStories'] = $this->getDataInt('/ExposeResult/AppartmentBuy/noStories');
        $lMarkerArray['isRented'] = $this->getDataBool('/ExposeResult/AppartmentBuy/isRented');
        $lMarkerArray['hasElevator'] = $this->getDataBool('/ExposeResult/AppartmentBuy/hasElevator');
        $lMarkerArray['hasBalcony'] = $this->getDataBool('/ExposeResult/AppartmentBuy/hasBalcony');
        $lMarkerArray['hasGarden'] = $this->getDataBool('/ExposeResult/AppartmentBuy/hasGarden');
        $lMarkerArray['hasCourtage'] = $this->getDataBool('/ExposeResult/AppartmentBuy/hasCourtage');
        $lMarkerArray['wheelchair'] = $this->getDataBool('/ExposeResult/AppartmentBuy/wheelchair');
        $lMarkerArray['noBathrooms'] = $this->getDataInt('/ExposeResult/AppartmentBuy/noBathrooms');
        $lMarkerArray['noBedrooms'] = $this->getDataInt('/ExposeResult/AppartmentBuy/noBedrooms');
        $lMarkerArray['kitchenComplete'] = $this->getDataBool('/ExposeResult/AppartmentBuy/kitchenComplete');
        $lMarkerArray['hasParking'] = $this->getDataBool('/ExposeResult/AppartmentBuy/hasParking');
        $lMarkerArray['parkingPrice'] = $this->getDataCurrency('/ExposeResult/AppartmentBuy/parkingPrice');
        $lMarkerArray['cared'] = $this->getDataBool('/ExposeResult/AppartmentBuy/cared');
        $lMarkerArray['description'] = $this->getDataString('/ExposeResult/AppartmentBuy/description');
        $lMarkerArray['interior'] = $this->getDataString('/ExposeResult/AppartmentBuy/interior');
        $lMarkerArray['otherInfo'] = $this->getDataString('/ExposeResult/AppartmentBuy/otherInfo');
        $lMarkerArray['position'] = $this->getDataString('/ExposeResult/AppartmentBuy/position');

        // Add markers from type RealEstate
        $lMarkerArray = array_merge($lMarkerArray, $this->parseRealEstate());

        // Add markers from type GISRealEstate
        $lMarkerArray = array_merge($lMarkerArray, $this->parseGISRealEstate());

        // Reset parser
        $this->oXpath->reset();

        return $lMarkerArray;
    }

}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/lumoscoutexpose/parsers/class.tx_lumoscoutexpose_parser_appartmentbuy.php']) {
    include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/lumoscoutexpose/parsers/class.tx_lumoscoutexpose_parser_appartmentbuy.php']);
}

?>