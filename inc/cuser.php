<?php

/**
 * cuser.php
 * 
 * User controller
 * 
 * @package user
 * @author Sascha Ohms
 * @author Philipp Hirsch
 * @copyright Copyright 2011, Bugtrckr-Team
 * @license http://www.gnu.org/licenses/lgpl.txt
 *   
 */
class cuser extends Controller
{
    /**
     *	Displays users infopage
     */
    function showUser()
    {
        $name = $this->get('PARAMS.name');

        $user = new User();
        $user->load(array('name = :name', array(':name' => $name)));

        if (!$user->id)
            return $this->tpfail("User not found");

        $ticket = new DisplayableTicket();
        $tickets = $ticket->find('owner = ' . $user->id);

        $this->set('user', $user);
        $this->set('tickets', $tickets);
        $this->set('template', 'user.tpl.php');
        $this->set('pageTitle', '{{@lng.user}} › ' . $name);
        $this->set('onpage', 'user');
        $this->tpserve();
    }
    
    /**
     *	Displays a form for registration
     */
    function showUserRegister()
    {
        $this->set('template', 'userRegister.tpl.php');
        $this->set('pageTitle', '{{@lng.user}} › {{@lng.registration}}');
        $this->set('onpage', 'registration');
        $this->tpserve();
    }

    /**
     *	Adds a new user to the database
     */
    function registerUser($name = false, $password = false, $email = false, $admin = false)
    {
		if (($this->get('POST.name') == "" && $name == "") ||
			($this->get('POST.email') == "" && $email == "") ||
			(helper::checkEmail($this->get('POST.email') == 0) && 
			 helper::checkEmail($email) == 0))
			return $this->tpfail('Please correct your data.');

        $salt = helper::randStr();

        $user = new user();
        $user->name = $name ? $name : $this->get('POST.name');
        $user->email = $email ? $email : $this->get('POST.email');
        $user->password = $password ? helper::salting($salt, $password) : helper::salting($salt, $this->get('POST.password'));
        $user->salt = $salt;
        $user->hash = helper::getFreeHash('User');
        $user->admin = $admin ? 1 : 0;
        $user->save();

        if (!$user->_id)
        {
            $this->tpfail("Failure while creating User");
            return;
        }

        if(!isset($name)) {
            $this->set('SESSION.SUCCESS', 'User registred successfully');
            $this->reroute($this->get('BASE') . '/');
        }
    }

    /**
     *	Show loginform
     */
    function showUserLogin()
    {
        $this->set('template', 'userLogin.tpl.php');
        $this->set('pageTitle', '{{@lng.user}} › {{@lng.login}}');
        $this->set('onpage', 'login');
        $this->tpserve();
    }

    /**
     *	Checks user to log in
     */
    function loginUser()
    {
        $user = new User();        
        $user->load(array('email = :email', array(':email' => $this->get('POST.email'))));
        $user->load(array('email = :email AND password = :password',
            array(':email' => $this->get('POST.email'),
                ':password' => helper::salting($user->salt, $this->get('POST.password')))));

        if ($user->dry())
        {
            $this->set('SESSION.FAILURE', 'Password or Email is incorrect');
            $this->reroute($this->get('BASE') . '/user/login');
        }

        echo $this->get('SESSION.project');

        // enable user's last used project if he hasn't already chosen one
        if($user->lastProject && !$this->get('SESSION.project'))
            $this->set('SESSION.project', $user->lastProject);

        $this->set('SESSION.user', array('name' => $user->name, 'id' => $user->id, 'admin' => $user->admin, 'hash' => $user->hash));
        $this->set('SESSION.SUCCESS', 'Login successful');
        $this->reroute($this->get('BASE') . '/');
    }

    /**
     *	Destroy users session 
     */
    function logoutUser()
    {
        $this->set('SESSION.userName', NULL);
        $this->set('SESSION.userPassword', NULL);
        $this->set('SESSION.userHash', NULL);
        $this->set('SESSION.userId', NULL);
        session_destroy();

        $this->set('SESSION.SUCCESS', 'User logged out');
        $this->reroute($this->get('BASE') . '/');
    }
}
