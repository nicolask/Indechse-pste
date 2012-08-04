<?php

/*
 * Copyright (C) 2011 Roberto Rodríguez Pino <rodpin@gmail.com>
 *           (C) 2012 Nicolas Krueger <nicolas.krueger@gmail.com>
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 3
 * of the License, or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 *
 */

// Database handler
class DB
{

    private $_conn;
    
    // Constructor - establishes DB connection
    public function __construct()
    {
        $this->_conn = Pste_Database::getInstance()->getConnection();
        
    }

    // How many pastes are in the database?
    function getPasteCount()
    {
        $res = $this->_conn->query('select count(*) as cnt from paste')->fetchColumn(0);
        return $res;
    }

    // Delete oldest $deletecount pastes from the database.
    function trimDomainPastes($deletecount)
    {
        // Build a one-shot statement to delete old pastes
        $pastesToDelete = $this->_conn->query("select id from paste order by posted asc limit {$this->_conn->quote($deletecount)}")->fetchAll(PDO::FETCH_ASSOC);
        
        $sql = 'delete from paste where pid in ('.implode(',', $pastesToDelete).')';
        $this->_conn->exec($sql);

    }

    // Delete all expired pastes.
    function deleteExpiredPastes()
    {
        $this->_conn->exec("delete from paste where expires is not null and now() > expires");
    }

    // Add paste and return ID.
    function addPost($poster, $format, $code, $parent_pid, $expiry_flag, $password)
    {
        //figure out expiry time
        switch ($expiry_flag) {
            case 'd':
                $date = new DateTime();
                $date->add(new DateInterval('P1D'));
                $expires = $date->format('Y-m-d H:i:s');
                break;
            case 'f':
                $expires = null;
                break;
            default:
                $date = new DateTime();
                $date->add(new DateInterval('P1M'));
                $expires = $date->format('Y-m-d H:i:s');;
                break;
        }
        $sql = 'insert into paste (poster, posted, format, code, parent_pid, expires, expiry_flag, password) ' .
                "values (:poster, now(), :format, :code, :parentpid, :expires, :expiryflag, :password)"; 
                
        $args = array(
            ':poster' => $poster, 
            ':format' => $format, 
            ':code' => $code, 
            ':parentpid' => $parent_pid, 
            ':expires' => $expires,
            ':expiryflag' => $expiry_flag, 
            ':password' => sha1($password)
        );
        
        $stmt = $this->_conn->prepare($sql);
        $stmt->execute($args);
        
        $id = $this->_conn->lastInsertId();
        return $id;
    }

    // Return entire paste row for given ID.
    function getPaste($id)
    {
        $stmt = $this->_conn->prepare('select *,posted as postdate from paste where pid=?');
        $stmt->execute(array($id));
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (count($result))
            return $result[0];
        else
            return false;
    }
    
    function getAllPastes($page=1, $limit=30)
    {
        $offset = ($page-1)*$limit;
        $stmt = $this->_conn->prepare("select * from paste ORDER BY posted DESC LIMIT {$limit} OFFSET {$offset}");
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $result;
    }

    // Return summaries for $count posts ($count=0 means all)
    function getRecentPostSummary($count)
    {
        $limit = $count ? "limit $count" : "";

        $posts = array();
        $sql = ("select pid, poster, extract(epoch from now())-extract(epoch from posted) as age, " .
                "posted as postdate " .
                "from paste " .
                "order by posted desc, pid desc $limit");
        
        $results = $this->_conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        

        return $results;
    }

    // Get follow up posts for a particular post
    function getFollowupPosts($pid, $limit = 5)
    {
        //any amendments?
        
        $sql = "select pid,poster," .
                "posted as postfmt " .
                "from paste where parent_pid=:pid " .
                "order by posted limit $limit";
        $stmt = $this->_conn->prepare($sql);
        $stmt->execute(array(':pid' => $pid));
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    }

    // Save formatted code for displaying.
    function saveFormatting($pid, $codefmt, $codecss)
    {
        $sql = "update paste set codefmt=:codefmt,codecss=:codecss where pid=:pid";
        
        $args = array(
            ':codefmt' => $codefmt, 
            ':codecss' => $codecss, 
            ':pid' => $pid
        );
        
        $stmt = $this->_conn->prepare($sql);
        $stmt->execute($args);
        
    }

}

