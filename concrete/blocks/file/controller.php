<?php

namespace Concrete\Block\File;

use Concrete\Core\Feature\Features;
use Concrete\Core\Feature\UsesFeatureInterface;
use File;
use Concrete\Core\Block\BlockController;

class Controller extends BlockController implements UsesFeatureInterface
{
    protected $btInterfaceWidth = 300;
    protected $btCacheBlockRecord = true;
    protected $btCacheBlockOutput = true;
    protected $btCacheBlockOutputOnPost = true;
    protected $btCacheBlockOutputForRegisteredUsers = true;
    protected $btInterfaceHeight = 320;
    protected $btTable = 'btContentFile';

    protected $btExportFileColumns = array('fID');

    /**
     * Used for localization. If we want to localize the name/description we have to include this.
     */
    public function getBlockTypeDescription()
    {
        return t("Link to files stored in the asset library.");
    }

    public function getBlockTypeName()
    {
        return t("File");
    }

    public function getJavaScriptStrings()
    {
        return array('file-required' => t('You must select a file.'));
    }

    public function getRequiredFeatures(): array
    {
        return [
            Features::BASICS
        ];
    }

    public function getSearchableContent()
    {
        return $this->fileLinkText;
    }

    public function add()
    {
        $this->set('bf', null);
        $this->set('fileLinkText', null);
        $this->set('forceDownload', 0);

        $this->set('al', $this->app->make('helper/concrete/asset_library'));
    }

    public function edit()
    {
        // file object
        $bf = null;
        if ($this->getFileID() > 0) {
            $bf = $this->getFileObject();
        }
        $this->set('bf', $bf);
        $this->set('fileLinkText', $this->getLinkText());
        $this->set('forceDownload', $this->forceDownload);

        $this->set('al', $this->app->make('helper/concrete/asset_library'));
    }

    public function validate_composer()
    {
        $f = $this->getFileObject();
        $e = $this->app->make('helper/validation/error');
        if (!is_object($f) || $f->isError() || !$f->getFileID()) {
            $e->add(t('You must specify a valid file.'));
        }

        return $e;
    }

    public function isComposerControlDraftValueEmpty()
    {
        $f = $this->getFileObject();
        if (is_object($f) && !$f->isError()) {
            return false;
        }

        return true;
    }

    public function save($args)
    {
        $args['forceDownload'] = ($args['forceDownload']) ? '1' : '0';
        parent::save($args);
    }

    public function validate($args)
    {

        $e = $this->app->make('helper/validation/error');
        if ($args['fID'] < 1) {
            $e->add(t('You must select a file.'));
        }
        if (trim($args['fileLinkText']) == '') {
            $e->add(t('You must enter the link text.'));
        }

        return $e;
    }

    public function getFileID()
    {
        return $this->fID;
    }

    public function getFileObject()
    {
        if ($this->fID) {
            return File::getByID($this->fID);
        } else {
            return null;
        }
    }

    public function getLinkText()
    {
        if ($this->fileLinkText) {
            return $this->fileLinkText;
        } else {
            $f = $this->getFileObject();

            return $f->getTitle();
        }
    }
}
