<?php

/**
 * main.php
 * 
 * Everything comes together in here
 * 
 * @package Main
 * @author Sascha Ohms
 * @author Philipp Hirsch
 * @copyright Copyright 2011, Bugtrckr-Team
 * @license http://www.gnu.org/licenses/lgpl.txt
 *   
 */
class cmain extends Controller
{

    function start()
    {
        $this->set('pageTitle', '{{@lng.home}}');
        $this->set('template', 'home.tpl.php');
        $this->tpserve();
    }
 
    /**
     *
     */
    function selectProject()
    {
        $url = $this->get('SERVER.HTTP_REFERER');

        $projectId = $this->get('POST.project');

        $project = new Project();
        $project->load("hash = '$projectId'");

        if (!$project->id)
        {
            $this->tpfail("Failure while changing Project");
            return;
        }

        if ($this->get('SESSION.user.id'))
        {
            $user = new User();
            $user->load("id = " . $this->get('SESSION.user.id'));
            $user->lastProject = $project->id;
            $user->save();
        }

        $this->set('SESSION.project', $project->id);
        $this->reroute($url);
    }

}