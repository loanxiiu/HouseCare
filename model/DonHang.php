<?php
	
	namespace BTL\model;
	
	class DonHang
	{
		public $ma;
		public $donGia;
		public $ngayBan;
		public $maKhachHang;
		public $maNhanVien;
		
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
		
		/**
		 * @return mixed
		 */
		public function getNgayBan()
		{
			return $this->ngayBan;
		}
		
		/**
		 * @param mixed $ngayBan
		 */
		public function setNgayBan($ngayBan)
		{
			$this->ngayBan = $ngayBan;
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
		public function setMaKhachHang($maKhachHang)
		{
			$this->maKhachHang = $maKhachHang;
		}
		
		/**
		 * @return mixed
		 */
		public function getMaNhanVien()
		{
			return $this->maNhanVien;
		}
		
		/**
		 * @param mixed $maNhanVien
		 */
		public function setMaNhanVien($maNhanVien)
		{
			$this->maNhanVien = $maNhanVien;
		}
	}