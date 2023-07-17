<?php

class Member {
    protected $db;                                       

    public function __construct(Database $db) {
        $this->db = $db;                                 
    }

    public function get(int $id) {
        $sql = "SELECT id, role, first_name, last_name, picture, joined 
                FROM member
               WHERE id = :id;";                         
        return $this->db->runSQL($sql, [$id])->fetch();  
    }

    
    public function getAll(): array {
        $sql = "SELECT id, role, first_name, last_name, email, picture, joined
                FROM member;";                           
        return $this->db->runSQL($sql)->fetchAll();      
    }

    public function create(array $member): bool {
        $member['password'] = password_hash($member['password'], PASSWORD_DEFAULT); 

        try {
            $sql = "INSERT INTO member (first_name, last_name, email, password)
                    VALUES (:first_name, :last_name, :email, :password);";
            $this->db->runSQL($sql, $member);
            return true;
        } catch (\PDOException $e) {
            if ($e->errorInfo[1] === 1062) {
                return false;
            } 
            throw $e;
        }
    }

    public function update(array $member): bool {
        unset($member['joined'],  $member['picture']);                
        try {                                                         
            $sql = "UPDATE member 
                       SET  role = :role, first_name = :first_name, last_name = :last_name, email = :email
                     WHERE id = :id;";                                
            $this->db->runSQL($sql, $member);                         
            return true;                                              
        } catch (\PDOException $e) {                                  
            if ($e->errorInfo[1] == 1062) {                           
                return false;                                         
            }                                                         
            throw $e;                                                 
        }
    }
    

    public function count(): int {
        $sql = "SELECT COUNT(id) FROM member;";                  
        return $this->db->runSQL($sql)->fetchColumn();           
    }


    public function login(string $email, string $password) {
        $sql = "SELECT id, role, first_name, last_name, email, password, picture, joined
                FROM member
                WHERE email = :email;";
        $member = $this->db->runSQL($sql, [$email])->fetch();
        if (!$member) {
            return false;
        }
        $authenticated = password_verify($password, $member['password']);
        return ($authenticated ? $member : false);
    }
    
    // Upload member profile image
    public function pictureCreate(int $id, string $filename, string $temporary, string $destination): bool {
        if ($temporary) {                                    // If an image was uploaded
            $image = new \Imagick($temporary);               // Object to represent image
            $image->cropThumbnailImage(350, 350);            // Create cropped image
            $saved = $image->writeImage($destination);       // Save file
            if ($saved == false) {                           // If save failed
                throw new Exception('Unable to save image'); // Throw an exception
            }
        }
        $filename = basename($destination);
        $sql = "UPDATE member 
                   SET picture = :picture
                 WHERE id = :id;";                                   // SQL to create picture
        $this->db->runSQL($sql, ['id'=>$id, 'picture'=>$filename],); // Run SQL pass in user id and filename
        return true;                                                 // Done return true
    }

    // Delete member profile image
    public function pictureDelete(int $id, string $path): bool {
        $unlink = unlink($path);                         // Delete image file
        if ($unlink === false) {                         // If failed throw exception
            throw new Exception('Unable to delete image or image is missing');
        }
        $sql = "UPDATE member 
                   SET picture = null
                 WHERE id = :id;";                       // SQL to set picture to null
        $this->db->runSQL($sql, ['id'=>$id,]);           // Run SQL
        return true;                                     // Return true
    }
   
    public function delete(int $id): bool
    {
        $sql = "DELETE FROM member WHERE id = :id;";    
        $this->db->runSql($sql, [$id]);                  
        return true;                                     
    }
 
    
    
    public function getIdByEmail(string $email) {
        $sql = "SELECT id
                  FROM member
                 WHERE email = :email;";                         
        return $this->db->runSQL($sql, [$email])->fetchColumn(); 
    }


    // Update member password
    public function passwordUpdate(int $id, string $password): bool {
        $hash = password_hash($password, PASSWORD_DEFAULT);           
        $sql = 'UPDATE member 
                   SET password = :password 
                 WHERE id = :id;';                                    
        $this->db->runSQL($sql, ['id' => $id, 'password' => $hash,]); 
        return true;                                                  
    }

}



