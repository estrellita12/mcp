<section class="main_inner" style="margin:auto">
    <div class="fixed-clear">
        <div class="rhead01_wrap fl" style="width:600px">
            <div class="h2">주문관리</div>
            <table> 
                <colgroup>
                    <col>
                    <col>
                    <col>
                    <col>
                    <col>
                    <col>
                </colgroup>
                <tbody>
                    <tr>
                        <th scope="row">입금대기</th>
                        <td><?=number_format($this->list['vbankCnt'])?> 건</td>
                        <th scope="row">결제완료</th>
                        <td><?=number_format($this->list['payCnt'])?> 건</td>
                        <th scope="row">배송준비</th>
                        <td><?=number_format($this->list['readyCnt'])?> 건</td>
                        <th scope="row">배송중</th>
                        <td><?=number_format($this->list['deliveryCnt'])?> 건</td>
                    </tr>
                    <tr>
                        <th scope="row">교환신청<br>/교환접수</th>
                        <td><?=number_format($this->list['changeCnt'])?> 건</td>
                        <th scope="row">반품신청<br>/반품접수</th>
                        <td><?=number_format($this->list['returnCnt'])?> 건</td>
                        <th scope="row">취소신청<br>/취소완료</th>
                        <td><?=number_format($this->list['cancelCnt'])?> 건</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="rhead01_wrap fl marl20" style="width:300px">
            <div class="h2">문의/답변관리</div>
            <table>
                <colgroup>
                    <col>
                    <col>
                </colgroup>
                <tbody>
                    <tr>
                        <th scope="row">상품문의</th>
                        <td class="tar"><?=number_format(0)?> 건</td>
                    </tr>
                    <tr>
                        <th scope="row">1:1문의</th>
                        <td class="tar"><?=number_format(0)?> 건</td>
                    </tr>
                    <tr>
                        <th scope="row">상품후기</th>
                        <td class="tar"><?=number_format(0)?> 건</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="fixed-clear">
        <div class="rhead01_wrap fl" style="width:calc(33.3% - 20px)">
            <div class="h2">공지사항</div>
            <table>
                <tbody>
                    <tr>
                        <td>출시안내</td>
                    </tr>
                    <tr>
                        <td>출시안내</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="rhead01_wrap fl marl20" style="width:calc(33.3% - 20px)">
            <div class="h2">공급사 공지사항</div>
            <table>
                <tbody>
                    <tr>
                        <td>출시안내</td>
                    </tr>
                    <tr>
                        <td>출시안내</td>
                    </tr>
                </tbody>
            </table>
        </div>
 
        <div class="rhead01_wrap fl marl20" style="width:calc(33.3% - 20px)">
             <div class="h2">가맹점 공지사항</div>
            <table>
                <tbody>
                    <tr>
                        <td>출시안내</td>
                    </tr>
                    <tr>
                        <td>출시안내</td>
                    </tr>
                </tbody>
            </table>
        </div>
 
    </div>
</section>
