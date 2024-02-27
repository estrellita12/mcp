$(function () {
    console.log("ready!!!");
    $(".chead01_wrap table").colResizable({
        liveDrag: true,
        resizeMode: "overflow",
        disabledColumns: [0],
        minWidth: 40,
    });

    // 검색폼 초기화
    $("#freset").on("click", function () {
        $("#frmSearch input[type=text]").val("");
        $("#frmSearch input[type=text]").attr("value", "");
        $("#frmSearch input")
            .not(":submit, :reset, :hidden, :button")
            .val("")
            .attr("value", "")
            .removeAttr("checked")
            .removeAttr("selected");
        $("#frmSearch #ctg").attr("value", "");
        $("#frmSearch select option").removeAttr("selected");
    });

    $(".list_update").on("click", function () {
        var page = $(this).attr("id");
        var tab = $(this).attr("data-tab");
        var type = $(this).attr("data-type");
        var idl = "";
        var chk_list = new Array();
        var $chk = $("input[name='chk[]']");

        $chk.each(function (index) {
            if ($(this).is(":checked")) {
                chk_list.push($("input[name='idl[" + index + "]']").val());
            }
        });

        if (chk_list.length > 0) {
            idl = chk_list.join();
        }
        if (idl == "") {
            alert("처리할 자료를 하나 이상 선택해 주십시오.");
            return false;
        } else {
            if (type == "popup") {
                winOpen(
                    "/" + tab + "/" + page + "/" + idl,
                    "",
                    "900",
                    "600",
                    "yes"
                );
            } else {
                var res = confirm(
                    "'" + $(this).html() + "' 작업을 처리 하시겠습니까?"
                );
                if (res) this.href = "/" + tab + "/" + page + "/" + idl;
            }
            return true;
        }
    });

    $("#sort_table th").each(function (column) {
        $(this).click(function () {
            if ($(this).is(".asc")) {
                $(this).removeClass("asc");
                $(this).addClass("desc");
                sortdir = -1;
            } else {
                $(this).addClass("asc");
                $(this).removeClass("desc");
                sortdir = 1;
            }
            $(this).siblings().removeClass("asc");
            $(this).siblings().removeClass("desc");

            var rec = $("#sort_table").find("tbody>tr").get();
            if ($(this).is(".nsort")) {
                rec.sort(function (a, b) {
                    var var1 = $(a)
                        .children("td")
                        .eq(column)
                        .text()
                        .toUpperCase();
                    var1 = var1.replace(/[^0-9]/g, "");
                    var1 = parseInt(var1);
                    var var2 = $(b)
                        .children("td")
                        .eq(column)
                        .text()
                        .toUpperCase();
                    var2 = var2.replace(/[^0-9]/g, "");
                    var2 = parseInt(var2);
                    return var1 < var2 ? -sortdir : var1 > var2 ? sortdir : 0;
                });
            } else {
                rec.sort(function (a, b) {
                    var var1 = $(a)
                        .children("td")
                        .eq(column)
                        .text()
                        .toUpperCase();
                    var var2 = $(b)
                        .children("td")
                        .eq(column)
                        .text()
                        .toUpperCase();
                    return var1 < var2 ? -sortdir : var1 > var2 ? sortdir : 0;
                });
            }

            $.each(rec, function (index, row) {
                $("#sort_table tbody").append(row);
            });
        });
    });

    /** ---- editor setting ---- **/
    var editor_box = {};
    // connect editors to textareas
    $(".s_editor").each(function (idx, obj) {
        const editor_id = obj.getAttribute("id");
        editor_box[editor_id] = [];
        nhn.husky.EZCreator.createInIFrame({
            oAppRef: editor_box[editor_id], //editors in editor_box
            elPlaceHolder: editor_id, //textare id
            sSkinURI:
                "/public/js/plugin/editor/smarteditor2/SmartEditor2Skin.html",
            fCreator: "createSEditor2",
            htParams: {
                bUseToolbar: true, // 툴바 사용 여부 (true:사용/ false:사용하지 않음)
                bUseVerticalResizer: true, // 입력창 크기 조절바 사용 여부 (true:사용/ false:사용하지 않음)
                bUseModeChanger: true, // 모드 탭(Editor | HTML | TEXT) 사용 여부 (true:사용/ false:사용하지 않음)
                //aAdditionalFontList : aAdditionalFontSet,		// 추가 글꼴 목록
                fOnBeforeUnload: function () {
                    //alert("완료!");
                },
            }, //boolean
            fOnAppLoad: function () {
                //예제 코드
                //oEditors.getById["ir1"].exec("PASTE_HTML", ["로딩이 완료된 후에 본문에 삽입되는 text입니다."]);
            },
        });
    });

    // push contents into textareas before submission
    $("#btn_submit").click(function () {
        if ($(".s_editor")) {
            $(".s_editor").each(function (idx, obj) {
                const editor_id = obj.getAttribute("id");
                editor_box[editor_id].getById[editor_id].exec(
                    "UPDATE_CONTENTS_FIELD",
                    []
                );
            });
        }
    });

    $(".comma").keyup(function () {
        this.value = comma(uncomma(this.value));
    });

    $("input[name='beginDate[]']").click(function () {
        $("input[name='beginDate']").prop("checked", false);
    });

    $("input[name='endDate[]']").click(function () {
        $("input[name='endDate']").prop("checked", false);
    });

    //$("#shop").select2();
    $(".select2").select2();

    $(".return_url").each(function (idx) {
        var href = $(this).attr("href");
        if( href.includes("?") ){
            href += "&returnUrl=";
        }else{
            href += "?returnUrl=";
        }
        var return_url = window.location.pathname+window.location.search;
        return_url = encodeURIComponent(return_url);
        $(this).attr("href",href+return_url)
    });

});
