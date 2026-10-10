<?php

namespace Haskimail;

use Haskimail\Models\DynamicResponseModel as DynamicResponseModel;
use Haskimail\HaskimailClientBase as HaskimailClientBase;

/**
 * The HaskimailAdminClient allows users to access and modify
 *  "Account-wide" settings. At this time the API supports
 *  management of the "Sender Signatures", "Domains", and "Servers."
 */
class HaskimailAdminClient extends HaskimailClientBase {

	/**
	 * Create a new HaskimailAdminClient.
	 *
	 * @param string $accountToken The Account Token used to access the Admin API.
	 *
	 * @param integer $timeout The timeout, in seconds, that API calls should wait before throwing an exception.
	 */
	function __construct($accountToken, $timeout = 60) {
		parent::__construct($accountToken, "X-Haskimail-Account-Token", $timeout);
	}

	/**
	 * Request a given server by ID.
	 *
	 * @param int $id The Id for the server you wish to retrieve.
	 * @return DynamicResponseModel
	 */
	function getServer($id) {
		return new DynamicResponseModel($this->processRestRequest('GET', "/servers/$id"));
	}

	/**
	 * Get a list of all servers configured on the account.
	 *
	 * @param integer $count  The number of servers to retrieve in the request, defaults to 100.
	 * @param integer $offset  The number of servers to "skip" when paging through lists of servers.
	 * @param string $name Filter by server name.
	 * @return DynamicResponseModel
	 */
	function listServers($count = 100, $offset = 0, $name = NULL) {
		$query = array();
		$query['count'] = $count;
		$query['offset'] = $offset;
		$query['name'] = $name;

		return new DynamicResponseModel($this->processRestRequest('GET', '/servers', $query));
	}

	/**
	 * Delete a Server used for sending/receiving mail. NOTE: To protect your account, you'll need to
	 * contact support and request that they enable this feature on your account before you can use this
	 * client to delete Servers.
	 *
	 * @param  integer $id The ID of the Server to delete.
	 * :return DynamicResponseModel
	 */
	function deleteServer($id) {
		return new DynamicResponseModel($this->processRestRequest('DELETE', "/servers/$id"));
	}

	/**
	 * Modify an existing Server. Any parameters passed with NULL will be
	 * ignored (their existing values will not be modified).
	 *
	 * @param integer $id The ID of the Server we wish to modify.
	 * @param string $name Set the name of the server.
	 * @param string $color Set the color for the server in the Haskimail WebUI (must be: 'purple', 'blue', 'turqoise', 'green', 'red', 'yellow', or 'grey')
	 * @param bool $rawEmailEnabled Enable raw email to be sent with inbound.
	 * @param bool $smtpApiActivated Specifies whether or not SMTP is enabled on this server.
	 * @param string $inboundHookUrl URL to POST to everytime an inbound event occurs.
	 * @param string $bounceHookUrl URL to POST to everytime a bounce event occurs.
	 * @param string $openHookUrl URL to POST to everytime an open event occurs.
	 * @param bool $postFirstOpenOnly If set to true, only the first open by a particular recipient will initiate the open webhook. Any subsequent opens of the same email by the same recipient will not initiate the webhook.
	 * @param bool $trackOpens Indicates if all emails being sent through this server have open tracking enabled.
	 * @param string $inboundDomain Inbound domain for MX setup.
	 * @param integer $inboundSpamThreshold The maximum spam score for an inbound message before it's blocked (range from 0-30).
	 * @param  string $trackLinks Indicates if all emails being sent through this server have link tracking enabled.
	 * @param  string $clickHookUrl URL to POST to everytime an click event occurs.
	 * @param  string $deliveryHookUrl URL to POST to everytime an click event occurs.
	 * @param  string $enableSmtpApiErrorHooks Specifies whether or not SMTP API Errors will be included with bounce webhooks.
	 * @return DynamicResponseModel
	 */
	function editServer($id, $name = NULL, $color = NULL,
		$rawEmailEnabled = NULL, $smtpApiActivated = NULL, $inboundHookUrl = NULL,
		$bounceHookUrl = NULL, $openHookUrl = NULL, $postFirstOpenOnly = NULL,
		$trackOpens = NULL, $inboundDomain = NULL, $inboundSpamThreshold = NULL,
		$trackLinks = NULL, $clickHookUrl = NULL, $deliveryHookUrl = NULL,
		$enableSmtpApiErrorHooks = NULL) {

		$body = array();
		$body['name'] = $name;
		$body['color'] = $color;
		$body['rawEmailEnabled'] = $rawEmailEnabled;
		$body['smtpApiActivated'] = $smtpApiActivated;
		$body['inboundHookUrl'] = $inboundHookUrl;
		$body['bounceHookUrl'] = $bounceHookUrl;
		$body['openHookUrl'] = $openHookUrl;
		$body['postFirstOpenOnly'] = $postFirstOpenOnly;
		$body['trackOpens'] = $trackOpens;
		$body['inboundDomain'] = $inboundDomain;
		$body['inboundSpamThreshold'] = $inboundSpamThreshold;
		$body['trackLinks'] = $trackLinks;
		$body["ClickHookUrl"] = $clickHookUrl;
		$body["DeliveryHookUrl"] = $deliveryHookUrl;
		$body["EnableSmtpApiErrorHooks"] = $enableSmtpApiErrorHooks;

		$response = new DynamicResponseModel($this->processRestRequest('PUT', "/servers/$id", $body));
		$response["ID"] = $id;
		return $response;
	}

	/**
	 * Create a new Server. Any parameters passed with NULL will be
	 * ignored (their default values will be used).
	 *
	 * @param string $name Set the name of the server.
	 * @param string $color Set the color for the server in the Haskimail WebUI (must be: 'purple', 'blue', 'turqoise', 'green', 'red', 'yellow', or 'grey')
	 * @param bool $rawEmailEnabled Enable raw email to be sent with inbound.
	 * @param bool $smtpApiActivated Specifies whether or not SMTP is enabled on this server.
	 * @param string $inboundHookUrl URL to POST to everytime an inbound event occurs.
	 * @param string $bounceHookUrl URL to POST to everytime a bounce event occurs.
	 * @param string $openHookUrl URL to POST to everytime an open event occurs.
	 * @param bool $postFirstOpenOnly If set to true, only the first open by a particular recipient will initiate the open webhook. Any subsequent opens of the same email by the same recipient will not initiate the webhook.
	 * @param bool $trackOpens Indicates if all emails being sent through this server have open tracking enabled.
	 * @param string $inboundDomain Inbound domain for MX setup.
	 * @param integer $inboundSpamThreshold The maximum spam score for an inbound message before it's blocked (range from 0-30).
	 * @param string $trackLinks Indicates if all emails being sent through this server have link tracking enabled.
	 * @param string $clickHookUrl URL to POST to everytime an click event occurs.
	 * @param string $deliveryHookUrl URL to POST to everytime an click event occurs.
	 * @param  string $enableSmtpApiErrorHooks Specifies whether or not SMTP API Errors will be included with bounce webhooks.
	 * @return DynamicResponseModel
	 */
	function createServer($name, $color = NULL,
		$rawEmailEnabled = NULL, $smtpApiActivated = NULL, $inboundHookUrl = NULL,
		$bounceHookUrl = NULL, $openHookUrl = NULL, $postFirstOpenOnly = NULL,
		$trackOpens = NULL, $inboundDomain = NULL, $inboundSpamThreshold = NULL,
		$trackLinks = NULL, $clickHookUrl = NULL, $deliveryHookUrl = NULL,
		$enableSmtpApiErrorHooks = NULL) {

		$body = array();
		$body['name'] = $name;
		$body['color'] = $color;
		$body['rawEmailEnabled'] = $rawEmailEnabled;
		$body['smtpApiActivated'] = $smtpApiActivated;
		$body['inboundHookUrl'] = $inboundHookUrl;
		$body['bounceHookUrl'] = $bounceHookUrl;
		$body['openHookUrl'] = $openHookUrl;
		$body['postFirstOpenOnly'] = $postFirstOpenOnly;
		$body['trackOpens'] = $trackOpens;
		$body['inboundDomain'] = $inboundDomain;
		$body['inboundSpamThreshold'] = $inboundSpamThreshold;
		$body['trackLinks'] = $trackLinks;
		$body["ClickHookUrl"] = $clickHookUrl;
		$body["DeliveryHookUrl"] = $deliveryHookUrl;
		$body["EnableSmtpApiErrorHooks"] = $enableSmtpApiErrorHooks;

		return new DynamicResponseModel($this->processRestRequest('POST', '/servers', $body));
	}

  /**
	 * Get a "page" of Domains.
	 *
	 * @param  integer $count The number of Domains to retrieve with this request.
	 *  param  integer $offset The number of Domains to 'skip' when 'paging' through them.
	 * @return DynamicResponseModel
	 */
	function listDomains($count = 100, $offset = 0) {

		$query = array();
		$query['count'] = $count;
		$query['offset'] = $offset;

		return new DynamicResponseModel($this->processRestRequest('GET', '/domains', $query));
	}

  /**
	 * Get information for a specific Domain.
	 *
	 * @param  integer $id The ID for the Domains you wish to retrieve.
	 * @return DynamicResponseModel
	 */
	function getDomain($id) {
		return new DynamicResponseModel($this->processRestRequest('GET', "/domains/$id"));
	}


  /**
	 * Create a new Domain with the given Name.
	 *
	 * @param  string $name The name of the Domain.
	 * @param  string $returnPathDomain The custom Return-Path domain for the Sender Signature.
	 * @return DynamicResponseModel
	 */
	function createDomain($name, $returnPathDomain = NULL) {
		$body = array();
		$body['name'] = $name;
		$body['returnPathDomain'] = $returnPathDomain;

		return new DynamicResponseModel($this->processRestRequest('POST', '/domains', $body));
	}

  /**
	 * Delete a Domain with the given ID.
	 *
	 * @param  integer $id The ID for the Domain we wish to delete.
	 * @return DynamicResponseModel
	 */
	function deleteDomain($id) {
		return new DynamicResponseModel($this->processRestRequest('DELETE', "/domains/$id"));
	}

  /**
	 * Request that the Haskimail API verify the SPF records associated
	 * with the Domain. Configuring SPF is not required to use
	 * Haskimail, but it is highly recommended, and can improve delivery rates.
	 *
	 * @param  integer $id The ID for the Domain for which we wish to verify the SPF records.
	 * @return DynamicResponseModel
	 */
	function verifyDomainSPF($id) {
		return new DynamicResponseModel($this->processRestRequest('PUT', "/domains/$id/verifyspf"));
	}
}
?>
