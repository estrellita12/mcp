<section class="cont_inner">
    <h1 class="pg_tit"> <?=$this->tabInfo['name']?></h1>
    <form>
        <div class="layout01_wrap">
            <div class="layout_inner">
                <div class="rect_wrap">
                    <div class="right_wrap">
                        <!-- <a href="/Member/registerAnalysisExcel?<?=get_qstr("rpp,page")?>" class="btn_excel"> 엑셀저장</a> -->
                    </div>
                </div>
                <div class="chead02_wrap">
                    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                    <div id="chart_div"></div>
                </div>
            </div>
        </div>
    </form>
</section>
<script>
    google.charts.load('current', {packages: ['corechart','bar']});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
        var sl_array = <?= json_encode($this->sl_li)?>;
        var js_array = <?= json_encode(array_values($this->row))?>;
        var data = new google.visualization.DataTable();
        data.addColumn('string', '공급사');
        data.addColumn('number', '누적수수료');
        var arr = new Array();
        for (var i=0; i < js_array.length ; i++ ){
            arr[i] = Object.values(js_array[i]);
            arr[i][0] = String(sl_array[arr[i][0]]);
            arr[i][1] = Number(arr[i][1]);
        }
        data.addRows( arr );
        data.addRows( [['테스트',1000]] );
        var options = {
            hAxis: {
                title: '원',
            },
            vAxis: {
                title: '가맹점'
            }

        };
        var chart = new google.visualization.BarChart(document.getElementById("chart_div"));
        chart.draw(data, options);
    }
</script>
