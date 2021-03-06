<?php

namespace Concrete\Controller\SinglePage\Dashboard\Blocks;

use Concrete\Core\Page\Controller\DashboardPageController;
use Concrete\Core\Permission\Access\Access;
use Concrete\Core\Permission\Checker;
use Concrete\Core\Permission\Key\Key as PermissionKey;

class Permissions extends DashboardPageController
{
    public function save()
    {
        if ($this->token->validate('save_permissions')) {
            $tp = new Checker();
            if ($tp->canAccessTaskPermissions()) {
                $permissions = PermissionKey::getList('block_type');
                foreach ($permissions as $pk) {
                    $paID = $_POST['pkID'][$pk->getPermissionKeyID()];
                    $pt = $pk->getPermissionAssignmentObject();
                    $pt->clearPermissionAssignment();
                    if ($paID > 0) {
                        $pa = Access::getByID($paID, $pk);
                        if (is_object($pa)) {
                            $pt->assignPermissionAccess($pa);
                        }
                    }
                }

                return $this->buildRedirect($this->action('updated'));
            }
        } else {
            $this->error->add($this->token->getErrorMessage());
        }
    }

    public function updated()
    {
        $this->set('success', t('Permissions updated successfully.'));
    }
}
