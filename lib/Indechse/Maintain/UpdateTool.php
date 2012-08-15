<?php

class Indechse_Maintain_UpdateTool
{
    private $_availableUpdates = array();
    
    private $_updateLocation;
    
    /**
     *
     * @var PDO 
     */
    private $_conn;
    
    /**
     * public constructor which gets the path to the update scripts and an
     * instance of PDO
     * 
     * @param string $updateLocation
     * @param PDO $db 
     */
    public function __construct($updateLocation, PDO $db) {
        $this->_updateLocation = $updateLocation;
        $this->_conn = $db;
        
        $this->_scanUpdatesFolder($updateLocation);
    }
    
    /**
     * starts the update process when called 
     */
    public function run() {
        $this->_performUpdates();
    }
    
    /**
     * method to scan the given folder for updates
     * 
     * @param type $dir
     * @throws Exception 
     */
    private function _scanUpdatesFolder($dir) {
        $dhandle = opendir($dir);
        if ($dhandle) {
            $currentRevision = $this->_getCurrentRevision();
            // loop through all of the files
            while (false !== ($fname = readdir($dhandle))) {
                if (preg_match("/^\./", $fname)) {
                    continue;
                }
                if (!is_dir($dir . "/" . $fname)) {
                    if (preg_match("/^(\d*)\.((pgsql|mysql)\.)?(.*)\.(php|sql)$/", $fname, $matches)) {
                        if (count($matches) != 6) {
                            printf("invalid filename '%s', skipped file ", $fname);
                            continue;
                        }
                        $number = intval($matches[1]);
                        if ($number == 0) {
                            printf("the update file '%s' does not contain a revision number in first place", $fname);
                        }
                        if ($number <= $currentRevision) continue;
                        if (!isset($this->_availableUpdates[$number])) {
                            $this->_availableUpdates[$number] = array();

                        }
                        $this->_availableUpdates[$number][] = $matches;
                    }

                } else {
                    $this->_scanUpdatesFolder($dir . "/" . $fname, $parts);
                }
            }
            ksort($this->_availableUpdates);
            closedir($dhandle);
        }
    }
    
    /**
     * executes all the update classes
     */
    private function _performUpdates() {
        foreach($this->_availableUpdates as $rev => $updateList) {
            foreach($updateList as $u) {
                if (!empty($u[3]) && $this->_conn->getAttribute(PDO::ATTR_DRIVER_NAME) != $u[3]) {
                    continue;
                }
                $updateFormat = $u[5];
                $this->_conn->beginTransaction();
                try {
                    $instance = null;
                    if ($updateFormat == 'sql') {
                        require_once('Indechse/Maintain/Update/SqlExecute.php');
                        $instance = new Indechse_Maintain_Update_SqlExecute($this->_conn, $rev);
                        $instance->setSql(file_get_contents($this->_updateLocation.'/'.$u[0]));
                    } else {
                        $className = 'Update_'.$u[4];
                        require_once($this->_updateLocation.'/'.$u[0]);
                        $instance = new $className($this->_conn, $rev);
                    }
                    $instance->update();
                    $this->_markUpdateComplete($rev, $u[4].'.'.$u[5]);
                    $this->_conn->commit();
                } catch (Exception $ex) {
                    $this->_conn->rollBack();
                    throw new Exception(sprintf("Update %s (%d) failed with message: %s", $u[0], $rev, $ex->getMessage()), $ex->getCode(), $ex);
                }
            }
        }
    }
    
    /**
     * inserts a record in database when an update was successful
     *  
     * @param type $rev
     * @param type $classname 
     */
    private function _markUpdateComplete($rev, $classname) {
        $stmt = $this->_conn->prepare("INSERT INTO dbrev (revision, updatename) VALUES (?,?)");
        $stmt->execute(array($rev, $classname));
        printf('#%2$d %1$s () completed'."\n", $classname, $rev);
        
    }
    
    /**
     * getter for current revision
     * 
     * @return int 
     */
    private function _getCurrentRevision() {
        try {
            $rev = $this->_conn->query("SELECT MAX(revision) FROM dbrev")->fetchColumn(0);
        } catch (PDOException $pex) {
            $rev = 0;
        }
        
        return $rev;
    }

}
