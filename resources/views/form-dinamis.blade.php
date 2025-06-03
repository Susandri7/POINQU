@php
function viewStyle($style) {
    $s = '';
    if(!is_array($style)) return '';
    if(!empty($style['bold'])) $s .= 'font-weight:bold;';
    if(!empty($style['italic'])) $s .= 'font-style:italic;';
    if(!empty($style['fontSize'])) $s .= 'font-size:'.$style['fontSize'].'px;';
    if(!empty($style['align'])) $s .= 'text-align:'.$style['align'].';';
    if(!empty($style['uppercase'])) $s .= 'text-transform:uppercase;';
    if(!empty($style['lowercase'])) $s .= 'text-transform:lowercase;';
    return $s;
}
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>{{ $landing->judul ?? $landing->slug }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            background: linear-gradient(135deg, #ffe082 0%, #ffd54f 100%);
            min-height: 100vh; margin: 0; padding: 0;
            font-family: 'Segoe UI', Arial, sans-serif;
            display: flex; flex-direction: column;
        }
        .container {
            flex: 1 0 auto;
            display: flex; flex-direction: column;
            align-items: center; justify-content: flex-start;
            min-height: 90vh;
        }
        .landing-box {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 4px 24px 0 #f7d06299;
            max-width: 480px;
            margin-top: 40px;
            width: 100%;
            padding: 2.2rem 2rem 2.5rem 2rem;
        }
        .landing-box img {
            max-width: 100%;
            border-radius: 10px;
            margin-bottom: 18px;
            box-shadow: 0 2px 12px #f2dfa499;
        }
        .konten-section {
            color: #333;
            margin-bottom: 1.5rem;
            font-size: 1.08rem;
        }
        .form-title {
            background: linear-gradient(90deg, #ffc107 75%, #ffe082 100%);
            border-radius: 8px;
            padding: 0.8rem 1rem;
            text-align: center;
            font-weight: bold;
            font-size: 1.18rem;
            color: #573500;
            margin-bottom: 1.5rem;
            box-shadow: 0 1px 4px #f5d06a44;
        }
        form label {
            font-weight: 600;
            color: #222;
            margin-bottom: 0.3rem;
            display: block;
        }
        .form-group {
            margin-bottom: 1.15rem;
        }
        .form-control, .form-select {
            width: 100%;
            box-sizing: border-box;
            padding: 0.7rem 1rem;
            border: 1.5px solid #ffe082;
            border-radius: 7px;
            font-size: 1.03rem;
            background: #fffbe8;
            margin-bottom: 0.15rem;
            outline: none;
            transition: border 0.2s;
        }
        .form-control:focus, .form-select:focus {
            border-color: #ffc107;
        }
        .form-row {
            display: flex;
            gap: 0.5rem;
        }
        .form-row .form-select {
            flex: 1 1 0;
        }
        .btn-submit {
            width: 100%;
            background: linear-gradient(90deg, #ffc107, #e6a800 90%);
            color: #fff;
            font-size: 1.14rem;
            font-weight: bold;
            border: none;
            border-radius: 7px;
            padding: 0.95rem 0;
            margin-top: 1.1rem;
            box-shadow: 0 2px 8px #f7d06244;
            cursor: pointer;
            transition: background 0.2s;
        }
        .btn-submit:hover {
            background: linear-gradient(90deg, #e6a800, #ffc107 90%);
        }
        footer {
            flex-shrink: 0;
            text-align: center;
            padding: 2rem 0 1rem 0;
            color: #785e12;
            font-size: 1rem;
            background: none;
        }
        /* Konten dinamis */
        h2 { font-size: 1.35em; margin: 1.2em 0 0.3em 0; }
        ul { padding-left: 1.5em; margin-bottom: 1em;}
        ul li { margin-bottom: 0.3em; }
        @media (max-width: 600px) {
            .landing-box { padding: 1rem 0.7rem 2rem 0.7rem; margin-top:24px;}
            .form-title { font-size: 1rem;}
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="landing-box">
            @if($landing->gambar)
                <img src="{{ asset('storage/'.$landing->gambar) }}" alt="Gambar Landing">
            @endif

            {{-- Konten builder --}}
            @if(is_array($landing->konten))
                @foreach($landing->konten as $konten)
                    @if(is_array($konten))
                        @if(($konten['type'] ?? '') === 'heading')
                            <h2 style="{{ viewStyle($konten['style'] ?? []) }}">{{ $konten['value'] ?? '' }}</h2>
                        @elseif(($konten['type'] ?? '') === 'text')
                            <div class="konten-section" style="{{ viewStyle($konten['style'] ?? []) }}">{!! nl2br(e($konten['value'] ?? '')) !!}</div>
                        @elseif(($konten['type'] ?? '') === 'image' && !empty($konten['value']))
                            <img src="{{ asset('storage/'.$konten['value']) }}" style="max-width:100%;border-radius:8px;margin:18px 0;">
                        @elseif(($konten['type'] ?? '') === 'list')
                            <ul>
                                @foreach(($konten['value'] ?? []) as $li)
                                    <li>{{ $li }}</li>
                                @endforeach
                            </ul>
                        @endif
                    @endif
                @endforeach
            @endif

            {{-- Form Dinamis --}}
            @if(is_array($landing->form_fields) && count($landing->form_fields))
                <div class="form-title">
                    Daftar dengan cara isi form berikut: <span style="font-size:1.2em;">👇</span>
                </div>
                <form method="POST" action="#">
                    @csrf
                    @foreach($landing->form_fields as $field)
                        <div class="form-group">
                            <label>
                                {{ $field['label'] ?? '-' }}:
                            </label>
                            @php $labelSlug = \Illuminate\Support\Str::slug($field['label']); @endphp
                            @if(($field['type'] ?? 'text') === 'date')
                                <div class="form-row">
                                    <select name="{{ $labelSlug }}[day]" class="form-select" required>
                                        <option value="">Tanggal</option>
                                        @for($i=1;$i<=31;$i++)
                                            <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>
                                    <select name="{{ $labelSlug }}[month]" class="form-select" required>
                                        <option value="">Bulan</option>
                                        @foreach(['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'] as $idx=>$bulan)
                                            <option value="{{ $idx+1 }}">{{ $bulan }}</option>
                                        @endforeach
                                    </select>
                                    <select name="{{ $labelSlug }}[year]" class="form-select" required>
                                        <option value="">Tahun</option>
                                        @for($i = date('Y'); $i >= 1950; $i--)
                                            <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                            @elseif(str_contains(strtolower($field['label']), 'wa'))
                                <input
                                    type="text"
                                    name="{{ $labelSlug }}"
                                    class="form-control"
                                    placeholder="{{ $field['placeholder'] ?? '08xxxxxxxxxx' }}"
                                    maxlength="15"
                                    minlength="10"
                                    required
                                    id="wa-field"
                                    autocomplete="off"
                                >
                            @else
                                <input
                                    type="{{ $field['type'] ?? 'text' }}"
                                    name="{{ $labelSlug }}"
                                    class="form-control"
                                    placeholder="{{ $field['placeholder'] ?? '' }}"
                                    @if(($field['type'] ?? '') !== 'number') autocomplete="off" @endif
                                    @if(($field['type'] ?? '') === 'number') pattern="[0-9]*" @endif
                                    required
                                >
                            @endif
                        </div>
                    @endforeach
                    <button type="submit" class="btn-submit">Daftar</button>
                </form>
            @endif
        </div>
    </div>
    <footer>
        Copyright {{ date('Y') }} {{ url('/') }} &ndash; All Rights Reserved
    </footer>
    <script>
        // Otomatis isi "08" ketika WA field diklik kosong
        document.addEventListener('DOMContentLoaded', function() {
            var waField = document.getElementById('wa-field');
            if(waField) {
                waField.addEventListener('focus', function() {
                    if(this.value === '') {
                        this.value = '08';
                        setTimeout(()=>{ this.setSelectionRange(this.value.length, this.value.length); }, 10);
                    }
                });
            }
        });
    </script>
</body>
</html>