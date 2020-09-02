<?php

/**
 * Copyright (c) 2018-2020 Comet Licensing Ltd.
 * Please see the LICENSE file for usage information.
 * 
 * SPDX-License-Identifier: MIT
 */

namespace Comet;

/** 
 * Comet Server AdminDispatcherRequestFilesystemObjects API 
 * Request a list of filesystem objects from a live connected device
 * The device must have granted the administrator permission to view its filenames.
 * 
 * You must supply administrator authentication credentials to use this API.
 * This API requires the Auth Role to be enabled.
 */
class AdminDispatcherRequestFilesystemObjectsRequest implements \Comet\NetworkRequest {
	
	/**
	 * The live connection GUID
	 *
	 * @var string
	 */
	protected $TargetID = null;
	
	/**
	 * Browse objects inside this path. If empty or not present, returns the top-level device paths (optional)
	 *
	 * @var string|null
	 */
	protected $Path = null;
	
	/**
	 * Construct a new AdminDispatcherRequestFilesystemObjectsRequest instance.
	 *
	 * @param string $TargetID The live connection GUID
	 * @param string $Path Browse objects inside this path. If empty or not present, returns the top-level device paths (optional)
	 */
	public function __construct($TargetID, $Path = null)
	{
		$this->TargetID = $TargetID;
		$this->Path = $Path;
	}
	
	/**
	 * Get the URL where this POST request should be submitted to.
	 *
	 * @return string
	 */
	public function Endpoint()
	{
		return '/api/v1/admin/dispatcher/request-filesystem-objects';
	}
	
	public function Method()
	{
		return 'POST';
	}
	
	/**
	 * Get the POST parameters for this request.
	 *
	 * @return string[]
	 */
	public function Parameters()
	{
		$ret = [];
		$ret["TargetID"] = (string)($this->TargetID);
		if ($this->Path !== null) {
			$ret["Path"] = (string)($this->Path);
		}
		return $ret;
	}
	
	/**
	 * Decode types used in a response to this request.
	 * Use any network library to make the request.
	 *
	 * @param int $responseCode HTTP response code
	 * @param string $body HTTP response body
	 * @return \Comet\StoredObject[] 
	 * @throws \Exception
	 */
	public static function ProcessResponse($responseCode, $body)
	{
		// Require expected HTTP 200 response
		if ($responseCode !== 200) {
			throw new \Exception("Unexpected HTTP " . intval($responseCode) . " response");
		}
		
		// Decode JSON
		$decoded = \json_decode($body); // as stdClass
		if (\json_last_error() != \JSON_ERROR_NONE) {
			throw new \Exception("JSON decode failed: " . \json_last_error_msg());
		}
		
		// Try to parse as error format
		$isCARMDerivedType = (($decoded instanceof \stdClass) && property_exists($decoded, 'Status') && property_exists($decoded, 'Message'));
		if ($isCARMDerivedType) {
			$carm = \Comet\APIResponseMessage::createFromStdclass($decoded);
			if ($carm->Status >= 400) {
				throw new \Exception("Error " . $carm->Status . ": " . $carm->Message);
			}
		}
		
		// Parse as []StoredObject
		$val_0 = [];
		if ($decoded !== null) {
			for($i_0 = 0; $i_0 < count($decoded); ++$i_0) {
				if (is_array($decoded[$i_0]) && count($decoded[$i_0]) === 0) {
				// Work around edge case in json_decode--json_encode stdClass conversion
					$val_0[] = \Comet\StoredObject::createFromStdclass(new \stdClass());
				} else {
					$val_0[] = \Comet\StoredObject::createFromStdclass($decoded[$i_0]);
				}
			}
		}
		$ret = $val_0;
		
		return $ret;
	}
	
}

