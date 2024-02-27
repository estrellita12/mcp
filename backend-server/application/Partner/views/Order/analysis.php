<section class="contents">
    <h1 class="cont_title"> <?=$this->tabPageInfo['name']?></h1>
    <div class="cont_wrap">
        <form action="" method="GET" name="frmSearch" id="frmSearch">
            <div class="search_wrap">
                <table>
                    <colgroup>
                        <col class="w120">
                        <col>
                    </colgroup>
                    <tbody>
                    <tr>
                        <th scope="row">주문일</th>
                        <td>
                            <?=get_search_date('beg','end',get_request("beg"),get_request("end"), false)?>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div class="confirm_wrap">
                    <input type="submit" value="검색" id="fsearch" class="btn_medium btn_theme">
                    <input type="reset" value="초기화" id="freset" class="btn_medium btn_white">
                </div>
            </div>
        </form>
        <form>
            <div class="list_wrap">
                <div class="rect_wrap">
                    <div class="right_wrap">
                        <a href="/Order/analysisExcel?<?=get_qstr("rpp,page")?>" class="btn_excel"> 엑셀저장</a>
                    </div>
                </div>
                <div class="chead02_wrap">
                    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                    <div id="chart_div"></div>
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
    console.log(js_array);
    var data = new google.visualization.DataTable();
    data.addColumn('string', '일');
    data.addColumn('number', '주문건수');

    var arr = new Array();
    for (var i=0; i < js_array.length ; i++ ){
        arr[i] = Object.values(js_array[i]);
    }
    data.addRows( arr );
    var options = {
series: {
0: { color: "<?=_COLOR?>" ,lineWidth:3 },
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
fontSize:14,
           }
       }
    };
    var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
    chart.draw(data, options);
}
</script>
