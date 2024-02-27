<section class="contents">
    <h1 class="cont_title"> <?=$this->tabPageInfo['name'];?> </h1>
    <p class="cont_info">
    <div class="cont_wrap">
        <form action="" method="GET" name="frmSearch" id="frmSearch">
            <div class="search_wrap">
                <table>
                    <colgroup>
                        <col class="w140">
                        <col>
                    </colgroup>
                    <tbody>
                    <tr>
                        <th>주문일</th>
                        <td>
                            <?=get_search_date('beg','end',isset($_REQUEST['beg'])?$_REQUEST['beg']:"",isset($_REQUEST['end'])?$_REQUEST['end']:"", false)?>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div class="confirm_wrap">
                    <input type="submit" value="검색" class="btn_medium btn_theme">
                    <input type="reset" value="초기화" id="frmRest" class="btn_medium btn_white">
                </div>
            </div>
        </form>
        <form>
            <div class="list_wrap">
                <div class="rect_wrap">
                    <span class="right_wrap">
                        <a href="/Partner/orderDailyAnalysisExcel?<?=get_qstr("rpp,page")?>" class="btn_excel"> 엑셀저장</a>
                    </span>
                </div>
                <div class="chead02_wrap">
                    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                    <div id="chart_div" style="height:100%"></div>
                </div>
            </div>
        </form>
    </div>
</section>
<script>
google.charts.load('current', {packages: ['corechart', 'line']});
google.charts.setOnLoadCallback(drawChart);

function drawChart() {
    var js_array = <?= json_encode(array_values($this->row))?>;
    var pt_li = Object.keys(js_array[0]);
    var data = new google.visualization.DataTable();
    data.addColumn('string', '일');
    for(var i=1;i<pt_li.length;i++){
        data.addColumn('number', pt_li[i]);
    }
    var arr = new Array();
    for (var i=0; i < js_array.length ; i++ ){
        tmp = Object.values(js_array[i]);
        tmp[0] = tmp[0].substr(5,9);
        arr[i] = tmp;
    }
    data.addRows( arr );
    var options = {
    series: {
    0: { color: "<?=_COLOR?>", lineWidth:3 },
        1: { color: "#f29c9f", lineWidth:3 },
        2: { color: '#f1ca3a', lineWidth:3  },
        3: { color: '#2980b9', lineWidth:3 },
        4: { color: '#e67e22', lineWidth:3 }
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

</script>
