<?php

namespace DotanCohen\MatrixCustomers\Routes;

abstract class RestRoute {

	const HTTP_STATUS_CODES = [200, 201, 400, 401, 403, 404, 405, 409, 500, 503];

	/**
	 * Provide a uniform response to the client
	 *
	 * @param int $code HTTP Response Code
	 * @param array $response
	 */
	protected function response(array $response, int $code=200) : void
	{
		if ( !in_array($code, self::HTTP_STATUS_CODES) ) {
			$code = 200;
		}
		http_response_code($code);

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