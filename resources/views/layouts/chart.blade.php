        var data = google.visualization.arrayToDataTable([
            ['SISTEM INFORMASI E-OFFICE', 'Total', { role: 'style' }],

            ['Disposisi', {{ $disposisis->count() }}, '#efd279'],['Rekrutmen', {{ $rekrutmens->count() }}, '#95cbe9'],['Surat Keluar', {{ $surat_keluars->count() }}, '#024769'],['Surat Masuk', {{ $surat_masuks->count() }}, '#afd775'],['Unit Kerja', {{ $unit_kerjas->count() }}, '#2c5700'],['User', {{ $users->count() }}, '#de9d7f']
        ]);

        var options = {
          title : 'SISTEM INFORMASI E-OFFICE',
          vAxis: {title: 'Total'},
          hAxis: {title: ''},
          seriesType: 'bars',
          series: {6: {type: 'line'}}
        };