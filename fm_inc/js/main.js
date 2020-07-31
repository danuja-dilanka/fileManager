var baseFile = 0;
var modType = 1;
function changeFileName(the_id) {
    $("#tr_n_" + the_id).hide();
    $("#tr_n_box_" + the_id).removeAttr('hidden');
    $("#tr_n_box_" + the_id).focus();
}
function saveAll(the_id) {
    var input_ele = $("#tr_n_box_" + the_id);
    $("#tr_n_" + the_id).show();
    input_ele.attr('hidden', 'true');
    $.post("fm_inc/modify_name.php", {newFname: input_ele.val(), theFile: $('#tr_n_' + the_id).attr('href')}, function () {
        $("body").load(location.href);
    });
}
function showTools(the_id) {
    $(".tools").hide();
    $("#tr_tools_" + the_id).show();
    $("#tr_lmod_" + the_id).hide();
}
function hideTools(the_id) {
    $(".tools").hide();
    $("#tr_lmod_" + the_id).show();
}
function modelChange(type, dataUrl, fileName) {
    if (type == 1) {
        $('#fileExplore_title').html('Copy Files To');
        $('#fileExplore_btn').html('Copy');
    } else {
        $('#fileExplore_title').html('Move Files To');
        $('#fileExplore_btn').html('Move');
    }
    baseFile = dataUrl;
    modType = type;
    $('#c_fileName').val(fileName);
}
function modifyFile(type = 0, baseFile2 = '') {
    if (type != 0) {
        modType = 3;
        baseFile = baseFile2;
    } else {
        $('#fileExplore_btn').hide();
    }
    $.post("fm_inc/modify.php", {data: baseFile, type: modType, fname: $('#c_fileName').val()}, function (data) {
        var obj = JSON.parse(data);
        var err = obj['error'];
        if (err == 0) {
            $('#toPath').attr('class', 'text-center alert alert-success');
            if (modType == 1) {
                $('#toPath').html('Copied!');
            } else {
                $('#toPath').html('Moved!');
            }
            setTimeout(function () {
                $("body").load(location.href);
            }, 200);
        } else {
            $('#fileExplore_btn').show();
            $('#toPath').attr('class', 'text-center alert alert-danger');
            $('#toPath').html('Error!');
        }
    });
}
$(document).on('click', '.dataURL', function () {
    var url = $(this).attr("id");
    $("#toPath").html(url.replace('.', 'root'));
    $.post("fm_inc/getFiles.php", {data: url}, function (data) {
        var obj = JSON.parse(data);
        var html_ele;
        $.each(obj, function (key, value) {
            if (value == '...') {
                html_ele = '<tr class="bg bg-light"><td><a href="#" class="dataURL" id="' + key + '">...</a></td></tr>';
            } else {
                html_ele = html_ele + '<tr><td><a class="dataURL" id="' + key + '" href="#">' + value + '</a></td></tr>';
            }
        });
        $('#window_getFiles').html(html_ele);
    });
    $('#c_fileName').focusout();
});
$(document).ready(function () {
    $('#fileTable').DataTable();
    $('[data-toggle="tooltip"]').tooltip();
});
$('#c_fileName').focusout(function () {
    var ele = $(this);
    ele.attr('readonly', 'true');
    var fileName = ele.val();
    $.post("fm_inc/check_name.php", {fname: fileName}, function (data) {
        var obj = JSON.parse(data);
        if (obj['error'] == 1) {
            ele.addClass('border border-warning');
        } else {
            ele.removeClass('border border-warning');
        }
    });
});
$(document).on('input', '#c_fileName', function () {
    var fname = $(this).val();
    var len = fname.length;
    var c_fname = true;
    var ele = $('#c_fileName');
    while (len > 0) {
        if (fname[len - 1] == " ") {
            c_fname = false;
            break;
        }
        len--;
    }
    if (c_fname != true) {
        ele.removeClass('border border-warning');
        ele.addClass('border border-danger');
    } else {
        $('#c_fileName').focusout();
        ele.removeClass('border border-danger');
    }
});