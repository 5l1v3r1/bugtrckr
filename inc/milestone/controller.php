<?php

/**
 * cmilestone.php
 * 
 * Milestone controller
 * 
 * @package milestone
 * @author Sascha Ohms
 * @author Philipp Hirsch
 * @copyright Copyright 2011, Bugtrckr-Team
 * @license http://www.gnu.org/licenses/lgpl.txt
 *   
 */
namespace milestone;

class controller extends \misc\controller
{

    /**
     *	Save a milestone to the database
     */
    function addEditMilestone($projHash = false)
    {
		if (!\misc\helper::getPermission('proj_editProject'))
			return $this->tpfail('You don\'t have the permissions to do this');

        $name = ($projHash) ? 'First milestone' : $this->get('POST.name');
        
        if(!isset($projHash)) {
            // This params have to be set
            if ($this->get('POST.name') == "" || $this->get('SESSION.project') <= 0)
                return $this->tpfail('Failure while editing milestone.');
        }

        $msHash = $this->get('POST.hash') ? $this->get('POST.hash') : \misc\helper::getFreeHash('Milestone');

        $milestone = new \milestone\model();
        if ($this->exists('POST.hash'))
        {
            $milestone->load(array('hash = :hash', array(':hash' => $msHash)));
            if ($milestone->dry())
                return $this->tpfail('Failure while editing milestone.');
        }

        $milestone->name = $name;
        $milestone->hash = $msHash;
        $milestone->description = ($projHash) ? 'My first milestone' : $this->get('POST.description');
        $milestone->project = ($projHash) ? $projHash : $this->get('SESSION.project');
        $milestone->finished = ($projHash) ? time()+2629743 : $this->get('POST.finished');
        $milestone->save();

        if(!$projHash)
            $this->reroute('/project/settings#milestones');
    }
    
    function deleteMilestone() 
    {
        $msHash = $this->get('PARAMS.hash');
        
        $tickets = new \ticket\model();
        $milestones = new \milestone\model();
        
        if($tickets->found(array('milestone = :ms', array(':ms' => $msHash))) < 1 && $milestones->found() > 1) {            
            $milestones->load(array('hash = :hash', array(':hash' => $msHash)));
            $milestones->erase();
            
            $this->set('SESSION.SUCCESS', 'Milestone has been deleted.');
            $this->reroute('/project/settings#milestones');
        } else {
            $this->tpfail('You cannot delete this milestone, because it still contains tickets or is at least the last one.');
        }
    }
}
