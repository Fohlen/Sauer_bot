<?php
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

class Bot extends \Prefab {
	private $_CLIENT; // The Guzzle HTTP client
	// A list of commands
	private $_COMMANDS = array(
		'start',
		'mix',
		'cw'
	);
	
	
	/**
	 * @return string[0] command, string[1] argument
	 * @throws Error for no/unknown command
	 * @param string $string
	 */
	private function _parseCommand($string) {
		if (strpos($string, '/') != 0 ) throw new Exception('No command found');
		$commands = explode(' ', $string, 2);
		$commands[0] = substr($commands[0], 1, strlen($commands[0]));
		if (in_array($commands[0], $this->_COMMANDS))
			return $commands;
		else
			throw new Exception('Command not found');
	}
	
	public function __construct() {
		// Initialise the base url for Telegram
		$this->_CLIENT = new Client ([
			'base_uri' => 'https://api.telegram.org/bot' . \Base::instance()->get('bot.token'),
			'timeout' => 2.0
		]);
	}
	
	public function respondMessage($message) {
		// TODO: Add additional code to verify the messages
		$command = $this->_parseCommand($message->text);
		
		switch($command[0]) {
			case 'mix':
				if (empty($command[1])) {
					$response = $message->from->first_name . ' is looking for';
				} else {
					$response = $message->from->first_name . ' requested a mix at ' . $command[1];
				}
				
				$responseMessage = array(
					'chat_id' => $message->chat->id,
					'text' => '_' . $response . '_',
					'parse_mode' => 'Markdown'
				);
				
				$request = new Request('POST', $this->_CLIENT->getConfig('base_uri') . '/sendMessage', ['Content-Type' => 'application/json'], json_encode($responseMessage));
				$res = $this->_CLIENT->send($request);
				break;
			case 'cw':
				
				if (empty($command[1])) {
					$response = $message->from->first_name . ' is looking for a clanwar.';
				} else {
					$response = $message->from->first_name . ' requests a clanwar, ' . $command[1];
				}
				
				$responseMessage = array(
						'chat_id' => $message->chat->id,
						'text' => '_' . $response . '_',
						'parse_mode' => 'Markdown'
				);
				
				$request = new Request('POST', $this->_CLIENT->getConfig('base_uri') . '/sendMessage', ['Content-Type' => 'application/json'], json_encode($responseMessage));
				$res = $this->_CLIENT->send($request);
				break;
			default:
				break;
		}
	}
}