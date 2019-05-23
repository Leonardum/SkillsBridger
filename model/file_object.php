<?php
/* This file contains the code for the userFile object and queries. */

class userFile {
    
    private $id;
    private $name;
    private $type;
    private $uploadObject;
    private $uploadId;
    private $readerObject;
    private $readerId;
    private $url;
        
    function __construct($id, $name, $type, $uploadObject, $uploadId, $readerObject, $readerId, $url) {
        $this->id = $id;
        $this->name = $name;
        $this->type = $type;
        $this->uploadObject = $uploadObject;
        $this->uploadId = $uploadId;
        $this->readerObject = $readerObject;
        $this->readerId = $readerId;
        $this->url = $url;
    }
    
    public function getId() {
        return $this->id;
    }
    public function getName() {
        return $this->name;
    }
    public function getType() {
        return $this->type;
    }
    public function getUploadObject() {
        return $this->uploadObject;
    }
    public function getUploadId() {
        return $this->uploadId;
    }
    public function getReaderObject() {
        return $this->readerObject;
    }
    public function getReaderId() {
        return $this->readerId;
    }
    public function getUrl() {
        return $this->url;
    }
    
    public function setId($id){
        if (is_int($id)) {
            $this->id = $id;
        }
    }
    public function setName($name) {
        if (is_string($name)) {
            $this->name = $name;
        }
    }
    public function setType($type) {
        if (is_string($type)) {
            $this->type = $type;
        }
    }
    public function setUploadObject($uploadObject) {
        if (is_string($uploadObject)) {
            $this->uploadObject = $uploadObject;
        }
    }
    public function setUploadId($uploadId) {
        if (is_int($uploadId)) {
            $this->uploadId = $uploadId;
        }
    }
    public function setReaderObject($readerObject) {
        if (is_string($readerObject)) {
            $this->readerObject = $readerObject;
        }
    }
    public function setReaderId($readerId) {
        if (is_int($readerId)) {
            $this->readerId = $readerId;
        }
    }
    public function setUrl($url) {
        if (is_string($url)) {
            $this->url = $url;
        }
    }
    
    // Save all changes made to the file info to the database.
    public function save() {
        /* Check if the file already exists in database. If it doesn't create a new record. If it does, update the current record. */
        if (!isset($this->id)) {
            global $db;
            
            $query = "INSERT INTO `file` (Name, Type, UploadObject, UploadId, ReaderObject, ReaderId, Url) VALUES (?, ?, ?, ?, ?, ?, ?)";
            
            $statement = $db->prepare($query);
            
            if ($statement == FALSE) {
                display_db_error($db->error);
            }
            
            $statement->bind_param("sssisis", $this->name, $this->type, $this->uploadObject, $this->uploadId, $this->readerObject, $this->readerId, $this->url);
            
            $success = $statement->execute();
            
            if ($success) {
                $fileId = $db->insert_id;
                $statement->close();
                return $fileId;
            } else {
                display_db_error($db->error);
            }
        } else {
            global $db;
            
            $query = "UPDATE `file` SET Name = ?, Type = ?, UploadObject = ?, UploadId = ?, ReaderObject = ?, ReaderId = ?, Url = ? WHERE File_id = ?";
            
            $statement = $db->prepare($query);
            
            if ($statement == FALSE) {
                display_db_error($db->error);
            }
            
            $statement->bind_param("sssisisi", $this->name, $this->type, $this->uploadObject, $this->uploadId, $this->readerObject, $this->readerId, $this->url, $this->id);
            
            $success = $statement->execute();
            
            if ($success) {
                $statement->close();
            } else {
                display_db_error($db->error);
            }
        }
    }
    
    
    // Delete the complete file record from the database.
    public function delete() {
        global $db;
        
        $query = "DELETE FROM `file` WHERE File_id = ?";
        
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
    
    
    /* Create a file object and store all information of the record with the given File_id in it. */
    static function get_fileById($id) {
        global $db;
        
        $id = $db->escape_string($id);
        
        $query = "SELECT * FROM `file` WHERE File_id = ?";
        
        $statement = $db->prepare($query);
		
		if ($statement == FALSE) {
			display_db_error($db->error);
		}
        
        $statement->bind_param("i", $id);
        
        $statement->execute();
        
        $statement->bind_result($id, $name, $type, $uploadObject, $uploadId, $readerObject, $readerId, $url);
        
        $statement->fetch();
        
        $userFile = new userFile($id, $name, $type, $uploadObject, $uploadId, $readerObject, $readerId, $url);
        
        $statement->close();
        
        return $userFile;
    }
    
    
    // Returns a list of all files for a certain Uploader.
    static function get_filesByUploader($uploadObject, $uploadId) {
        global $db;
        
        $uploadObject = $db->escape_string($uploadObject);
        $uploadId = $db->escape_string($uploadId);
        
        $query = "SELECT * FROM `file` WHERE UploadObject = ? AND UploadId = ?";
        
        $statement = $db->prepare($query);
		
		if ($statement == FALSE) {
			display_db_error($db->error);
		}
        
        $statement->bind_param("si", $uploadObject, $uploadId);
        
        $statement->execute();
        
        $result = $statement->get_result();
        
        if ($result == FALSE) {
            display_db_error($db->error);
        }
        
        $userFiles = array();
        
        while ($row = $result->fetch_assoc()) {
            $userFiles[] = array ($row['File_id'], $row['Name'], $row['Type'], $row['UploadObject'], $row['UploadId'], $row['ReaderObject'], $row['ReaderId'], $row['Url']);
        }
        
        $statement->close();
        
        return $userFiles;
    }
    
    
    // Returns a list of all files for a certain recipient.
    static function get_filesByReader($readerObject, $readerId) {
        global $db;
        
        $readerObject = $db->escape_string($readerObject);
        $readerId = $db->escape_string($readerId);
        
        $query = "SELECT * FROM `file` WHERE ReaderObject = ? AND ReaderId = ?";
        
        $statement = $db->prepare($query);
		
		if ($statement == FALSE) {
			display_db_error($db->error);
		}
        
        $statement->bind_param("si", $readerObject, $readerId);
        
        $statement->execute();
        
        $result = $statement->get_result();
        
        if ($result == FALSE) {
            display_db_error($db->error);
        }
        
        $userFiles = array();
        
        while ($row = $result->fetch_assoc()) {
            $userFiles[] = array ($row['File_id'], $row['Name'], $row['Type'], $row['UploadObject'], $row['UploadId'], $row['ReaderObject'], $row['ReaderId'], $row['Url']);
        }
        
        $statement->close();
        
        return $userFiles;
    }
    
    
    // Returns the image (profile picture or logo) associated with a specific instance of an object.
    static function get_imageOfUploader($uploadObject, $uploadId) {
        global $db;
        
        $uploadObject = $db->escape_string($uploadObject);
        $uploadId = $db->escape_string($uploadId);
        
        $query = "SELECT * FROM `file` WHERE Type = 'image' AND UploadObject = ? AND UploadId = ?";
        
        $statement = $db->prepare($query);
		
		if ($statement == FALSE) {
			display_db_error($db->error);
		}
        
        $statement->bind_param("si", $uploadObject, $uploadId);
        
        $statement->execute();
        
        $statement->bind_result($id, $name, $type, $uploadObject, $uploadId, $readerObject, $readerId, $url);
        
        $statement->fetch();
        
        $userFile = new userFile($id, $name, $type, $uploadObject, $uploadId, $readerObject, $readerId, $url);
        
        $statement->close();
        
        return $userFile;
    }
}

?>