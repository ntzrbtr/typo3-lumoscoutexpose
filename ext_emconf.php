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
    'author_email' => 'retiolum@googlemail.com',
    'state' => 'alpha',
    'uploadfolder' => TRUE,
    'clearCacheOnLoad' => FALSE,
    'version' => '0.1.2',
    'constraints' => array(
        'depends' => array(
            'typo3' => '4.0.0-4.7.99',
        ),
        'conflicts' => array(
        ),
        'suggests' => array(
        ),
    ),
);
