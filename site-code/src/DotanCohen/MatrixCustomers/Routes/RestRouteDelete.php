<?php

namespace DotanCohen\MatrixCustomers\Routes;

use DotanCohen\MatrixCustomers\Database\Customer;

class RestRouteDelete extends RestRoute {
	
	public function customer($params=[], $body=null) : void
	{
		if ( count($params)<1 ) {
			$resp = ['error' => 'Missing Phone'];
			self::response($resp, 400);
			return;
		}

		if ( !is_numeric($params[0]) ) {
			$resp = ['error' => 'ID is not an integer'];
			self::response($resp, 400);
			return;
		}

		$id =(int)$params[0];
		Customer::deleteByID($id);

		$resp = ['deleted'];
		self::response($resp, 204);
	}

}