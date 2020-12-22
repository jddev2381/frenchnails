<?php

	/*
	 * PDO Database Class
	 * Connects to DB
	 * Creates Prepared Statements
	 * Binds Values
	 * Returns Rows and Results
	*/

	class Admin extends Core {

		

		public function __construct() {
			$this->db = new Database;
		}



		public function addNailTech($name) {
			$this->db->query("INSERT INTO workers (name) VALUES (:techName)");
			$this->db->bind(':techName', $name);
			if($this->db->execute()) {
				$this->setMessage('success', "<h1>Nice! <i class=\"fas fa-check\"></i></h1><h2>You just added $name as a nail tech.<h2>");
				return true;
			}
			$this->setMessage('error', "<h1>Damn It!</h1><h2>Something went wrong.<h2><h3>Unable to add new staff member</h3>");
			return false;
		}


		public function getAllTechs() {
			$this->db->query("SELECT * FROM workers ORDER BY name");
			$nailTechs = $this->db->resultSet();
			if($nailTechs) {
				return $nailTechs;
			}
			return false;
		}

		public function getTechName($id) {
			if($id == 'first') {
				return 'First Available';
			}
			$id = (int) $id;
			$this->db->query("SELECT * FROM workers WHERE worker_id = :wid");
			$this->db->bind(':wid', $id);
			$worker = $this->db->single();
			if($worker) {
				return $worker->name;
			}
			return 'Error';
		}


		public function deleteTech($id) {
			$this->db->query("SELECT * FROM workers WHERE worker_id = :wid");
			$this->db->bind(':wid', $id);
			$tech = $this->db->single();
			//die('Tech is: ' . $tech . ' And id is: ' . $id);
			if($tech) {
				$techName = $tech->name;
				$this->db->query("DELETE FROM workers WHERE worker_id = :wid");
				$this->db->bind(':wid', $id);
				if($this->db->execute()) {
					$this->setMessage('success', "<h1>You got it! <i class=\"fas fa-check\"></i></h1><h2>$techName has been deleted.<h2>");
					return true;
				}
				$this->setMessage('error', "<h1>OOPS! <i class=\"fas fa-exclamation-triangle\"></i></h1><h2>I had a problem trying to delete $techName.<h2><h3>Please try again.</h3>");
				return false;	
			}
			$this->setMessage('error', "<h1>OOPS! <i class=\"fas fa-exclamation-triangle\"></i></h1><h2>Something went wrong.<h2><h3>Please try again.</h3>");
			return false;
		}


		function toggleTechAvailability($id) {
			$this->db->query("SELECT * FROM workers WHERE worker_id = :wid");
			$this->db->bind(':wid', $id);
			$tech = $this->db->single();
			if($tech->available == '1') {
				$this->db->query("UPDATE workers SET available = '0' WHERE worker_id = :wid");
				$this->db->bind(':wid', $id);
				$this->db->execute();
			} else {
				$this->db->query("UPDATE workers SET available = '1' WHERE worker_id = :wid");
				$this->db->bind(':wid', $id);
				$this->db->execute();
			}
			return;
		}


			//{"feet": null, "feet1": null, "hands": "on", "feet21": "", "feet22": "", "hands1": "full", "hands21": "", "hands22": "color"}
		function formatWorkDetails($json, $whichOne = 'both') {
			$handsString = '';
			$feetString = '';
			$json = json_decode($json);
			if($json->hands) {
				$handsString .= '<b>Hands</b>: ';
				switch($json->hands1) {
					case 'full':
						$json->hands1 = 'Full Set';
						break;
					case 'fill':
						$json->hands1 = 'Fill In';
						break;
					default:
						$json->hands1 = 'Manicure';
				}
				$handsString .= $json->hands1;
				if($json->hands21) {
					switch($json->hands21) {
						case 'color':
							$json->hands21 = 'Color';
							break;
						case 'gel':
							$json->hands21 = 'Gel';
							break;
						default:
							$json->hands21 = 'White Tips';
					}
					$handsString .= '/' . $json->hands21;		
				}
				if($json->hands22) {
					switch($json->hands22) {
						case 'color':
							$json->hands22 = 'Color';
							break;
						case 'gel':
							$json->hands22 = 'Gel';
							break;
						case 'pw':
							$json->hands22 = 'Pink & White'; 
							break;
						case 'powder':
							$json->hands22 = 'Powder Dip';
							break;
						default:
							$json->hands22 = 'White Tips';
					}
					$handsString .= '/' . $json->hands22;		
				}
				
			}

			if($json->feet) {
				$feetString = '<b>Feet</b>: ';
				switch($json->feet1) {
					case 'pedi' : 
						$json->feet1 = 'Pedicure';
						break;
					case 'paint' :
						$json->feet1 = 'Paint';
						break;
					default:
						$json->feet1 = 'Error';
				}
				$feetString .= $json->feet1;
				if($json->feet21) {
					switch($json->feet21) {
						case 'color' :
							$json->feet21 = 'Color';
							break;
						case 'gel' :
							$json->feet21 = 'Gel';
							break;
						case 'tips' :
							$json->feet21 = 'White Tips';
							break;
						case 'pedi' :
							$json->feet21 = 'Pedicure Only';
							break;
						default:
							$json->feet21 = 'Error';
					}
					$feetString .= '/' . $json->feet21;
				}
				if($json->feet22) {
					switch($json->feet22) {
						case 'color' :
							$json->feet22 = 'Color';
							break;
						case 'gel' :
							$json->feet22 = 'Gel';
							break;
						case 'tips' :
							$json->feet22 = 'White Tips';
							break;
						default:
							$json->feet22 = 'Error';
					}
					$feetString .= '/' . $json->feet22;
				}
			}

			if($whichOne == 'hands') {
				return $handsString;
			}
			if($whichOne == 'feet') {
				return $feetString;
			}
			return $handsString . ' ' . $feetString;
		}




		public function getClientInfo($clientID) {
			$this->db->query("SELECT * FROM visitors WHERE id = :cid");
			$this->db->bind(':cid', $clientID);
			$clientInfo = $this->db->single();
			if($clientInfo) {
				return $clientInfo;
			}
			return false;
		}




		public function markAsNoShow($id) {
			$this->db->query("UPDATE visitors SET checked_out_at = :currentTimeStamp, checked_out_by = 'admin', did_complete = 'no' WHERE id = :vid");
			$this->db->bind(':currentTimeStamp', $this->currentTimeStamp());
			$this->db->bind(':vid', $id);
			if($this->db->execute()) {
				return true;
			}
			return false;
		}


		public function markAsCheckedIn($id) {
			$this->db->query("UPDATE visitors SET checked_out_at = :currentTimeStamp, checked_out_by = 'admin', did_complete = 'yes' WHERE id = :vid");
			$this->db->bind(':currentTimeStamp', $this->currentTimeStamp());
			$this->db->bind(':vid', $id);
			if($this->db->execute()) {
				return true;
			}
			return false;
		}




	}
