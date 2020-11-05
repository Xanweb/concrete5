<?php

defined('C5_EXECUTE') or die('Access Denied.');

// @var Concrete\Core\Routing\Router $router

/*
 * Base path: /ccm/system/group
 * Namespace: Concrete\Controller\Backend\
 */
$router->post('/chooser/tree', 'Group\Chooser::getTree');
$router->post('/chooser/search', 'Group\Chooser::search');
