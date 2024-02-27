(function ($) {
    $.fn.ctg_select_box = function (selectID, cnt, url, emptyText) {
        return this.each(function (index, domEle) {
            $(this).change(function (event) {
                var thisID = event.currentTarget.id; // #ctgCode1    // 변경되는 select의 ID값
                var selectPanel =
                    parseInt(thisID.substr(selectID.length - 1, 1)) + 1; // 2            // 변경되는 select의 다음 select의 ID번호
                var targetID = selectID + selectPanel; // #ctgCode2    // 변경할 select의 ID값
                var code = $(this).val();
                code = Array.isArray(code) ? code[0] : code; // select가 multiple인 경우, 배열이 넘어올 수 있음
                var parameters = { depth: selectPanel, upper: code };
                var tmpID = "";
                $(selectID).val(code);
                if (typeof changeData == "function") changeData(code);

                if ($(targetID).length < 1) return;

                postCallback = function (data) {
                    if (emptyText != "" && emptyText != null) {
                        for (var i = selectPanel; i <= cnt; i++) {
                            tmpID = selectID + i;
                            $(tmpID).html(
                                '<option value="">' + emptyText + "</option>"
                            );
                        }
                    }
                    data = eval(data);
                    if (data != "" && data != null) {
                        $(targetID).html("");
                        var k = 1;
                        for (var j = 0; j < data.length; j++) {
                            if (
                                j == 0 &&
                                emptyText != "" &&
                                emptyText != null
                            ) {
                                $(targetID)
                                    .get(0)
                                    .add(
                                        new Option(emptyText, ""),
                                        document.all ? j : null
                                    );
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
