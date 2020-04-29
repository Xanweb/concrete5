<?php

use Concrete\Core\Block\View\BlockView;

defined('C5_EXECUTE') or die('Access Denied.');
?>
<div class="block-content" style="zoom: 0.6;padding:15px;transform-origin: 0 0;">
    <?php
    $bv = new BlockView($block);
    $bv->render('scrapbook');
    ?>
</div>
