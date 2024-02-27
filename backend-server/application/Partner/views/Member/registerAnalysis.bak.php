<section class="cont_inner">
    <h1 class="pg_tit"> <?=$this->tabInfo['name']?></h1>
    <form action="" method="GET">
        <div class="search_wrap">
            <table>
                <colgroup>
                    <col class="w120">
                    <col>
                </colgroup>
                <tbody>
                    <tr>
                        <th scope="row">가맹점</th>
                        <td>
                            <select name="shop" class="w130">
                                <?= get_frm_option('', isset($_REQUEST['shop'])?$_REQUEST['shop']:"", '전체'); ?>
                                <?php foreach($this->pt_li as $key=>$value){ ?>
                                <?= get_frm_option($key, isset($_REQUEST['shop'])?$_REQUEST['shop']:"", $value); ?>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">가입일</th>
                        <td>
                            <input type="hidden" name="term" value="regdt">
                            <?=get_search_date('beg','end',isset($_REQUEST['beg'])?$_REQUEST['beg']:"",isset($_REQUEST['end'])?$_REQUEST['end']:"")?>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="confirm_wrap">
                <input type="submit" value="검색" id="fsearch" class="btn_medium btn_black">
                <input type="reset" value="초기화" id="freset" class="btn_medium btn_gray">
            </div>
        </div>
    </form>
    <form>
        <div class="layout01_wrap">
            <div class="layout_inner">
                <div class="rect_wrap">
                    <div class="right_wrap">
                        <a href="/Member/registerAnalysisExcel?<?=get_qstr("rpp,page")?>" class="btn_excel"> 엑셀저장</a>
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
/*
    google.charts.load("current", {packages:["bar"]});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
        var js_array = <?= json_encode(array_values($this->row))?>;
        var data = new google.visualization.DataTable();
        data.addColumn('string', '일');
        <?php foreach($this->pt_li as $key=>$value){ ?>
            data.addColumn('number', '<?=$value?>');
            <?php }?>

        var arr = new Array();
        for (var i=0; i < js_array.length ; i++ ){
            arr[i] = Object.values(js_array[i]);
        }
        data.addRows( arr );

        var options = {
            bars: 'horizontal',
            isStacked: true,
            height: i*25,
            hAxis: {
                title:'명',
                minValue : 0,
            }
        };
        var chart = new google.charts.Bar(document.getElementById('chart_div'));
        chart.draw(data, google.charts.Bar.convertOptions(options));
    }
*/
</script>
