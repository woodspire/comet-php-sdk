<?php

namespace Comet;

/** 
 * Comet Server AdminGetUserProfileHash API 
 * Get user account profile (hash)
 * The profile hash can be used to determine if a user account profile has changed.
 * The hash format is not publicly documented and may change in a future server version. Use server APIs to retrieve current hash values.
 * 
 * You must supply administrator authentication credentials to use this API.
 * This API requires the Auth Role to be enabled.
 */
class AdminGetUserProfileHashRequest implements \Comet\NetworkRequest {
	
	/**
	 * Selected account username
	 *
	 * @var string
	 */
	protected $TargetUser = null;
	
	/**
	 * Construct a new AdminGetUserProfileHashRequest instance.
	 *
	 * @param string $TargetUser Selected account username
	 */
	public function __construct($TargetUser)
	{
		$this->TargetUser = $TargetUser;
	}
	
	/**
	 * Get the URL where this POST request should be submitted to.
	 *
	 * @return string
	 */
	public function Endpoint()
	{
		return '/api/v1/admin/get-user-profile-hash';
	}
	
	/**
	 * Get the POST parameters for this request.
	 *
	 * @return string[]
	 */
	public function Parameters()
	{
		$ret = [];
		$ret["TargetUser"] = (string)($this->TargetUser);
		return $ret;
	}
	
	/**
	 * Decode types used in a response to this request.
	 * Use any network library to make the request.
	 *
	 * @param int $responseCode HTTP response code
	 * @param string $body HTTP response body
	 * @return \Comet\GetProfileHashResponseMessage 
	 * @throws \Exception
	 */
	public static function ProcessResponse($responseCode, $body)
	{
		// Require expected HTTP 200 response
		if ($responseCode !== 200) {
			throw new \Exception("Unexpected HTTP " . intval($responseCode) . " response");
		}
		
		// Decode JSON
		$decoded = \json_decode($body, true);
		if (\json_last_error() != \JSON_ERROR_NONE) {
			throw new \Exception("JSON decode failed: " . \json_last_error_msg());
		}
		
		// Try to parse as error format
		if (array_key_exists('Status', $decoded) && array_key_exists('Message', $decoded)) {
			$carm = \Comet\APIResponseMessage::createFrom($decoded);
			if ($carm->Status !== 0 || $carm->Message != "") {
				throw new \Exception("Error " . $carm->Status . ": " . $carm->Message);
			}
		}
		
		// Parse as GetProfileHashResponseMessage
		$ret = \Comet\GetProfileHashResponseMessage::createFrom(isset($decoded) ? $decoded : []);
		
		return $ret;
	}
	
}

