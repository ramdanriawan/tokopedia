
            @if(in_array(auth()->user()->level, ['Admin']))
            <li>
                <a @if(Route::current()->action['as'] == 'berita.index') class='active-menu' @endif href="{{ route('berita.index') }}"><i class="fa fa-table"></i>Berita</a>
            </li>
            @endif

            @if(in_array(auth()->user()->level, ['Admin']))
            <li>
                <a @if(Route::current()->action['as'] == 'user.index') class='active-menu' @endif href="{{ route('user.index') }}"><i class="fa fa-table"></i>User</a>
            </li>
            @endif
            
            @if(in_array(auth()->user()->level, ['Admin']))
            <li>
                <a @if(Route::current()->action['as'] == 'bagian.index') class='active-menu' @endif href="{{ route('bagian.index') }}"><i class="fa fa-table"></i>Bagian</a>
            </li>
            @endif

            {{-- @if(in_array(auth()->user()->level, ['Admin']))
            <li>
                <a @if(Route::current()->action['as'] == 'sifat_surat.index') class='active-menu' @endif href="{{ route('sifat_surat.index') }}"><i class="fa fa-table"></i>Sifat Surat</a>
            </li>
            @endif --}}

            @if(in_array(auth()->user()->level, ['Admin']))
            <li>
                <a @if(Route::current()->action['as'] == 'jabatan.index') class='active-menu' @endif href="{{ route('jabatan.index') }}"><i class="fa fa-table"></i>Jabatan</a>
            </li>
            @endif

            @if(in_array(auth()->user()->level, ['Admin']))
            <li>
                <a @if(Route::current()->action['as'] == 'unit_kerja.index') class='active-menu' @endif href="{{ route('unit_kerja.index') }}"><i class="fa fa-table"></i>Unit Kerja</a>
            </li>
            @endif

            @if(in_array(auth()->user()->level, ['Admin']))
            <li>
                <a @if(Route::current()->action['as'] == 'rekrutmen.index') class='active-menu' @endif href="{{ route('rekrutmen.index') }}"><i class="fa fa-table"></i>Rekrutmen</a>
            </li>
            @endif

            @if(in_array(auth()->user()->level, ['Admin', 'Unit Kerja']))
            <li>
                <a @if(Route::current()->action['as'] == 'surat_masuk.index') class='active-menu' @endif href="{{ route('surat_masuk.index') }}"><i class="fa fa-table"></i>Surat Masuk</a>
            </li>
            @endif

            @if(in_array(auth()->user()->level, ['Admin', 'Unit Kerja']))
            <li>
                <a @if(Route::current()->action['as'] == 'surat_keluar.index') class='active-menu' @endif href="{{ route('surat_keluar.index') }}"><i class="fa fa-table"></i>Surat Keluar</a>
            </li>
            @endif

            @if(in_array(auth()->user()->level, ['Admin', 'Unit Kerja', 'Rekrutmen']))
            <li>
                <a @if(Route::current()->action['as'] == 'disposisi.index') class='active-menu' @endif href="{{ route('disposisi.index') }}"><i class="fa fa-table"></i>Disposisi</a>
            </li>
            @endif
            

            @if(in_array(auth()->user()->level, ['Admin']))
            <li>
                <a href="#"><i class="fa fa-sitemap"></i>Laporan <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level  @if(Request::segment(2) == 'laporan') collapse in @endif">
                    
                    @if(in_array(auth()->user()->level, ['Admin']))
                    <li>
                        <a  @if(Route::current()->action['as'] == 'user.laporan.index') class='active-menu' @endif href="{{ route('user.laporan.index') }}"><i class="fa fa-table"></i>User</a>
                    </li>
                    @endif

                    @if(in_array(auth()->user()->level, ['Admin']))
                    <li>
                        <a  @if(Route::current()->action['as'] == 'bagian.laporan.index') class='active-menu' @endif href="{{ route('bagian.laporan.index') }}"><i class="fa fa-table"></i>Bagian</a>
                    </li>
                    @endif

                    {{-- @if(in_array(auth()->user()->level, ['Admin']))
                    <li>
                        <a  @if(Route::current()->action['as'] == 'sifat_surat.laporan.index') class='active-menu' @endif href="{{ route('sifat_surat.laporan.index') }}"><i class="fa fa-table"></i>Sifat Surat</a>
                    </li>
                    @endif --}}

                    @if(in_array(auth()->user()->level, ['Admin']))
                    <li>
                        <a  @if(Route::current()->action['as'] == 'jabatan.laporan.index') class='active-menu' @endif href="{{ route('jabatan.laporan.index') }}"><i class="fa fa-table"></i>Jabatan</a>
                    </li>
                    @endif

                    @if(in_array(auth()->user()->level, ['Admin']))
                    <li>
                        <a  @if(Route::current()->action['as'] == 'unit_kerja.laporan.index') class='active-menu' @endif href="{{ route('unit_kerja.laporan.index') }}"><i class="fa fa-table"></i>Unit Kerja</a>
                    </li>
                    @endif

                    @if(in_array(auth()->user()->level, ['Admin']))
                    <li>
                        <a  @if(Route::current()->action['as'] == 'rekrutmen.laporan.index') class='active-menu' @endif href="{{ route('rekrutmen.laporan.index') }}"><i class="fa fa-table"></i>Rekrutmen</a>
                    </li>
                    @endif

                    @if(in_array(auth()->user()->level, ['Admin']))
                    <li>
                        <a  @if(Route::current()->action['as'] == 'surat_masuk.laporan.index') class='active-menu' @endif href="{{ route('surat_masuk.laporan.index') }}"><i class="fa fa-table"></i>Surat Masuk</a>
                    </li>
                    @endif

                    @if(in_array(auth()->user()->level, ['Admin']))
                    <li>
                        <a  @if(Route::current()->action['as'] == 'surat_keluar.laporan.index') class='active-menu' @endif href="{{ route('surat_keluar.laporan.index') }}"><i class="fa fa-table"></i>Surat Keluar</a>
                    </li>
                    @endif

                    @if(in_array(auth()->user()->level, ['Admin']))
                    <li>
                        <a  @if(Route::current()->action['as'] == 'disposisi.laporan.index') class='active-menu' @endif href="{{ route('disposisi.laporan.index') }}"><i class="fa fa-table"></i>Disposisi</a>
                    </li>
                    @endif
                </ul>
            </li>
            @endif