<?php
namespace Concrete\Core\Attribute\Category;

use Concrete\Core\Attribute\Category\AttributeType;
use Concrete\Core\Attribute\Category\SearchIndexer\StandardSearchIndexerInterface;
use Concrete\Core\Attribute\UserKeySetManager;
use Concrete\Core\Entity\Attribute\Key\Key;
use Concrete\Core\Entity\Attribute\Key\UserKey;
use Concrete\Core\Entity\Attribute\Key\UserKeyPerUserGroup;
use Concrete\Core\Entity\Attribute\Type;
use Concrete\Core\Entity\Package;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\Request;

class UserCategory extends AbstractStandardCategory
{

    public function createAttributeKey()
    {
        return new UserKey();
    }

    public function getIndexedSearchTable()
    {
        return 'UserSearchIndexAttributes';
    }

    public function getIndexedSearchPrimaryKeyValue($mixed)
    {
        return $mixed->getUserID();
    }

    public function getSearchIndexFieldDefinition()
    {
        return array(
            'columns' => array(
                array(
                    'name' => 'uID',
                    'type' => 'integer',
                    'options' => array('unsigned' => true, 'default' => 0, 'notnull' => true),
                ),
            ),
            'primary' => array('uID'),
        );
    }

    public function getAttributeKeyRepository()
    {
        return $this->entityManager->getRepository('\Concrete\Core\Entity\Attribute\Key\UserKey');
    }

    public function getAttributeValueRepository()
    {
        return $this->entityManager->getRepository('\Concrete\Core\Entity\Attribute\Value\UserValue');
    }


    /**
     * Method that return commons and associated to groups User key list
     * Note if groups is empty we return only common user attributes
     * @param array $groups
     * @return mixed
     */
    public function getUserKeyList($groups=array())
    {
        return $this->getAttributeKeyRepository()->getList($groups);
    }

    /**
     * Method that return commons and associated to groups User key list available on page MemberList
     * Note if groups is empty we return only common user attributes
     * @var \Group[] $groups
     * @return array
     **/
    public function getMemberListList($groups=array())
    {
        return $this->getAttributeKeyRepository()->getMemberListList($groups);
    }
    /**
     * Method that return commons and associated to groups User key list available on User Public Profile Page
     * Note if groups is empty we return only common user attributes
     * @var \Group[] $groups
     * @return array
     **/
    public function getPublicProfileList($groups=array())
    {
        return $this->getAttributeKeyRepository()->getPublicProfileList($groups);
    }

    /**
     * Method that return commons and associated to groups User key list available on Registration Page
     * Note if groups is empty we return only common user attributes
     * @var \Group[] $groups
     * @return array
     **/
    public function getRegistrationList($groups=array())
    {
        return $this->getAttributeKeyRepository()->getRegistrationList($groups);
    }

    /**
     * Method that return commons and associated to groups User key list available on User Profile Edit Page
     * Note if groups is empty we return only common user attributes
     * @var \Group[] $groups
     * @return array
     **/
    public function getEditableInProfileList($groups=array())
    {
        return $this->getAttributeKeyRepository()->getEditableInProfileList($groups);
    }

    /**
     * Method that return commons User keys list
     * Note if groups is empty we return only common user attributes
     * @var \Group[] $groups
     * @return array
     **/
    public function getCommonList()
    {
        return $this->getAttributeKeyRepository()->getCommonList();
    }

    /**
     * Method that return all user common attribute are available in register form
     * @return mixed
     */
    public function getCommonRegistrationList()
    {
        return $this->getAttributeKeyRepository()->getCommonRegistrationList();
    }

    /**
     * Method that return all user common attributes available in view list
     * @return mixed
     */
    public function getCommonMemberListList()
    {
        return $this->getAttributeKeyRepository()->getCommonMemberListList();
    }

    /**
     * Method that return all user common attributes available in profile list
     * @return mixed
     */
    public function getCommonPublicProfileList()
    {
        return $this->getAttributeKeyRepository()-> getCommonPublicProfileList();
    }

    /**
     * Method that return all user common attribute are editable in profile list
     * @return mixed
     */
    public function getCommonEditableInProfileList()
    {
        return $this->getAttributeKeyRepository()->getCommonEditableInProfileList();
    }

    /** Method that return Only User Keys available for groups in Registration Form
     * @param array $groups
     * @return mixed
     */
    public function getGroupsRegistrationList($groups=array())
    {
        return $this->getAttributeKeyRepository()->getGroupsRegistrationList($groups);
    }

    /**
     * @param array $groups
     * @return mixed
     */
    public function getGroupsMemberListList($groups=array())
    {
        return $this->getAttributeKeyRepository()->getGroupsMemberListList($groups);
    }

    /**
     * @param array $groups
     * @return mixed
     */
    public function getGroupsPublicProfileList($groups=array())
    {
        return $this->getAttributeKeyRepository()->getGroupsPublicProfileList($groups);
    }

    /**
     * @param array $groups
     * @return mixed
     */
    public function getGroupsEditableInProfileList($groups=array())
    {
        return $this->getAttributeKeyRepository()->getGroupsEditableInProfileList($groups);
    }


    /**
     * @param UserKey $key
     * @param Request $request
     *
     * @return Key
     */
    protected function saveFromRequest(Key $key, Request $request)
    {
        $key->setAttributeKeyDisplayedOnProfile((string) $request->request->get('uakProfileDisplay') == 1);
        $key->setAttributeKeyEditableOnProfile((string) $request->request->get('uakProfileEdit') == 1);
        $key->setAttributeKeyRequiredOnProfile((string) $request->request->get('uakProfileEditRequired') == 1);
        $key->setAttributeKeyEditableOnRegister((string) $request->request->get('uakRegisterEdit') == 1);
        $key->setAttributeKeyRequiredOnRegister((string) $request->request->get('uakRegisterEditRequired') == 1);
        $key->setAttributeKeyDisplayedOnMemberList((string) $request->request->get('uakMemberListDisplay') == 1);
        $this->setAssociatedGroupsAndTheirConfigurationFromRequest($key,$request);

        return $key;
    }

    public function addFromRequest(Type $type, Request $request)
    {
        $key = parent::addFromRequest($type, $request);

        return $this->saveFromRequest($key, $request);
    }

    public function updateFromRequest(Key $key, Request $request)
    {
        $key = parent::updateFromRequest($key, $request);

        return $this->saveFromRequest($key, $request);
    }

    public function import(Type $type, \SimpleXMLElement $element, Package $package = null)
    {
        /*
         * @var UserKey
         */
        $key = parent::import($type, $element);
        $key->setAttributeKeyDisplayedOnProfile((string) $element['profile-displayed'] == 1);
        $key->setAttributeKeyEditableOnProfile((string) $element['profile-editable'] == 1);
        $key->setAttributeKeyRequiredOnProfile((string) $element['profile-required'] == 1);
        $key->setAttributeKeyEditableOnRegister((string) $element['register-editable'] == 1);
        $key->setAttributeKeyRequiredOnRegister((string) $element['register-required'] == 1);
        $key->setAttributeKeyDisplayedOnMemberList((string) $element['member-list-displayed'] == 1);

        return $key;
    }

    public function getAttributeValues($user)
    {
        $r = $this->entityManager->getRepository('\Concrete\Core\Entity\Attribute\Value\UserValue');
        $values = $r->findBy(array(
            'user' => $user,
        ));

        return $values;
    }

    public function getAttributeValue(Key $key, $user)
    {
        $r = $this->entityManager->getRepository('\Concrete\Core\Entity\Attribute\Value\UserValue');
        $value = $r->findOneBy(array(
            'user' => $user,
            'attribute_key' => $key,
        ));

        return $value;
    }

    public function getSetManager()
    {
        if (!isset($this->setManager)) {
            $this->setManager = new UserKeySetManager($this->categoryEntity, $this->getEntityManager());
        }
        return $this->setManager;
    }

    /**
     *  Method define if key is associated to specific groups and save its configuration for every one
     * @param UserKey $userKey
     * @param Request $request
     */
    protected function setAssociatedGroupsAndTheirConfigurationFromRequest(UserKey $userKey,Request $request)
    {
        $data=$request->request->get('gIDS',array());
        $associatedGroupIDs=(isset($data['ids']))?$data['ids']:array();
        $userKeyPerUserGroupCollection=new ArrayCollection();
        if(sizeof($associatedGroupIDs)>0)
        {
            foreach($associatedGroupIDs as $gID)
            {
                $keyConfigurationForGroup=(isset($data[$gID]))?$data[$gID]:array();
                $userKeyPerUserGroup=new UserKeyPerUserGroup();
                $userKeyPerUserGroup
                    ->setAttributeKeyDisplayedOnProfile(isset($keyConfigurationForGroup['uakProfileDisplay'])? true:false)
                    ->setAttributeKeyEditableOnProfile(isset($keyConfigurationForGroup['uakProfileEdit'])?true:false )
                    ->setAttributeKeyRequiredOnProfile(isset($keyConfigurationForGroup['uakProfileEditRequired'])?true:false)
                    ->setAttributeKeyRequiredOnRegister(isset($keyConfigurationForGroup['uakRegisterEditRequired'])?true:false)
                    ->setAttributeKeyEditableOnRegister(isset($keyConfigurationForGroup['uakRegisterEdit'])?true:false)
                    ->setAttributeKeyDisplayedOnMemberList(isset($keyConfigurationForGroup['uakMemberListDisplay'])?true:false)
                    ->setGID($gID)
                    ->setUserAttributeKey($userKey);
                $userKeyPerUserGroupCollection->add($userKeyPerUserGroup);
            }
        }
        $userKey->setUserKeyPerUserGroups($userKeyPerUserGroupCollection);
    }

}
