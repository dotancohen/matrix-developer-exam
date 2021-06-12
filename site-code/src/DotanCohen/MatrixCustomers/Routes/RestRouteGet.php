<?php

namespace DotanCohen\MatrixCustomers\Routes;

use DotanCohen\MatrixCustomers\Database\Customer;

class RestRouteGet extends RestRoute {


	public function customerPhone($params=[], $body=null) : void
	{
		// TODO
		echo "GET PHONE";
	}


	public function customerIdGov($params=[], $body=null) : void
	{
		if ( count($params)<1 ) {
			$resp = ['error' => 'Missing ID'];
			self::response($resp, 400);
		}

		$id_gov = $params[0];
		$c = Customer::getByGovId($id_gov);

		if ( !isset($c->id) ) {
			$resp = ['customer' => null];
			self::response($resp, 404);
			return;
		}

		$resp = ['customer' => $c->toPublic()];
		self::response($resp);
	}

}