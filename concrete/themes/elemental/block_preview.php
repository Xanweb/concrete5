<?php
defined('C5_EXECUTE') or die("Access Denied.");
$this->inc('elements/header_top.php', array(
    'c' => \Concrete\Core\Page\Page::getByPath('/'),
));
?>
    <div class="ccm-block-preview">
        <?php echo $innerContent ?>
    </div>
<?php
$this->inc('elements/footer_bottom.php');


