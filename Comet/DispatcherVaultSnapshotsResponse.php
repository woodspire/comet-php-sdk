<?php

namespace Comet;

class DispatcherVaultSnapshotsResponse {
	
	/**
	 * @var int
	 */
	public $Status = 0;
	
	/**
	 * @var string
	 */
	public $Message = "";
	
	/**
	 * @var \Comet\VaultSnapshot[]
	 */
	public $Snapshots = [];
	
	/**
	 * Preserve unknown properties when dealing with future server versions.
	 *
	 * @see DispatcherVaultSnapshotsResponse::RemoveUnknownProperties() Remove all unknown properties
	 * @var array
	 */
	private $__unknown_properties = [];
	
	/**
	 * Replace the content of this DispatcherVaultSnapshotsResponse object from a PHP array.
	 * The data could be supplied from an API call after json_decode(..., true); or generated manually.
	 *
	 * @param array $decodedJsonObject Object data as PHP array
	 * @return void
	 */
	public function inflateFrom(array $decodedJsonObject)
	{
		$this->Status = (int)($decodedJsonObject['Status']);
		
		$this->Message = (string)($decodedJsonObject['Message']);
		
		$val_2 = [];
		for($i_2 = 0; $i_2 < count($decodedJsonObject['Snapshots']); ++$i_2) {
			$val_2[] = \Comet\VaultSnapshot::createFrom(isset($decodedJsonObject['Snapshots'][$i_2]) ? $decodedJsonObject['Snapshots'][$i_2] : []);
		}
		$this->Snapshots = $val_2;
		
		foreach($decodedJsonObject as $k => $v) {
			switch($k) {
			case 'Status':
			case 'Message':
			case 'Snapshots':
				break;
			default:
				$this->__unknown_properties[$k] = $v;
			}
		}
	}
	
	/**
	 * Coerce a plain PHP array into a new strongly-typed DispatcherVaultSnapshotsResponse object.
	 * The data could be supplied from an API call after json_decode(..., true); or generated manually.
	 *
	 * @param array $decodedJsonObject Object data as PHP array
	 * @return DispatcherVaultSnapshotsResponse
	 */
	public static function createFrom(array $decodedJsonObject)
	{
		$retn = new DispatcherVaultSnapshotsResponse();
		$retn->inflateFrom($decodedJsonObject);
		return $retn;
	}
	
	/**
	 * Convert this DispatcherVaultSnapshotsResponse object into a plain PHP array.
	 *
	 * @param bool $forJSONEncode Set true to use stdClass() for empty objects instead of just [], in order to
	 *                             accurately roundtrip empty objects/arrays through json_encode() compatibility
	 * @return array
	 */
	public function toArray($forJSONEncode=false)
	{
		$ret = [];
		$ret["Status"] = $this->Status;
		$ret["Message"] = $this->Message;
		{
			$c0 = [];
			for($i0 = 0; $i0 < count($this->Snapshots); ++$i0) {
				if ( $this->Snapshots[$i0] === null ) {
					$val0 = $for_json_encode ? (object)[] : [];
				} else {
					$val0 = $this->Snapshots[$i0]->toArray($for_json_encode);
				}
				$c0[] = $val0;
			}
			$ret["Snapshots"] = $c0;
		}
		
		// Reinstate unknown properties from future server versions
		foreach($this->__unknown_properties as $k => $v) {
			if ($forJSONEncode && is_array($v) && count($v) == 0) {
				$ret[$k] = (object)[];
			} else {
				$ret[$k] = $v;
			}
		}
		
		// Special handling for empty objects
		if ($forJSONEncode && count($ret) === 0) {
			return new stdClass();
		}
		return $ret;
	}
	
	/**
	 * Convert this object to a JSON string.
	 * The result is suitable to submit to the Comet Server API.
	 *
	 * @return string
	 */
	public function toJSON()
	{
		return json_encode( self::toArray(true) );
	}
	
	/**
	 * Erase any preserved object properties that are unknown to this Comet Server SDK.
	 *
	 * @return void
	 */
	public function RemoveUnknownProperties()
	{
		$this->__unknown_properties = [];
	}
	
}
