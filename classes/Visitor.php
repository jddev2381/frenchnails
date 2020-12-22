<?php

	/*
	 * PDO Database Class
	 * Connects to DB
	 * Creates Prepared Statements
	 * Binds Values
	 * Returns Rows and Results
	*/

	class Visitor extends Core {

		

		public function __construct() {
			$this->db = new Database;
		}



		public function checkVisitorIn($fname, $lname, $phone, $tech, $deets) {
			$this->db->query("INSERT INTO visitors (first_name, last_name, phone_number, desired_tech, work_done, checked_in_at) VALUES (:fname, :lname, :phone, :desiredTech, :deets, :currentTimeStamp)");
			$this->db->bind(':fname', $fname);
			$this->db->bind(':lname', $lname);
			$this->db->bind(':phone', $phone);
			$this->db->bind(':desiredTech', $tech);
			$this->db->bind(':deets', $deets);
			$this->db->bind(':currentTimeStamp', $this->currentTimeStamp());
			if($this->db->execute()) {
				return true;
			}
			return false;
		}


		


		public function getNext() {
			$this->db->query("SELECT * FROM visitors WHERE checked_out_at IS NULL ORDER BY checked_in_at ASC LIMIT 1");
			$visitor = $this->db->single();
			if($visitor) {
				return $visitor;
			}
			return false;
		}

		public function queueCount() {
			$this->db->query("SELECT * FROM visitors WHERE checked_out_at IS NULL ORDER BY checked_in_at ASC");
			$this->db->execute();
			return $this->db->rowCount();
		}

		public function getQueue() {
			$this->db->query("SELECT * FROM visitors WHERE checked_out_at IS NULL ORDER BY checked_in_at ASC");
			return $this->db->resultSet();
		}

		public function getQueueByPhone($phone) {
			$this->db->query("SELECT * FROM visitors WHERE checked_out_at IS NULL AND phone_number = :phoneNumber ORDER BY checked_in_at ASC");
			$this->db->bind(':phoneNumber', $phone);
			return $this->db->resultSet();
		}

		//this function allows for all or single visitor checkout
		public function cancelVisit($phone, $cancelID = 'ALL') {
			if($cancelID=='ALL') {
				$this->db->query("UPDATE visitors SET checked_out_at = :currentTimeStamp, checked_out_by = 'self', did_complete = 'no' WHERE checked_out_at IS NULL AND phone_number = :phone");
				$this->db->bind(':currentTimeStamp', $this->currentTimeStamp());
				$this->db->bind(':phone', $phone);
				$this->db->execute();
				$this->setMessage('success', '<h1>Success! <i class="fas fa-check"></i></h1><h2>We have checked everyone associated with that number out.<h2><h3>Please come back soon and we will get you taken care of.<h3>');
				$this->redirect('');
				return true;
			}
			$this->db->query("UPDATE visitors SET checked_out_at = :currentTimeStamp, checked_out_by = 'self', did_complete = 'no' WHERE checked_out_at IS NULL AND phone_number = :phone AND id = :cancelID");
			$this->db->bind(':currentTimeStamp', $this->currentTimeStamp());
			$this->db->bind(':phone', $phone);
			$this->db->bind(':cancelID', $cancelID);
			$this->db->execute();
			$this->setMessage('success', '<h1>Success! <i class="fas fa-check"></i></h1><h2>We have checked you out.<h2><h3>Remember: There are still others checked in with this phone number.<h3>');
			$this->redirect('');
			return true;
		}



		//This checks a certain visitor out
		public function checkVisitorOut($phone) {
			$this->db->query("SELECT * FROM visitors WHERE checked_out_at IS NULL AND phone_number = :phone");
			$this->db->bind(':phone', $phone);
			$this->db->execute();
			$rows = $this->db->rowCount();
			if($rows == 0) {
				$this->setMessage('error', "<h1>Sorry!</h1><h2>No one with that number was in the queue.</h2><h3>You may have typed it in wrong. Try again and if this problem persists, please notify an attendant.</h3>");
				$this->redirect('');
				return true;
			}
			if($rows > 1) {
				$this->redirect('multiple-visitors.php?number='.$phone);
				return true;
			}
			$this->db->query("UPDATE visitors SET checked_out_at = :currentTimeStamp, checked_out_by = 'self', did_complete = 'no' WHERE checked_out_at IS NULL AND phone_number = :phone");
			$this->db->bind(':currentTimeStamp', $this->currentTimeStamp());
			$this->db->bind(':phone', $phone);
			if($this->db->execute()) {
				$this->setMessage('success', '<h1>We\'ve removed you from the queue. <i class="fas fa-check"></i></h1><h2>We are sorry to see you go.<h2><h3>Please come back soon and we will get you taken care of.<h3>');
				$this->redirect('');
				return true;
			}
			$this->setMessage('error', "<h1>Oops!</h1><h2>Something went wrong.</h2><h3>Please notify attendant for help.</h3>");
			$this->redirect('');

		}


		public function getAvailableTechs() {
			$this->db->query("SELECT * FROM workers WHERE available = '1' ORDER BY name");
			$nailTechs = $this->db->resultSet();
			if($nailTechs) {
				return $nailTechs;
			}
			return false;
		}

			

	}