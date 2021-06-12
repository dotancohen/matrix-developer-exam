<?php

namespace DotanCohen\MatrixCustomers\Routes;

use DotanCohen\MatrixCustomers\Database\Customer;

class RestRoutePost extends RestRoute {
	
	public function customer(?array $params=[], ?\stdClass $body=null) : void
	{
		$c = new Customer();
		$c->id_gov = $body->id_gov;
		$c->name_first = $body->name_first;
		$c->name_last = $body->name_last;
		$c->date_birth = new \DateTime($body->date_birth);
		$c->sex = $body->sex;
		$c->phones = $body->phones;
		$customer = $c->save();

		$resp = ['customer' => $customer->toPublic()];
		self::response($resp, 201);
	}

}