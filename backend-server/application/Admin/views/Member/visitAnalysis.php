<div id="contents">
    <div class="pg_header">
        <p class="pg_nav">홈<span class="rangle">＞</span><?=$preMenu['name'];?></p>
    </div>
    <section class="cont_inner">
        <h1 class="pg_tit"> <?=$preMenu['name']?></h1>
        <form action="" method="GET">
            <input type="hidden" name="search" id="search">
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
                                <?= get_frm_option('', $_REQUEST['shop'], '전체'); ?>
                                <?php foreach($this->pt_li as $key=>$value){ ?>
                                <?= get_frm_option($key, $_REQUEST['shop'], $value); ?>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">접속일</th>
                        <td>
                            <input type="hidden" name="term" value="regdt">
                            <?=get_search_date('beg','end',$_REQUEST['beg'],$_REQUEST['end'])?>
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
                        <a href="/Member/visitExcel?<?=get_qstr("rpp,page")?>" class="btn_excel">엑셀저장</a>
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
</div>
<script>
google.charts.load('current', {packages: ['corechart', 'line']});
google.charts.setOnLoadCallback(drawBackgroundColor);

function drawBackgroundColor() {
    var data = new google.visualization.DataTable();
    data.addColumn('number', 'X');
    data.addColumn('number', '킬딜');

    data.addRows([
        [0, 0],   [1, 10],  [2, 23],  [3, 17],  [4, 18],  [5, 9],
        [6, 11],  [7, 27],  [8, 33],  [9, 40],  [10, 32], [11, 35],
        [12, 30], [13, 40], [14, 42], [15, 47], [16, 44], [17, 48],
        [18, 52], [19, 54], [20, 42], [21, 55], [22, 56], [23, 57],
        [24, 60], [25, 50], [26, 52], [27, 51], [28, 49], [29, 53],
        [30, 55], [31, 60], [32, 61], [33, 59], [34, 62], [35, 65],
        [36, 62], [37, 58], [38, 55], [39, 61], [40, 64], [41, 65],
        [42, 63], [43, 66], [44, 67], [45, 69], [46, 69], [47, 70],
        [48, 72], [49, 68], [50, 66], [51, 65], [52, 67], [53, 70],
        [54, 71], [55, 72], [56, 73], [57, 75], [58, 70], [59, 68],
        [60, 64], [61, 60], [62, 65], [63, 67], [64, 68], [65, 69],
        [66, 70], [67, 72], [68, 75], [69, 80]
      ]);

    var options = {
    hAxis: {
    title: '일별'
        },
        vAxis: {
        title: '접속자(명)'
        }
      };

      var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
      chart.draw(data, options);
    }
</script>
