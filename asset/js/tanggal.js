function myformatter(date) {
    var y = date.getFullYear();
    var m = date.getMonth() + 1;
    var d = date.getDate();
    return (d < 10 ? ('0' + d) : d) + '/' + (m < 10 ? ('0' + m) : m) + '/' + y;
}

function myparser(s) {
    if (!s)
        return new Date();
    var ss = (s.split('/'));
    var y = parseInt(ss[2], 10);
    var m = parseInt(ss[1], 10);
    var d = parseInt(ss[0], 10);
    if (!isNaN(y) && !isNaN(m) && !isNaN(d)) {
        return new Date(y, m - 1, d);
    } else {
        return new Date();
    }
}

function encode_tanggal(value) {
    var values = value.split("/");
    var keys = ["day", "month", "year"];
    var final = {};
    for (var i = 0; i < values.length; i++) {
        final[keys[i]] = values[i];
    }
    var new_date = final.year + "-" + final.month + "-" + final.day;
    return new_date;
}

function decode_tanggal(value) {
    if (value === "0000-00-00 00:00:00" || value === "0000-00-00") {
        return "";
    } else {
        var tgl = new Date(value);
        var y = tgl.getFullYear();
        var m = tgl.getMonth() + 1;
        var d = tgl.getDate();
        return (d < 10 ? '0' + d : d) + '/' + (m < 10 ? '0' + m : m) + '/' + y;
    }
}

function tanggal_awal() {
    var date = new Date(), y = date.getFullYear(), m = date.getMonth();
    var firstDay = new Date(y, m, 1);
    return decode_tanggal(firstDay);
}

function tanggal_akhir() {
    var date = new Date(), y = date.getFullYear(), m = date.getMonth();
    var lastDay = new Date(y, m + 1, 0);
    return decode_tanggal(lastDay);
}

function tahun(element) {
    $(element).inputmask("y", {
        alias: "date",
        placeholder: "yyyy",
        yearrange: {minyear: 1900, maxyear: (new Date()).getFullYear()}
    });
}

function today() {
    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth()+1; //January is 0!
    var yyyy = today.getFullYear();

    if(dd<10) {
        dd='0'+dd;
    } 

    if(mm<10) {
        mm='0'+mm;
    } 

    return dd+'/'+mm+'/'+yyyy;    
}

function bulan_now(format) {
    var d = new Date();
    var n;
    if(format == 'mmmm') {
        var month = new Array();
        month[0] = "Januari";
        month[1] = "Februari";
        month[2] = "Maret";
        month[3] = "April";
        month[4] = "Mei";
        month[5] = "Juni";
        month[6] = "Juli";
        month[7] = "Agustus";
        month[8] = "September";
        month[9] = "Oktober";
        month[10] = "Nopember";
        month[11] = "Desember";
        n = month[d.getMonth()];
    } else if (format == 'mm') {
        n = d.getMonth() + 1;
        if(n<10) {
            n='0' + n;
        } 
    } else {
        n = d.getMonth() + 1;
    }
    return n;
}

function tahun_now() {
    var d = new Date();
    var n = d.getFullYear();
    return n;
}