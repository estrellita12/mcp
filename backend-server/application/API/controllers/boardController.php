<?php
namespace application\API\controllers;

class boardController extends Controller
{
    function getList(){
        if($_GET['no'] == "5"){
            $row = array(
                array("id"=>"1","mainImg"=>"http://i.ytimg.com/vi/LwZCRL0NAgs/mqdefault.jpg", "title"=>"2022 신상 갓성비 골프 파우치","url"=>"https://killdeal.co.kr/bbs/read.php?index_no=203&boardid=43&page=1"),
                array("id"=>"2","mainImg"=>"http://i.ytimg.com/vi/t9w0YpHxEok/mqdefault.jpg", "title"=>"데상트 니삭스 양말 리뷰","url"=>"https://killdeal.co.kr/bbs/read.php?index_no=203&boardid=43&page=1"),
                array("id"=>"3","mainImg"=>"http://i.ytimg.com/vi/vufc-C6EhoQ/mqdefault.jpg", "title"=>"여름에는 시원하게! 겨울에는 따뜻하게! 만능 이너웨어 리뷰","url"=>"https://killdeal.co.kr/bbs/read.php?index_no=203&boardid=43&page=1"),
                array("id"=>"4","mainImg"=>"http://i.ytimg.com/vi/YcxYToMptGw/mqdefault.jpg", "title"=>"어떤 옷에도 잘 어울리는 미즈노 모자 리뷰","url"=>"https://killdeal.co.kr/bbs/read.php?index_no=203&boardid=43&page=1"),
            );
            $arr = array("result"=>"000", "client"=>_SHOP, "data"=>$row);
            echo json_encode($arr);
        }

        if($_GET['no'] == "6"){
            $row = array(
                array("id"=>"1","mainImg"=>"https://killdeal.co.kr/data/editor/2207/4a19e752b7eee6194c6ea0bce58c9d68_1656908475_4333.jpg", "title"=>"내 발에 착! 헤지스골프 신상 골프화! 신규입고! ✔✔","url"=>"https://killdeal.co.kr/bbs/read.php?index_no=203&boardid=43&page=1"),
                array("id"=>"2","mainImg"=>"https://killdeal.co.kr/data/editor/2206/a3f55bbd2692f8aa01902072ec0754aa_1656466123_872.jpg", "title"=>"프로 경기에서 포착! 특허로 무장한 거리측정기","url"=>"https://killdeal.co.kr/bbs/read.php?index_no=203&boardid=43&page=1"),
                array("id"=>"3","mainImg"=>"https://killdeal.co.kr/data/editor/2206/8111c612f45ec8444f65e1456338a705_1656392304_3071.jpg", "title"=>"완벽하다고 생각한 내 샷이 배치기 스윙? 지금 바로 점검하기","url"=>"https://killdeal.co.kr/bbs/read.php?index_no=203&boardid=43&page=1"),
                array("id"=>"4","mainImg"=>"https://killdeal.co.kr/data/editor/2205/d6690391f1896a444247e341516e37fe_1653540371_2758.jpg", "title"=>"여름 라운딩에서 자외선 철벽방어 해줄 아이템!","url"=>"https://killdeal.co.kr/bbs/read.php?index_no=203&boardid=43&page=1")
            );
            $arr = array("result"=>"000", "client"=>_SHOP, "data"=>$row);
            echo json_encode($arr);
        }

    }

    function get(){
        $row = array();
        $arr = array("client"=>_PTID,"data"=>$row);
        echo json_encode($arr);
    }
}
?>
