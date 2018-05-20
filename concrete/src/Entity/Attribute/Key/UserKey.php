<?php

namespace Concrete\Core\Entity\Attribute\Key;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="\Concrete\Core\Entity\User\AttributeRepository")
 * @ORM\Table(name="UserAttributeKeys")
 */
class UserKey extends Key
{
    /**
     * @ORM\Column(type="boolean")
     */
    protected $uakProfileDisplay = false;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $uakProfileEdit = false;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $uakProfileEditRequired = false;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $uakRegisterEdit = false;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $uakRegisterEditRequired = false;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $uakMemberListDisplay = false;

    /**
     * @return mixed
     */
    public function isAttributeKeyDisplayedOnProfile()
    {
        return $this->uakProfileDisplay;
    }

    /**
     * @ORM\OneToMany(targetEntity="UserKeyPerUserGroup",mappedBy="userAttributeKey",orphanRemoval=true,cascade={"all"})
     * @var ArrayCollection
     */
    protected $userKeyPerUserGroups;

    /**
     * @return ArrayCollection
     */
    public function getUserKeyPerUserGroups()
    {
        if (empty($this->userKeyPerUserGroups)) {
            $this->userKeyPerUserGroups = new ArrayCollection();
        }
        return $this->userKeyPerUserGroups;
    }

    /**
     * @param ArrayCollection $userKeyPerUserGroups
     * @return $this
     */
    public function setUserKeyPerUserGroups($userKeyPerUserGroups)
    {
        if (empty($this->userKeyPerUserGroups)) {
            $this->userKeyPerUserGroups = new ArrayCollection();
        } else {
            $this->userKeyPerUserGroups->clear();
        }
        foreach ($userKeyPerUserGroups as $userKeyPerUserGroup) {
            $this->addUserKeyPerUserGroups($userKeyPerUserGroup);
        }
        return $this;
    }


    /**
     * @param UserKeyPerUserGroup $userKeyPerUserGroup
     * @return $this
     */
    public function addUserKeyPerUserGroups(UserKeyPerUserGroup $userKeyPerUserGroup)
    {
        if (empty($this->userKeyPerUserGroups)) {
            $this->userKeyPerUserGroups = new ArrayCollection();
        }
        if (!$this->userKeyPerUserGroups->contains($userKeyPerUserGroup)) {
            $this->userKeyPerUserGroups->add($userKeyPerUserGroup);
        }
        return $this;
    }


    public function removeUserKeyPerUserGroups(UserKeyPerUserGroup $userKeyPerUserGroup)
    {
        if (empty($this->userKeyPerUserGroups)) {
            $this->userKeyPerUserGroups = new ArrayCollection();
        }
        if ($this->userKeyPerUserGroups->contains($userKeyPerUserGroup)) {
            $this->userKeyPerUserGroups->removeElement($userKeyPerUserGroup);
        }
    }


    /**
     * @param mixed $uakProfileDisplay
     */
    public function setAttributeKeyDisplayedOnProfile($uakProfileDisplay)
    {
        $this->uakProfileDisplay = $uakProfileDisplay;
    }

    /**
     * @return mixed
     */
    public function isAttributeKeyEditableOnProfile()
    {
        return $this->uakProfileEdit;
    }

    /**
     * @param mixed $uakProfileEdit
     */
    public function setAttributeKeyEditableOnProfile($uakProfileEdit)
    {
        $this->uakProfileEdit = $uakProfileEdit;
    }

    /**
     * @return mixed
     */
    public function isAttributeKeyRequiredOnProfile()
    {
        return $this->uakProfileEditRequired;
    }

    /**
     * @param mixed $uakProfileEditRequired
     */
    public function setAttributeKeyRequiredOnProfile($uakProfileEditRequired)
    {
        $this->uakProfileEditRequired = $uakProfileEditRequired;
    }

    /**
     * @return mixed
     */
    public function isAttributeKeyEditableOnRegister()
    {
        return $this->uakRegisterEdit;
    }

    /**
     * @param mixed $uakRegisterEdit
     */
    public function setAttributeKeyEditableOnRegister($uakRegisterEdit)
    {
        $this->uakRegisterEdit = $uakRegisterEdit;
    }

    /**
     * @return mixed
     */
    public function isAttributeKeyRequiredOnRegister()
    {
        return $this->uakRegisterEditRequired;
    }

    /**
     * @param mixed $uakRegisterEditRequired
     */
    public function setAttributeKeyRequiredOnRegister($uakRegisterEditRequired)
    {
        $this->uakRegisterEditRequired = $uakRegisterEditRequired;
    }

    /**
     * @return mixed
     */
    public function isAttributeKeyDisplayedOnMemberList()
    {
        return $this->uakMemberListDisplay;
    }

    /**
     * @param mixed $uakMemberListDisplay
     */
    public function setAttributeKeyDisplayedOnMemberList($uakMemberListDisplay)
    {
        $this->uakMemberListDisplay = $uakMemberListDisplay;
    }

    public function getAttributeKeyCategoryHandle()
    {
        return 'user';
    }

    /**
     * @return \Group[]
     */
    public function getAssociatedGroups()
    {
        $groups = array();
        if ($this->userKeyPerUserGroups->count() > 0) {
            /**
             * @var $userKeyPerUserGroup UserKeyPerUserGroup
             */
            foreach ($this->userKeyPerUserGroups as $userKeyPerUserGroup) {
                $group = $userKeyPerUserGroup->getGroup();
                if (is_object($group)) {
                    $groups[$group->getGroupID()] = $group;
                }
            }
        }
        return $groups;
    }

    /**
     * Method that return key configuration for specific associated group
     * @param \Group $group
     * @return UserKeyPerUserGroup|null
     */
    public function getKeyConfigurationForGroup(\Group $group)
    {
        $userKeyPerUserGroup = null;
        if ($this->userKeyPerUserGroups->count() > 0) {
            foreach ($this->userKeyPerUserGroups as $userKeyPerUserGroup1) {
                if ($group->getGroupID() == $userKeyPerUserGroup1->getGID()) {
                    $userKeyPerUserGroup = $userKeyPerUserGroup1;
                    break;
                }
            }
        }
        return $userKeyPerUserGroup;

    }

}
