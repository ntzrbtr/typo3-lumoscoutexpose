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

require_once(PATH_tslib . 'class.tslib_pibase.php');

require_once(t3lib_extMgm::extPath('lumoscoutexpose') . 'libs/Request.php');
require_once(t3lib_extMgm::extPath('lumoscoutexpose') . 'libs/XPath.class.php');

require_once(t3lib_extMgm::extPath('lumoscoutexpose') . 'parsers/class.tx_lumoscoutexpose_parser.php');

/**
 * Plugin 'ImmobilienScout24.de Exposé' for the 'lumoscoutexpose' extension.
 *
 * @author	Thomas Off <typo3@retiolum.de>
 * @package	TYPO3
 * @subpackage	tx_lumoscoutexpose
 */
class tx_lumoscoutexpose_pi1 extends tslib_pibase {
	var $prefixId       = 'tx_lumoscoutexpose_pi1';		// Same as class name
	var $scriptRelPath  = 'pi1/class.tx_lumoscoutexpose_pi1.php';	// Path to this script relative to the extension dir.
	var $extKey         = 'lumoscoutexpose';	// The extension key.
	var $pi_checkCHash  = true;
	
	var $lServiceURLs   = array();
	
	/**
	 * The main method of the PlugIn
	 *
	 * @param	string		$content: The PlugIn content
	 * @param	array		$conf: The PlugIn configuration
	 * @return	The content that is displayed on the website
	 */
	function main($content, $conf)	{
		// Initialize
		$this->init($conf);
		
		// Initialize content
		$content = '';
		
		// Open session
		if (!$this->openSession()) {
			return $this->pi_wrapInBaseClass($content);
		}
		
		// Do exposé request
		if (!$this->doExposeRequest($this->lConf['scout_id'])) {
			return $this->pi_wrapInBaseClass($content);
		}
		
		// Parse response XML to determine template to be used
		$oXpath =& new XPath();
		$oXpath->importFromString($this->sExpose);
		$sExposeType = $oXpath->nodeName('/ExposeResult/*');
		$oXpath->reset(); 

		// Choose template file and get template part
		$sTemplateFile = $this->lConf['template_file'][strtolower($sExposeType)];
		$sTemplateFile = $this->lConf['template_file']['all'] != '' ? $this->lConf['template_file']['all'] : $sTemplateFile;
		$sTemplateFile = $this->lConf['template_file']['local'] != '' ? $this->lConf['template_file']['local'] : $sTemplateFile;
		$sTemplateCode = $this->cObj->fileResource($sTemplateFile);
		$sTemplate = $this->cObj->getSubpart($sTemplateCode, '###TEMPLATE_' . strtoupper($sExposeType) . '###');
		
		// Prepare array with language strings to handle it to parser class
		$this->pi_loadLL();
		$lLang = array(
			'yes'           => $this->pi_getLL('data.yes'),
			'no'            => $this->pi_getLL('data.no'),
			'date_format'   => $this->pi_getLL('data.date_format'),
			'sep_thousands' => $this->pi_getLL('data.sep_thousands'),
			'sep_decimals'  => $this->pi_getLL('data.sep_decimals'),
		);
		
		// Call class to fill marker array
		$oParser =& new tx_lumoscoutexpose_parser($sExposeType, $lLang);
		$lMarkerArray = $oParser->parse($this->sExpose);

		// Process subpart for attachments
		$sTemplateAttachment = $this->cObj->getSubpart($sTemplate, '###ATTACHMENT###');
		$sAttachments = '';
		for ($i = 0; $i < count($lMarkerArray['Attachments']); $i++) {
			$sAttachments .= $this->cObj->substituteMarkerArray($sTemplateAttachment, $lMarkerArray['Attachments'][$i], '###|###', true);
		}
		$sTemplate = $this->cObj->substituteSubpart($sTemplate, '###ATTACHMENT###', $sAttachments);
		unset($lMarkerArray['Attachments']);

		// Process rest of template		
		$content = $this->cObj->substituteMarkerArray($sTemplate, $lMarkerArray, '###|###');
	
		// Return content
		return $this->pi_wrapInBaseClass($content);
	}
	
	/**
	 * Initialize plugin and get configuration values.
	 *
	 * @param	array		$conf : configuration array from TS
	 */
	function init($conf) {
		// Store configuration
		$this->conf = $conf;

		// Loading language-labels
		$this->pi_loadLL();

		// Set default piVars from TS
		$this->pi_setPiVarDefaults();

		// Init and get the flexform data of the plugin
		$this->pi_initPIflexForm();

		// Assign the flexform data to a local variable for easier access
		$piFlexForm = $this->cObj->data['pi_flexform'];

		// Array for local configuration
		$this->lConf = array();
		
		// FlexForm: Sheet: General

		// Scout ID
		$vScoutId = $this->pi_getFFvalue($this->cObj->data['pi_flexform'], 'scout_id', 'sGeneral'); // Get from FlexForm
		$this->lConf['scout_id'] = $vScoutId;

		// Template files
		// File from flexform
		$vTemplateFile = $this->pi_getFFvalue($this->cObj->data['pi_flexform'], 'template_file', 'sGeneral');
		$vTemplateFile = $vTemplateFile ? ('uploads/tx_lumoscoutexpose/' . $vTemplateFile) : '';
		$vTemplateFile = $vTemplateFile ? t3lib_div::getFileAbsFileName($vTemplateFile) : '';
		$vTemplateFile = preg_replace('~^' . PATH_site . '~', '', $vTemplateFile); // Strip PATH_site from path
		$this->lConf['template_file']['local'] = $vTemplateFile;
		// Files from TypoScript
		$this->lConf['template_file']['all'] = $this->getTemplateFile('all');
		$this->lConf['template_file']['appartmentbuy'] = $this->getTemplateFile('appartmentbuy');
		$this->lConf['template_file']['appartmentrent'] = $this->getTemplateFile('appartmentrent');
		$this->lConf['template_file']['gastronomy'] = $this->getTemplateFile('gastronomy');
		$this->lConf['template_file']['housebuy'] = $this->getTemplateFile('housebuy');
		$this->lConf['template_file']['houserent'] = $this->getTemplateFile('houserent');
		$this->lConf['template_file']['housetype'] = $this->getTemplateFile('housetype');
		$this->lConf['template_file']['industry'] = $this->getTemplateFile('industry');
		$this->lConf['template_file']['investment'] = $this->getTemplateFile('investment');
		$this->lConf['template_file']['misc'] = $this->getTemplateFile('misc');
		$this->lConf['template_file']['office'] = $this->getTemplateFile('office');
		$this->lConf['template_file']['site'] = $this->getTemplateFile('site');
		$this->lConf['template_file']['store'] = $this->getTemplateFile('store');
		$this->lConf['template_file']['waz'] = $this->getTemplateFile('waz');

		// Purely set from TypoScript

		// API key
		$vApiKey = trim($this->conf['api_key']);
		$this->lConf['api_key'] = $vApiKey;

		// Vendor ID
		$vVendorId = trim($this->conf['vendor_id']);
		$this->lConf['vendor_id'] = $vVendorId;
	}
	
	function getTemplateFile($sKey) {
		$vTemplateFile = trim($this->conf['template.'][$sKey]);
		$vTemplateFile = $vTemplateFile ? t3lib_div::getFileAbsFileName($vTemplateFile) : '';
		$vTemplateFile = preg_replace('~^' . PATH_site . '~', '', $vTemplateFile); // Strip PATH_site from path
		return $vTemplateFile;
	}
	
	function openSession() {
		// Build up parameter XML fragment
		$sParam = '<?xml version="1.0" encoding="iso-8859-1"?>';
		$sParam .= '<CreateSessionRequest xmlns="http://www.immobilienscout24.de/api/schema/general/1.0">';
		$sParam .= '<accesskey>' . $this->lConf['api_key'] . '</accesskey>';
		$sParam .= '<vendor>' . $this->lConf['vendor_id'] . '</vendor>';
		$sParam .= '</CreateSessionRequest>';
		
		// Build request and send
		$oRequest =& new HTTP_Request("http://api.immobilienscout24.de/api/xmlhttp/SessionService");
		$oRequest->setMethod(HTTP_REQUEST_METHOD_POST);
		$oRequest->addRawPostData($sParam);
		if (PEAR::isError($oRequest->sendRequest())) {
			return false;
		}
		
		// Check response from server
		if ($oRequest->getResponseHeader('xmlhttp-status') != 'OK') {
			return false;
		}
		
		// Parse response and get service URLs
		$oXml =& new XPath();
		$oXml->importFromString($oRequest->getResponseBody());
		$this->lServiceURLs['GeoInfoService'] = $oXml->getData('//GeoInfoService');
		$this->lServiceURLs['RequestService'] = $oXml->getData('//RequestService');
		$this->lServiceURLs['ContactService'] = $oXml->getData('//ContactService');
		$this->lServiceURLs['SessionService'] = $oXml->getData('//SessionService');
		
		return true;
	}
	
	function doExposeRequest($sScoutId) {
		// Build up parameter XML fragment
		$sParam = '<?xml version="1.0" encoding="iso-8859-1"?>';
		$sParam .= '<ExposeRequest xmlns="http://www.immobilienscout24.de/api/schema/expose/1.0" uuid="' . $sScoutId . '" pictureType="Expose"></ExposeRequest>';

		// Build request and send
		$oRequest =& new HTTP_Request($this->lServiceURLs['RequestService']);
		$oRequest->setMethod(HTTP_REQUEST_METHOD_POST);
		$oRequest->addRawPostData($sParam);
		if (PEAR::isError($oRequest->sendRequest())) {
			return false;
		}
		
		// Check response from server
		if ($oRequest->getResponseHeader('xmlhttp-status') != 'OK') {
			return false;
		}
		
		// Save response
		$this->sExpose = $oRequest->getResponseBody();
		
		return true;
	}
	
}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/lumoscoutexpose/pi1/class.tx_lumoscoutexpose_pi1.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/lumoscoutexpose/pi1/class.tx_lumoscoutexpose_pi1.php']);
}

?>