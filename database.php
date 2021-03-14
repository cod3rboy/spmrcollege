<?php
    // Database Connectivity Class
    class CollegeDatabase{
        // Host Name
        private $host = 'localhost';
        // Username
        private $user = 'root';
        // Password
        private $pwd = '';
        // Database Name
        private $db = 'id2719738_college';
        // Flag to check database connectivity state
        private $is_connected = false;
        // Store database connection object
        public $conn;


        // Connects to database
        public function connect(){
            // Create Database connection object
            $this->conn = new mysqli($this->host, $this->user, $this->pwd, $this->db);
            if($this->conn->connect_error){  // Connection Error
                $this->is_connected = false;
                return null;
            }else{ // Connection Successful
                $this->is_connected = true; // Set database connectivity flag to true
                return $this->conn; // Return Connection Object
            }
        }

        // Disconnects from database
        public function disconnect(){
            // Check whether connected to database
            if($this->is_connected){
                $this->conn->close(); // Close Opened Database Connection
                $this->is_connected = false; // Set database connectivity flag to false
            }
        }

        // Returns Database Connectivity flag
        public function isConnected(){
             return $this->is_connected;
        }

        // Executes Sql commands
        public function executeSql($sql_command_string){
            // Check whether connected to database
            if($this->is_connected){
                return $this->conn->query($sql_command_string); // Execute Sql Query if connected to database
            }else{ // Not Connected to database
                return false;
            }
        }
        // Destructor
        function __destruct(){
            // disconnect with opened database connection
            $this->disconnect();
        }
    }
?>