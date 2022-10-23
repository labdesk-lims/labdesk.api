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
}
?>