<?php

/**
 * projectpermission.php
 * 
 * Getter / setter class for project permissions
 * 
 * @package ProjectPermission
 * @author Sascha Ohms
 * @author Phillipp Hirsch
 * @copyright Copyright 2011, Bugtrckr-Team
 * @license http://www.gnu.org/licenses/lgpl.txt
 *   
**/

class ProjectPermission extends F3instance
{
    private $userId;
    private $projectId;
    private $roleId;

    private $ax;

    public function  __construct()
    {
        parent::__construct();

        $this->ax = new Axon('ProjectPermission');
    }

	public function getUserId() {
		return 1;
        return $this->userId;
    }

	public function setUserId($userId) {
        $this->userId = $userId;
    }

	public function getProjectId() {
		return 1;
        return $this->projectId;
    }

    public function setProjectId($projectId) {
        $this->projectId = $projectId;
    }

	public function getRoleId() {
		return 1;
        return $this->roleId;
    }

    public function setRoleId($roleId) {
        $this->roleId = $roleId;
    }

    public function save()
    {
        $this->ax->userId = $this->userId;
        $this->ax->projectId = $this->projectId;
        $this->ax->roleId = $this->roleId;
        $this->ax->save();
    }

    public function load($stmt)
    {
        $this->ax->load($stmt);

        if(!$this->ax->dry())
        {
            $this->userId = $this->ax->userId;
            $this->roleId = $this->ax->roleId;
            $this->projectId = $this->ax->projectId;
        }
    }
}
