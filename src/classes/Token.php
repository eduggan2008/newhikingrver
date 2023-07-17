<?php                              

class Token
{
    protected $db;                                       

    public function __construct(Database $db) {
        $this->db = $db;                                 
    }

    // Create a new token (requires member id and purpose of token)
    public function create(int $id, string $purpose): string {
        $arguments['token']     = bin2hex(random_bytes(64));                   // Token
        $arguments['expires']   = date("Y-m-d H:i:s", strtotime('+4 hours'));  // Expiration
        $arguments['member_id'] = $id;                                         // Member id
        $arguments['purpose']   = $purpose;                                    // Purpose
        $sql     = "INSERT INTO token (token, member_id, expires, purpose)
                    VALUES (:token, :member_id, :expires, :purpose);"; // SQL to add token to database
        $this->db->runSQL($sql, $arguments);                           // Run SQL statement
        return $arguments['token'];                                    // Return new token
    }

    // Check if token is valid
    public function getMemberId(string $token, string $purpose): ?int {
        $arguments = ['token' => $token, 'purpose' => $purpose,];
        $sql = "SELECT member_id
                  FROM token
                 WHERE token = :token AND purpose = :purpose
                   AND expires > NOW();";                                                          
        return $this->db->runSQL($sql, ['token' => $token, 'purpose' => $purpose])->fetchColumn(); 
    }
}