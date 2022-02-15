$(".btnApprove").click(function()
{
    var curID = $(this).attr('id').split("-");
    var name = $("#".concat(curID[0], "-", curID[1], "-name")).html();
    var badge = curID[0];
    var date = $("#".concat(curID[0], "-", curID[1], "-date")).html();
    var hin = $("#".concat(curID[0], "-", curID[1], "-in")).html();
    var hout = $("#".concat(curID[0], "-", curID[1], "-out")).html();
    var wrk = $("#".concat(curID[0], "-", curID[1], "-worked")).html();
    var otr = $("#".concat(curID[0], "-", curID[1], "-ot")).html();
    var ot = $("#".concat(curID[0], "-", curID[1], "-otapp")).val();
    var usr = curID[3];

    var cutoff = $('#ddcutoff').children("option:selected").val();
    var dates = cutoff.split(" - ");

    if (ot < 0.5)
    {
        alert("Cannot approve any overtime less than 30 minutes!");
        return;
    }
    
    if (confirm('Are you sure you want to approve this leave?'))
    {
        $("#contents").html();
        var url = "../controller/otApprovalProcess.php";
        
        $.post (
            url,
            { 
                choice: 1,
                _name: name,
                _badge: badge,
                _date: date,
                _hin: hin,
                _hout: hout,
                _wrk: wrk,
                _otr: otr,
                _ot: ot,
                _usr: usr,
                _dateFrom: dates[0],
                _dateTo: dates[1]
            },
            function(data) { 
                $("#contents").html(data).show();
                $("#tPlanned").html('');
                $("#tPlanned2").html('');
                $("#tRendered").html('');

                var tplan = 0;
                var tplan2 = 0;
                var trendered = 0;

                $('.tplanned').each(function() {
                    var value = parseFloat($(this).text());
                    if (!isNaN(value)) {
                        tplan += value;
                    }
                });
                $('.tplanned2').each(function() {
                    var value = parseFloat($(this).text());
                    if (!isNaN(value)) {
                        tplan2 += value;
                    }
                });
                $('.trendered').each(function() {
                    var value = parseFloat($(this).text());
                    if (!isNaN(value)) {
                        trendered += value;
                    }
                });

                $("#tPlanned").html(tplan.toFixed(2)).show();
                $("#tPlanned2").html(tplan2.toFixed(2)).show();
                $("#tRendered").html(trendered.toFixed(2)).show();

                if (trendered < 0.5)
                {
                    $("#autoapprove").prop("disabled", true);
                    $("#autoreject").prop("disabled", true);
                }
                else
                {
                    $("#autoapprove").prop("disabled", false);
                    $("#autoreject").prop("disabled", false);
                }
            }
        );
    }
});

$(".btnReject").click(function()
{
    var b_ID = $(this).attr('id');
    var b_curID = b_ID.split("-");
    var b_name = $("#".concat(b_curID[0], "-", b_curID[1], "-name")).html();
    var b_date = $("#".concat(b_curID[0], "-", b_curID[1], "-date")).html();
    var b_hin = $("#".concat(b_curID[0], "-", b_curID[1], "-in")).html();
    var b_hout = $("#".concat(b_curID[0], "-", b_curID[1], "-out")).html();
    var b_wrk = $("#".concat(b_curID[0], "-", b_curID[1], "-worked")).html();

    var modalObjectContent = $("#rejectForm .modal-body");
    
    modalObjectContent.find("#modal-data").attr("data-atrr", b_ID);
    modalObjectContent.find('#modal-name').html(b_name);
    modalObjectContent.find('#modal-date').html(b_date);
    modalObjectContent.find('#modal-tin').html(b_hin);
    modalObjectContent.find('#modal-tout').html(b_hout);
    modalObjectContent.find('#modal-hrs').html(b_wrk);
});

$("#btnRejectConfirm").click(function()
{
    var modalObjectContent = $("#rejectForm .modal-body");

    var curID = modalObjectContent.find("#modal-data").attr('data-atrr').split("-");
    var name = $("#".concat(curID[0], "-", curID[1], "-name")).html();
    var badge = curID[0];
    var date = $("#".concat(curID[0], "-", curID[1], "-date")).html();
    var hin = $("#".concat(curID[0], "-", curID[1], "-in")).html();
    var hout = $("#".concat(curID[0], "-", curID[1], "-out")).html();
    var wrk = $("#".concat(curID[0], "-", curID[1], "-worked")).html();
    var otr = $("#".concat(curID[0], "-", curID[1], "-ot")).html();
    var usr = curID[3];
    var cutoff = $('#ddcutoff').children("option:selected").val();
    var dates = cutoff.split(" - ");
    var rem = modalObjectContent.find("#modal-rem").val();

    if (confirm('Are you sure you want to reject this leave?'))
    {
        $("#contents").html();
        var url = "../controller/otApprovalProcess.php";
        
        $.post (
            url,
            {
                choice: 2,
                _name: name,
                _badge: badge,
                _date: date,
                _hin: hin,
                _hout: hout,
                _wrk: wrk,
                _otr: otr,
                _usr: usr,
                _dateFrom: dates[0],
                _dateTo: dates[1],
                _remarks: rem
            },
            function(data) {
                $('#rejectForm').modal('hide');
                $('.modal-backdrop').remove();
                $("#contents").html(data).show();
                $("#tPlanned").html('');
                $("#tPlanned2").html('');
                $("#tRendered").html('');

                var tplan = 0;
                var tplan2 = 0;
                var trendered = 0;

                $('.tplanned').each(function() {
                    var value = parseFloat($(this).text());
                    if (!isNaN(value)) {
                        tplan += value;
                    }
                });
                $('.tplanned2').each(function() {
                    var value = parseFloat($(this).text());
                    if (!isNaN(value)) {
                        tplan2 += value;
                    }
                });
                $('.trendered').each(function() {
                    var value = parseFloat($(this).text());
                    if (!isNaN(value)) {
                        trendered += value;
                    }
                });

                $("#tPlanned").html(tplan.toFixed(2)).show();
                $("#tPlanned2").html(tplan2.toFixed(2)).show();
                $("#tRendered").html(trendered.toFixed(2)).show();

                if (trendered < 0.5)
                {
                    $("#autoapprove").prop("disabled", true);
                    $("#autoreject").prop("disabled", true);
                }
                else
                {
                    $("#autoapprove").prop("disabled", false);
                    $("#autoreject").prop("disabled", false);
                }
            }
        );
    }
});

$(".editable").on("keyup", function(){
    var curID = $(this).attr("id").split("-");
    var curValue = $(this).val();
    var checkElement = $("#".concat(curID[0], "-", curID[1], "-ot")).html();

    if (curValue > parseFloat(checkElement))
    {
        $(this).val(parseFloat(checkElement));
        $(this).attr("value", parseFloat(checkElement));
    }
});

$(".atview").click(function()
{
    var id = $(this).attr("id");
    var url = "../controller/otApprovalPDF.php";

    $.post(
        url,
        {
            _id: id
        },
        function(data)
        {
            window.open('../pages/PDFViewer.php?id=' + id);
        }
    );
});

$('.editable').on("change keyup",function()
{
    $("#tEditable").html('');
    var teditable = 0;

    $('.editable').each(function(){
        var value = parseFloat($(this).val());

        if (!isNaN(value)){ teditable += value; }
    });
    
    $("#tEditable").html(teditable.toFixed(2)).show();
});

$("#checkall").on("change", function()
{
    if ($(this).is(":checked"))
    {
        $(".cb").each(function(){
            $(this).prop("checked", true);
            $("#autoapprove").html("APPROVE ALL");
            $("#autoreject").html("REJECT ALL");
        });
    }
    else
    {
        $(".cb").each(function(){
            $(this).prop("checked", false);
            $("#autoapprove").html("APPROVE SELECTED");
            $("#autoreject").html("REJECT SELECTED");
        });
    }
});

$(".cb").on("change", function()
{
    var count = $(".cb").length;
    var curcount = $(".cb:checked").length;
    var curID = $(this).attr("id").split("-");
    var btnApprove = $("button[id^='".concat(curID[0], "-", curID[1], "-approve']"));
    var btnReject = $("button[id^='".concat(curID[0], "-", curID[1], "-reject']"));

    if ($(this).is(":checked"))
    {
        $(btnApprove).css("display", "none");
        $(btnReject).css("display", "none");
    }
    else
    {
        $(btnApprove).css("display", "inherit");
        $(btnReject).css("display", "inherit");
    }

    if (curcount == count)
    {
        $("#checkall").prop("checked", true);
        $("#autoapprove").html("APPROVE ALL");
        $("#autoreject").html("REJECT ALL");
    }
    else
    {
        $("#checkall").prop("checked", false);
        $("#autoapprove").html("APPROVE SELECTED");
        $("#autoreject").html("REJECT SELECTED");
    }
})