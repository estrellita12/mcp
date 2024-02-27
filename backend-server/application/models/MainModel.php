<?php
namespace application\models;

// DB 선언된 내용을 가져오는 기능. 
// 보편적으로는 그냥 PDO 클래스를 부르면 되지만, autoload를 사용하였기 때문에 use 키워드가 필요하다
// use 키워드가 없으면, 해당 클래스를 autoload에서 검색하게 되고, 결국 없다는 결과가 도출된다
use \PDO;

class MainModel extends Model
{
    public function selectList($category, $idx, $pageNo,$searchKey)
    {
        $sql = 'SELECT index_no, gname FROM shop_goods limit 5';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}


?>
