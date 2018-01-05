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
        pageLength:5,
        "language": {"url": "adminbsb/plugins/jquery-datatable/Indonesian.json"},
        "lengthMenu": [ [5, 10, 25, -1], [5, 10, 25, "All"] ],"pageLength": 5
    });
    $('.tabel-no-sort').DataTable({
        responsive: true,
        pageLength:5,
        "language": {"url": "adminbsb/plugins/jquery-datatable/Indonesian.json"},
        "lengthMenu": [ [5, 10, 25, -1], [5, 10, 25, "All"] ],"pageLength": 5,
        sorting:false
    });
});
////////////
