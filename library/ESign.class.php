<?php

include_once("{$GLOBALS['srcdir']}/sql.inc");

/**
 * HTML e-signature helper class to facilitate standardized signatures for forms and documents.  
 *
 * @author jwallace
 */
class ESign
{

    private $unsigned_signatures;
    private $signed_signatures;

    /**
     * Create an empty eSign object ready to attach signatures. 
     */
    function __construct()
    {
        $this->unsigned_signatures = array();
        $this->signed_signatures = array();
    }

    /**
     * Initialize eSign class for all signatures matching a table/tid
     * 
     * Use to recall existing signatures for a table row that haven't been signed
     * 
     * @param type $tid  - id for row in table.   column name may not be id exactly, but equivalent. 
     * @param type $table  - table name of the row the signature is for.
     */
    function init($tid, $table)
    {
        if (empty($tid) || empty($table))
        {
            return;
        }

        //get the existing unsigned signatures into the unsigned signatures array
        $result = sqlStatement("Select * from eSignatures where `tid` = '$tid' and `table` = '$table' and signed = 0");
        $hasUnsignedSigs = false;
        
        // check to see if there are any sigs that haven't been signed.  If so, add them to the object. 
        while ($sig = sqlFetchArray($result))
        {
            $hasUnsignedSigs = true;    
            $this->attachSignatureFromId($sig['id']);
        }
        
        if(!$hasUnsignedSigs)
        {
            // if no unsigned sigs exist, add empty signature for signing - We always want a waiting empty signature for a record that's been created and is signable.
            $this->attachUnsignedSignature($tid, $table);
        }

        // get any existing signed signatures
        $result = sqlStatement("Select * from eSignatures where `tid` = '$tid' and `table` = '$table' and signed = 1");

        while ($sig = sqlFetchArray($result))
        {
            $this->attachSignatureFromId($sig['id']);
        }
    }

    // return newest signed signature
    public function getNewestSignedSignature()
    {
        
        //sort by date using ascii string comparison. 
        $newest_sig = null;
        
        foreach($this->signed_signatures as $sig)
        {
            if(isset($newest_sig))
            {
                $newest_sig = $newest_sig->getDatetime() >= $sig->getDatetime() ? $newest_sig : $sig;
            }
            else
            {
                $newest_sig = $sig;
            }
        }
        return $newest_sig;
    }
    
    // return newest unsigned signature
    public function getNewestUnsignedSignature()
    {
        //sort by date using ascii string comparison. 
        $newest_sig = null;
        
        foreach($this->unsigned_signatures as $sig)
        {
            if(isset($newest_sig))
            {
                $newest_sig = $newest_sig->getDatetime() >= $sig->getDatetime() ? $newest_sig : $sig;
            }
            else
            {
                $newest_sig = $sig;
            }
        }
        
        return $newest_sig;
    }
    
    /**
     * attaches signature from signature id
     * 
     * @param type $id 
     */
    public function attachSignatureFromId($id)
    {
        $tmp_sig = new Signature();
        $tmp_sig->load($id);
        //echo "attach";

        if($tmp_sig->isSigned())
            array_push($this->signed_signatures, $tmp_sig);
        else
            array_push($this->unsigned_signatures, $tmp_sig);

    }

    /**
     * Attaches an additional signature of type $roleType to the form
     * 
     * @param $tid - id for table record
     * @param $table - table name for the record we're signing.  Can be considered record type.
     */
    public function attachUnsignedSignature($tid, $table)
    {
        $tmp_sig = new Signature();
        $tmp_sig->create($tid, $table);

        array_push($this->unsigned_signatures, $tmp_sig);
    }

    /**
     * Remove the signature object from the signatures array. 
     * 
     * @param type $table
     * @param type $uid
     */
    public function removeSignature($table, $uid)
    {
        return false;  // no clean-up allowed at this time.
    }

    /**
     * Returns the array of SIGNED signatures
     * 
     * @return array  
     */
    public function getSignatures()
    {
        return $this->signed_signatures;
    }

    public function getUnsignedSignatures()
    {
        return $this->unsigned_signatures;
    }

    /**
     * Creates the default visual component
     * Shows the log of all signatures for *$this
     * 
     * this can be replaced, overridden, or whatever.
     * 
     * @return echoes the html is $draw is set true, else returns the html as a string. 
     */
    public function getDefaultSignatureLog($draw=false)
    {
        $html = "";
        $html .= "<table width=100% cellspacing=0 cellpadding=2 style='border:1px black solid;font-size:small'>";
        $html .= "<tr><td colspan=2 class='body_title' style='text-align:center;'>e-Signature Log</td></tr>";

        if(count($this->signed_signatures) > 0)
        {
        foreach ($this->signed_signatures as $sig)
        {
            if ($sig->isSigned())
            {

                //get doctor info
                $user_info = sqlQuery("select * from users where id = '" . $sig->getUid() . "'");
                $status = "on file: " . $sig->getDatetime();

                $html .= "<tr><td>";

                // this maybe needs to reflect the ACL?
                if ($sig->getUid() != $user_id)  //need to check on user_id's val - should equal whoever's signed in
                  $html .= $user_info['fname'] . " " . $user_info['lname'] . " - signature $status</td></tr>";
            }
        }
        }
        else
        {
            $html .= "<tr><td>No signatures on file</td></tr>";
        }

        $html .= "</table>";

        if ($draw)
            echo $html;
        else
            return $html;
    }

}

class Signature
{

    private $id;
    private $tid;
    private $table;
    private $uid;
    private $datetime;
    private $signed;

    /**
     *  load a signature record by the id.
     */
    function load($id)
    {
        $this->id = $id;
        $this->sync();
    }

    /**
     * Creates _NEW_ signature entry. 
     * 
     * @param type $table
     * @param type $uid
     */
    function create($tid, $table)
    {

        if (empty($table))
        {
            throw new Exception("Table value must not be empty when attaching a new signature.");
        }

        if (empty($tid))
        {
            throw new Exception("The table id cannot be empty when attaching a new signature.");
        }

        $this->setTable($table);
        $this->setTid($tid);

        $this->saveOrUpdate();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getTid()
    {
        return $this->tid;
    }

    public function setTid($tid)
    {
        $this->tid = $tid;
    }

    public function getTable()
    {
        return $this->table;
    }

    public function setTable($table)
    {
        $this->table = $table;
    }

    public function getUid()
    {
        return $this->uid;
    }

    public function setUid($uid)
    {
        $this->uid = $uid;
    }

    public function getDatetime()
    {
        return $this->datetime;
    }

    public function isSigned()
    {
        return $this->signed;
    }

    public function setSigned($signed)
    {
        $this->signed = $signed;
    }

    private function addSeparator($args)
    {
        if ($args > 0)
            return ", ";
        else
            return "";
    }
    
    private function addAnd($args)
    {
        if ($args > 0)
            return "AND ";
        else
            return "";
    }
    public function saveOrUpdate()
    {
        $query = "eSignatures set ";
        $q2 = "eSignatures where ";
        $args = 0;

        if (!empty($this->tid))
        {
            $query .= "`tid` = '" . $this->tid . "' ";
            $q2 .= "`tid` = '" . $this->tid . "' ";
            $args++;
        }

        if (!empty($this->table))
        {
            $query .= $this->addSeparator($args);
            $query .= "`table` = '" . $this->table . "' ";
            
            $q2 .= $this->addAnd($args);
            $q2 .= "`table` = '" . $this->table . "' ";
            $args++;
        }

        if (!empty($this->uid))
        {
            $query .= $this->addSeparator($args);
            $query .= "`uid` = '" . $this->uid . "' ";
            
            $q2 .= $this->addAnd($args);
            $q2 .= "`uid` = '" . $this->uid . "' ";
            $args++;
        }

        if ($this->isSigned())
        {
            //sig
            $query .= $this->addSeparator($args);
            $query .= "`signed` = '" . $this->signed . "' ";
            
            //datetime
            $query .= $this->addSeparator($args);
            $query .= "`datetime` = now() ";

            // thinking I don't need to check for datetime for the where clause here. 
            
            $args++;
        } else
        {
            $query .= $this->addSeparator($args);
            $query .= "`signed` = '0' ";
            $args++;
        }


        if ($args && empty($this->id))
        {
            //if empty id, just add new record

            sqlInsert("insert into " . $query);
            
            $eSignRow = sqlQuery("select id from " . $q2);
            $this->id = $eSignRow['id'];
            
            //$this->id = sqlLastID();
        } else if ($args)
        {
            // if id has value, update with new values
            sqlStatement("update " . $query . " where id = '" . $this->id . "'");
        }

        $this->sync();
    }

    public function sync()
    {
        //re-sync from the database
        if (!empty($this->id))
        {
            $res = sqlQuery("select * from eSignatures where id = '" . $this->id . "'");

            if ($res)
            {
                foreach ($res as $key => $val)
                {
                    $this->$key = $val;
                }
            }
        }
    }

}
?>
