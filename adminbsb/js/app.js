//Membuat animasi fadeout selama 5 dtk untuk notifikasi
$(".alert").delay(3000).fadeOut(500);

//Membuat javascript jam
function startTime() {
    var today=new Date(),
        curr_hour=today.getHours(),
        curr_min=today.getMinutes(),
        curr_sec=today.getSeconds();
    curr_hour=checkTime(curr_hour);
    curr_min=checkTime(curr_min);
    curr_sec=checkTime(curr_sec);
    document.getElementById('clock').innerHTML=curr_hour+":"+curr_min+":"+curr_sec;
}
function checkTime(i) {
    if (i<10) {
        i="0" + i;
    }
    return i;
}
setInterval(startTime, 500);
/////////////////////////

//Datepicker
$(function () {
    //Textare auto growth
    autosize($('textarea.auto-growth'));
    $('.datepicker').bootstrapMaterialDatePicker({
        // format: 'dddd DD MMMM YYYY',
        format: 'YYYY-MM-DD',
        clearButton: true,
        weekStart: 1,
        time: false
    });
});
////////////

//script untuk membuat menu yang  dengan jquery situs:http://gawibowo.com/menandai-highlight-halaman-aktif-di-menu-menggunakan-jquery.htm
$(function() {
    $('.ml-menu a[href~="' + location.href + '"]').parents('li').addClass('active');
});
$(function() {
    $(".klik").click(function () {
        $(this)
    }).addClass("toggled");
});

$(function() {
    $('.ml-menu a[href~="' + location.href + '"]').parents('ul').css({display:"block"});
});
////////////

//datatable
$(function () {
    $('.tabel-no-search-length').DataTable({
        responsive: true,
        pageLength:5,
        "language": {"url": "adminbsb/plugins/jquery-datatable/Indonesian.json"},
        searching: false,
        "lengthChange": false
    });
    $('.tabel-biasa').DataTable({
        responsive: true,
        "language": {"url": "adminbsb/plugins/jquery-datatable/Indonesian.json"},
        "lengthMenu": [ [5, 10, 25, -1], [5, 10, 25, "All"] ],"pageLength": 5
    });
    $('.tabel-biasa-2').DataTable({
        responsive: true,
        "language": {"url": "adminbsb/plugins/jquery-datatable/Indonesian.json"},
        "lengthMenu": [ [2, 10, 25, -1], [2, 10, 25, "All"] ],"pageLength": 2
    });
    $('.tabel-no-sort').DataTable({
        responsive: true,
        "language": {"url": "adminbsb/plugins/jquery-datatable/Indonesian.json"},
        "lengthMenu": [ [5, 10, 25, -1], [5, 10, 25, "All"] ],"pageLength": 5,
        sorting:false
    });
});
////////////

//userAutocomplete untuk admin (Ajax)
function userAutoComplete() {
    var base_url = window.location.origin;
    var min_length = 0;//min caracters display autocomplete
    var keywords = $('#search_user').val();
    if (keywords.length >= min_length) {
        $.ajax({
            url:'/peminjaman/user_auto_complete',
            type: 'POST',
            data:{keywords:keywords},
            success:function (data) {
                $('#user_list').show();
                $('#user_list').html(data);
            }
        });
    }else {
        $('#user_list').hide();
    }
}

//bukuAutocomplete untuk admin (Ajax)
function bukuAutoComplete() {
    var min_length = 0;//min caracters display autocomplete
    var keywords = $('#search_buku').val();
    if (keywords.length >= min_length) {
        $.ajax({
            url:'/peminjaman/buku_auto_complete',
            type: 'POST',
            data: {keywords:keywords},
            success:function (data) {
                $('#buku_list').show();
                $('#buku_list').html(data);
            }
        });
    } else {
        $('#buku_list').hide();
    }
}

//bukuAutocomplete untuk admin (Ajax)
function bukuAutoComplete4() {
    var min_length = 0;//min caracters display autocomplete
    var keywords = $('#search_buku2').val();
    if (keywords.length >= min_length) {
        $.ajax({
            url:'/peminjaman/buku_auto_complete2',
            type: 'POST',
            data: {keywords:keywords},
            success:function (data) {
                $('#buku_list2').show();
                $('#buku_list2').html(data);
            }
        });
    } else {
        $('#buku_list2').hide();
    }
}

//userAutocomplete untuk anggota (Ajax)
function userAutoComplete2() {
    var min_length = 0;//min caracters display autocomplete
    var keywords = $('#search_user').val();
    if (keywords.length >= min_length) {
        $.ajax({
            url:'/peminjaman_user/user_auto_complete',
            type: 'POST',
            data:{keywords:keywords},
            success:function (data) {
                $('#user_list').show();
                $('#user_list').html(data);
            }
        });
    }else {
        $('#user_list').hide();
    }
}

//bukuAutocomplete untuk anggota (Ajax)
function bukuAutoComplete2() {
    var min_length = 0;//min caracters display autocomplete
    var keywords = $('#search_buku').val();
    if (keywords.length >= min_length) {
        $.ajax({
            url:'/peminjaman_user/buku_auto_complete',
            type: 'POST',
            data: {keywords:keywords},
            success:function (data) {
                $('#buku_list').show();
                $('#buku_list').html(data);
            }
        });
    } else {
        $('#buku_list').hide();
    }
}
//bukuAutocomplete untuk anggota (Ajax)
function bukuAutoComplete3() {
    var min_length = 0;//min caracters display autocomplete
    var keywords = $('#search_buku2').val();
    if (keywords.length >= min_length) {
        $.ajax({
            url:'/peminjaman_user/buku_auto_complete2',
            type: 'POST',
            data: {keywords:keywords},
            success:function (data) {
                $('#buku_list2').show();
                $('#buku_list2').html(data);
            }
        });
    } else {
        $('#buku_list2').hide();
    }
}


// setItem : Change the value of input when "clicked"
function setItemUser(item) {
    //change input value
    $('#search_user').val(item);
    $('#user_list').hide();
}

function setItemBuku(item) {
    //change input value
    $('#search_buku').val(item);
    $('#buku_list').hide();
}

function setItemBuku2(item) {
    //change input value
    $('#search_buku2').val(item);
    $('#buku_list2').hide();
}

// Create input "id_user" if not exist
function makeHiddenIdUser(nilai) {
    if ($("#id_user").length > 0) {
        $("#id_user").attr('value',nilai);
    } else {
        str = '<input type="hidden" id="id-user" name="id_user" value="'+nilai+'" />';
        $("#form-peminjaman").append(str);
    }
}

//Create input "id_buku" if not exist
function makeHiddenIdBuku(nilai) {
    if ($("#id-buku").length > 0) {
        $("#id-buku").attr('value',nilai);
    } else {
        str = '<input type="hidden" id="id-buku" name="id_buku" value="'+nilai+'" />';
        $("#form-peminjaman").append(str);
    }
}

//Create input "id_buku" if not exist
function makeHiddenIdBuku2(nilai) {
    if ($("#id-buku2").length > 0) {
        $("#id-buku2").attr('value',nilai);
    } else {
        str = '<input type="hidden" id="id-buku2" name="id_buku2" value="'+nilai+'" />';
        $("#form-peminjaman").append(str);
    }
}

//jquery show and hide
$("#input2").click(function () {
    $("#input-buku2").toggle();
});

