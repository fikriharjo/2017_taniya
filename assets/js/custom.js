function rupiahFormat(num) {
    var	numStr = num.toString(),
        sisa   = numStr.length % 3,
        rupiah = numStr.substr(0, sisa),
        ribuan = numStr.substr(sisa).match(/\d{3}/g);

    if (ribuan) {
        separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
    }

    return rupiah;
}