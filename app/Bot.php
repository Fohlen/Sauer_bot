<?php

class Bot extends \Prefab {
	private $_BASE_URL; // Telegram API URL
	// A list of commands
	private $_COMMANDS = array(
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
		if (in_array(substr($commands[0], 1, strlen($commands[0])), $this->_COMMANDS))
			return $commands;
		else
			throw new Exception('Command not found');
	}
	
	public function __construct() {
		// Initialise the base url for Telegram
		$this->_BASE_URL = 'https://api.telegram.org/bot' . \Base::instance()->get('bot.token');
	}
	
	public function respondMessage($message) {
		$command = $this->_parseCommand($message->text);
		$options = array(
				'method' => 'POST',
				'Content-Type' => 'application/json',
		);
		
		switch($command[0]) {
			case 'mix':
				$response = $message->from->first_name . ' requested a mix at ' . $command[1];
				$responseMessage = array(
					'chat_id' => $message->chat->id,
					'text' => $response
				);
				$options['content'] = json_encode($responseMessage);
				
				$result = \Web::instance()->request($this->_BASE_URL . '/sendMessage', $options);
				break;
			case 'cw':
				$response = $message->from->first_name . ' is looking for a clanwar. ' . $command[1];
				$responseMessage = array(
						'chat_id' => $message->chat->id,
						'text' => $response
				);
				$options['content'] = json_encode($responseMessage);
				
				$result = \Web::instance()->request($this->_BASE_URL . '/sendMessage', $options);
				break;
		}
	}
}