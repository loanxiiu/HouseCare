<?php
	
	namespace BTL\model;
	
	class ChiTietDonHang
	{
		public $ma;
		public $maDH;
		public $maSP;
		public $soluong;
		
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
		public function getMaDH()
		{
			return $this->maDH;
		}
		
		/**
		 * @param mixed $maDH
		 */
		public function setMaDH($maDH)
		{
			$this->maDH = $maDH;
		}
		
		/**
		 * @return mixed
		 */
		public function getMaSP()
		{
			return $this->maSP;
		}
		
		/**
		 * @param mixed $maSP
		 */
		public function setMaSP($maSP)
		{
			$this->maSP = $maSP;
		}
		
		/**
		 * @return mixed
		 */
		public function getSoluong()
		{
			return $this->soluong;
		}
		
		/**
		 * @param mixed $soluong
		 */
		public function setSoluong($soluong)
		{
			$this->soluong = $soluong;
		}
	}