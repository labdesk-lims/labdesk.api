<?php
require_once PROJECT_ROOT_PATH . "/Model/Database.php";
 
class MaterialModel extends Database
{
    public function listMaterial($limit)
    {
        return $this->executeStatement("SELECT TOP $limit * FROM material ORDER BY id ASC");
    }

    public function getMaterial($sap_matno)
    {
        return $this->executeStatement("SELECT * FROM material WHERE sap_matno=?", [$sap_matno]);
    }

    public function setMaterial($sap_matno, $sap_blocked, $sap_additionals, $title)
    {
        $obj = $this->executeStatement("SELECT * FROM material WHERE sap_matno=?", [$sap_matno]);

        If (!is_null($obj)) {
            return $this->executeStatement("UPDATE material SET sap_blocked = ?, sap_additionals = ?, title = ? WHERE sap_matno = ?", array($sap_blocked, $sap_additionals, $title, $sap_matno));
        } else {
            return $this->executeStatement("INSERT INTO material (sap_matno, sap_blocked, sap_additionals, title) VALUES (?, ?, ?, ?)", array($sap_matno, $sap_blocked, $sap_additionals, $title));   
        }
    }
}
?>