<div class="btn-group">
    <span data-toggle="tooltip" data-placement="left" title="Lihat Transaksi">
        <a href="{{url('lihattransaksi')}}/{{Crypt::encrypt($id)}}" class="btn btn-sm btn-outline-danger"><i class="fas fa-money"></i></a>
    </span>
    <span data-toggle="tooltip" data-placement="left" title="Lihat Hasil Ujian">
        <a href="{{url('lihathasilujian')}}/{{Crypt::encrypt($id)}}" class="btn btn-sm btn-outline-success"><i class="fas fa-list"></i></a>
    </span>
    <span data-toggle="tooltip" data-placement="left" title="Reset Password">
        <button data-toggle="modal" data-target="#modal-reset-{{$id}}" type="button" class="btn btn-sm btn-outline-primary"><i class="fas fa-undo"></i></button>
    </span>
    <span data-toggle="tooltip" data-placement="left" title="Ubah Data">
        <button data-toggle="modal" data-target="#modal-edit-{{$id}}" type="button" class="btn btn-sm btn-outline-warning"><i class="fas fa-edit"></i></button>
    </span>
    <span data-toggle="tooltip" data-placement="left" title="Hapus Data">
        <button data-toggle="modal" data-target="#modal-hapus-{{$id}}" type="button" class="btn btn-sm btn-outline-danger"><i class="far fa-trash-alt"></i></button>
    </span>
</div>