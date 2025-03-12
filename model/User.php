<?php
	
	namespace BTL\model;
	
	class User
	{
		public $ma;
		public $ten;
		public $email;
		public $diaChi;
		public $anh;
		
		
		public function __construct($id, $ten, $email, $address, $image)
		{
			$this->ma = $id;
			$this->ten = $ten;
			$this->email = $email;
			$this->diaChi = $address;
			$this->anh = $image;
		}
		
		public function setMa($ma)
		{
			$this->ma = $ma;
		}
		
		public function getMa()
		{
			return $this->ma;
		}
		
		public function setTen($ten)
		{
			$this->ten = $ten;
		}
		
		public function getTen()
		{
			return $this->ten;
		}
		
		public function setEmail($email)
		{
			$this->email = $email;
		}
		
		public function getEmail()
		{
			return $this->email;
		}
		
		public function setDiaChi($diaChi)
		{
			$this->diaChi = $diaChi;
		}
		
		public function getDiaChi()
		{
			return $this->diaChi;
		}
		
		public function setAnh($anh)
		{
			$this->anh = $anh;
		}
		
		public function getAnh()
		{
			return $this->anh;
		}
	}
	
	?>