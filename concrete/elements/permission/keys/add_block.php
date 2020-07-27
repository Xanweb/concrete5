<?php defined('C5_EXECUTE') or die('Access Denied.');
 /**
  * @var \Concrete\Core\Permission\Access\Access $permissionAccess
  */
 $included = $permissionAccess->getAccessListItems(PermissionKey::ACCESS_TYPE_INCLUDE);
 $excluded = $permissionAccess->getAccessListItems(PermissionKey::ACCESS_TYPE_EXCLUDE);
 $btl = new BlockTypeList();
$blockTypes = $btl->get();
$app = \Concrete\Core\Support\Facade\Application::getFacadeApplication();
 $form = $app->make('helper/form');
 if (count($included) > 0 || count($excluded) > 0) {
     if (count($included) > 0) {
    ?>

<h4><?=t('Who can add what?')?></h4>

<?php foreach ($included as $assignment) {
    $entity = $assignment->getAccessEntityObject();
    ?>
<div class="form-group">
	<label class="col-form-label"><?=$entity->getAccessEntityLabel()?></label>
	<?=$form->select('blockTypesIncluded[' . $entity->getAccessEntityID() . ']', ['A' => t('All Block Types'), 'C' => t('Custom')], $assignment->getBlockTypesAllowedPermission())?>
	<div class="inputs-list mt-4" <?php if ($assignment->getBlockTypesAllowedPermission() != 'C') {
    ?>style="display: none"<?php } ?>>
		<?php foreach ($blockTypes as$index => $bt) {?>
            <div class="form-check">
                <input type="checkbox" name="btIDInclude[<?=$entity->getAccessEntityID()?>][]" id="btIDInclude<?=$index?>" value="<?=$bt->getBlockTypeID()?>" <?php if (in_array($bt->getBlockTypeID(), $assignment->getBlockTypesAllowedArray())) {
                    ?> checked="checked" <?php
                }
                ?> />
                <label class="form-check-label" for="btIDInclude<?=$index?>">
                    <?=t($bt->getBlockTypeName())?>
                </label>
            </div>
		<?php } ?>
	</div>
</div>
<?php
}
}
     if (count($excluded) > 0) {
    ?>

<h3><?=t('Who can\'t add what?')?></h3>

<?php foreach ($excluded as $assignment) {
    $entity = $assignment->getAccessEntityObject();
    ?>
<div class="form-group">
    <label class="col-form-label"><?=$entity->getAccessEntityLabel()?></label>
	<?=$form->select('blockTypesExcluded[' . $entity->getAccessEntityID() . ']', ['N' => t('No Block Types'), 'C' => t('Custom')], $assignment->getBlockTypesAllowedPermission())?>
	<div class="inputs-list mt-4" <?php if ($assignment->getBlockTypesAllowedPermission() != 'C') {
    ?>style="display: none"<?php } ?>>
        <?php foreach ($blockTypes as $index => $bt) {?>
            <div class="form-check">
                <input type="checkbox" name="btIDExclude[<?=$entity->getAccessEntityID()?>][]" id="btIDExclude<?=$index?>" value="<?=$bt->getBlockTypeID()?>" <?php if (in_array($bt->getBlockTypeID(), $assignment->getBlockTypesAllowedArray())) {?> checked="checked" <?php } ?> />
                <label class="form-check-label" for="btIDExclude<?=$index?>">
                    <?=t($bt->getBlockTypeName())?>
                </label>
            </div>
		<?php
}
    ?>
	</div>
</div>
<?php
}
}
    ?>
<?php
} else {
    ?>
	<p><?=t('No users or groups selected.')?></p>
<?php
} ?>

<script type="text/javascript">
$(function() {
	$("#ccm-tab-content-custom-options select").change(function() {
		if ($(this).val() == 'C') {
			$(this).parent().find('div.inputs-list').show();
		} else {
			$(this).parent().find('div.inputs-list').hide();
		}
	});
});
</script>