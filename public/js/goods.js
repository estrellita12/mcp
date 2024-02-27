function ctgAdd() {
    var chk = false;
    $("select[name^=ctg] option:selected").each(function () {
        chk = true;
    });

    if (!chk) {
        alert("카테고리를 하나이상 선택하세요.");
        return;
    }

    var sel_count = $("select#selectCtg option").length;
    if (sel_count >= 3) {
        alert("카테고리는 최대 3개까지만 등록 가능합니다.");
        return;
    }

    var sel_text = "";
    var sel_value = "";
    var gubun = "";
    for (var i = 1; i <= 5; i++) {
        $this = $("select#ctg" + i + " option:selected");
        if ($this.val()) {
            sel_text += gubun + $this.text();
            sel_value = $this.val();
            gubun = " > ";
        }
    }

    if (sel_value.length <= 3) {
        alert("카테고리를 대분류 > 중분류이상 설정해야 등록이 가능합니다.");
        return;
    }

    if (sel_value) {
        chk = false;
        $("select#selectCtg option").each(function () {
            if (sel_value == $(this).val()) {
                chk = true;
                return;
            }
        });

        if (chk) {
            alert("이미 선택하신 카테고리 입니다.");
            return;
        }
    }
    $("select#selectCtg").append(
        '<option value="' + sel_value + '">' + sel_text + "</option>"
    );
}

function ctgMove(type) {
    $obj = $("select#selectCtg option:selected");
    if ($obj.length > 0) {
        if (type == "prev") {
            $obj.insertBefore($obj.prev());
        } else {
            $obj.insertAfter($obj.next());
        }
    } else {
        alert("이동할 항목을 선택해 주세요.");
        return;
    }
}

function ctgRemove() {
    $this = $("select#selectCtg option:selected");
    $this.remove();
    console.log($this.val());
}

function roptAdd() {
    var str = "";
    str += "<tr>";
    str +=
        "<td>신규</td><td><input type='text' name='opt[code][]' class='tar w100p' size=5></td>";
    str +=
        "<td><input type='hidden' name='opt[id][]' value=''><input type='hidden' name='opt[type][]' value='1'>";
    str +=
        "<input type='text' name='opt[name][]' value='' class='w100p opt_name required' placeholder='화이트 250' required onkeyup='stockCnt()'></td>";
    str +=
        "<td><input type='text' name='opt[supplyPrice][]' value='' class='tar supply_price comma w100p' readonly></td>";
    str +=
        "<td><input type='text' name='opt[addPrice][]' value='0' class='tar add_price comma w100p' onkeyup='getSupplyPrice()'></td>";
    str +=
        "<td><input type='text' name='opt[stockQty][]' value='0' class='tar stock_qty comma w100p' maxlength=3 onkeyup='stockCnt()'></td>";
    //str +=
    //    "<td><input type='text' name='opt[qtyNoti][]'  value='10' class='tar' size=3></td>";
    str +=
        "<td><select name='opt[useYn][]' class='use_yn'><option value='y'>사용</option><option value='n'>미사용</option></select></td>";
    str +=
        "<td><button type='button' class='btn btn_ssmall btn_gray' onclick='optDel(this)'>삭제</button></td>";
    str += "</tr>";
    $("#ropt").append(str);

    $(".comma").keyup(function () {
        this.value = comma(uncomma(this.value));
    });
}

function aoptAdd() {
    var str = "";
    str += "<tr>";
    str +=
        "<td>신규</td><td><input type='text' name='aopt[code][]' class='tar' size=5></td>";
    str +=
        "<td><input type='hidden' name='aopt[id][]' value=''><input type='hidden' name='aopt[type][]' value='2'>";
    str +=
        "<input type='text' name='aopt[name][]' value='' class='w100p opt_name' placeholder='쇼핑백'></td>";
    str +=
        "<td><input type='text' name='aopt[addPrice][]' value='0' class='tar comma' size=5></td>";
    str +=
        "<td><input type='text' name='opt[stockQty][]' value='0' class='tar comma' size=3></td>";
    //str +=
    //    "<td><input type='text' name='aopt[qtyNoti][]' value='10' class='tar' size=3></td>";
    str +=
        "<td><select name='aopt[useYn][]' class='use_yn'><option value='y'>사용</option><option value='n'>미사용</option></select></td>";
    str +=
        "<td><button type='button' class='btn btn_ssmall btn_gray' onclick='optDel(this)'>삭제</button></td>";
    str += "</tr>";
    $("#aopt").append(str);
}

function optDel(obj) {
    $(obj).closest("tr").find(".opt_name").val("");
    $(obj).closest("tr").find(".opt_name").removeAttr("required");
    $(obj).closest("tr").css("display", "none");
}

function stockCnt(){
    var stock_qty = 0;
    $("tbody#ropt tr").each(function () {
        if ($(this).css("display") != "none") {
            if (
                $(this).find(".use_yn").val() == "y" &&
                $(this).find(".opt_name").val() != ""
            ) {
                var qty = uncomma($(this).find(".stock_qty").val());
                if( !!qty )  stock_qty += parseInt(qty);
            }
        }
        $("input[name=stockQty]").val(stock_qty);
    });
}

function deliveryChange(type) {
    switch(type){
        case "1":
            $(".delivery_charge").hide();
            $(".delivery_free").hide();     
            break;
        case "3":
            $(".delivery_charge").show();
            $(".delivery_free").hide();     
            break;
        case "5":
            $(".delivery_charge").show();
            $(".delivery_free").show();     
            break;
    }
}

function detailPriceAuto(type) {
    if (type == "1") {
        $(".detail_price").css("display", "none");
    } else {
        $(".detail_price").css("display", "revert");
    }
}

function frmGoodsSubmit() {
    getSupplyPrice();

    let multi_caid = new Array();
    let new_caid = "";

    $("select#selectCtg option").each(function () {
        new_caid = $(this).val();
        if (new_caid == "") return true;
        multi_caid.push(new_caid);
    });
    if (multi_caid.length > 0) {
        $("input[name=goodsCtg]").val(multi_caid[0]);
        $("input[name=goodsCtg2]").val(multi_caid[1]);
        $("input[name=goodsCtg3]").val(multi_caid[2]);
    }

    let sel_count = $("select#selectCtg option").length;
    if (sel_count < 1) {
        alert("카테고리를 하나이상 선택하세요.");
        return false;
    } else if (sel_count > 3) {
        alert("카테고리는 최대 3개까지만 등록 가능합니다.");
        return false;
    }

    let opt_count = 0;
    let stock_qty = 0;
    $("tbody#ropt tr").each(function () {
        if ($(this).css("display") != "none") {
            opt_count++;
            if (
                $(this).find(".use_yn").val() == "y" &&
                $(this).find(".opt_name").val() != ""
            ) {
                stock_qty += parseInt($(this).find(".stock_qty").val());
            }
        }
        $("input[name=stockQty]").val(stock_qty);
    });

    if (opt_count < 1) {
        alert("옵션을 하나 이상 설정해주세요.");
        return false;
    }

    $(".comma").each(function () {
        data = uncomma($(this).val());
        $(this).val(data);
    });

    return true;
}

function infoValue(pre) {
    var str = "";
    for (key in item_info[pre]["article"]) {
        str += "<tr>";
        str += "<th>" + item_info[pre]["article"][key][0] + "</th>";
        str +=
            "<td><input type='text' name='infoValue[" +
            key +
            "]' value='상세페이지 참조' size='40'>";
        if (item_info[pre]["article"][key][1] != "") {
            str +=
                "<span class='tooltip'>&nbsp;<span class='tooltiptext'>" +
                item_info[pre]["article"][key][1] +
                "</span>&nbsp;</span> </td>";
        }
        str += "</tr>";
    }
    return str;
}

$(function () {
    let pre = $("#infoTypePre").val();
    let str = "";
    let type = "";
    let value = "";

    str = "<option value=''>선택</option>";
    for (key in item_info) {
        var selected = "";
        if (key == pre) selected = "selected";
        str +=
            "<option value=" +
            key +
            " " +
            selected +
            ">" +
            item_info[key]["title"] +
            "</option>";
    }
    $("#infoType").empty().html(str);
    if (pre != "") $("#infoValue").empty().html(infoValue(pre));

    $("#infoType").change("change", function () {
        str = "";
        pre = $(this).val();
        if (pre != "") $("#infoValue").empty().html(infoValue(pre));
    });

    $(".sortable").sortable();

    $("input[name=goodsPriceAuto]").change(function () {
        detailPriceAuto($(this).val());
    });

    $("input[name=deliveryType]").change(function () {
        deliveryChange($(this).val());
    });

    $("#goodsPrice").change(function () {
        getSupplyPrice();
    });

    $("#goodsPrice").keyup(function () {
        getSupplyPrice();
    });

    $("input[name=simgType]").click(function(){
        var type = $(this).val();
        if(type=="0"){
            $(".simg").attr("type","file");
        }else{
            $(".simg").attr("type","text");
        }
    })

});

function getSupplyPrice(){
    var payRate = $("#payRate").val();
    var rate = (100 - payRate) / 100;
    var goodsPrice = uncomma($("#goodsPrice").val())
    //var supplyPrice =  comma(Math.round((goodsPrice * rate) / 10) * 10);
    var supplyPrice =  comma(Math.floor(goodsPrice * rate));
    $("#supplyPrice").val(supplyPrice);

    $("tbody#ropt tr").each(function () {
        if ($(this).css("display") != "none") {
            var addPrice = uncomma($(this).find(".add_price").val());
            var optGoodsPrice = parseInt(goodsPrice)+parseInt(addPrice);
            //var optSupplyPrice =  comma(Math.round(((optGoodsPrice) * rate) / 10) * 10);
            var optSupplyPrice =  comma(Math.floor(optGoodsPrice * rate));
            $(this).find(".supply_price").val(optSupplyPrice);
        }
    });
}
