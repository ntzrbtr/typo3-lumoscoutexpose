<?php

########################################################################
# Extension Manager/Repository config file for ext: "lumoscoutexpose"
#
# Auto generated 15-12-2006 14:45
#
# Manual updates:
# Only the data in the array - anything else is removed by next write.
# "version" and "dependencies" must not be touched!
########################################################################

$EM_CONF[$_EXTKEY] = array(
    'title' => 'LumoNet ImmobilienScout24.de Expose',
    'description' => 'Show exposes from ImmobilienScout24.de via their XML API (customer account required).',
    'category' => 'plugin',
    'author' => 'Thomas Off',
    'author_email' => 'typo3@retiolum.de',
    'author_company' => '',
    'shy' => 0,
    'dependencies' => '',
    'conflicts' => '',
    'priority' => '',
    'module' => '',
    'state' => 'alpha',
    'internal' => '',
    'uploadfolder' => 1,
    'createDirs' => '',
    'modify_tables' => '',
    'clearCacheOnLoad' => 1,
    'lockType' => '',
    'version' => '0.1.2',
    'constraints' => array(
        'depends' => array(
            'typo3' => '4.0-',
            'php' => '4.0.0-',
        ),
        'conflicts' => array(
        ),
        'suggests' => array(
        ),
    ),
    '_md5_values_when_last_written' => 'a:52:{s:9:"ChangeLog";s:4:"e9d2";s:10:"README.txt";s:4:"35fa";s:12:"ext_icon.gif";s:4:"3672";s:17:"ext_localconf.php";s:4:"83c4";s:14:"ext_tables.php";s:4:"a3b6";s:28:"ext_typoscript_constants.txt";s:4:"038c";s:28:"ext_typoscript_editorcfg.txt";s:4:"70a9";s:24:"ext_typoscript_setup.txt";s:4:"e3f5";s:13:"locallang.xml";s:4:"ffb5";s:16:"locallang_db.xml";s:4:"eb7a";s:41:"doc/immobilienscout24_api_techdoc_v18.pdf";s:4:"be20";s:14:"doc/manual.sxw";s:4:"f76c";s:14:"pi1/ce_wiz.gif";s:4:"b345";s:36:"pi1/class.tx_lumoscoutexpose_pi1.php";s:4:"bf40";s:44:"pi1/class.tx_lumoscoutexpose_pi1_wizicon.php";s:4:"197b";s:13:"pi1/clear.gif";s:4:"cc11";s:23:"pi1/flexform_ds_pi1.xml";s:4:"89c8";s:17:"pi1/locallang.xml";s:4:"674d";s:43:"parsers/class.tx_lumoscoutexpose_parser.php";s:4:"8136";s:57:"parsers/class.tx_lumoscoutexpose_parser_appartmentbuy.php";s:4:"7224";s:58:"parsers/class.tx_lumoscoutexpose_parser_appartmentrent.php";s:4:"4ff5";s:48:"parsers/class.tx_lumoscoutexpose_parser_base.php";s:4:"6807";s:54:"parsers/class.tx_lumoscoutexpose_parser_gastronomy.php";s:4:"4326";s:52:"parsers/class.tx_lumoscoutexpose_parser_housebuy.php";s:4:"f705";s:53:"parsers/class.tx_lumoscoutexpose_parser_houserent.php";s:4:"054e";s:53:"parsers/class.tx_lumoscoutexpose_parser_housetype.php";s:4:"a475";s:52:"parsers/class.tx_lumoscoutexpose_parser_industry.php";s:4:"920b";s:54:"parsers/class.tx_lumoscoutexpose_parser_investment.php";s:4:"2536";s:48:"parsers/class.tx_lumoscoutexpose_parser_misc.php";s:4:"f1b1";s:50:"parsers/class.tx_lumoscoutexpose_parser_office.php";s:4:"ec3f";s:48:"parsers/class.tx_lumoscoutexpose_parser_site.php";s:4:"a714";s:49:"parsers/class.tx_lumoscoutexpose_parser_store.php";s:4:"08a7";s:47:"parsers/class.tx_lumoscoutexpose_parser_waz.php";s:4:"3b09";s:13:"libs/PEAR.php";s:4:"266b";s:16:"libs/Request.php";s:4:"5345";s:15:"libs/Socket.php";s:4:"3e67";s:15:"libs/System.php";s:4:"ec80";s:12:"libs/URL.php";s:4:"74a1";s:20:"libs/XPath.class.php";s:4:"f1ed";s:37:"templates/template_appartmentbuy.html";s:4:"1be0";s:38:"templates/template_appartmentrent.html";s:4:"f8ce";s:34:"templates/template_gastronomy.html";s:4:"6008";s:32:"templates/template_housebuy.html";s:4:"8397";s:33:"templates/template_houserent.html";s:4:"ab8e";s:33:"templates/template_housetype.html";s:4:"5bee";s:32:"templates/template_industry.html";s:4:"32b3";s:34:"templates/template_investment.html";s:4:"1554";s:28:"templates/template_misc.html";s:4:"4481";s:30:"templates/template_office.html";s:4:"06dd";s:28:"templates/template_site.html";s:4:"e104";s:29:"templates/template_store.html";s:4:"f57e";s:27:"templates/template_waz.html";s:4:"669d";}',
    'suggests' => array(
    ),
);

?>