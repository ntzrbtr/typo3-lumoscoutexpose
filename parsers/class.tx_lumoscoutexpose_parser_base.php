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

/**
 * Base class for all the parsers for the different types of ExposeResult(s);
 * provides common functions (like parsing the parent types of the different exposés).
 *
 * @author Thomas Off <typo3@retiolum.de>
 * @package TYPO3
 * @subpackage tx_lumoscoutexpose
 */
class tx_lumoscoutexpose_parser_base {
    var $oXpath;
    var $lLang;

    /**
     * Get the content of the given node in the XML document and return it as a string.
     *
     * @param string $sXpath: XPath expression of the node whose content shall be fetched
     * @return string The node's content as a string
     */
    function getDataString($sXpath) {
        // Initialize data variable
        $vData = '';

        if ($this->oXpath->match($sXpath)) {
            $vData = $this->oXpath->getData($sXpath);
            $vData = utf8_decode($vData);
        }
        return $vData;
    }

    /**
     * Get the content of the given node in the XML document and return it as an integer.
     *
     * @param string $sXpath: XPath expression of the node whose content shall be fetched
     * @return string The node's content as an integer
     */
    function getDataInt($sXpath) {
        // Initialize data variable
        $vData = 0;

        if ($this->oXpath->match($sXpath)) {
            $vData = $this->oXpath->getData($sXpath);
            $vData = utf8_decode($vData);
            if (preg_match('/^[0-9]*\.[0-9]*$/', $vData)) {
                $vData = number_format(intval($vData), 0, $this->lLang['sep_decimals'], $this->lLang['sep_thousands']);
            }
        }
        return $vData;
    }

    /**
     * Get the content of the given node in the XML document and return it as a float.
     *
     * @param string $sXpath: XPath expression of the node whose content shall be fetched
     * @return string The node's content as a float
     */
    function getDataFloat($sXpath, $sDecimals = '2') {
        // Initialize data variable
        $vData = 0.0;

        if ($this->oXpath->match($sXpath)) {
            $vData = $this->oXpath->getData($sXpath);
            $vData = utf8_decode($vData);
            if (preg_match('/^[0-9]*\.[0-9]*$/', $vData)) {
                $vData = number_format(floatval($vData), $sDecimals, $this->lLang['sep_decimals'], $this->lLang['sep_thousands']);
            }
        }
        return $vData;
    }

    /**
     * Get the content of the given node in the XML document and return it formatted as a 'boolean string' (according to the set language label).
     *
     * @param string $sXpath: XPath expression of the node whose content shall be fetched
     * @return string The node's content formatted as a 'boolean string' (according to the set language label)
     */
    function getDataBool($sXpath) {
        // Initialize data variable
        $vData = '';

        if ($this->oXpath->match($sXpath)) {
            $vData = $this->oXpath->getData($sXpath);
            $vData = utf8_decode($vData);
            if ($vData == 'true') {
                $vData = $this->lLang['yes'];
            }
            else if ($vData == 'false') {
                $vData = $this->lLang['no'];
            }
        }
        return $vData;
    }

    /**
     * Get the content of the given node in the XML document and return it formatted as a date (according to the set language label).
     *
     * @param string $sXpath: XPath expression of the node whose content shall be fetched
     * @return string The node's content formatted as a date (according to the set language label)
     */
    function getDataDate($sXpath) {
        // Initialize data variable
        $vData = '';

        if ($this->oXpath->match($sXpath)) {
            $vData = $this->oXpath->getData($sXpath);
            $vData = utf8_decode($vData);
            if (preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2}/', $vData)) {
                $vData = strftime($this->lLang['date_format'], strtotime(substr($vData, 0, 10)));
            }
        }
        return $vData;
    }

    /**
     * Get the content of the given node in the XML document and return it formatted as a currency value (according to the set language label).
     * Fetches the node's value (the amount) and the node's attribute <pre>currency</pre> and combines them.
     *
     * @param string $sXpath: XPath expression of the node whose content shall be fetched
     * @return string The node's content formatted as a currency value (according to the set language label)
     */
    function getDataCurrency($sXpath) {
        // Initialize data variable
        $vData = 0;

        // Compose data from value and currency name
        $sValue = $this->getDataString($sXpath);
        $sValue = number_format(floatval($sValue), 2, $this->lLang['sep_decimals'], $this->lLang['sep_thousands']);
        $sCurrency = $this->getAttributeString($sXpath, 'currency');
        $vData = trim($sValue . ' ' . $sCurrency);

        return $vData;
    }

    /**
     * Get the specified attribute from the given node in the XML document and return it as a string.
     *
     * @param string $sXpath: XPath expression of the node from which the attribute shall be fetched
     * @param string $sName: Name of the attribute to be fetched
     * @return string The attribute's value as a string
     */
    function getAttributeString($sXpath, $sName) {
        // Initialize data variable
        $vData = '';

        if ($this->oXpath->match($sXpath)) {
            $lAttributes = $this->oXpath->getAttributes($sXpath);
            if (array_key_exists($sName, $lAttributes)) {
                $vData = $lAttributes[$sName];
                $vData = utf8_decode($vData);
            }
        }

        return $vData;
    }

    /**
     * Get the specified attribute from the given node in the XML document and return it as an integer.
     *
     * @param string $sXpath: XPath expression of the node from which the attribute shall be fetched
     * @param string $sName: Name of the attribute to be fetched
     * @return string The attribute's value as an integer
     */
    function getAttributeInt($sXpath, $sName) {
        // Initialize data variable
        $vData = 0;

        if ($this->oXpath->match($sXpath)) {
            $lAttributes = $this->oXpath->getAttributes($sXpath);
            if (array_key_exists($sName, $lAttributes)) {
                $vData = $lAttributes[$sName];
                $vData = utf8_decode($vData);
                if (preg_match('/^[0-9]*\.[0-9]*$/', $vData)) {
                    $vData = number_format(intval($vData), 0, $this->lLang['sep_decimals'], $this->lLang['sep_thousands']);
                }
            }
        }

        return $vData;
    }

    /**
     * Get the specified attribute from the given node in the XML document and return it as a float.
     *
     * @param string $sXpath: XPath expression of the node from which the attribute shall be fetched
     * @param string $sName: Name of the attribute to be fetched
     * @return string The attribute's value as a float
     */
    function getAttributeFloat($sXpath, $sName, $sDecimals = 2) {
        // Initialize data variable
        $vData = 0.0;

        if ($this->oXpath->match($sXpath)) {
            $lAttributes = $this->oXpath->getAttributes($sXpath);
            if (array_key_exists($sName, $lAttributes)) {
                $vData = $lAttributes[$sName];
                $vData = utf8_decode($vData);
                if (preg_match('/^[0-9]*\.[0-9]*$/', $vData)) {
                    $vData = number_format(floatval($vData), $sDecimals, $this->lLang['sep_decimals'], $this->lLang['sep_thousands']);
                }
            }
        }

        return $vData;
    }

    /**
     * Get the specified attribute from the given node in the XML document and return it formatted as a 'boolean string' (according to the set language label).
     *
     * @param string $sXpath: XPath expression of the node from which the attribute shall be fetched
     * @param string $sName: Name of the attribute to be fetched
     * @return string The attribute's value formatted as a 'boolean string' (according to the set language label)
     */
    function getAttributeBool($sXpath, $sName) {
        // Initialize data variable
        $vData = '';

        if ($this->oXpath->match($sXpath)) {
            $lAttributes = $this->oXpath->getAttributes($sXpath);
            if (array_key_exists($sName, $lAttributes)) {
                $vData = $lAttributes[$sName];
                $vData = utf8_decode($vData);
                if ($vData == 'true') {
                    $vData = $this->lLang['yes'];
                }
                else if ($vData == 'false') {
                    $vData = $this->lLang['no'];
                }
            }
        }

        return $vData;
    }

    /**
     * Get the specified attribute from the given node in the XML document and return it formatted as a date (according to the set language label).
     *
     * @param string $sXpath: XPath expression of the node from which the attribute shall be fetched
     * @param string $sName: Name of the attribute to be fetched
     * @return string The attribute's value formatted as a date (according to the set language label)
     */
    function getAttributeDate($sXpath, $sName) {
        // Initialize data variable
        $vData = '';

        if ($this->oXpath->match($sXpath)) {
            $lAttributes = $this->oXpath->getAttributes($sXpath);
            if (array_key_exists($sName, $lAttributes)) {
                $vData = $lAttributes[$sName];
                $vData = utf8_decode($vData);
                if (preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2}/', $vData)) {
                    $vData = strftime($this->lLang['date_format'], strtotime(substr($vData, 0, 10)));
                }
            }
        }

        return $vData;
    }

    /**
     * Parse the object's exposé and extract the markers from the base type RealEstate.
     *
     * @return array An array of markers to be replaced in the template used
     */
    function parseRealEstate() {
        // Set up marker array
        $lMarkerArray = array();

        // Markers from type RealEstate
        $lMarkerArray['CreationDate'] = $this->getDataDate('/ExposeResult/*/CreationDate');
        $lMarkerArray['DeactivationDate'] = $this->getDataDate('/ExposeResult/*/DeactivationDate');
        $lMarkerArray['LastModificationDate'] = $this->getDataDate('/ExposeResult/*/LastModificationDate');
        $lMarkerArray['Heading'] = $this->getDataString('/ExposeResult/*/Heading');
        $lMarkerArray['vendor'] = $this->getDataString('/ExposeResult/*/vendor');
        $lMarkerArray['foreignKey'] = $this->getDataString('/ExposeResult/*/foreignKey');
        $lMarkerArray['groupNumber'] = $this->getDataInt('/ExposeResult/*/groupNumber');

        // Special case: make attribute 'uuid' a marker
        $lMarkerArray['uuid'] = $this->getAttributeString('/ExposeResult/*', 'uuid');

        // Special case: contact address (all data stored in attributes)
        $lMarkerArray['ContactAddress_company1'] = $this->getAttributeString('/ExposeResult/*/ContactAddress', 'company1');
        $lMarkerArray['ContactAddress_company2'] = $this->getAttributeString('/ExposeResult/*/ContactAddress', 'company2');
        $lMarkerArray['ContactAddress_title'] = $this->getAttributeString('/ExposeResult/*/ContactAddress', 'title');
        $lMarkerArray['ContactAddress_salutation'] = $this->getAttributeString('/ExposeResult/*/ContactAddress', 'salutation');
        $lMarkerArray['ContactAddress_firstName'] = $this->getAttributeString('/ExposeResult/*/ContactAddress', 'firstName');
        $lMarkerArray['ContactAddress_lastName'] = $this->getAttributeString('/ExposeResult/*/ContactAddress', 'lastName');
        $lMarkerArray['ContactAddress_phone'] = $this->getAttributeString('/ExposeResult/*/ContactAddress', 'phone');
        $lMarkerArray['ContactAddress_mobile'] = $this->getAttributeString('/ExposeResult/*/ContactAddress', 'mobile');
        $lMarkerArray['ContactAddress_fax'] = $this->getAttributeString('/ExposeResult/*/ContactAddress', 'fax');
        $lMarkerArray['ContactAddress_eMail'] = $this->getAttributeString('/ExposeResult/*/ContactAddress', 'eMail');
        $lMarkerArray['ContactAddress_homepage'] = $this->getAttributeString('/ExposeResult/*/ContactAddress', 'homepage');
        $lMarkerArray['ContactAddress_businessPhone'] = $this->getAttributeString('/ExposeResult/*/ContactAddress', 'businessPhone');
        $lMarkerArray['ContactAddress_businessFax'] = $this->getAttributeString('/ExposeResult/*/ContactAddress', 'businessFax');
        $lMarkerArray['ContactAddress_callBeforeFax'] = $this->getAttributeBool('/ExposeResult/*/ContactAddress', 'callBeforeFax');

        // Special case: attachments
        $lTemp = $this->oXpath->match('/ExposeResult/*/Attachments/Picture');
        for ($i = 0; $i < count($lTemp); $i++) {
            $lMarkerArray['Attachments'][$i]['Attachment_caption'] = $this->getDataString('/ExposeResult/*/Attachments/Picture[' . ($i + 1) . ']/caption');
            $lMarkerArray['Attachments'][$i]['Attachment_url'] = $this->getDataString('/ExposeResult/*/Attachments/Picture[' . ($i + 1) . ']/url');
        }

        return $lMarkerArray;
    }

    /**
     * Parse the object's exposé and extract the markers from the base type GISRealEstate.
     *
     * @return array An array of markers to be replaced in the template used
     */
    function parseGISRealEstate() {
        // Set up marker array
        $lMarkerArray = array();

        // Markers from type GISRealEstate
        $lMarkerArray['Address_street'] = $this->getAttributeString('/ExposeResult/*/Address', 'street');
        $lMarkerArray['Address_houseNo'] = $this->getAttributeString('/ExposeResult/*/Address', 'houseNo');
        $lMarkerArray['Address_zip'] = $this->getAttributeString('/ExposeResult/*/Address', 'zip');
        $lMarkerArray['Address_city'] = $this->getAttributeString('/ExposeResult/*/Address', 'city');
        $lMarkerArray['showAddress'] = $this->getDataBool('/ExposeResult/*/showAddress');
        $lMarkerArray['Continent'] = $this->getAttributeString('/ExposeResult/*/Continent', 'name');
        $lMarkerArray['Country'] = $this->getAttributeString('/ExposeResult/*/Country', 'name');
        $lMarkerArray['Region'] = $this->getAttributeString('/ExposeResult/*/Region', 'name');
        $lMarkerArray['City'] = $this->getAttributeString('/ExposeResult/*/City', 'name');
        $lMarkerArray['Quarter'] = $this->getAttributeString('/ExposeResult/*/Quarter', 'name');
        $lMarkerArray['geoX'] = $this->getDataInt('/ExposeResult/*/geoX');
        $lMarkerArray['geoY'] = $this->getDataInt('/ExposeResult/*/geoY');

        return $lMarkerArray;
    }

}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/lumoscoutexpose/parsers/class.tx_lumoscoutexpose_parser_base.php']) {
    include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/lumoscoutexpose/parsers/class.tx_lumoscoutexpose_parser_base.php']);
}

?>