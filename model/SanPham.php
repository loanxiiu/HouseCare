<?php
	namespace BTL\model;
	
	class SanPham
	{
		private $ma;
		private $ten;
		private $soLuong;
		private $gia;
		private $anh;
		private $maDanhMuc;
		
		private $moTa;
		
		/**
		 * @param $ma
		 * @param $ten
		 * @param $soLuong
		 * @param $gia
		 * @param $anh
		 * @param $maDanhMuc
		 */
		public function __construct($ma, $ten, $soLuong, $gia, $anh, $maDanhMuc, $moTa)
		{
			$this->ma = $ma;
			$this->ten = $ten;
			$this->soLuong = $soLuong;
			$this->gia = $gia;
			$this->anh = $anh;
			$this->maDanhMuc = $maDanhMuc;
			$this->moTa = $moTa;
		}
		
		/**
		 * @return mixed
		 */
		public function getMoTa()
		{
			return $this->moTa;
		}
		
		/**
		 * @param mixed $moTa
		 */
		public function setMoTa($moTa): void
		{
			$this->moTa = $moTa;
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
		public function getTen()
		{
			return $this->ten;
		}
		
		/**
		 * @param mixed $ten
		 */
		public function setTen($ten): void
		{
			$this->ten = $ten;
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
		public function setSoLuong($soLuong): void
		{
			$this->soLuong = $soLuong;
		}
		
		/**
		 * @return mixed
		 */
		public function getGia()
		{
			return $this->gia;
		}
		
		/**
		 * @param mixed $gia
		 */
		public function setGia($gia): void
		{
			$this->gia = $gia;
		}
		
		/**
		 * @return mixed
		 */
		public function getAnh()
		{
			return $this->anh;
		}
		
		/**
		 * @param mixed $anh
		 */
		public function setAnh($anh): void
		{
			$this->anh = $anh;
		}
		
		/**
		 * @return mixed
		 */
		public function getMaDanhMuc()
		{
			return $this->maDanhMuc;
		}
		
		/**
		 * @param mixed $maDanhMuc
		 */
		public function setMaDanhMuc($maDanhMuc): void
		{
			$this->maDanhMuc = $maDanhMuc;
		}
		
	}
?>
