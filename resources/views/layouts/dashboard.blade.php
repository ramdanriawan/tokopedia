
                <div class="col-md-3">
                    <div class="main-box mb-red"  style="background-color: #00CA79;">
                        <a href="{{ route('rekrutmen.index') }}">
                            <i class="fa fa-bolt fa-5x"></i>
                            <h5>({{ $rekrutmens->count() }}) rekrutmen</h5>
                        </a>
                    </div>
                </div>
            
                <div class="col-md-3">
                    <div class="main-box mb-red"  style="background-color: #00CA79;">
                        <a href="{{ route('surat_keluar.index') }}">
                            <i class="fa fa-bolt fa-5x"></i>
                            <h5>({{ $surat_keluars->count() }}) Surat Keluar</h5>
                        </a>
                    </div>
                </div>
            
                <div class="col-md-3">
                    <div class="main-box mb-red"  style="background-color: #00CA79;">
                        <a href="{{ route('surat_masuk.index') }}">
                            <i class="fa fa-bolt fa-5x"></i>
                            <h5>({{ $surat_masuks->count() }}) Surat Masuk</h5>
                        </a>
                    </div>
                </div>
            
                <div class="col-md-3">
                    <div class="main-box mb-red"  style="background-color: #00CA79;">
                        <a href="{{ route('unit_kerja.index') }}">
                            <i class="fa fa-bolt fa-5x"></i>
                            <h5>({{ $unit_kerjas->count() }}) Unit Kerja</h5>
                        </a>
                    </div>
                </div>
            