<?php 
$goodsModel = new \application\models\GoodsModel();
$row = $goodsModel->get("*",array("sl_id"=>$_SESSION['user_id']),true);
print_r($_SESSION);

?>
<section class="contents">
    <h1 class="cont_title">상품 목록</h1>
    <div class="cont_wrap">
        <div class="rhead01_wrap">
            <table>
                <tbody>
                    <colgroup>
                        <col class="w200">
                        <col>
                    </colgroup>
                    <tr>
                        <th>메인</th>
                        <td class="tal">
                            <a href="/mypage/page.php?code=seller_main">/mypage/page.php?code=seller_main</a>
                        </td>
                    </tr>
                    <tr>
                        <th>상품 목록</th>
                        <td class="tal">
                            <a href="/mypage/page.php?code=seller_goods_list">/mypage/page.php?code=seller_goods_list</a>
                        </td>
                    </tr>
                    <tr>
                        <th>상품 등록 FORM</th>
                        <td class="tal">
                            <a href="/mypage/page.php?code=seller_goods_form">/mypage/page.php?code=seller_goods_form</a>
                        </td>
                    </tr>
                    <tr>
                        <th>상품 등록(*)</th>
                        <td class="tal">
                            <a href="/mypage/page.php?code=seller_goods_form_update">/mypage/page.php?code=seller_goods_form_update</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</section>

