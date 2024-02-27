(function ($) {
    $.fn.ctg_select_box = function (selectID, cnt, url, emptyText) {
        return this.each(function (index, domEle) {
            $(this).change(function (event) {
                var thisID = event.currentTarget.id; // #ctgCode1    // 변경되는 select의 ID값
                var selectPanel = parseInt(thisID.substr(selectID.length - 1, 1)) + 1; // 2            // 변경되는 select의 다음 select의 ID번호
                var targetID = selectID + selectPanel; // #ctgCode2    // 변경할 select의 ID값
                var code = $(this).val();
                code = Array.isArray(code) ? code[0] : code; // select가 multiple인 경우, 배열이 넘어올 수 있음
                var parameters = { depth: selectPanel, upper: code };
                var tmpID = "";

                $(selectID).val(code);
                if (typeof changeData == "function") changeData(code);
                postCallback = function (data) {
                    if (emptyText != "" && emptyText != null) {
                        for (var i = selectPanel; i <= cnt; i++) {
                            tmpID = selectID + i;
                            $(tmpID).html('<option value="">' + emptyText + "</option>");
                        }
                    }
                    data = eval(data);
                    if (data != "" && data != null) {
                        $(targetID).html("");
                        var k = 1;
                        for (var j = 0; j < data.length; j++) {
                            if (j == 0 && emptyText != "" && emptyText != null) {
                                $(targetID)
                                    .get(0)
                                    .add(new Option(emptyText, ""), document.all ? j : null);
                            }
                            k = k + j;

                            $("<option/>", {
                                text: data[j]["optionText"],
                                value: data[j]["optionValue"],
                                data: {
                                    flag: data[j]["flag"],
                                    mallName: data[j]["mallName"],
                                },
                            }).appendTo(targetID);
                        }
                    }
                };
                if (url) {
                    $.post(url, parameters, postCallback);
                }
            });
        });
    };
})(jQuery);

// 날짜검색
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
        var weekEndDate = new Date(nowYear, nowMonth, nowDay + (6 - nowDayOfWeek));

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

$(function () {
    console.log("ready!");
    // 검색폼 초기화
    $("#freset").on("click", function () {
        $("input", "#fsearch")
            .not(":submit, :reset, :hidden, :button")
            .val("")
            .removeAttr("checked")
            .removeAttr("selected");
    });

    $("#fexcel").on("click", function () {
        var idx = "";
        var chk_list = new Array();
        var $el_chk = $("input[name='chk[]']");

        $el_chk.each(function (index) {
            if ($(this).is(":checked")) {
                chk_list.push($("input[name='idxl[" + index + "]']").val());
            }
        });

        if (chk_list.length > 0) {
            idx = chk_list.join();
        }

        if (idx == "") {
            alert("처리할 자료를 하나 이상 선택해 주십시오.");
            return false;
        } else {
            var table = $(this).attr("data-file");
            //this.href = "/Excel/"+table+"/"+idx;
            this.href = table + "/" + idx;
            return true;
        }
    });
});

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
    str = String(str);
    return str.replace(/[^\d]+/g, "");
}

function onlynumber(str) {
    str = String(str);
    return str.replace(/(\d)(?=(?:\d{3})+(?!\d))/g, "$1");
}

function inputNumberFormat(obj) {
    obj.value = comma(uncomma(obj.value));
}

function inputOnlyNumberFormat(obj) {
    obj.value = onlynumber(uncomma(obj.value));
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

function checkAll(f) {
    console.log("check_all");
    var chk = document.getElementsByName("chk[]");
    for (i = 0; i < chk.length; i++) chk[i].checked = f.chkall.checked;
}
/*
function sortableUpdate(event, url, list) {
    $.ajax({
        type: "POST",
        url: url,
        data: { list: list },
        success: function (data) {
            console.log(data);
        },
    });
}
*/
function frmSearch() {
    var srch = $("#srch").val();
    var kwd = $("#kwd").val();
    $("#search").val(srch + "=" + kwd);
}
