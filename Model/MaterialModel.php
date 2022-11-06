<?php
require_once PROJECT_ROOT_PATH . "/Model/Database.php";
 
class MaterialModel extends Database
{
    public function getMaterials($limit)
    {
        return $this->executeStatement("SELECT TOP $limit * FROM material ORDER BY id ASC");
    }

    public function getMaterial($id)
    {
        return $this->executeStatement("SELECT * FROM material WHERE id=?", [$id]);
    }

    public function setMaterial($sap_matno, $sap_blocked, $sap_additionals, $title)
    {
        return $this->executeStatement("INSERT INTO material (sap_matno, sap_blocked, sap_additionals, title) VALUES (?, ?, ?, ?)", array($sap_matno, $sap_blocked, $sap_additionals, $title));
    }

    public function updateMaterial($id, $sap_blocked, $sap_additionals, $title)
    {
        return $this->executeStatement("UPDATE material SET sap_blocked = ?, sap_additionals = ?, title = ? WHERE id = ?", array($sap_blocked, $sap_additionals, $title, $id));
    }
}
?>