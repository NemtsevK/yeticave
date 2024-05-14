<?php

const UPLOAD_DIR = __DIR__ . '/uploads';
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

date_default_timezone_set('Asia/Yekaterinburg');

require_once __DIR__ . '/helpers.php';
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/email.php';
require_once __DIR__ . '/validators/lot-validators.php';
require_once __DIR__ . '/validators/user-validators.php';
require_once __DIR__ . '/validators/bet-validators.php';

$config = require __DIR__ . '/config.php';
$link = dbConnect($config['db']);
$page_title = $config['main']['name'];
$categories = getCategories($link);


