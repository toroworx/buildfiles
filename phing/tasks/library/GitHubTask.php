<?php
/**
 * Akeeba Build Files
 *
 * @package    buildfiles
 * @copyright  (c) 2010-2017 Akeeba Ltd
 */

use Github\Client;

if (!class_exists('Github\\Client'))
{
	$autoloaderFile = __DIR__ . '/../../../vendor/autoload.php';

	if (!file_exists($autoloaderFile))
	{
		echo <<< END

********************************************************************************
**                                   WARNING                                  **
********************************************************************************

You have NOT initialized Composer on the buildfiles repository. This script is
about to die with an error.

--------------------------------------------------------------------------------
HOW TO FIX
--------------------------------------------------------------------------------

Go to the buildfiles repository and run:

php ./composer.phar install


END;

		throw new \RuntimeException("Composer is not initialized in the buildfiles repository");
	}

	require_once $autoloaderFile;
}

/**
 * Abstract base class for GitHub tasks
 */
abstract class GitHubTask extends Task
{
	/**
	 * The GitHub client object
	 *
	 * @var   Client
	 */
	protected $client;

	/**
	 * The organization the repository belongs to. That's the part after github.com in the repo's URL.
	 *
	 * @var   string
	 */
	protected $organization;

	/**
	 * The name of the repository. That's the part after github.com/yourOrganization in the repo's URL.
	 *
	 * @var   string
	 */
	protected $repository;

	/**
	 * GitHub API token
	 *
	 * @var   string
	 */
	protected $token;

	/**
	 * Set the repository's organization
	 *
	 * @param   string  $organization
	 *
	 * @return  void
	 */
	public function setOrganization($organization)
	{
		$this->organization = $organization;
	}

	/**
	 * Set the repository's name
	 *
	 * @param   string  $repository
	 *
	 * @return  void
	 */
	public function setRepository($repository)
	{
		$this->repository = $repository;
	}

	/**
	 * Set the GitHub token
	 *
	 * @param   string  $token
	 *
	 * @return  void
	 */
	public function setToken($token)
	{
		$this->token = $token;
	}

	public function init()
	{
		// Make sure we have a token
		if (empty($this->token))
		{
			throw new ConfigurationException('You need to provide your GitHub token.');
		}

		// Create the API client object and apply authentication
		$this->client = new Client();
		$this->client->authenticate($this->token, null, Client::AUTH_HTTP_TOKEN);
	}
}