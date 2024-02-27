<?php
$res_code = array(
    "000"=>"000 성공",
    "001"=>"001 조회/변경된 데이터가 없습니다.", 
    "002"=>"002 필수 파라미터 누락되었습니다." , 
    "003"=>"003 중복된 데이터입니다.", 
    "004"=>"004 Permission Denied",
    "005"=>"005 파일 업로드에 대한 에러가 발생하였습니다.",
    "006"=>"006 메일 발송에 대한 에러가 발생하였습니다.",
    "007"=>"007 카카오톡/SMS 발송에 대한 에러가 발생하였습니다.",
    "008"=>"008 ",
    "009"=>"009 쿼리 에러 오류가 발생하였습니다.",

    "100"=>"100 존재하지 않는 사용자입니다.",
    "101"=>"101 등록된 가맹점과 접근 허용을 신청한 가맹점이 상이합니다.",
    "102"=>"102 패스워드가 올바르지 않습니다.",
    "103"=>"103 차단 또는 승인되지 않은 사용자입니다.",
    "104"=>"104 카카오 로그인 실패.",
    "105"=>"105 네이버 로그인 실패.",
    "106"=>"106 포인트 오류.",
    "109"=>"109 인증 오류(token 오류)가 발생하였습니다.",
    "110"=>"110 결제 처리 에러",
    "111"=>"111 결제 승인 처리 에러",
    "112"=>"112 결제 취소 처리 에러",
    "113"=>"113 결제 취소 처리 에러. 존재하지 않는 MID 입니다. 결제취소를 위해서는 PG사에 문의하시기 바랍니다.",
    "114"=>"114 결제 취소 처리 에러. 존재하지 않는 결제사입니다. 결제취소를 위해서는 PG사에 문의하시기 바랍니다.",
    "114"=>"115 주문 처리 에러.",

    "403"=>"Permission Denied (인증 오류가 발생하였습니다.)",
    "404"=>"Not Found File (존재하지 않는 파일입니다.)",

    "500"=>"Internal Server Error (서버 내부 오류가 발생하였습니다.)"   
);
$deny_id = array("admin","root","administrator");
$company_type = array( "1" => "일반과세자", "2" => "간이과세자", "3" => "면세사업자" );
$media_type = array( "1" => "세로", "2" => "가로" );

$user_type = array("administrator"=>"관리자","seller"=>"판매자", "partner"=>"가맹점","member"=>"회원", "guest"=>"비회원");
$skin_type = array("basic","media","list","image","magazin");

$cs_type = array("일반","클레임","문의");

// web_member
$mb_stt = array( "1" =>"대기", "2" =>"승인");
$mb_gender = array( "M" =>"남성", "W" =>"여성" );
$mb_emailser = array( "Y" =>"수신동의", "N" =>"수신거절" );
$mb_smsser = array( "Y" =>"수신동의", "N" =>"수신거절" );
$price_sale_unit = array("1"=>"원 단위 할인","2"=>"% 단위 할인");

// web_partner
$pt_stt = array("1"=>"대기","2"=>"승인","3"=>"만료");

// web_seller
$sl_stt = array("1"=>"대기","2"=>"승인","3"=>"만료");
$dv_type = array(
    "1" =>array("무료","배송비가 부과되지 않습니다."),
    //"2" =>array("착불","주문시 또는 장바구니에 배송비가 [착불]이라는 글이 출력되며 배송비는 부과되지 않습니다."),
    "3" =>array("선결제","주문 금액 또는 수량에 상관없이 동일 주문건에 배송비를 한번만 부과됩니다."),
    //"4" =>array("착불/선결제","배송비를 착불/선결제로 선택하여 처리합니다."),
    "5" =>array("조건부 무료","일정 금액 이하의 주문건의 경우, 배송비를 부과합니다"),
);

// web_order
$od_stt = array(
    //"0" =>array("title"=>"결제진행중","next"=>array("1","2","42")),
    "1" =>array("title"=>"입금대기","next"=>array("2","42")),
    "2" =>array("title"=>"결제완료","next"=>array("3","42")),
    "3" =>array("title"=>"상품준비중","next"=>array("11","41")),

    "11" =>array("title"=>"배송준비","next"=>array("13","12","41")),
    "12" =>array("title"=>"배송보류","next"=>array("11","41","42")),
    "13" =>array("title"=>"배송중","next"=>array("14")),
    "14" =>array("title"=>"배송완료","next"=>array("21","31")),

    "20" =>array("title"=>"교환철회","next"=>array("14")),
    "21" =>array("title"=>"교환신청","next"=>array("22","14")),
    "22" =>array("title"=>"교환접수","next"=>array("23")),
    "23" =>array("title"=>"교환회수단계","next"=>array("27","26")),
    //"23" =>array("title"=>"교환회수준비","next"=>array("24")),
    //"24" =>array("title"=>"교환회수중","next"=>array("25")),
    //"25" =>array("title"=>"교환회수완료","next"=>array("26")),
    "26" =>array("title"=>"교환보류","next"=>array("27","14","36")),
    "27" =>array("title"=>"교환발송단계","next"=>array("29")),
    //"27" =>array("title"=>"교환발송준비","next"=>array("27")),
    //"28" =>array("title"=>"교환발송중","next"=>array("28")),
    "29" =>array("title"=>"교환완료","next"=>array()),

    "30" =>array("title"=>"반품철회","next"=>array("14")),
    "31" =>array("title"=>"반품신청","next"=>array("32","14")),
    "32" =>array("title"=>"반품접수","next"=>array("33")),
    "33" =>array("title"=>"반품회수단계","next"=>array("37")),
    //"33" =>array("title"=>"반품회수준비","next"=>array("34")),
    //"34" =>array("title"=>"반품회수중","next"=>array("35")),
    //"35" =>array("title"=>"반품회수완료","next"=>array("37")),
    "36" =>array("title"=>"반품보류","next"=>array("14","37")),
    "37" =>array("title"=>"반품완료","next"=>array()),

    "40" =>array("title"=>"취소철회","next"=>array("2")),
    "41" =>array("title"=>"취소신청","next"=>array("42")),
    "42" =>array("title"=>"취소완료","next"=>array()),
);
/*
$od_stt_type = array(
    "주문"=>"2,11,12,13,14,20,21,22,23,24,25,26,27,28,29",
    "취소"=>"42,36",
    "정산"=>"13,14,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35"
);
*/
$od_stt_type = array(
    "주문"=>"2,3,11,12,13,14,20,21,22,23,24,25,26,27,28,29",
    "취소"=>"42,37",
    "정산"=>"13,14,21,22,23,26,29,31,32,33,36"
);

$pay_stt = array(
    "1"=>"정산대기",
    "2"=>"정산완료",
    "3"=>"교환/반품 정산대기",
    "4"=>"교환/반품 정산완료"
);

$edm_stt = array("1"=>"대기","2"=>"승인","3"=>"취소");
$lms_stt = array("1"=>"대기","2"=>"승인","3"=>"취소");

// 결제 방법
$paymethod = array(
    "bank" =>"무통장입금",
    "card" =>"신용카드",
    "iche" =>"실시간계좌이체",
    "vbank" =>"가상계좌",
    "hp" =>"휴대폰결제"
);

$pg_company= array(
    "inicis"=>array("KG이니시스","https://iniweb.inicis.com"),
    "kcp"=>array("KCP","https://iniweb.inicis.com"),
    "toss"=>array("토스페이먼트","https://iniweb.inicis.com")
);

$gs_stt = array( "1" =>"대기", "2" =>"승인", "3" =>"보류", "4"=>"삭제" );
$gs_pt_only = array( "1" =>"전체", "2" =>"가맹점" );

$target = array(
    '_self'=>'현재창에서',
    '_blank'=>'새창에서'
);

$device = array("1"=>"PC","2"=>"Mobile");

$gs_tax = array(
    '1' => '과세',
    '2' => '면세',
    '3' => '자료없음',
    '4' => '비과세',
);

$gs_sex = array(
    '1' => '남성용',
    '2' => '여성용',
    '3' => '공용',
    '4' => '해당없음',
);

$gs_season = array(
    '1' => '봄',
    '2' => '여름',
    '3' => '가을',
    '4' => '겨울',
    '5' => 'FW',
    '6' => 'SS',
    '7' => '해당없음',
);

$gs_isopen = array(
    "1" =>"진열",
    "2" =>"품절", // 화면에 출력됨
    "3" =>"단종",
    "4" =>"중지" // 화면에 출력되지 않음
);

// 판매지역 delv_able_region 
$gs_region = array(
    "1" =>"전국",
    "2" =>"전국(도서제외)",
    "3" =>"수도권",
    "4" =>"기타",
);

$gs_opt_type = array(
    "1" => "필수",
    "2" => "추가"
);

//비밀글 사용 (게시판)
$bo_use_secret = array(
    "1" => "체크하여 사용",
    "2" => "항상 사용",
    "3" => "미사용"    
);

//글내용 옵션 (게시판)
$bo_content_opt = array(
    "1" => "전체 목록 출력",
    "2" => "이전글 다음글만 출력",
    "3" => "미사용"
);

// 관리자 승인 상태
$adm_stt = array( "1" =>"승인", "2" =>"차단");

$banner = array(
    "1" => array(
        '1'=>'1240px X 120px 배너',
        '2'=>'1240px X 400px 배너',
        '3'=>'1680px X 120px 배너',
        '4'=>'1680px X 650px 배너',
        '5'=>'1920px X 120px 배너',
        '6'=>'1920px X 650px 배너',
        '7'=>'640px X 120px 배너',
        '8'=>'640px X 400px 배너',
    ),
    "2" => array(
        '1'=>'640px X 200px 배너',
        '2'=>'640px X 400px 배너',
        '3'=>'640px X 1000px 배너',
 
    )
);

$template_type = array(
    "1"=>"메일",
    "2"=>"알림톡",
    "3"=>"SMS",
);

// 상품 정렬탭
$gs_sort_tab = array(
    array("index_no", "desc", "신상품"),
    array("readcount",  "desc", "인기상품순"),
    //array("sum_qty",  "desc", "인기상품순"),
    array("goods_price", "asc", "낮은가격순"),
    array("goods_price", "desc", "높은가격순"),
    array("m_count", "desc", "리뷰순"),
    array("dis", "desc", "할인율순")
);

$theme = array("Basic","Fashion","Video","Other");
$mtheme = array("Basic","Fashion","Video","Other");

$qa_type = array(
    '1'=>'상품 문의',
    '2'=>'배송 문의',
    '3'=>'반품/환불/취소 문의',
    '4'=>'교환 문의',
    '5'=>'기타 문의'
);



?>
