<?php
	namespace BTL\controller;
	require_once __DIR__ . '/../model/SanPham.php';
	require_once __DIR__ . '/../db/SanPhamDB.php';
	
	use BTL\db\SanPhamDB;
	use BTL\model\User;
	
	class UserController
	{
//		public function index(){
//			$user = new User(1, "John Doe", "john@example.com", "123 Street", "avatar.jpg");
//			echo $user->getTen();
//		}
		
	}
	
//	$user = new UserController();
//	 $user->index();
	 $sanphamDB = new SanPhamDB();
	 echo $sanphamDB->conn;
	
	