<?php defined('C5_EXECUTE') or die("Access Denied.");

/**
 * @var Concrete\Block\File\Controller $controller
 * @var $label string
 * @var $description text
 */

$app = \Concrete\Core\Support\Facade\Application::getFacadeApplication();
$al = $app->make('helper/concrete/asset_library');

if ($controller->getFileID() > 0) {
    $bf = $controller->getFileObject();
}

$setcontrol = $control->getPageTypeComposerFormLayoutSetControlObject();
?>

<div class="control-group">
	<label class="control-label"><?=$label?></label>
	<?php if ($description): ?>
	<i class="fa fa-question-circle launch-tooltip" title="" data-original-title="<?=$description?>"></i>
	<?php endif; ?>
	<div class="controls">
		<?php echo $al->file('ccm-b-file-'.$setcontrol->getPageTypeComposerFormLayoutSetControlID(), $view->field('fID'), t('Choose File'), $bf); ?>
	</div>
</div>
