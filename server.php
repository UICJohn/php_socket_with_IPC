<?php
	class Server implements SplObserver{
		private $host;
		private $port;
		private $socket;
		private $_LISTEN;
		
		function __construct($host,$port){
			$this->host = $host;
			$this->port = $port;
			$this->_LISTEN = true;
		}

		function update(SplSubject $subject){
			echo $subject->get_mess();
		}

		function server_up(){
	                if(($this->socket = socket_create(AF_INET, SOCK_STREAM,0))<0){
	                        echo "Error in creating socket => ".socket_strerror($this->socket);
	                        exit();
	                }
	                if(($fed = socket_bind($this->socket, $this->host, $this->port))<0){
	                        echo "Error in binding socket => ".socket_strerror($this->socket);
	                        exit();
	                }
	                if(($fed = socket_listen($this->socket, 9))<0){
	                        echo "Error in listenning socket => ".socket_strerror($this->socket);
	                        exit();
	                }
	                socket_set_nonblock($this->socket);
	                while($this->_LISTEN){
	                        $conn = @socket_accept($this->socket);
	                        if(!$conn){
	                                usleep(500);
	                        }
	                        else if($conn > 0){
	                                socket_write($conn,"Hello World !");
					$this->server_down();
	                        }
	                        else {
     	                 	        echo "Error in connecting => ".socket_strerror($conn);
       	         	                die;
        	                }
	                }
                	socket_close($conn);
                	socket_close($this->socket);
        	}
		
		function server_down(){
			$this->_LISTEN = false;
		}

	}

?>
