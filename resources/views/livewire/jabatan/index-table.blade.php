<table class="table" id='dataTable'>
    <thead>
        <tr>
            <th width=2>#</th>
            <th>Nama</th>
            <th class="text-center">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($jabatan as $item)
        <tr data-id='{{ $item->id }}'>
            <td>
                {{ $loop->iteration }}
            </td>

            <td>{{ $item->nama }}</td>

            <td class="text-center">
                <a class="label label-primary" href="{{ url('/jabatan/' . $item->id . '/edit') }}">Edit</a>
                <label class="lblHapus label label-danger" href="" for='btnSubmit-{{ $item->id }}' style='cursor: pointer;'
                    data-toggle="modal" data-modal-id='{{ $item->id }}' data-target="#modal-{{ $item->id }}">Hapus</label>
                
                <div class="modal modal-alert"  id="modal-{{ $item->id }}" tabindex="-1" aria-labelledby="modal-{{ $item->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-sm modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title text-center" id="modal-{{ $item->id }}">Yakin akan menghapus data ini?</h5>
                
                            </div>
                            <div class="modal-body text-right">
                                <button type="button" class="btn-modal btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <button type="button" wire:click="destroy('{{ $item->id }}')" class="btn-modal btn btn-danger" data-dismiss="modal" onclick='destroy(); '>Ok</button>
                            </div>
                        </div>
                    </div>
                </div>
                
                @if($loop->iteration == 1)
                <div class="modal modal-alert"  id="modal-hapus-semua" tabindex="-1" aria-labelledby="modal-hapus-semua" aria-hidden="true">
                    <div class="modal-dialog modal-sm modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title text-center">Yakin akan menghapus banyak data ini?</h5>
                
                            </div>
                            <div class="modal-body text-right">
                                <button type="button" class="btn-modal btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <button type="button" wire:click="hapus_semua" class="btn-modal btn btn-danger" data-dismiss="modal" onclick='hapus_semua(); '>Ok</button>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

            </td>
        </tr>
        @endforeach
    </tbody>

</table>

<div id="snackbar" role="alert" class='error'>
    Berhasil menghapus data jabatan
</div>

<div id="snackbar" role="alert" class='hapus_semua'>
    Berhasil menghapus banyak data jabatan
</div>



<script>
    const locationHrefHapusSemua = "{{ url('jabatan/hapus_semua') }}";
    const locationHrefAktifkanSemua = "{{ url('jabatan/aktifkan_semua') }}";
    const locationHrefCreate = "{{ url('jabatan/create') }}";

    var columnOrders = [{{ $jabatan_count }}];
    var urlSearch = "{{ url('jabatan') }}";
    var q = "{{ $_GET['q'] ?? '' }}";
    var placeholder = "Filter...";
    var tampilkan_buttons = true;
    var button_manual = true;

    function destroy()
    {
        var x = $("#snackbar");

        x.addClass('success show');

        setTimeout(function(){ x.removeClass('success show'); }, 2000);
    }

    function hapus_semua()
    {
        var x = $("#snackbar.hapus_semua");

        x.addClass('success show');

        setTimeout(function(){ x.removeClass('success show'); }, 2000);
    }

</script>