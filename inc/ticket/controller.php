<?php

/**
 * ticket\controller.php
 * 
 * Ticket controller
 * 
 * @package ticket
 * @author Sascha Ohms
 * @author Philipp Hirsch
 * @copyright Copyright 2011, Bugtrckr-Team
 * @license http://www.gnu.org/licenses/lgpl.txt
 *   
 */
namespace ticket;

class controller extends \misc\controller
{

    /**
     *	Add Ticket into the database
     */
    function addTicket()
    {
        if (!\misc\helper::getPermission('iss_addIssues'))
            return $this->tpfail('You are not allowed to add tickets.');

        $ticket = new \ticket\model();
        $ticket->hash = \misc\helper::getFreeHash('Ticket');
        $ticket->title = $this->get('POST.title');
        $ticket->description = $this->get('POST.description');
        $ticket->owner = $this->get('SESSION.user.hash');
        $ticket->assigned = 0; // do not assign to anyone
        $ticket->type = $this->get('POST.type');
        $ticket->state = 1;
        $ticket->created = time();
        $ticket->priority = $this->get('POST.priority');
        $ticket->category = $this->get('POST.category');
        $ticket->milestone = $this->get('POST.milestone');
        $ticket->save();

        if (!$ticket->_id)
            return $this->tpfail($this->get('lng.failTicketSave'));

        \misc\helper::addActivity(
            $this->get('lng.ticket') . " '$ticket->title' " . $this->get('lng.added') . ".", $ticket->_id);

        $this->reroute($this->get('BASE') . '/ticket/' . $ticket->hash);
    }

    /**
     *	Updates a Ticket in the database
     */
    function editTicket()
    {
		if (!is_numeric($this->get('POST.state')) || 
			$this->get('POST.state') <= 0 || 
			$this->get('POST.state') > 5)
			return $this->tpfail($this->get('lng.failTicketSave'));

        $hash = $this->get('PARAMS.hash');

        $ticket = new \ticket\model();
        $ticket->load(array('hash = :hash', array(':hash' => $hash)));

        $ticket->state = $this->get('POST.state');
		if (ctype_alnum($this->get('POST.user')))
			$ticket->assigned = $this->get('POST.user');
		if (ctype_alnum($this->get('POST.milestone')))
        	$ticket->milestone = $this->get('POST.milestone');

        $ticket->save();

        if (!$ticket->hash)
            return $this->tpfail($this->get('lng.failTicketSave'));

        \misc\helper::addActivity(
			$this->get('lng.ticket') . " '" .$ticket->title. "' " .$this->get('lng.edited'), $ticket->hash, $this->get('POST.comment'));

        $this->reroute($this->get('BASE').'/ticket/'.$hash);
    }
}
