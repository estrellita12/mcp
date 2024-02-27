function getExcelUrl(obj) {
    var url = $(obj).val();
    $("#getDownload").attr("href", url);
}

/*
function checking_showYn(){
    if ($("input:checkbox[name=showYnChk]").is(":checked")) {
        $("#showYn").val("y");
    } else {
        $("#showYn").val("n");
    }
};
*/

function chkData(id) {
    if ($("input:checkbox[name=" + id + "Chk]").is(":checked")) {
        $("#" + id).val("y");
    } else {
        $("#" + id).val("n");
    }
}

/*
function chkListClick(obj) {
    name = $(obj).attr("name");

    if ($(obj).val() == "") {
        name += "[]";
        $('input[name="' + name + '"]').prop("checked", false);
        $(this).prop("checked", true);
    } else {
        name = $(this).attr("name");
        name = name.slice(0, -2);
        $('input[name="' + name + '"][value=""]').prop("checked", false);
    }
}
*/

function chkListClick(obj) {
    let name = $(obj).attr("name");
    const res = $(obj).is(":checked");
    const value = $(obj).val();

    if (value == "" || value=="all") {
        if (res) {
            $('input[name="' + name + '"]').prop("checked", true);
        } else {
            $('input[name="' + name + '"]').prop("checked", false);
        }
    } else if (value != "") {
        let flag = "";
        if (res) {
            flag = true;
            $('input[name="' + name + '"]').each(function (inx, el) {
                if ($(el).val() != "") {
                    if (!$(el).is(":checked")) flag = false;
                }
            });
        } else {
            flag = false;
        }
        name = name.slice(0, -2);
        $("#" + name).prop("checked", flag);
    }
}

// 날짜계산
function formatDate(date) {
    var mymonth = date.getMonth() + 1;
    var myweekday = date.getDate();
    return (
        date.getFullYear() +
        "-" +
        (mymonth < 10 ? "0" : "") +
        mymonth +
        "-" +
        (myweekday < 10 ? "0" : "") +
        myweekday
    );
}

function searchDate(fr_date, to_date, today) {
    if (today == "오늘") {
        var obj1 = document.getElementById(fr_date);
        var obj2 = document.getElementById(to_date);
        var mydate = new Date();
        mydate.setDate(mydate.getDate());

        obj1.value = formatDate(mydate);
        if (obj2 != null) {
            obj2.value = obj1.value;
        }
    } else if (today == "어제") {
        var obj1 = document.getElementById(fr_date);
        var obj2 = document.getElementById(to_date);
        var mydate = new Date();
        mydate.setDate(mydate.getDate() - 1);

        obj1.value = formatDate(mydate);
        if (obj2 != null) {
            obj2.value = obj1.value;
        }
    } else if (today == "이번주") {
        var obj1 = document.getElementById(fr_date);
        var obj2 = document.getElementById(to_date);

        var now = new Date();
        var nowDayOfWeek = now.getDay();
        var nowDay = now.getDate();
        var nowMonth = now.getMonth();
        var nowYear = now.getYear();
        nowYear += nowYear < 2000 ? 1900 : 0;
        var weekStartDate = new Date(nowYear, nowMonth, nowDay - nowDayOfWeek);
        var weekEndDate = new Date(
            nowYear,
            nowMonth,
            nowDay + (6 - nowDayOfWeek)
        );

        obj1.value = formatDate(weekStartDate);
        obj2.value = formatDate(weekEndDate);
    } else if (today == "이번달") {
        var obj1 = document.getElementById(fr_date);
        var obj2 = document.getElementById(to_date);

        var now = new Date();
        var nowDayOfWeek = now.getDay();
        var nowDay = now.getDate();
        var nowMonth = now.getMonth();
        var nowYear = now.getYear();
        nowYear += nowYear < 2000 ? 1900 : 0;

        var monthStarDate = new Date(nowYear, nowMonth, nowDay - nowDay + 1);
        var monthEndDate = new Date(nowYear, nowMonth, nowDay);

        obj1.value = formatDate(monthStarDate);
        obj2.value = formatDate(monthEndDate);
    } else if (today == "일주일") {
        var obj1 = document.getElementById(fr_date);
        var obj2 = document.getElementById(to_date);
        var mydate = new Date();

        mydate.setDate(mydate.getDate() - 7);
        obj1.value = formatDate(mydate);
        obj2.value = formatDate(new Date());
    } else if (today == "1개월") {
        var obj1 = document.getElementById(fr_date);
        var obj2 = document.getElementById(to_date);
        var mydate = new Date();
        mydate.setDate(mydate.getDate() - 30);

        obj1.value = formatDate(mydate);
        obj2.value = formatDate(new Date());
    } else if (today == "2개월") {
        var obj1 = document.getElementById(fr_date);
        var obj2 = document.getElementById(to_date);
        var mydate = new Date();
        mydate.setDate(mydate.getDate() - 60);

        obj1.value = formatDate(mydate);
        obj2.value = formatDate(new Date());
    } else if (today == "3개월") {
        var obj1 = document.getElementById(fr_date);
        var obj2 = document.getElementById(to_date);

        var mydate = new Date();
        mydate.setDate(mydate.getDate() - 90);

        obj1.value = formatDate(mydate);
        obj2.value = formatDate(new Date());
    } else if (today == "이번달") {
        var obj1 = document.getElementById(fr_date);
        var obj2 = document.getElementById(to_date);

        var d2, d3;
        var now = new Date();
        var nowYear = now.getYear();
        nowYear += nowYear < 2000 ? 1900 : 0;

        d2 = new Date(nowYear, now.getMonth());
        d3 = new Date(nowYear, now.getMonth() + 1, "");

        obj1.value = formatDate(d2);
        obj2.value = formatDate(d3);
    } else if (today == "지난달") {
        var obj1 = document.getElementById(fr_date);
        var obj2 = document.getElementById(to_date);

        var d2, d3;
        var now = new Date();
        var nowYear = now.getYear();
        nowYear += nowYear < 2000 ? 1900 : 0;

        d2 = new Date(nowYear, now.getMonth() - 1);
        d3 = new Date(nowYear, now.getMonth(), "");

        obj1.value = formatDate(d2);
        obj2.value = formatDate(d3);
    } else if (today == "6개월") {
        var obj1 = document.getElementById(fr_date);
        var obj2 = document.getElementById(to_date);

        var mydate = new Date();
        mydate.setDate(mydate.getDate() - 180);

        obj1.value = formatDate(mydate);
        obj2.value = formatDate(new Date());
    } else if (today == "전체") {
        var obj1 = document.getElementById(fr_date);
        var obj2 = document.getElementById(to_date);
        obj1.value = "";
        obj2.value = "";
    }
}

// 팝업 중앙에 띄우기
function winOpen(url, name, w, h, scroll) {
    var pwin = null;
    LeftPosition = screen.width ? (screen.width - w) / 2 : 0;
    TopPosition = screen.height ? (screen.height - h) / 2 : 0;
    settings =
        "height=" +
        h +
        ",width=" +
        w +
        ",top=" +
        TopPosition +
        ",left=" +
        LeftPosition +
        ",scrollbars=" +
        scroll +
        ",resizable=no";
    pwin = window.open(url, name, settings);
}

// 5자리 우편번호 도로명 우편번호 창
function winZip(frm_name, frm_zip, frm_addr1, frm_addr2, frm_addr3) {
    var url =
        "/Popup/kakaoAddr?frm_name=" +
        frm_name +
        "&frm_zip=" +
        frm_zip +
        "&frm_addr1=" +
        frm_addr1 +
        "&frm_addr2=" +
        frm_addr2 +
        "&frm_addr3=" +
        frm_addr3;
    winOpen(url, "winZip", "483", "600", "yes");
}

function comma(str) {
    str = String(str);
    return str.replace(/(\d)(?=(?:\d{3})+(?!\d))/g, "$1,");
}

function uncomma(str) {
    var op = "";
    if (str.substr(0, 1) == "-") op = "-";
    str = String(str);
    return op + str.replace(/[^\d]+/g, "");
}
function only_number(str) {
    str = String(str);
    return str.replace(/[^\d]+/g, "");
}

/*
function inputNumberFormat(obj) {
obj.value = comma(uncomma(obj.value));
}

function inputOnlyNumberFormat(obj) {
obj.value = onlynumber(uncomma(obj.value));
}
*/

function isId(value) {
    var regExp = /^[a-zA-Z0-9-_]{5,19}$/g;
    return regExp.test(value);
}

function isPassword(value) {
    var regExp =
        /^(?=.*[a-zA-z])(?=.*[0-9])(?=.*[$`~!@$!%*#^?&\\(\\)\-_=+]).{8,16}$/;
    return regExp.test(value);
}

function isEmail(value) {
    var regExp =
        /^[0-9a-zA-Z]([-_\.]?[0-9a-zA-Z])*@[0-9a-zA-Z]([-_\.]?[0-9a-zA-Z])*\.[a-zA-Z]{2,3}$/i;
    return regExp.test(value);
}

function isCellphone(value) {
    var regExp = /^01(?:0|1|[6-9])-(?:\d{3}|\d{4})-\d{4}$/;
    return regExp.test(value);
}

function setCellphone(value) {
    return value
        .replace(/[^0-9]/g, "")
        .replace(/^(\d{0,3})(\d{0,4})(\d{0,4})$/g, "$1-$2-$3")
        .replace(/(\-{1,2})$/g, "");
}

function checkAll(f) {
    var chk = document.getElementsByName("chk[]");
    for (i = 0; i < chk.length; i++){
        if( !chk[i].disabled && !chk[i].readOnly )
            chk[i].checked = f.chkall.checked;
    }
}

function frmCommaSubmit() {
    $(".comma").each(function () {
        data = uncomma($(this).val());
        $(this).val(data);
    });
    return true;
}

function reloadArea(url) {
    /*
    //$('.chead01_wrap > table').load(url+' .chead01_wrap > table > *');
    $(".chead01_wrap").load(url + " .chead01_wrap > *", function () {
        $(".chead01_wrap table").colResizable({
            liveDrag: true,
            resizeMode: "overflow",
            disabledColumns: [0],
            minWidth: 40,
        });

        if (typeof ready == "function") {
            ready();
        }
    });
    */
    $(".pg_wrap").load(url + " .pg_wrap > .pg");
    history.pushState(null, null, url);
    $(".chead01_wrap").load(url + " .chead01_wrap > *", function () {
        $(".chead01_wrap table").colResizable({
            liveDrag: true,
            resizeMode: "overflow",
            disabledColumns: [0],
            minWidth: 40,
        });
        dragtable.reset();
        if (typeof ready == "function") {
            ready();
        }
    });

    $("#reload_wrap table ").load(url + " #reload_wrap table > *", function () {
        if (typeof ready == "function") {
            ready();
        }
    });
}

function d_msg(title, content, mod = "confirm") {
    return new Promise((resolve) => {
        const chk_span = document.getElementById("dialog-span");
        if (!chk_span) {
            const d_div = document.createElement("div");
            const d_p = document.createElement("p");
            const d_span = document.createElement("span");
            d_div.setAttribute("id", "dialog-confirm");
            d_div.setAttribute("title", title);
            d_span.setAttribute("id", "dialog-span");
            d_span.innerHTML = content;
            d_p.appendChild(d_span);
            d_div.appendChild(d_p);
            document.body.appendChild(d_div);
        } else {
            chk_span.innerHTML = content;
        }

        const option = {
            resizable: false,
            height: "auto",
            width: 400,
            modal: true,
            buttons: {
                확인: function () {
                    $(this).dialog("close");
                    $(this).remove();
                    resolve(true);
                },
                취소: function () {
                    $(this).dialog("close");
                    $(this).remove();
                    resolve(false);
                },
            },
        };

        if (mod == "alert") delete option.buttons["취소"];
        $("#dialog-confirm").dialog(option);
    });
}

//모달창으로 결과 알람 받는 페이지 초기 실행 함수
function respond_alert(target, origin_url) {
    const now_url = new URL(window.location.href);
    const urlParams = now_url.searchParams;
    const act = urlParams.get("act");
    const res = urlParams.get("res");
    if (act && res) {
        let act_word = "";
        if (act == "u") {
            act_word = "수정";
        } else if (act == "r") {
            act_word = "등록";
        } else if (act == "d") {
            act_word = "삭제";
        }
        let result_word = res == "s" ? "성공" : "실패";
        d_msg(
            "알람",
            `${target} ${act_word}에 ${result_word}하였습니다.`,
            (mod = "alert")
        );
    }
    history.pushState(null, null, origin_url);
}

function trDel(obj) {
    $(obj).closest("tr").remove();
}


function apiTypeList(obj){
    var str = "";
    var type = $(obj).val();
    var col =  $(obj).data('col') ;
    var value = "";
    switch(type){
        case "goods":
            str+= "<select name='mainLayoutApiCol[]' class='w100'>";
            str += "<option value='col=gs_order_qty&colby=desc&rpp=12' "+(col=='col=gs_order_qty&colby=desc&rpp=12'?"selected":"")+">인기상품</option>";
            str += "<option value='col=gs_reg_dt&colby=desc&rpp=12' "+(col=='col=gs_reg_dt&colby=desc&rpp=12'?"selected":"")+">신상품</option>";
            str += "<option value='type=1' "+(col=='type=1'?"selected":"")+">메뉴1</option>";
            str += "<option value='type=2' "+(col=='type=2'?"selected":"")+">메뉴2</option>";
            str+= "</select>"
                break;
        case "banner":
            str+= "<select name='mainLayoutApiCol[]' class='w100'>";
            str += "<option value='position=2' "+(col=='type=1'?"selected":"")+">메인 중간 배너</option>";
            str+= "</select>"
                break;
        case "media":
            str+= "<select name='mainLayoutApiCol[]' class='w100'>";
            value = "media_type=1"; 
            str += "<option value='"+value+"' "+(col==value?"selected":"")+">Shorts 미디어</option>";
            value = "media_type=2"; 
            str += "<option value='"+value+"' "+(col==value?"selected":"")+">기본 미디어</option>";
            str+= "</select>"
                break;
        case "plan":
            str += "<input type='text' name='mainLayoutApiCol[]' value='' size='4' class='w100' readonly>";
            break;
        default:
            str += "<input type='text' name='mainLayoutApiCol[]' value='"+col+"' size='4' class='w100'>";
    }
    $(obj).next().html(str);
}

function mainLayoutAdd(){
    var str = "<tr>";
    str += "<td><input type=\"text\" name=\"mainLayoutTitle[]\" placeholder=\"이름\" class=\"w100p\"></td>";
    str += "<td><input type=\"text\" name=\"mainLayoutUrl[]\" placeholder=\"연결 링크 주소\" class=\"w100p\"></td>";
    str += "<td>";
    str += "<select type=\"text\" name=\"mainLayoutApiUrl[]\" placeholder=\"연결 링크 주소\" class=\"w100 api-type\" onchange=\"apiTypeList(this)\">";
    str += "<option value=\"goods\">상품</option>";
    str += "<option value=\"banner\">배너</option>";
    str += "<option value=\"plan\">기획전</option>";
    str += "<option value=\"media\">미디어</option>";
    str += "<option value=\"board\">게시판</option>";
    str += "</select>";
    str += "<span class=\"w100\">";
    str+= "<select name='mainLayoutApiCol[]' class='w100'>";
    str += "<option value='col=gs_order_qty&rpp=12' >인기상품</option>";
    str += "<option value='col=gs_reg_dt&rpp=12' >신상품</option>";
    str += "<option value='type=1' >메뉴1</option>";
    str += "<option value='type=2' >메뉴2</option>";
    str += "</span>";
    str += "</td>";
    str += "<td>";
    str += "<select type=\"text\" name=\"mainLayoutType[]\" class=\"w100p\">";
    str += "<option value=\"1\">고정 레이아웃</option>";
    str += "<option value=\"2\">스와이프 레이아웃</option>";
    str += "</select>";
    str += "</td>";
    str += "<td>";
    str += "<select type=\"text\" name=\"mainLayoutDesign[]\" class=\"w100p\">";
    str += "<option value=\"1\">이미지형</option>";
    str += "<option value=\"2\">이미지+타이틀형</option>";
    str += "<option value=\"3\">이미지+타이틀+상품형</option>";
    str += "</select>";
    str += "</td>";
    str += "<td><input type=\"number\" name=\"mainLayoutCnt[]\" class=\"w40\"><input type=\"number\" name=\"mainLayoutRpp[]\" class=\"w40\"></td>";
    str += "<td><input type=\"number\" name=\"mainLayoutMCnt[]\" class=\"w40\"><input type=\"number\" name=\"mainLayoutMRpp[]\" class=\"w40\"></td>";
    str += "</tr>";
    $("#main_sortable").append(str);
}

