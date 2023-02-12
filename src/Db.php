<?php
declare(strict_types = 1);
namespace Avi;

/**
 * Just another database wrapper
 * @author aviato-vasile
 *
 */
class Db
{

	private $oc;

	private $log;

	public $cnt = 0;


	public function __construct(?array $options = [])
	{
		$this->log = new \Avi\Log();
		$this->connect(
			$options['server'] ?? AVI_DB_SERVER,
			$options['user'] ?? AVI_DB_USER,
			$options['password'] ?? \Avi\Tools::dec(AVI_DB_PASSWORD),
			$options['database'] ?? AVI_DB_DATABASE,
			$options['port'] ?? AVI_DB_PORT ?? 3306);

		return $this;
	}


	public function __destruct() {
		$this->oc->close();
	}


	private function connect(string $server, string $user, string $password, string $database, int $port = 3306)
	{
		$this->oc = new \mysqli($server, $user, $password, $database, $port);

		if (! $this->oc) {
			$this->log->trace(
				implode('',
					[
						'Error #'.mysqli_connect_errno().': Unable to connect to server:'.$server.
						'<hr />MySql Server is down or connection is not properly configured. '.
						'Please check the configuration of sql connection!<hr />'.mysqli_connect_error()
					]));
			;
			return false;
		}

		$this->oc->set_charset(defined('AVI_DB_CHARSET') ? AVI_DB_CHARSET: 'utf8');
	}
}