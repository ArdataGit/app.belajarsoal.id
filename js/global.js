function reload(time){
    setTimeout( function(){
        window.location.reload();
    },time);
}
function reload_url(time,url){
    setTimeout( function(){
        window.location.href=url;
    },time);
}
function onlyPhotoVideo(idphoto){
    var id = $("#"+idphoto).val();
    var idlabel = $("#"+idphoto).attr('idlabel');
    var ext = id.substr(id.lastIndexOf('.') + 1);
    ext = ext.toLowerCase();
    switch (ext) {
        case '':
        case 'png':
        case 'jpg':
        case 'jpeg':
        case 'mp4':
        case 'avi':
        case '3gp':
            break;
        default:
            $("#"+idphoto).val('');
            $("#" + idlabel).text("Choose file");
            Swal.fire({
                title: 'Format file tidak sesuai',
                icon: 'error',
                confirmButtonText: 'Ok'
            });
    }
}
function onlyPhoto(idphoto){
    var id = $("#"+idphoto).val();
    var idlabel = $("#"+idphoto).attr('idlabel');
    var ext = id.substr(id.lastIndexOf('.') + 1);
    ext = ext.toLowerCase();
    switch (ext) {
        case '':
        case 'png':
        case 'jpg':
        case 'jpeg':
            break;
        default:
            $("#"+idphoto).val('');
            $("#" + idlabel).text("Choose file");
            Swal.fire({
                title: 'Format file tidak sesuai!',
                text: 'Silahkan input file dengan format jpg/jpeg/png',
                icon: 'warning',
                confirmButtonText: 'Ok'
            });
    }
}
function onlyPhoto2(idphoto){
    var id = $("#"+idphoto).val();
    var idlabel = $("#"+idphoto).attr('idlabel');
    $("#" + idlabel).text(id);
    var ext = id.substr(id.lastIndexOf('.') + 1);
    ext = ext.toLowerCase();
    switch (ext) {
        case '':
        case 'png':
        case 'jpg':
        case 'jpeg':
            break;
        default:
            $("#"+idphoto).val('');
            $("#" + idlabel).text("Pilih file");
            Swal.fire({
                title: 'Format file tidak sesuai!',
                text: 'Silahkan input file dengan format jpg/jpeg/png',
                icon: 'warning',
                confirmButtonText: 'Ok'
            });
    }
}
function onlyPdf(idpdf){
    var id = $("#"+idpdf).val();
    var idlabel = $("#"+idpdf).attr('idlabel');
    var ext = id.substr(id.lastIndexOf('.') + 1);
    ext = ext.toLowerCase();
    switch (ext) {
        case '':
        case 'pdf':
            break;
        default:
            $("#"+idpdf).val('');
            $("#" + idlabel).text("Choose file");
            Swal.fire({
                title: 'Format file tidak sesuai!',
                text: 'Silahkan input file dengan format pdf',
                icon: 'warning',
                confirmButtonText: 'Ok'
            });
    }
}
function onlyExcel(idfile){
    var id = $("#"+idfile).val();
    var idlabel = $("#"+idfile).attr('idlabel');
    var ext = id.substr(id.lastIndexOf('.') + 1);
    ext = ext.toLowerCase();
    switch (ext) {
        case '':
        case 'xlsx':
            break;
        default:
            $("#"+idfile).val('');
            $("#" + idlabel).text("Choose file");
            Swal.fire({
                title: 'Format file tidak sesuai!',
                text: 'Silahkan input file dengan format xlsx',
                icon: 'warning',
                confirmButtonText: 'Ok'
            });
    }
}
/* Fungsi formatRupiah */
function formatRupiah(bilangan){
		
    var	reverse = bilangan.toString().split('').reverse().join(''),
        ribuan 	= reverse.match(/\d{1,3}/g);
        ribuan	= ribuan.join('.').split('').reverse().join('');
    
    // Cetak hasil	
     // Hasil: 23.456.789
    return "Rp "+ribuan;
}
function hanyaInteger(idorclass){
    val = $(idorclass).val();
    x = $.isNumeric(val);
    if(x==true){
        val = val.replace(/\D/g, '');
        val = parseInt(val);
        $(idorclass).val(val);
    }else{
        $(idorclass).val(0);        
    }
}

function hanyaAngka(idorclass){
    $(idorclass).val($(idorclass).val().replace(/\D/g, ''));
}

function hanyaAngkaAndMinus(idorclass){
    $(idorclass).val($(idorclass).val().replace(/[^0-9-]/g, ''));
}

function hanyaAngkaAndBesar(idorclass){
    $(idorclass).val($(idorclass).val().replace(/[^0-9A-Z]/g, ''));
}

function hanyaDecimal(idorclass){
    $(idorclass).on('input paste', function () {
        val = $(this).val();
        if(val==""){
            $(this).val(0);        
        }
    });

    $(idorclass).keypress(function (event) {
        var $this = $(this);
       
        if ((event.which != 44 || $this.val().indexOf(',') != -1) &&
                ((event.which < 48 || event.which > 57) &&
                        (event.which != 0 && event.which != 8))) {
            event.preventDefault();
        }

        var text = $(this).val();
        if ((event.which == 188) && (text.indexOf(',') == -1)) {
            setTimeout(function () {
                if ($this.val().substring($this.val().indexOf(',')).length > 3) {
                    $this.val($this.val().substring(0, $this.val().indexOf(',') + 3));
                }
            }, 1);
        }

        if ((text.indexOf(',') != -1) &&
                (text.substring(text.indexOf(',')).length > 2) &&
                (event.which != 0 && event.which != 8) &&
                ($(this)[0].selectionStart >= text.length - 2)) {
            event.preventDefault();
        }
    });

    $(idorclass).bind("paste", function (e) {
        var text = e.originalEvent.clipboardData.getData('Text');
        if ($.isNumeric(text)) {
            if ((text.substring(text.indexOf(',')).length > 3) && (text.indexOf(',') > -1)) {
                e.preventDefault();
                $(this).val(text.substring(0, text.indexOf(',') + 3));
            }
        } else {
            e.preventDefault();
        }
    });
}

function modalImage(titlemodal,link) {
    $('#modal-title-image').html(titlemodal);
    $('#modal-body-image').attr('src',link);
    $('#modal-body-href').attr('href',link);
    $('#modal-image').modal('show');
}

function getKabupaten(provinsi,kabupaten,kecamatan,url,imgloading){

    $('#'+provinsi).select2({
        placeholder: "Pilih Provinsi"
      });
    $('#'+kabupaten).select2({
        placeholder: "Pilih Kota/Kabupaten"
    });
    $('#'+kecamatan).select2({
        placeholder: "Pilih Kecamatan"
    });

    $('#'+provinsi).on('select2:select', function (e) {
        var valProvinsi = $(this).val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: url,
            type: 'POST',
            dataType: "JSON",
            data: {
                "valProvinsi":valProvinsi
            },
            beforeSend: function () {
                $.LoadingOverlay("show", {
                    image       : imgloading
                });
            },
            success: function (response) {
                if (response.status == true) {
                    
                    $("#"+kecamatan).html("");
                    var newOption = new Option('', '', false, false);
                    $("#"+kecamatan).append(newOption).trigger('change');
                    $("#"+kecamatan).attr("data-placeholder","Pilih Kecamatan");

                    $("#"+kabupaten).html("");
                    var newOption = new Option('', '', false, false);
                    $("#"+kabupaten).append(newOption).trigger('change');
                    $("#"+kabupaten).attr("data-placeholder","Pilih Kota/Kabupaten");

                    $("#"+kabupaten).select2({
                        data: response.kabupaten
                    });
                }else{
                    Swal.fire({
                        title: "Error!!!",
                        icon: 'error',
                        confirmButtonText: 'Ok'
                    });
                }
            },
            error: function (xhr, status) {
                alert('Error!!!');
            },
            complete: function () {
                $.LoadingOverlay("hide");
            }
        });
    });
}

function getKecamatan(kabupaten,kecamatan,url,imgloading){

    $('#'+kabupaten).on('select2:select', function (e) {
        var valKab = $(this).val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: url,
            type: 'POST',
            dataType: "JSON",
            data: {
                "valKab":valKab
            },
            beforeSend: function () {
                $.LoadingOverlay("show", {
                    image       : imgloading
                });
            },
            success: function (response) {
                if (response.status == true) {
                    $("#"+kecamatan).html("");
                    $("#"+kecamatan).select2({
                    data: response.kecamatan
                    })
                }else{
                    Swal.fire({
                        title: "Error!!!",
                        icon: 'error',
                        confirmButtonText: 'Ok'
                    });
                }
            },
            error: function (xhr, status) {
                alert('Error!!!');
            },
            complete: function () {
                $.LoadingOverlay("hide");
            }
        });
    });
}

function getSemuaKota(provinsi,kota,url,imgloading){
    $('#'+provinsi).select2({
        placeholder: "Pilih Provinsi"
      });
    $('#'+kota).select2({
        placeholder: "Pilih Kota/Kabupaten"
    });

    $('#'+provinsi).on('select2:select', function (e) {
        var valProvinsi = $(this).val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: url,
            type: 'POST',
            dataType: "JSON",
            data: {
                "valProvinsi":valProvinsi
            },
            beforeSend: function () {
                $.LoadingOverlay("show", {
                    image       : imgloading
                });
            },
            success: function (response) {
                if (response.status == true) {

                    $("#"+kota).html("");
                    var newOption = new Option('', '', false, false);
                    $("#"+kota).append(newOption).trigger('change');
                    $("#"+kota).attr("data-placeholder","Pilih Kota/Kabupaten");

                    $("#"+kota).select2({
                        data: response.kabupaten
                    });
                }else{
                    Swal.fire({
                        title: "Error!!!",
                        icon: 'error',
                        confirmButtonText: 'Ok'
                    });
                }
            },
            error: function (xhr, status) {
                alert('Error!!!');
            },
            complete: function () {
                $.LoadingOverlay("hide");
            }
        });
    });
}

function datatableCustom1(id){
    $("#"+id).DataTable({
        // "scrollY":"25vw",
        // "scrollCollapse": true,
        "lengthChange": false,
        "oLanguage": {
            "sEmptyTable": "Belum Ada Data"
        }
        // "autoWidth": false,
        // "scrollX": true,
    });
}

function datatableItemKat(id){
    $("#"+id).DataTable({
        "lengthChange": false,
        "oLanguage": {
            "sEmptyTable": "Belum Ada Data"
        },
        "aaSorting": [],
        "columnDefs": [ {
            "targets": [0,2,3],
            "orderable": false
        } ]
    });
}
function datatableItemMas(id){
    $("#"+id).DataTable({
        "lengthChange": false,
        "oLanguage": {
            "sEmptyTable": "Belum Ada Data"
        },
        "aaSorting": [],
        "columnDefs": [ {
            "targets": [0,2,3],
            "orderable": false
        } ]
    });
}
function datatableReward(id){
    $("#"+id).DataTable({
        "lengthChange": false,
        "oLanguage": {
            "sEmptyTable": "Belum Ada Data"
        },
        "aaSorting": [],
        "columnDefs": [ {
            "targets": [0,3],
            "orderable": false
        } ]
    });
}
function datatableManual(id){
    $("#"+id).DataTable({
        "lengthChange": false,
        "oLanguage": {
            "sEmptyTable": "Belum Ada Data"
        },
        "aaSorting": [],
        "columnDefs": [ {
            "targets": [0],
            "orderable": false
        } ]
    });
}
function datatableItemHistory(id){
    $("#"+id).DataTable({
        "lengthChange": false,
        "oLanguage": {
            "sEmptyTable": "Belum Ada Data"
        },
        "aaSorting": [],
        "columnDefs": [ {
            "targets": [0],
            "orderable": false
        } ]
    });
}
function datatabletopuphistory(id){
    $("#"+id).DataTable({
        "lengthChange": false,
        "oLanguage": {
            "sEmptyTable": "Belum Ada Data"
        },
        "aaSorting": [],
        "columnDefs": [ {
            "targets": [0],
            "orderable": false
        } ]
    });
}

function datatableUser(id){
    $("#"+id).DataTable({
        "lengthChange": false,
        "oLanguage": {
            "sEmptyTable": "Belum Ada Data"
        },
        "aaSorting": [],
        "columnDefs": [ {
            "targets": [0],
            "orderable": false
        } ]
    });
}

function datatablelihattran(id){
    $("#"+id).DataTable({
        "lengthChange": false,
        "oLanguage": {
            "sEmptyTable": "Belum Ada Data"
        },
        "aaSorting": [],
        "columnDefs": [ {
            "targets": [0,5],
            "orderable": false
        } ]
    });
}

function datatablelihathadiah(id){
    $("#"+id).DataTable({
        "lengthChange": false,
        "oLanguage": {
            "sEmptyTable": "Belum Ada Data"
        },
        "aaSorting": [],
        "columnDefs": [ {
            "targets": [0,9],
            "orderable": false
        } ]
    });
}

function datatablelihatsyarat(id){
    $("#"+id).DataTable({
        "lengthChange": false,
        "oLanguage": {
            "sEmptyTable": "Belum Ada Data"
        },
        "aaSorting": [],
        "columnDefs": [ {
            "targets": [0,3],
            "orderable": false
        } ]
    });
}

function datatablememberuser(id){
    $("#"+id).DataTable({
        "lengthChange": false,
        "oLanguage": {
            "sEmptyTable": "Belum Ada Data"
        },
        "aaSorting": [],
        "columnDefs": [ {
            "targets": [0,4],
            "orderable": false
        } ]
    });
}

function datatablepeserta(id){
    $("#"+id).DataTable({
        "searching": false,
        "lengthChange": false,
        "oLanguage": {
            "sEmptyTable": "Belum Ada Data"
        },
        "aaSorting": [],
        "columnDefs": [ {
            "targets": [0],
            "orderable": false
        } ]
    });
}

function tablerankingpeserta(id){
    $("#"+id).DataTable({
        "searching": false,
        "lengthChange": false,
        "oLanguage": {
            "sEmptyTable": "Belum Ada Data"
        },
        "aaSorting": [],
        "columnDefs": [ {
            "targets": [0],
            "orderable": false
        } ]
    });
}

function datatabletmp(id){
    $("#"+id).DataTable({
        "lengthChange": false,
        "oLanguage": {
            "sEmptyTable": "Belum Ada Data"
        },
        "aaSorting": [],
        "columnDefs": [ {
            "targets": [0,3],
            "orderable": false
        } ]
    });
}

function datatableCharlist(id){
    $("#"+id).DataTable({
        "lengthChange": false,
        "oLanguage": {
            "sEmptyTable": "Belum Ada Data"
        },
        "aaSorting": [],
        "columnDefs": [ {
            "targets": [2],
            "orderable": false
        } ]
    });
}
function datatableItem(id){
    $("#"+id).DataTable({
        "lengthChange": false,
        "oLanguage": {
            "sEmptyTable": "Belum Ada Data"
        },
        "aaSorting": [],
        "columnDefs": [ {
            "targets": [0,5,6],
            "orderable": false
        } ]
    });
}
function datatableListuser(id){
    $("#"+id).DataTable({
        "lengthChange": false,
        "oLanguage": {
            "sEmptyTable": "Belum Ada Data"
        },
        "aaSorting": [],
        "columnDefs": [ {
            "targets": [0],
            "orderable": false
        } ]
    });
}
function datatableContactus(id){
    $("#"+id).DataTable({
        "lengthChange": false,
        "oLanguage": {
            "sEmptyTable": "Belum Ada Data"
        },
        "aaSorting": [],
        "columnDefs": [ {
            "targets": [0,4],
            "orderable": false
        } ]
    });
}
function datatablekatesoal(id){
    $("#"+id).DataTable({
        "lengthChange": false,
        "oLanguage": {
            "sEmptyTable": "Belum Ada Data"
        },
        "bPaginate": false,
        "aaSorting": [],
        "columnDefs": [ {
            "targets": [0],
            "orderable": false
        } ]
    });
}
function datatablekatkec(id){
    $("#"+id).DataTable({
        "lengthChange": false,
        "oLanguage": {
            "sEmptyTable": "Belum Ada Data"
        },
        "bPaginate": false,
        "aaSorting": [],
        "columnDefs": [ {
            "targets": [0,3],
            "orderable": false
        } ]
    });
}
function datatablerekmst(id){
    $("#"+id).DataTable({
        "lengthChange": false,
        "oLanguage": {
            "sEmptyTable": "Belum Ada Data"
        },
        "bPaginate": false,
        "aaSorting": [],
        "columnDefs": [ {
            "targets": [0,5],
            "orderable": false
        } ]
    });
}
function datatableeventdtl(id){
    $("#"+id).DataTable({
        "lengthChange": false,
        "oLanguage": {
            "sEmptyTable": "Belum Ada Data"
        },
        "aaSorting": [],
        "columnDefs": [ {
            "targets": [0,2],
            "orderable": false
        } ]
    });
}
function datatableeventsyarat(id){
    $("#"+id).DataTable({
        "lengthChange": false,
        "oLanguage": {
            "sEmptyTable": "Belum Ada Data"
        },
        "aaSorting": [],
        "columnDefs": [ {
            "targets": [0,2],
            "orderable": false
        } ]
    });
}
function tablepaketmateri(id){
    $("#"+id).DataTable({
        "lengthChange": false,
        "oLanguage": {
            "sEmptyTable": "Belum Ada Data"
        },
        "aaSorting": [],
        "columnDefs": [ {
            "targets": [0,2,4],
            "orderable": false
        } ]
    });
}
function tablekodepotongan(id){
    $("#"+id).DataTable({
        "lengthChange": false,
        "oLanguage": {
            "sEmptyTable": "Belum Ada Data"
        },
        "aaSorting": [],
        "columnDefs": [ {
            "targets": [0,2],
            "orderable": false
        } ]
    });
}
function tableinformasi(id){
    $("#"+id).DataTable({
        "lengthChange": false,
        "oLanguage": {
            "sEmptyTable": "Belum Ada Data"
        },
        "aaSorting": [],
        "columnDefs": [ {
            "targets": [0,3],
            "orderable": false
        } ]
    });
}
function tablepaketzoom(id){
    $("#"+id).DataTable({
        "lengthChange": false,
        "oLanguage": {
            "sEmptyTable": "Belum Ada Data"
        },
        "aaSorting": [],
        "columnDefs": [ {
            "targets": [0,2],
            "orderable": false
        } ]
    });
}
function datatablemasterevent(id){
    $("#"+id).DataTable({
        "lengthChange": false,
        "oLanguage": {
            "sEmptyTable": "Belum Ada Data"
        },
        "aaSorting": [],
        "columnDefs": [ {
            "targets": [0,4],
            "orderable": false
        } ]
    });
}
function datatablemastersoal(id){
    $("#"+id).DataTable({
        "lengthChange": false,
        "oLanguage": {
            "sEmptyTable": "Belum Ada Data"
        },
        "aaSorting": [],
        "columnDefs": [ {
            "targets": [0,2],
            "orderable": false
        } ]
    });
}
function datatablemastersoalpil(id){
    $("#"+id).DataTable({
        "lengthChange": false,
        "oLanguage": {
            "sEmptyTable": "Belum Ada Data"
        },
        "bPaginate": false,
        "aaSorting": [],
        "columnDefs": [ {
            "targets": [0,3,4],
            "orderable": false
        } ]
    });
}
function datatabledtlkec(id){
    $("#"+id).DataTable({
        "lengthChange": false,
        "oLanguage": {
            "sEmptyTable": "Belum Ada Data"
        },
        "aaSorting": [],
        "columnDefs": [ {
            "targets": [0,4],
            "orderable": false
        } ]
    });
}
function datatablemapelmst(id){
    $("#"+id).DataTable({
        "lengthChange": false,
        "oLanguage": {
            "sEmptyTable": "Belum Ada Data"
        },
        "aaSorting": [],
        "columnDefs": [ {
            "targets": [0,5],
            "orderable": false
        } ]
    });
}
function datatablehadiah(id){
    $("#"+id).DataTable({
        "lengthChange": false,
        "oLanguage": {
            "sEmptyTable": "Belum Ada Data"
        },
        "aaSorting": [],
        "columnDefs": [ {
            "targets": [0,5],
            "orderable": false
        } ]
    });
}

function datatablepaketsoalkec(id){
    $("#"+id).DataTable({
        "lengthChange": false,
        "oLanguage": {
            "sEmptyTable": "Belum Ada Data"
        },
        "aaSorting": [],
        "columnDefs": [ {
            "targets": [0,5],
            "orderable": false
        } ]
    });
}

function datatableNews(id){
    $("#"+id).DataTable({
        "lengthChange": false,
        "oLanguage": {
            "sEmptyTable": "Belum Ada Data"
        },
        "aaSorting": [],
        "columnDefs": [ {
            "targets": [0],
            "orderable": false
        } ]
    });
}








