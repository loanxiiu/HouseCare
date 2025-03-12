<?php
	
	namespace BTL\model;
	
	class TaiKhoan
	{
		public $ma;
		public $maUser;
		public $maQuyen;
		public $username;
		public $password;
		
		/**
		 * @return mixed
		 */
		public function getMaQuyen()
		{
			return $this->maQuyen;
		}
		
		/**
		 * @param mixed $maQuyen
		 */
		public function setMaQuyen($maQuyen): void
		{
			$this->maQuyen = $maQuyen;
		}
		
		/**
		 * @return mixed
		 */
		public function getMa()
		{
			return $this->ma;
		}
		
		/**
		 * @param mixed $ma
		 */
		public function setMa($ma): void
		{
			$this->ma = $ma;
		}
		
		/**
		 * @return mixed
		 */
		public function getMaUser()
		{
			return $this->maUser;
		}
		
		/**
		 * @param mixed $maUser
		 */
		public function setMaUser($maUser): void
		{
			$this->maUser = $maUser;
		}
		
		/**
		 * @return mixed
		 */
		public function getUsername()
		{
			return $this->username;
		}
		
		/**
		 * @param mixed $username
		 */
		public function setUsername($username): void
		{
			$this->username = $username;
		}
		
		/**
		 * @return mixed
		 */
		public function getPassword()
		{
			return $this->password;
		}
		
		/**
		 * @param mixed $password
		 */
		public function setPassword($password): void
		{
			$this->password = $password;
		}
		
	}