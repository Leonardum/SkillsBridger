<?php
/* This file contains the code for the address object and queries. */

class address {
    
    private $id;
    private $name;
    private $street;
    private $number;
    private $zip;
    private $city;
    private $province;
    private $state;
    private $country;
    
    function __construct($id, $name, $street, $number, $zip, $city, $province, $state, $country) {
        $this->id = $id;
        $this->name = $name;
        $this->street = $street;
        $this->number = $number;
        $this->zip = $zip;
        $this->city = $city;
        $this->province = $province;
        $this->state = $state;
        $this->country = $country;
    }
    
    public function getId() {
        return $this->id;
    }
    public function getName() {
        return $this->name;
    }
    public function getStreet() {
        return $this->street;
    }
    public function getNumber() {
        return $this->number;
    }
    public function getZip() {
        return $this->zip;
    }
    public function getCity() {
        return $this->city;
    }
    public function getProvince() {
        return $this->province;
    }
    public function getState() {
        return $this->state;
    }
    public function getCountry() {
        return $this->country;
    }
    
    public function setId($id) {
        if (is_int($id)) {
            $this->id = $id;
        }
    }
    public function setName($name) {
        if (is_string($name)) {
            $this->name = $name;
        }
    }
    public function setStreet($street) {
        if (is_string($street)) {
            $this->street = $street;
        }
    }
    public function setNumber($number) {
        if (is_string($number)) {
            $this->number = $number;
        }
    }
    public function setZip($zip) {
        if (is_string($zip)) {
            $this->zip = $zip;
        }
    }
    public function setCity($city) {
        if (is_string($city)) {
            $this->city = $city;
        }
    }
    public function setProvince($province) {
        if (is_string($province)) {
            $this->province = $province;
        }
    }
    public function setState($state) {
        if (is_string($state)) {
            $this->state = $state;
        }
    }
    public function setCountry($country) {
        if (is_int($country)) {
            $this->country = $country;
        }
    }
    
    // Save all changes made to the address info to the database.
    public function save() {
        if (!isset($this->id)) {
            global $db;
            
            $query = "INSERT INTO `address` (LocationName, Street, StreetNumber, ZipCode, City, Province, State, Country) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            
            $statement = $db->prepare($query);
            
            if ($statement == FALSE) {
                display_db_error($db->error);
            }
            
            $statement->bind_param("ssiissss", $this->name, $this->street, $this->number, $this->zip, $this->city, $this->province, $this->state, $this->country);
            
            $success = $statement->execute();
            
            if ($success) {
                $addressId = $db->insert_id;
                $statement->close();
                return $addressId;
            } else {
                display_db_error($db->error);
            }
        } else {
            global $db;
            
            $query = "UPDATE `address` SET LocationName = ?, Street = ?, StreetNumber = ?, ZipCode = ?, City = ?, Province = ?, State = ?, Country = ? WHERE Address_id = ?";
            
            $statement = $db->prepare($query);
            
            if ($statement == FALSE) {
                display_db_error($db->error);
            }
            
            $statement->bind_param("ssiissssi", $this->name, $this->street, $this->number, $this->zip, $this->city, $this->province, $this->state, $this->country, $this->id);
            
            $success = $statement->execute();
            
            if ($success) {
                $statement->close();
            } else {
                display_db_error($db->error);
            }
        }
    }
    
    
    // Delete the complete address record from the database.
    public function delete() {
        global $db;
        
        $query = "DELETE FROM `address` WHERE Address_id = ?";
        
        $statement = $db->prepare($query);
        
        if ($statement == FALSE) {
            display_db_error($db->error);
        }
        
        $statement->bind_param("i", $this->id);
        
        $success = $statement->execute();
        
        if ($success) {
            $count = $db->affected_rows;
            $statement->close();
            return $count;
        } else {
            display_db_error($db->error);
        }
    }
	
	
	/* Check how many addresses in the database have the same parameters as the current object. */
    public function compare_address() {
        global $db;
        
        $query = "SELECT * FROM `address` WHERE LocationName = ? AND Street = ? AND StreetNumber = ? AND ZipCode = ? AND City = ? AND Province = ? AND (State = ? OR State IS NULL) AND (Country = ? OR Country IS NULL)";
        
        $statement = $db->prepare($query);
		
		if ($statement == FALSE) {
            display_db_error($db->error);
        }
		
		$statement->bind_param("ssiissss", $this->name, $this->street, $this->number, $this->zip, $this->city, $this->province, $this->state, $this->country);
        
        $statement->execute();
        
        $result = $statement->get_result();
        
        if ($result == FALSE) {
            display_db_error($db->error);
        }
        
		$results = array();
		array_push($results, $result->num_rows);
		
        while ($row = $result->fetch_assoc()) {
            array_push($results, $row['Address_id']);
        }
		
		$statement->close();
        
        return $results;
    }
    
    
    /* Create an address object and store all information of the record with the given Address_id in it. */
    static function get_addressById($id) {
        global $db;
        
        $id = $db->escape_string($id);
        
        $query = "SELECT * FROM `address` WHERE Address_id = ?";
        
        $statement = $db->prepare($query);
		
		if ($statement == FALSE) {
			display_db_error($db->error);
		}
        
        $statement->bind_param("i", $id);
        
        $statement->execute();
        
        $statement->bind_result($id, $name, $street, $number, $zip, $city, $province, $state, $country);
        
        $statement->fetch();
        
        $address = new address($id, $name, $street, $number, $zip, $city, $province, $state, $country);
        
        $statement->close();
        
        return $address;
    }
	
	
	/* Create an array and store all the information of the record with the given Address_id in it. */
	static function get_addressArrayById($id) {
		global $db;
        
        $id = $db->escape_string($id);
        
        $query = "SELECT * FROM `address` WHERE Address_id = ?";
        
        $statement = $db->prepare($query);
		
		if ($statement == FALSE) {
			display_db_error($db->error);
		}
        
        $statement->bind_param("i", $id);
        
        $statement->execute();
        
        $result = $statement->get_result();
        
        if ($result == FALSE) {
            display_db_error($db->error);
        }
        
        while ($row = $result->fetch_assoc()) {
            $address = $row;
        }
        
        $statement->close();
        
        return $address;
	}
	
	
	/* Create an array of all existing provinces in the database. */
    static function get_regions() {
        global $db;
        
        $query = "SELECT DISTINCT Province FROM `address`";
        
        $statement = $db->prepare($query);
		
		if ($statement == FALSE) {
            display_db_error($db->error);
        }
        
        $statement->execute();
        
        $result = $statement->get_result();
        
        if ($result == FALSE) {
            display_db_error($db->error);
        }
        
        $provinces = array();
        
        while ($row = $result->fetch_assoc()) {
            $provinces[] = $row['Province'];
        }
        
        $statement->close();
        
        return $provinces;
    }
}

?>