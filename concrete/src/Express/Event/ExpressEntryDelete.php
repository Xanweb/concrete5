<?php
/**
 *Developer: Ben Ali Faker
 *ProjectManager/developer
 *Date 29/05/18
 *Time 16:41
 **/

namespace Concrete\Core\Express\Event;


class ExpressEntryDelete extends Event
{
   protected $proceed=true;


   public function cancelDelete()
   {
       $this->proceed=false;
   }

   public function proceed()
   {
       return $this->proceed;
   }

}