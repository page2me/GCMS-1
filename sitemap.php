<?php
/**
 * sitemap.php
 *
 * @author Goragod Wiriya <admin@goragod.com>
 * @link http://www.kotchasan.com/
 * @copyright 2016 Goragod.com
 * @license http://www.kotchasan.com/license/
 */
// load Kotchasan
include 'load.php';
// Initial Kotchasan Framework
$app = Kotchasan::createWebApplication('Gcms\Config');
$app->defaultRouter = 'Gcms\Router';
$app->defaultController = 'Index\Sitemap\Controller';
$app->run();
