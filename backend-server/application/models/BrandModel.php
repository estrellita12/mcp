<?php
namespace application\models;

use \PDO;

class BrandModel extends Model
{
    const _TABLE = "web_brand";

    public function getList($col="*")
    {
        $sql = "SELECT $col FROM ".self::_TABLE."    ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}
?>
