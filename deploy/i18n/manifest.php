<?php
/******************************************
 * SuiteCRM Translations
 * @URL: https://crowdin.com/project/suitecrmtrans
 * @author SuiteCRM Community via Crowdin
 ******************************************/

$manifest = array(
    'name' => 'Chinese (China)',
    'description' => 'Translation: crowdin.com/project/suitecrmtranslations',
    'type' => 'langpack',
    'is_uninstallable' => '是',
    'author' => 'SuiteCRM 社区',
    'version' => '7.15-26.10',
    'published_date' => '2026-10-02',
);
$installdefs = array(
    'id' => 'zh_CN',
    'image_dir' => '<basepath>/images',
    'copy' => array(
        array('from' => '<basepath>/include', 'to' => 'include'),
        array('from' => '<basepath>/modules', 'to' => 'modules'),
        array('from' => '<basepath>/install', 'to' => 'install'),
    )
);
