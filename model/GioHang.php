<?php
	namespace BTL\model;
	
	class GioHang
	{
		public $ma;
		public $maKhachHang;
		public $donGia;
		private $chiTietGioHangs = []; // Add this to store cart items
		
		public function __construct($ma, $maKhachHang, $donGia)
		{
			$this->ma = $ma;
			$this->maKhachHang = $maKhachHang;
			$this->donGia = $donGia;
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
		public function getMaKhachHang()
		{
			return $this->maKhachHang;
		}
		
		/**
		 * @param mixed $maKhachHang
		 */
		public function setMaKhachHang($maKhachHang): void
		{
			$this->maKhachHang = $maKhachHang;
		}
		
		/**
		 * @return mixed
		 */
		public function getDonGia()
		{
			return $this->donGia;
		}
		
		/**
		 * @param mixed $donGia
		 */
		public function setDonGia($donGia): void
		{
			$this->donGia = $donGia;
		}
		
		
		// Existing getters and setters...
		
		public function getChiTietGioHangs()
		{
			return $this->chiTietGioHangs;
		}
		
		public function setChiTietGioHangs($chiTietGioHangs)
		{
			$this->chiTietGioHangs = $chiTietGioHangs;
		}
	}