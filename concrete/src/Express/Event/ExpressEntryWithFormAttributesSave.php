<?php
/**
 *Developer: Ben Ali Faker
 *ProjectManager/developer
 *Date 29/05/18
 *Time 16:54
 **/

namespace Concrete\Core\Express\Event;


class ExpressEntryWithFormAttributesSave extends Event
{

    protected $proceed=true;
    protected $form =null;

    public function __construct($entry,$form)
    {
        $this->form=$form;
        parent::__construct($entry);
    }


    public function cancelDelete()
    {
        $this->proceed=false;
    }

    public function proceed()
    {
        return $this->proceed;
    }




    /**
     * @return null
     */
    public function getForm()
    {
        return $this->form;
    }

    /**
     * @param null $form
     * @return ExpressEntryWithFormAttributesSave
     */
    public function setForm($form)
    {
        $this->form = $form;
        return $this;
    }


}