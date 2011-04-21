<?php

	class user extends F3instance
	{
		private $id;
        private $hash;
        private $password;
        private $salt;
        private $email;
        private $admin;
        private $name;
        private $role;

        private $ax;

        public function __construct()
        {
            parent::__construct();

            $this->ax = new Axon('User');
        }

        public function setId($id)
        {
            $this->id = $id;
        }

        public function setName($name)
        {
            $this->name = $name;
        }

        public function setHash($hash)
        {
            $this->hash = $hash;
        }

        public function setPassword($password)
        {
            $this->password = $password;
        }

        public function setSalt($salt)
        {
            $this->salt = $salt;
        }

        public function setEmail($email)
        {
            $this->email = $email;
        }

        public function setAdmin($admin)
        {
            $this->admin = $admin;
        }

        public function setRole($role)
        {
            $this->role = $role;
        }

        public function getId()
        {
            return $this->id;
        }

        public function getName()
        {
            return $this->name;
        }

        public function getHash()
        {
            return $this->hash;
        }

        public function getPassword()
        {
            return $this->password;
        }

        public function getSalt()
        {
            return $this->salt;
        }

        public function getEmail()
        {
            return $this->email;
        }

        public function getAdmin()
        {
            return $this->admin;
        }

        public function getRole()
        {
            return $this->role;
        }

        public function save()
        {
            $this->ax->load('hash = "' .$this->hash. '"');
            $this->ax->name = $this->name;
            $this->ax->hash = $this->hash;
            $this->ax->password = $this->password;
            $this->ax->salt = $this->salt;
            $this->ax->email = $this->email;
            $this->ax->admin = $this->admin;
            $this->ax->role = $this->role;
            $this->ax->save();
        }

        public function load($stmt)
        {
            $this->ax->load($stmt);

            if(!$this->ax->dry())
            {
                $this->name = $this->ax->name;
                $this->hash = $this->ax->hash;
                $this->password = $this->ax->password;
                $this->salt = $this->ax->salt;
                $this->email = $this->ax->email;
                $this->admin = $this->ax->admin;
                $this->id = $this->ax->id;
                $this->role = $this->ax->role;
            }
        }
	}
