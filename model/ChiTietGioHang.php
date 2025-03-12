<?php
	
	namespace BTL\model;
	
	class ChiTietGioHang
	{
		public $ma;
		public $maGioHang;
		public $maSanPham;
		public $soLuong;
		
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
		public function getMaGioHang()
		{
			return $this->maGioHang;
		}
		
		/**
		 * @param mixed $maGioHang
		 */
		public function setMaGioHang($maGioHang)
		{
			$this->maGioHang = $maGioHang;
		}
		
		/**
		 * @return mixed
		 */
		public function getMaSanPham()
		{
			return $this->maSanPham;
		}
		
		/**
		 * @param mixed $maSanPham
		 */
		public function setMaSanPham($maSanPham)
		{
			$this->maSanPham = $maSanPham;
		}
		
		/**
		 * @return mixed
		 */
		public function getSoLuong()
		{
			return $this->soLuong;
		}
		
		/**
		 * @param mixed $soLuong
		 */
		public function setSoLuong($soLuong)
		{
			$this->soLuong = $soLuong;
		}
	}