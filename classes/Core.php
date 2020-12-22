<?php

	class Core {
		public $db;
		


		public function __construct() {
			$this->db = new Database;
		}

		public function redirect($path) {
			header('Location: ' . SITE_URL . $path);
		}
		public function setMessage($type, $msg) {
			// danger, success, warning, info are the available types
			$_SESSION['message_type'] = $type;
			$_SESSION['message'] = $msg;
		}
		public function clearMessage() {
			unset($_SESSION['message']);
			unset($_SESSION['message_type']);
		}
		public function setSessionVar($name, $value = null) {
			$_SESSION[$name] = $value;
		}
		public function clearSessionVar($name) {
			unset($_SESSION[$name]);
		}

		public function randomString($n) {
			$randString = "";
			$stringToChooseFrom = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!)';
			$length = strlen($stringToChooseFrom);
			for($i=0; $i < $n; $i++) {
				$index = rand(0, $length - 1);
				$randString = $randString . $stringToChooseFrom[$index];
			}
			return $randString;
		}



		public function formatPhone($phoneNumber) {
			$phoneNumber = str_replace('(', '', $phoneNumber);
			$phoneNumber = str_replace(')', '', $phoneNumber);
			$phoneNumber = str_replace('-', '', $phoneNumber);
			$phoneNumber = str_replace('.', '', $phoneNumber);
			$phoneNumber = str_replace(' ', '', $phoneNumber);
			return $phoneNumber;
		}


		public function prettyPhone($number) {
			$phoneNumber = substr_replace($number, ')', 3, 0);
			$phoneNumber = substr_replace($phoneNumber, '-', 7, 0);
			$phoneNumber = substr_replace($phoneNumber, ' ', 4, 0);
			$phoneNumber = '(' . $phoneNumber;
			return $phoneNumber;
		}



		public function currentTimeStamp() {
			$date = new DateTime();
			$date->setTimezone(new DateTimeZone('America/New_York'));
			$currentTimeStamp = $date->format('Y-m-d H:i:s');
			return $currentTimeStamp;
		}


		public function checkIP($ip) {
			$this->db->query("SELECT * FROM cleared_ip ORDER BY date_added DESC LIMIT 1");
			$result = $this->db->single();
			if($ip == $result->ip_address) {
				return true;
			}
			$this->redirect('forbidden.php');
		}


		public function updateNewIP($ip, $pw = '78$%67y6&#oiutYo') {
			if($pw == 'clumsybiketanktruckcarswimmermanpaddedcorkwhiskey') {
				$this->db->query("INSERT INTO cleared_ip (ip_address, date_added) VALUES (:ip, :ts)");
				$this->db->bind(':ip', $ip);
				$this->db->bind('ts', $this->currentTimeStamp());
				$this->db->execute();
				return true;	
			}
			return false;
		}

		public function reverseIP($ip) {
			$this->db->query("SELECT * FROM cleared_ip ORDER BY date_added DESC LIMIT 1");
			$result = $this->db->single();
			if($ip == $result->ip_address) {
				$this->redirect('');
			}
			return false;
		}



	}