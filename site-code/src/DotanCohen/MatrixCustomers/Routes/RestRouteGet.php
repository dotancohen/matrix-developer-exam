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

		$resp = ['customer' => $c->toPublic()];
		$code = is_null($c->id) ? 404 : 200;
		self::response($resp, $code);
	}

}