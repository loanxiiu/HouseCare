<?php
	
	namespace BTL\model;
	
	class Quyen
	{
		public $ma;
		public $ten;
		
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