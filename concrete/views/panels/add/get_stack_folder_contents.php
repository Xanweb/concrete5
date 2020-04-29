<?php
/* @var Concrete\Core\Page\Stack\Stack[] $stacks */
?>
<div class="ccm-panel-add-folder-stack-list">
<?php
foreach ($stacks as $stack) {
    if (!$stack) {
        continue;
    }
    //$blocks = $stack->getBlocks();
    if($stack->getCollectionTypeHandle() == STACK_CATEGORY_PAGE_TYPE){
        ?>
        <div class="ccm-panel-add-folder-stack-item"
             data-cID="<?= (int)$c->getCollectionID() ?>"
             data-sfID="<?= (int)$stack->getCollectionID() ?>">
            <div class="stack-folder-name">
                <div class="ccm-panel-add-folder-stack-item-handle">
                    <svg><use xlink:href="#icon-panel-folder" /></svg>
                    <span class="stack-folder-name-inner"><?= h($stack->getCollectionName()) ?></span>
                </div>
                <a class="ccm-stack-folder-expander" href="javascript:void(0);"><i
                            class="fa fa-angle-down"></i></a>
            </div>
        </div>
        <?php
    }else {
        ?>

        <div
                class="ccm-panel-add-block-stack-item"
                data-panel-add-block-drag-item="stack-item"
                data-cID="<?= (int)$c->getCollectionID() ?>"
                data-sID="<?= (int)$stack->getCollectionID() ?>"
                data-block-type-handle="stack"
                data-has-add-template="no"
                data-supports-inline-add="no" ,
                data-token="<?= Core::make('token')->generate('load_stack') ?>"
                data-btID="0"
                data-dragging-avatar="<?= h('<p><svg><use xlink:href="#icon-panel-stack" /></svg><span>' . t('Stack') . '</span></p>') ?>"
                data-block-id="<?= (int)$stack->getCollectionID() ?>">
            <div class="stack-name">
                <div class="ccm-panel-add-block-stack-item-handle">
                    <svg><use xlink:href="#icon-panel-stack" /></svg>
                    <span class="stack-name-inner"><?= h($stack->getStackName()) ?></span>
                </div>
                <a class="ccm-stack-expander" href="javascript:void(0);"><i
                            class="fa fa-angle-down"></i></a>
            </div>
        </div>
        <?php
    }
}
?>
</div>
