<?php
namespace Concrete\Controller\Panel;

use Concrete\Core\Controller\Controller;
use Concrete\Core\Block\Block;

class AddBlockPreview extends Controller
{
    protected $viewPath = '/panels/add/get_block_contents';

    public function getBlockPreview()
    {
        $this->set('ci', $this->app->make('helper/concrete/urls'));
        $this->set('block', Block::getByID($this->request->query->get('blockID')));
        $currentTheme = \PageTheme::getSiteTheme();
        $this->setTheme($currentTheme);
        $this->setThemeViewTemplate('block_preview.php');
        return;
    }
}
