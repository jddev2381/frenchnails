<?php

	/*
	 * PDO Database Class
	 * Connects to DB
	 * Creates Prepared Statements
	 * Binds Values
	 * Returns Rows and Results
	*/

	class Login extends Core {

		

		public function __construct() {
			$this->db = new Database;
		}


		public function check() {
			if(!isset($_SESSION['French_Nails']['key']) || !isset($_SESSION['French_Nails']['uid'])) {
				$this->setMessageAndRedirect();
			}
			$loggedInKey = $_SESSION['French_Nails']['key'];
			$userID = $_SESSION['French_Nails']['uid'];
			$this->db->query("SELECT * FROM logged_in_users WHERE logged_in_key = :key AND user_id = :uid");
			$this->db->bind(":key", $loggedInKey);
			$this->db->bind(':uid', $userID);
			$result = $this->db->single();
			if(!$result) {
				$this->setMessageAndRedirect();
			}
			$expiredTime = strtotime("+15 minutes", strtotime($result->last_activity));
			if($expiredTime < strtotime($this->currentTimeStamp())) {
				$this->setMessageAndRedirect();
				die();
			}
			$this->db->query("UPDATE logged_in_users SET last_activity = :cts WHERE user_id = :uid AND logged_in_key = :key");
			$this->db->bind(':cts', $this->currentTimeStamp());
			$this->db->bind(':uid', $userID);
			$this->db->bind(':key', $loggedInKey);
			$this->db->execute();
			return true;
		}

		private function setMessageAndRedirect() {
			$this->setMessage('error', "<h1>Uh Oh!</h1><h2>It looks like you aren't logged in.<h2><h3>You must be logged in to view that page.</h3>");
			$this->redirect('admin/login.php');
			die();
		}

		public function logIn($email, $pw) {
			$email = strtolower(trim($email));
			$this->db->query("SELECT * FROM users WHERE email_address = :email");
			$this->db->bind(':email', $email);
			$result = $this->db->single();
			if(!$result) {
				return false;
			}
			if(!password_verify($pw, $result->password)) {
				return false;
			}
			$newKey = md5($email . $this->randomString(10));
			$_SESSION['French_Nails']['key'] = $newKey;
			$_SESSION['French_Nails']['uid'] = $result->user_id;

			$this->db->query("DELETE FROM logged_in_users WHERE user_id = :uid");
			$this->db->bind(':uid', $result->user_id);
			$this->db->execute();

			$this->db->query("INSERT INTO logged_in_users (user_id, logged_in_key, last_activity) VALUES (:uid, :key, :ts)");
			$this->db->bind(':uid', $result->user_id);
			$this->db->bind(':key', $newKey);
			$this->db->bind(':ts', $this->currentTimeStamp());
			$this->db->execute();

			$this->redirect('admin/');
		}

		public function checkCurrentPW($pw) {
			$this->db->query("SELECT * FROM users WHERE user_id = :uid");
			$this->db->bind(':uid', $_SESSION['French_Nails']['uid']);
			$result = $this->db->single();
			if(!$result) {
				return false;
				die();
			}
			if(!password_verify($pw, $result->password)) {
				return false;
				die();
			}
			return true;
		}

		public function updatePW($newPW) {
			$newPW = password_hash($newPW, PASSWORD_DEFAULT);
			$this->db->query("UPDATE users SET password = :pw WHERE user_id = :uid");
			$this->db->bind(':pw', $newPW);
			$this->db->bind(':uid', $_SESSION['French_Nails']['uid']);
			if($this->db->execute()) {
				$this->setMessage('success', '<h1>Success!</h1><h2>Your password has been updated.<h2>');
				return true;
				die();
			}
			$this->setMessage('error', '<h1>Oops!</h1><h2>Your password has NOT been updated.<h2><h3>Something went wrong!<h3>');
			return false;
			die();
		}
		

			

	}