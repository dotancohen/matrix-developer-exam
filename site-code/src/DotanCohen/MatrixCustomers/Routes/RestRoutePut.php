<?php

namespace DotanCohen\MatrixCustomers\Routes;

use DotanCohen\MatrixCustomers\Database\Customer;

class RestRoutePut extends RestRoute {
	
	public function customer($params=[], $body=null) : void
	{
		if ( count($params)<1 ) {
			$resp = ['error' => 'Missing ID'];
			self::response($resp, 400);
		}

		$id = $params[0];
		$c = Customer::getById($id);

		if ( !isset($c->id) ) {
			$resp = ['customer' => null];
			self::response($resp, 404);
			return;
		}

		if ( isset($body->id_gov) ) {
			$c->id_gov = $body->id_gov;
		}

		if ( isset($body->name_first) ) {
			$c->name_first = $body->name_first;
		}

		if ( isset($body->name_last) ) {
			$c->name_last = $body->name_last;
		}

		if ( isset($body->date_birth) ) {
			$c->date_birth = new \DateTime($body->date_birth);
		}

		if ( isset($body->sex) ) {
			$c->sex = $body->sex;
		}

		if ( isset($body->phones) ) {
			$c->phones = $body->phones;
		}

		$customer = $c->save();

		$resp = ['customer' => $customer->toPublic()];
		self::response($resp, 201);
	}

}