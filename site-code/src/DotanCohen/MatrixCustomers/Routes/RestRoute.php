<?php

namespace DotanCohen\MatrixCustomers\Routes;

class RestRoute {

	/**
	 * Provide a uniform response to the client
	 * 
	 * @param array $response
	 */
	protected function response(array $response) : void
	{
		header('content-type: application/json');
		header('access-control-allow-credentials: true');
		//header('access-control-allow-methods: GET, POST, HEAD, OPTIONS, DELETE');
		header('access-control-allow-methods: GET, POST, HEAD, DELETE');
		header('access-control-allow-origin: *');
		header('access-control-max-age: 300');
		header('cache-control: no-cache, no-store');

		echo json_encode($response);
	}

}