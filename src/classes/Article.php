<?php

class Article {

    protected $db;

    public function __construct(Database $db) {
        $this->db = $db;
    }

    public function get(int $id, bool $published = true) {
        $sql = "SELECT a.id, a.title, a.subtitle, a.summary, a.content, a.created, a.category_id, a.member_id, a.published,
                       c.name AS category,
                       CONCAT (m.first_name, ' ', m.last_name) AS author,
                       i.id AS image_id,
                       i.file AS image_file,
                       i.alt AS image_alt
                FROM article AS a
                JOIN category AS c ON a.category_id = c.id
                JOIN member AS m ON a.member_id = m.id
                LEFT JOIN image AS i ON a.image_id = i.id
                WHERE a.id = :id "; 
        if($published) {
            $sql .= "AND a.published = 1;";
        }
        return $this->db->runSQL($sql, [$id])->fetch();
    }

    public function getAll($published = true, $category = null, $member = null, $limit = 10000): array {
        $arguments['category'] = $category;
        $arguments['category1'] = $category;
        $arguments['member'] = $member;
        $arguments['member1'] = $member;
        $arguments['limit'] = $limit;

        $sql = "SELECT a.id, a.title, a.subtitle, a.summary, a.content, a.created, a.category_id, a.member_id, a.published,
                       c.name AS category,
                       CONCAT (m.first_name, ' ', m.last_name) AS author,
                       i.id AS image_id,
                       i.file AS image_file,
                       i.alt AS image_alt
                FROM article AS a
                JOIN category AS c ON a.category_id = c.id
                JOIN member AS m ON a.member_id = m.id
                LEFT JOIN image AS i ON a.image_id = i.id
                WHERE (a.category_id = :category OR :category1 IS null)
                AND (a.member_id = :member OR :member1 IS null) "; 
        if($published) {
            $sql .= "AND a.published = 1 ";
        }
        $sql .= "ORDER BY a.id 
                DESC LIMIT :limit;";
        return $this->db->runSQL($sql, $arguments)->fetchAll();
    }

    public function count(): int {
        $sql = "SELECT COUNT(id) FROM article;";         
        return $this->db->runSql($sql)->fetchColumn();   
    }

    

    // -----------------Multiple Functions I am testing for multiple images----------------


    /* public function create (array $article) {
        foreach ($_FILES['image']['name'] as $filename) {
            
            $image_filenames = $image_filenames . $filename . ',' ;

            $sql = "INSERT INTO article (title, subtitle, summary, content, category_id, member_id,
                            images, published)
                        VALUES (:title, :subtitle, :summary, :content, :category_id, :member_id,
                            :images, :published);";     
                $this->db->runSql($sql, $article);           
                $this->db->commit();                         
                return true; 
        }

            print_r($image_filenames);
            echo "<script>console.log('Debug Objects: " . $image_filenames . "' );</script>";
        
    } */
    

   
    public function createCopy1 (array $article, array $temporary, string $destination): bool {  

        try {   

            // in order to see this echo you need to comment out the success redirect on line 103 in article.php (member)

            // this isn't working but ideal to get something like this to work as opposed to above - $temporary is defined on line 13 in article.php (member)
            /* foreach($temporary as $file) {
                echo "<script>console.log('Debug Objects: " . $file . "' );</script>";
            } */
 

            $image_filenames = '';
                    foreach ($_FILES['image']['name'] as $filename) {
                        $image_filenames = $image_filenames . $filename . ','; 
                    }

                    $comma_separated_image_filenames = rtrim($image_filenames,',');

                    echo "<script>console.log('Debug Objects: " . $comma_separated_image_filenames . "' );</script>";
                    print_r ($comma_separated_image_filenames);

                // 8/1/23 notes: need to move sql into foreach
                // and need to change DB structure so image table references article, and article table does NOT reference image
                    // and then you will need to update your references in the code to account for the new DB structure

                $this->db->beginTransaction();               
                if ($destination) {                          
                    $imagick = new \Imagick($temporary);     
                    $imagick->cropThumbnailImage(1200, 700); 
                    $imagick->writeImage($destination);      

                    $sql = "INSERT INTO image (file, alt)
                            VALUES (:file, :alt);";                           
                    $this->db->runSql($sql, [$article['image_file'], $article['image_alt']]);            
                    $article['image_id'] = $this->db->lastInsertId(); 
                }
                unset($article['image_file'], $article['image_alt']);
                $sql = "INSERT INTO article (title, subtitle, summary, content, category_id, member_id,
                            image_id, published)
                        VALUES (:title, :subtitle, :summary, :content, :category_id, :member_id,
                            :image_id, :published);";     
                $this->db->runSql($sql, $article);           
                $this->db->commit();                         
                return true;     

        } catch (Exception $e) {                         
            $this->db->rollBack();                       
            if (file_exists($destination)) {             
                unlink($destination);                    
            }
            if (($e instanceof PDOException) and ($e->errorInfo[1] === 1062)) { 
                return false;                            
            } else {                                     
                throw $e;                               
            }
        }
    
    }
    

    
    public function createMemberNewArticle (array $article, array $temporary, string $destination): bool {  
        
            $image_filenames = '';
                    foreach ($image_filenames as $filename) {
                        $image_filenames = $image_filenames . $filename . ','; 

                         
                        if ($destination) {                          
                            $imagick = new \Imagick($temporary);     
                            $imagick->cropThumbnailImage(1200, 700); 
                            $imagick->writeImage($destination);  
 
        
                        $sql = "INSERT INTO article (title, filenames, published)
                                VALUES (:title, :filenames, :published);";     
                        $this->db->runSql($sql, $article);                      
                        return true;  
                        
                    }
                }
            
                    $comma_separated_image_filenames = rtrim($image_filenames,',');

                    echo "<script>console.log('Debug Objects: " . $comma_separated_image_filenames . "' );</script>";
                    print_r ($comma_separated_image_filenames);

                // 8/1/23 notes: need to move sql into foreach
                // and need to change DB structure so image table references article, and article table does NOT reference image
                    // and then you will need to update your references in the code to account for the new DB structure

    }
    

    function incoming_files() {
        $files = $_FILES;
        $files2 = [];
        foreach ($files as $input => $infoArr) {
            $filesByInput = [];
            foreach ($infoArr as $key => $valueArr) {
                if (is_array($valueArr)) { // file input "multiple"
                    foreach($valueArr as $i=>$value) {
                        $filesByInput[$i][$key] = $value;
                    }
                }
                else { // -> string, normal file input
                    $filesByInput[] = $infoArr;
                    break;
                }
            }
            $files2 = array_merge($files2,$filesByInput);
        }
        $files3 = [];
        foreach($files2 as $file) { // let's filter empty & errors
            if (!$file['error']) $files3[] = $file;
        }
        return $files3;
    }


    // -----------------End of Multiple Functions I am testing for multiple images----------------
    


    public function create(array $article, string $temporary, string $destination): bool {
    /* public function create(array $article, array $temporary, string $destination): bool { */
        try {                                            
            $this->db->beginTransaction();               
            if ($destination) {                          
                $imagick = new \Imagick($temporary);     
                $imagick->cropThumbnailImage(1200, 700); 
                $imagick->writeImage($destination);      

                $sql = "INSERT INTO image (file, alt)
                        VALUES (:file, :alt);";                
                $this->db->runSql($sql, [$article['image_file'], $article['image_alt']]);            
                $article['image_id'] = $this->db->lastInsertId(); 
            }
            unset($article['image_file'], $article['image_alt']);
            $sql = "INSERT INTO article (title, subtitle, summary, content, category_id, member_id,
                           image_id, published)
                    VALUES (:title, :subtitle, :summary, :content, :category_id, :member_id,
                           :image_id, :published);";     
            $this->db->runSql($sql, $article);           
            $this->db->commit();                         
            return true;                                 
        } catch (Exception $e) {                         
            $this->db->rollBack();                       
            if (file_exists($destination)) {             
                unlink($destination);                    
            }
            if (($e instanceof PDOException) and ($e->errorInfo[1] === 1062)) { 
                return false;                            
            } else {                                     
                throw $e;                               
            }
        }
    }

    public function update(array $article, string $temporary, string $destination): bool {
        try {                                            
            $this->db->beginTransaction();               
            if ($destination) {                   
                $imagick = new \Imagick($temporary);     
                $imagick->cropThumbnailImage(1200, 700); 
                $imagick->writeImage($destination);      

                $sql = "INSERT INTO image (file, alt)
                  VALUES (:file, :alt);";                
                $this->db->runSql($sql, [$article['image_file'], $article['image_alt']]);    
                $article['image_id'] = $this->db->lastInsertId();  
            }
            // Remove unwanted elements from $article
            unset($article['category'], $article['created'], $article['author'], $article['image_file'], $article['image_alt']);
            $sql = "UPDATE article SET title = :title, subtitle = :subtitle, summary = :summary, content = :content, 
                           category_id = :category_id, member_id = :member_id, 
                           image_id = :image_id, published = :published 
                     WHERE id = :id;";                       
            $this->db->runSql($sql, $article)->rowCount(); 
            $this->db->commit();               
            return true;                                 
        } catch (Exception $e) {                         
            $this->db->rollBack();            
            if (file_exists($destination)) {             
                unlink($destination);                    
            }
            if (($e instanceof PDOException) and ($e->errorInfo[1] === 1062)) { 
                return false;                            
            } else {                                     
                throw $e;                               
            }
        }
    }

    public function delete(int $id): bool {
        $sql = "DELETE FROM article WHERE id = :id;";    
        $this->db->runSql($sql, [$id]);                  
        return true;                                     
    }

    public function imageDelete(int $image_id, string $path, int $article_id) {
        $sql = "UPDATE article SET image_id = null 
               WHERE id = :article_id;";                 
        $this->db->runSql($sql, [$article_id]);          
        $sql = "DELETE FROM image 
               WHERE id = :id;";                         
        $this->db->runSql($sql, [$image_id]);            

        if (file_exists($path)) {                        
            unlink($path);                               
        }
    }

    public function altUpdate(int $image_id, string $alt) {
        $sql = "UPDATE image SET alt = :alt 
               WHERE id = :article_id;";                 
        $this->db->runSql($sql, [$alt, $image_id]);      
    }

    // Get count of search matches
    public function searchCount(string $term): int {
        $arguments['term1'] = '%' . $term . '%';         // Add wildcards to search term
        $arguments['term2'] = '%' . $term . '%';         // Add wildcards to search term
        $arguments['term3'] = '%' . $term . '%';         // Add wildcards to search term
        $arguments['term4'] = '%' . $term . '%';         // Add wildcards to search term
        $sql   = "SELECT COUNT(title)
                FROM article
               WHERE article.title   LIKE :term1 
                  OR article.subtitle   LIKE :term2
                  OR article.summary LIKE :term3
                  OR article.content LIKE :term4
                 AND article.published = 1;";            
        return $this->db->runSQL($sql, $arguments)->fetchColumn  (); // Return number of matches
    }

    // Get article summaries of search matches
    public function search(string $term, int $show = 6, int $from = 0): array {
        $arguments['term1'] = '%' . $term . '%';         // Add wildcards to search term
        $arguments['term2'] = '%' . $term . '%';         // Add wildcards to search term
        $arguments['term3'] = '%' . $term . '%';         // Add wildcards to search term
        $arguments['term4'] = '%' . $term . '%';         // Add wildcards to search term
        $arguments['show']  = $show;                     // Number of results to show
        $arguments['from']  = $from;                     // Number of results to skip
        $sql  = "SELECT a.id, a.title, a.subtitle, a.summary, a.content, a.created, a.category_id, a.member_id,
                     c.name      AS category,
                     CONCAT(m.first_name, ' ', m.last_name) AS author,
                     i.file      AS image_file, 
                     i.alt       AS image_alt

                FROM article     AS a
                JOIN category    AS c    ON a.category_id = c.id
                JOIN member      AS m    ON a.member_id   = m.id
                LEFT JOIN image  AS i    ON a.image_id    = i.id

               WHERE a.title     LIKE :term1 
                  OR a.subtitle   LIKE :term2
                  OR a.summary   LIKE :term3
                  OR a.content   LIKE :term4
                 AND a.published = 1
               ORDER BY a.id DESC
               LIMIT :show 
              OFFSET :from;";                            
        return $this->db->runSQL($sql, $arguments)->fetchAll();  
    }

}




