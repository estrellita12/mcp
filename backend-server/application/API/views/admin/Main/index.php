<section class="cont_inner">
    <div class="chead01_wrap">
        <h2>최근 7일 주문통계</h2>
        <table>
            <colgroup>
                <col>
                <col>
                <col>
            </colgroup>
            <thead>
                <tr>
                    <th scope="col">총 주문건수</th>
                    <th scope="col">총 주문갯수</th>
                    <th scope="col">총 주문액</th>
                </tr>
            </thead>
            <tbody>
            <?php 
            $date = date("Y-m-d", strtotime("-7 day"));
            $row = $this->query->getRow("web_order"," count(distinct od_id) as cnt , sum(sum_qty) as qty, sum(use_price) as price  "," and left(od_time,10) > '$date' " ) ?>
            <tr>
                <td><?=number_format($row['cnt'])?></td>
                <td><?=number_format($row['qty'])?></td>
                <td><?=number_format($row['price'])?></td>
            </tr>
            </tbody>
        </table>
    </div>
    <div class="chead01_wrap">
        <h2>최근 주문 내역</h2>
        <table>
            <colgroup>
                <col>
                <col>
                <col>
                <col>
                <col>
                <col>
                <col>
                <col>
            </colgroup>
            <thead>
                <tr>
                    <th scope="col">주문번호</th>
                    <th scope="col">주문자명</th>
                    <th scope="col">전화번호</th>
                    <th scope="col">메일</th>
                    <th scope="col">결제방법</th>
                    <th scope="col">총주문액</th>
                    <th scope="col">총결제액</th>
                    <th scope="col">주문일시</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($this->query->getRowAll("web_order","*",""," order by od_time desc "," limit 5 " ) as $row ){ ?>
            <tr>
                <td><?=$row['od_id']?></td>
                <td><?=$row['name']?></td>
                <td><?=$row['cellphone']?></td>
                <td><?=$row['email']?></td>
                <td><?=$row['paymethod']?></td>
                <td><?=number_format($row['goods_price'])?>원</td>
                <td><?=number_format($row['use_price'])?>원</td>
                <td><?=$row['od_time']?></td>
            </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
    <div class="chead01_wrap">
        <h2>최근 회원 가입</h2>
        <table>
            <colgroup>
                <col>
                <col>
                <col>
                <col>
                <col>
                <col>
            </colgroup>
            <thead>
                <tr>
                    <th scope="col">이름</th>
                    <th scope="col">아이디</th>
                    <th scope="col">전화번호</th>
                    <th scope="col">메일</th>
                    <th scope="col">가맹점</th>
                    <th scope="col">가입일시</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($this->query->getRowAll("web_member","*",""," order by reg_date desc "," limit 5 " ) as $row ){ ?>
            <tr>
                <td><?=$row['name']?></td>
                <td><?=$row['id']?></td>
                <td><?=$row['cellphone']?></td>
                <td><?=$row['email']?></td>
                <td><?=$this->partner->getName($row['pt_id'])?></td>
                <td><?=$row['reg_date']?></td>
            </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</section>
