<section class="contents" id="main_index">
    <div class="marb40">
        <div class="notice_wrap">
            <div class="board_item">
                <div class="board_title"><span><?=$this->board['bo_name']?><span><img src="/public/img/icon/loud-speaker.png"></div>
                <div class="post_title"><span onclick=winOpen("/Main/notice","noticeBoard","1200px","800px")><?=$this->board['list']['bopo_title']?><span></div>
            </div>
        </div>
    </div>
    <div class="marb40">
        <div class="h2">매출/통계</div>
        <div class="index_wrap">
            <div class="box_wrap box_col4">
                <div class="item_wrap box_col3">
                    <div class="item_title">오늘 주문건</div>
                    <div class="item_data"><span class="number_data"><?=number_format($this->today['od_cnt'])?></span>건</div>
                </div>
                <div class="item_wrap box_col3">
                    <div class="item_title">오늘 매출금액</div>
                    <div class="item_data"><span class="number_data"><?=number_format($this->today['od_amount'])?></span>원</div>
                </div>
            </div>
            <div class="box_wrap box_col2 marl30">
                <div class="item_wrap box_col6">
                    <div class="item_title">매출통계</div>
                    <div style="height:calc(100% - 30px); width:90%; margin:auto">
                        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                        <div id="chart_div" style="height:100%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="marb40">
        <div class="h2">주문/배송/클레임 관리</div>
        <div class="index_wrap">
            <div class="box_wrap box_col6">
                <div class="item_wrap box_col1">
                    <div class="item_title">결제완료</div>
                    <div class="item_data"><span class="number_data"><?=number_format($this->order['pay_cnt'])?></span>건</div>
                </div>
                <div class="item_wrap box_col1">
                    <div class="item_title">상품준비중</div>
                    <div class="item_data"><span class="number_data"><?=number_format($this->order['comp_cnt'])?></span>건</div>
                </div>
                <div class="item_wrap box_col1">
                    <div class="item_title">배송준비</div>
                    <div class="item_data"><span class="number_data"><?=number_format($this->order['ready_cnt'])?></span>건</div>
                </div>
                <div class="item_wrap box_col1">
                    <div class="item_title">배송중</div>
                    <div class="item_data"><span class="number_data"><?=number_format($this->order['delivery_cnt'])?></span>건</div>
                </div>
                <div class="item_wrap box_col1">
                    <div class="item_title">반품</div>
                    <div class="item_data"><span class="number_data"><?=number_format($this->order['return_cnt'])?></span>건</div>
                </div>
                <div class="item_wrap box_col1">
                    <div class="item_title">교환</div>
                    <div class="item_data"><span class="number_data"><?=number_format($this->order['change_cnt'])?></span>건</div>
                </div>
            </div>
        </div>
    </div>
    <div class="marb40">
        <div class="h2">CS현황</div>
        <div class="index_wrap">
            <div class="box_wrap box_col1">
                <div class="item_wrap box_col6">
                    <div class="item_title">상품 문의 미답변</div>
                    <div class="item_data"><span class="number_data"><?=number_format($this->answer['qa_cnt'])?></span>건</div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    google.charts.load('current', {packages: ['corechart', 'line']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var js_array = <?= json_encode(array_values($this->analysis))?>;
        var data = new google.visualization.DataTable();
        data.addColumn('string', '일');
        data.addColumn('number', '주문건수');

        var arr = new Array();
        for (var i=0; i < js_array.length ; i++ ){
            tmp = Object.values(js_array[i]);
            tmp[0] = tmp[0].substr(8,9);
            arr[i] = tmp;
        }
        data.addRows( arr );
        var options = {
            series: {
                0: { color: "<?=_COLOR?>", lineWidth:3 },
                1: { color: "#f29c9f" },
                2: { color: '#f1ca3a' },
                3: { color: '#2980b9' },
                4: { color: '#e67e22' }
            },
            chartArea: {width: '100%'},
            axisTitlesPosition:"none",
            hAxis: {
                textStyle: {
                    fontSize:10,
                }
            },
            vAxis: {
                textStyle: {
                    //fontSize:10,
                    textPosition:'none',
                }
            }
        };
        var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
        chart.draw(data, options);
    }
    $(window).resize(function(){
        drawChart();
    });

    $(function(){
        $(".number_data").each(function(index,el){
            if( $(el).html() <= 0 ){
                $(el).addClass("fc_gray");
            }
        })
    })



</script>
