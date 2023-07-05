<?php

/**
 * The goal of this file is to allow developers a location
 * where they can overwrite core procedural functions and
 * replace them with their own. This file is loaded during
 * the bootstrap process and is called during the frameworks
 * execution.
 *
 * This can be looked at as a `master helper` file that is
 * loaded early on, and may also contain additional functions
 * that you'd like to use throughout your entire application
 *
 * @link: https://codeigniter4.github.io/CodeIgniter4/
 */
require_once APPPATH . 'Config/Settingconstant.php';
// require_once APPPATH . 'ThirdParty/tcpdf/config/tcpdf_config.php';
// require_once APPPATH . 'ThirdParty/tcpdf/tcpdf.php';

// $license_date = strtotime(LICENSE_DATE);
// $currentdate = strtotime(date('d-m-Y'));
// if($currentdate > $license_date)
// {
//     die('Your software license is expired. kindly contact to your developer');
// }
