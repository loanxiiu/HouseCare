<?php
	
	namespace BTL\model;
	
	class ThanhToan
	{
		public $ma;
		public $maDonHang;
		public $ngayTao;
		public $tongTien;
		public $maKhachHang;
		public $phuongThucThanhToan;
		public $trangThai;
		
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
		public function getMaDonHang()
		{
			return $this->maDonHang;
		}
		
		/**
		 * @param mixed $maDonHang
		 */
		public function setMaDonHang($maDonHang)
		{
			$this->maDonHang = $maDonHang;
		}
		
		/**
		 * @return mixed
		 */
		public function getNgayTao()
		{
			return $this->ngayTao;
		}
		
		/**
		 * @param mixed $ngayTao
		 */
		public function setNgayTao($ngayTao)
		{
			$this->ngayTao = $ngayTao;
		}
		
		/**
		 * @return mixed
		 */
		public function getTongTien()
		{
			return $this->tongTien;
		}
		
		/**
		 * @param mixed $tongTien
		 */
		public function setTongTien($tongTien)
		{
			$this->tongTien = $tongTien;
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
		public function getPhuongThucThanhToan()
		{
			return $this->phuongThucThanhToan;
		}
		
		/**
		 * @param mixed $phuongThucThanhToan
		 */
		public function setPhuongThucThanhToan($phuongThucThanhToan)
		{
			$this->phuongThucThanhToan = $phuongThucThanhToan;
		}
		
		/**
		 * @return mixed
		 */
		public function getTrangThai()
		{
			return $this->trangThai;
		}
		
		/**
		 * @param mixed $trangThai
		 */
		public function setTrangThai($trangThai)
		{
			$this->trangThai = $trangThai;
		}
	}