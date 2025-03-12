<?php
	
	namespace BTL\model;
	
	class GioHang
	{
		public $ma;
		public $maKhachHang;
		public $donGia;

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

		public function getMaKhachHang()
		{
			return $this->maKhachHang;
		}
		
		/**
		 * @param mixed $maKhachHang
		 */
		public function setMaKhachHang($maKhachHang)
		{
			$this->maKhachHang = $maKhachHang;
		}

		public function getDonGia()
		{
			return $this->donGia;
		}
		
		/**
		 * @param mixed $donGia
		 */
		public function setDonGia($donGia)
		{
			$this->donGia = $donGia;
		}
		
	}