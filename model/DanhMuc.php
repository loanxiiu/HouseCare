<?php
	
	namespace BTL\model;
	
	class DanhMuc
	{
		public $ma;
		public $ten;
		
		/**
		 * @param $ma
		 * @param $ten
		 */
		public function __construct($ma, $ten)
		{
			$this->ma = $ma;
			$this->ten = $ten;
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
		public function setMa($ma)
		{
			$this->ma = $ma;
		}
		
		/**
		 * @return mixed
		 */
		public function getTen()
		{
			return $this->ten;
		}
		
		/**
		 * @param mixed $ten
		 */
		public function setTen($ten)
		{
			$this->ten = $ten;
		}
	}