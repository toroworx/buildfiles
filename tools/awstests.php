<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

if (!file_exists(__DIR__ . '/../vendor/autoload.php'))
{
	die('Run "composer install" before attempting to spin an EC2 instance');
}

require_once __DIR__ . '/../vendor/autoload.php';
require_once 'awstests.config.php';

$ec2 = new Aws\Ec2\Ec2Client([
	'credentials' => [
		'key'    => $aws_config['key'],
		'secret' => $aws_config['secret']
	],
	'region'  => 'us-east-1',
	'version' => 'latest'
]);

//
try
{
	$result = $ec2->runInstances([
		'ImageId'        => $aws_config['imageId'],
		'MinCount'       => 1,
		'MaxCount'       => 1,
		'InstanceType'   => $aws_config['type']
	]);
}
catch (Exception $e)
{
	echo "!!! An error occurred while trying to create the test instance";
	exit(-1);
}

echo "An EC2 instance has been created. It will take up to 5 minutes to get provisioned and running.";



