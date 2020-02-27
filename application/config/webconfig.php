<?php defined('BASEPATH') or exit('No direct script access allowed');

// file pto
$config['file_pto'] = 'assets/PTO_MMC.pdf';

// Config database
$config['hostname'] = 'devel2.bsm.co.id'; // devel2.bsm.co.id
$config['username'] = 'bbg'; // bbg
$config['password'] = 'BBG1234'; // BBG1234
$config['database'] = 'bbg'; // bbg

// Login
$config['login'] = 'login/auth'; // login/ldap
// $config['login'] = 'login/ldap'; // login/auth

// Config send mail
$config['protocol'] = 'mail';
$config['smtp_host'] = 'bsmmail.syariahmandiri.co.id'; // webmail.syariahmandiri.co.id
$config['smtp_user'] = 'adminmmc@syariahmandiri.co.id';
$config['smtp_pass'] = 'Bsm123';

// Config ftp local - PROSES IN
$config['ftp_host_local'] = '10.9.9.36'; // 10.9.9.36
$config['ftp_user_local'] = 'ftp_mmc'; // ftp_mmc
$config['ftp_pass_local'] = 'Bsm123'; // Bsm123

// Config ftp server - PROSES OUT
$config['ftp_host_srv'] = '10.9.9.36'; // 10.9.9.36
$config['ftp_user_srv'] = 'ftp_mmc_bbg'; // ftp_mmc
$config['ftp_pass_srv'] = 'Bsm123'; // Bsm123

// Config database QA
/* $config['hostname'] = 'localhost'; // devel2.bsm.co.id
$config['username'] = 'heri'; // bbg
$config['password'] = 'Bsm1234'; // BBG1234
$config['database'] = 'heri_mmc'; // bbg */