<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.2/css/jquery.dataTables.css">
<style>
table.dataTable thead th {
  font-weight: 500 !important;
}
#loading{
    position:fixed; 
    z-index:2000;
    background-color:#fff; 
    opacity:0.8; 
    width:calc(100% - 200px); 
    height:calc(100% - 95px); 
    top:95px; left:200px;
    font-size:40px;
    color:#fff;
    text-align:center;
    padding-top:20%;
    box-sizing:border-box;
}
</style>
<section class="contents">
    <div id="loading"><img src="/public/img/loading.gif"></div>
    <h1 class="cont_title"> <?=$this->tabPageInfo['name']?> </h1>
    <div class="cont_wrap">
        <form action="" method="GET" id="frmSearch" name="frmSearch">
            <div class="search_wrap">
                <table>
                    <colgroup>
                        <col class="w140">
                        <col>
                    </colgroup>
                    <tbody>
                    <tr>
                        <th scope="row">상품명</th>
                        <td>
                            <input type="text" name="name" value="" size="30">
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">카테고리</th>
                        <td>
                            <span class="inline w15p"><label><input type="checkbox" name="category" value="골프클럽">골프클럽</label></span>
                            <span class="inline w15p"><label><input type="checkbox" name="category" value="골프의류">골프의류</label></span>
                            <span class="inline w15p"><label><input type="checkbox" name="category" value="골프모자">골프모자</label></span>
                            <span class="inline w15p"><label><input type="checkbox" name="category" value="골프장갑">골프장갑</label></span>
                            <span class="inline w15p"><label><input type="checkbox" name="category" value="골프벨트">골프벨트</label></span>
                            <span class="inline w15p"><label><input type="checkbox" name="category" value="골프백">골프백</label></span>
                            <span class="inline w15p"><label><input type="checkbox" name="category" value="골프화">골프화</label></span>
                            <span class="inline w15p"><label><input type="checkbox" name="category" value="방한용품">방한용품</label></span>
                            <span class="inline w15p"><label><input type="checkbox" name="category" value="필드용품">필드용품</label></span>
                            <span class="inline w15p"><label><input type="checkbox" name="category" value="골프볼">골프볼</label></span>
                            <span class="inline w15p"><label><input type="checkbox" name="category" value="로스트볼">로스트볼</label></span>
                            <span class="inline w15p"><label><input type="checkbox" name="category" value="거리측정기">거리측정기</label></span>
                            <span class="inline w15p"><label><input type="checkbox" name="category" value="골프우산">골프우산</label></span>
                            <span class="inline w15p"><label><input type="checkbox" name="category" value="연습용품">연습용품</label></span>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">A가 가격</th>
                        <td>
                            <input type="text" name="price_a1" value="" size="10">원 이상 ~ <input type="text" name="price_a2" value="" size="10">원 이하
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">B가 가격</th>
                        <td>
                            <input type="text" name="price_b1" value="" size="10">원 이상 ~ <input type="text" name="price_b2" value="" size="10">원 이하
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">C가 가격</th>
                        <td>
                            <input type="text" name="price_c1" value="" size="10">원 이상 ~ <input type="text" name="price_c2" value="" size="10">원 이하
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div class="confirm_wrap">
                    <button type="button" onclick='getFilter(this)' class="btn_medium btn_theme">검색</button>
                </div>
            </div>
        </form>
        <form>
            <div class="list_wrap">
                <!--
                <div class="rect_wrap">
                    <span class="cnt_wrap">
                        검색된 상품 :<b class="cnt"><?= number_format($this->cnt) ?></b>개
                    </span>
                    <span class="rpp_wrap">
                        <select id="rpp" onchange="location='<?=get_query("rpp,page")."&&rpp="?>'+this.value;" >
                            <?= get_frm_rpp( $_REQUEST['rpp'] );?>
                        </select>
                    </span>
                    <span class="right_wrap">
                        <select onchange="getExcelUrl(this)">
                            <option value="/Goods/listExcel?<?=get_qstr("rpp,page")?>">검색 결과</option>
                            <option value="/Goods/bulkEditExcel?<?=get_qstr("rpp,page")?>">일괄 상품 수정</option>
                        </select>
                        <a href="/Goods/listExcel?<?=get_qstr("rpp,page")?>" class="btn_excel" id="getDownload"> 엑셀저장</a>
                    </span>
                </div>
                <div class="btn_wrap">
                    <a href="#" id="wait" class="list_update btn_small btn_line_blue" data-tab="Goods">선택 대기</a>
                </div>
                -->
                <div class="chead02_wrap">
                    <table id="sheets_data"> 
                        <colgroup>
                            <col class="w120">
                            <col class="w120">
                            <col class="w120">
                            <col>
                            <col class="w100">
                            <col class="w100">
                            <col class="w100">
                        </colgroup>
                        <thead> 
                            <th class="w100">이지어드민</th>
                            <th>사방넷</th>
                            <th>카테고리</th>
                            <th>상품명</th>
                            <th>A가</th>
                            <th>B가</th>
                            <th>C가</th>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </form>
    </div>
</section>

<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.js"></script>
<script src="https://cdn.jsdelivr.net/gh/tanaikech/GetAccessTokenFromServiceAccount_js@master/getaccesstokengromserviceaccount_js.min.js"></script>
<!-- <script async defer src="https://accounts.google.com/gsi/client" onload="gisLoaded()"></script> -->
<script async defer src="https://apis.google.com/js/api.js" onload="gapiLoaded()"></script>
<script>
let origin = "";
let table = "";
const object = {
private_key: "-----BEGIN PRIVATE KEY-----\nMIIEvAIBADANBgkqhkiG9w0BAQEFAASCBKYwggSiAgEAAoIBAQCEYD4WFJJZifz2\nuczyZ7v8B+HTrUP0nS51eG73ZuUgTF0X1dMWDZCR5ZU/Us2rTmb9erh/ttgg1F6f\n6UXJ4aLn2E652WILau+uaU8M+eJfsw+LCmiAVZSQ9+FHbeX6OO3yxzJT/+qu3xxK\nVo0NpH8rOGJTdENPysVecPX+spIBfvo3pNfBCf2g/J/fntSW1d6P21XW41pO8VMh\nMdJzCj9CwAR2ce6j+6ZB5kvrI3XwqrA6fr3V6OPt/7uE1YwA2jL6tF4lc0YfxZGS\nvRjRBr8qup6bdlV4n9+4rMeZIra+PLO4GBmJ7wCm75hcAuxu4B/wsDLT6ZFRwXVt\nBS4Nj6+BAgMBAAECggEAQAO8snfTSBqLKpMyUX0pspjrM66j4KyMNYF+hASNw/85\nu5eLIyx/H5a7BGraC7/33ReWFijJPqMEeWdY+OY1HdIETCqcF7JoYtsJP9itiKLy\nXsYzP/BiznIYzq6OGuGh7Bg5NdbZ2iQJrcdKIfFNEA0Nu5bLIFCJ/oA47ajUI4Ve\nlfDtQTWtuqm7KlDMZtP+i5MtFDIvUaf0JB4Gvoq45sqqylm76P+ee/dUWUdGNFtD\nzaEHBoRtKozCKn20biXOIlfJwaSsID8OPeXIxsbWcFu5cRqSdS5cgP8TbmysxOFt\nZkhcLf1k1YgIg8tIBdIryWMw4OdU4xKGuGcDutTC2wKBgQC5Em9hUXoy7sld8mtm\nfI0NNH8Pg+6I8jmSplqUVGxttmnim9Mm5sPgYOcznHos24uuw5YdMrhUMcmNf8gF\nhosI4PfW2pnzFn9KOEz5L0ozyhziITTem3qNTXEfRsq2SwfCD4vSBayzGlw3BnNG\nRTgq9PKD2yY9xZf/VhMMs/RkuwKBgQC3G8D+bv0cWqKVrdL9V5QJohL+R+E4rR29\n1oAP3+oKGHAtiLmevDldSP5I3npwgA+czlq27WMW7CYdnLDmXUa/1IUaY/RqHmJI\nr7vAv11CU2uICf4qRRHjxdS7qNNxQOjwez0N6pTn9ia6TnuU6oo/IaQuJzIMSZpi\nUfqt6wQW8wKBgHnoA8fl5IliMvAYO9iRWFQHbV6p99jrPTM1Mtsb1SRbkNm87NRm\nE0Zcbk7X1r5vi0399YacH0EOXoY/UmEZY8HgdkBnVBsEiao49bL6DHWav3XQi8PK\nRGqJRWdluSdkuuKAXQhlxoFfbrisHgh+leXt3UUveLwdyOZfK0Ml0mj7AoGAFm4T\n6hb2cm6309YDLn136OYtpXBwqlyqdAK+lTM8nBf6Rdmlw0gTTtYOMCbwoK9POkoc\n2qOhq8Epuh7jnJR4gi8qTt1Hp2gpafX87dODPQiy92sh81OaqWgmcwZvQERPRIYU\nKIw/yVphzBipEsjYPnuEfRLYEqFBhCG+r2dGjPkCgYAiVRVvIBqrX3yLG1xLV36L\nXWARF99EGv06W7cPNySVwRkiHYg8uOV3x71iW3wrfr56IPDBQqrfrc8+YfLty+LF\nh75FNlX9UX/RCPppNzIQSFObXxPu46p+Yc2RMJ7Fm7Q+TZRpWz+PWm8hsCPcFnq6\n5VX2DDByMhfAfk9rWsrSqw==\n-----END PRIVATE KEY-----\n",
    client_email: "newbiz@newbz-378501.iam.gserviceaccount.com",
    scopes: ["https://www.googleapis.com/auth/spreadsheets.readonly"],
    };

    const DISCOVERY_DOC = 'https://sheets.googleapis.com/$discovery/rest?version=v4';

    function gapiLoaded() {
        gapi.load('client', initializeGapiClient);
    }   

    async function initializeGapiClient() {
        gapi.auth.setToken(await GetAccessTokenFromServiceAccount.do(object));
        await gapi.client.init({
        //apiKey: API_KEY,
        discoveryDocs: [DISCOVERY_DOC],
        });
        gapiInited = true;
        getData();
    }

    async function getData() {
        let response;
        let range;
        let dataList = [];
        let major = [];
        let mwo = [];

        try {
            response = await gapi.client.sheets.spreadsheets.values.get({
            spreadsheetId: '1gc-fvfQxq_P8LfbUKsI865JIO55XgUUCjeyKmK6S1YM',
                range: '용인메이저!A9:AG'
            });

            range = response.result;
            if (!range || !range.values || range.values.length == 0) {
                console.log("No values found.");
                return;
            }else{
                major = range.values.map((cell)=>{
                    var data = ['','','','','','',''];
                    if(cell[4]){
                        data = [
                            cell[4],
                            only_number(cell[6]),
                            cell[5],
                            cell[11],
                            cell[20],
                            cell[25],
                            cell[26],
                        ]
                    }
                    return data;
                });
                major = major.filter((c)=>c[0].length>3);
            }
        } catch (err) {
            console.log(err.message);
            return;
        }

        try {
            response = await gapi.client.sheets.spreadsheets.values.get({
            spreadsheetId: '1gc-fvfQxq_P8LfbUKsI865JIO55XgUUCjeyKmK6S1YM',
                range: 'MWO공급사!A4:AK'
            });

            range = response.result;
            if (!range || !range.values || range.values.length == 0) {
                console.log("No values found.");
                return;
            }else{
                mwo = range.values.map((cell)=>{
                    var data = ['','','','','','',''];
                    if(cell[13]){
                        data[0] = cell[6];
                        data[1] = only_number(cell[8]);
                        data[2] = cell[33]?cell[33]:'';
                        data[3] = cell[13]?cell[13]:'';
                        data[4] = cell[26]?cell[26]:0;
                        data[5] = cell[27]?cell[27]:0;
                        data[6] = cell[28]?cell[28]:0;
                    }
                    return data;
                });
                mwo = mwo.filter((c)=>c[3].length>0);
            }
        } catch (err) {
            console.log(err.message);
            return;
        }
        dataList = major.concat(mwo);
        table = $('#sheets_data').dataTable({
            data:dataList,

        });
        $("#loading").css("display","none");
    }

    function getFilter(){
        let selectedName = $("input[name='name']").val();
        selectedName = selectedName.split(" ");

        const selectedCategory = [];
        $("input[name='category']:checked").each(function(){
            var checkVal = $(this).val();
            selectedCategory.push(checkVal);
        });

        const price_a1 = parseInt($("input[name='price_a1']").val());
        const price_a2 = parseInt($("input[name='price_a2']").val());
        const price_b1 = parseInt($("input[name='price_b1']").val());
        const price_b2 = parseInt($("input[name='price_b2']").val());
        const price_c1 = parseInt($("input[name='price_c1']").val());
        const price_c2 = parseInt($("input[name='price_c2']").val());

        const output = origin.filter((cell)=>{
        if( !!selectedName && selectedName.length != 0 ){
            const name = cell[3];
            for( let i = 0;i<selectedName.length;i++ ){
                if( !name.includes(selectedName[i]) ) return false;
                }
            }

            if( !!selectedCategory && selectedCategory.length != 0 ){
                const category = cell[2];
                if( selectedCategory.indexOf(category) < 0 ) return false;
            }

            if( !!price_a1 || !!price_a2 ){
                const price_a = parseInt(only_number(cell[4]));
                if( !price_a ) return false;
                if( !!price_a1 && price_a < price_a1 ) return false;   
                if( !!price_a2 && price_a > price_a2 ) return false;   
            }

            if( !!price_b1 || !!price_b2 ){
                const price_b = parseInt(only_number(cell[5]));
                if( !price_b ) return false;
                if( !!price_b1 && price_b < price_b1 ) return false;   
                if( !!price_b2 && price_b > price_b2 ) return false;   
            }

            if( !!price_c1 || !!price_c2 ){
                const price_c = parseInt(only_number(cell[6]));
                if( !price_c ) return false;
                if( !!price_c1 && parseInt(price_c) < price_c1 ) return false;   
                if( !!price_c2 && parseInt(price_c) > price_c2 ) return false;   
            }


           return true;
        })
        table.fnDestroy();
        table = $('#sheets_data').dataTable({
            data:output
        });
    }
</script>

