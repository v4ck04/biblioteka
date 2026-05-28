@extends('layouts.admin')

@section('title', 'Zahtevi za pozajmicu')

@section('content')

<div class="page-head">
    <div>
        <div class="page-title">Zahtevi za pozajmicu</div>
        <div class="page-sub">Zahtevi čitalaca – pregled i obrada</div>
    </div>
</div>

{{-- Session flash --}}
@if(session('success'))
<div class="alert" style="background:var(--success-soft); color:var(--success-ink); border:1px solid rgba(29,170,110,.2); border-radius:var(--r-md); padding:.75rem 1rem; margin-bottom:1.25rem; font-size:.85rem; display:flex; align-items:center; gap:.6rem;">
    <i class="bi bi-check-circle-fill"></i>{{ session('success') }}
</div>
@endif

{{-- Stats row --}}
<div class="grid-stats mb-4">
    <div class="card">
        <div class="d-flex align-items-start justify-content-between mb-3">
            <div>
                <div style="font-size:.72rem; font-weight:700; letter-spacing:.08em; text-transform:uppercase; color:var(--ink-3);">Na čekanju</div>
                <div style="font-size:1.8rem; font-weight:700; font-family:'JetBrains Mono',monospace; color:var(--warning); line-height:1.1; margin-top:.2rem;">{{ $counts['pending'] }}</div>
            </div>
            <div style="width:36px; height:36px; border-radius:10px; background:var(--warning-soft); display:flex; align-items:center; justify-content:center; color:var(--warning);">
                <i class="bi bi-clock-fill" style="font-size:.95rem;"></i>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="d-flex align-items-start justify-content-between mb-3">
            <div>
                <div style="font-size:.72rem; font-weight:700; letter-spacing:.08em; text-transform:uppercase; color:var(--ink-3);">Odobreno</div>
                <div style="font-size:1.8rem; font-weight:700; font-family:'JetBrains Mono',monospace; color:var(--success); line-height:1.1; margin-top:.2rem;">{{ $counts['approved'] }}</div>
            </div>
            <div style="width:36px; height:36px; border-radius:10px; background:var(--success-soft); display:flex; align-items:center; justify-content:center; color:var(--success);">
                <i class="bi bi-check-circle-fill" style="font-size:.95rem;"></i>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="d-flex align-items-start justify-content-between mb-3">
            <div>
                <div style="font-size:.72rem; font-weight:700; letter-spacing:.08em; text-transform:uppercase; color:var(--ink-3);">Odbijeno</div>
                <div style="font-size:1.8rem; font-weight:700; font-family:'JetBrains Mono',monospace; color:var(--danger); line-height:1.1; margin-top:.2rem;">{{ $counts['rejected'] }}</div>
            </div>
            <div style="width:36px; height:36px; border-radius:10px; background:var(--danger-soft); display:flex; align-items:center; justify-content:center; color:var(--danger);">
                <i class="bi bi-x-circle-fill" style="font-size:.95rem;"></i>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="d-flex align-items-start justify-content-between mb-3">
            <div>
                <div style="font-size:.72rem; font-weight:700; letter-spacing:.08em; text-transform:uppercase; color:var(--ink-3);">Ukupno</div>
                <div style="font-size:1.8rem; font-weight:700; font-family:'JetBrains Mono',monospace; color:var(--primary); line-height:1.1; margin-top:.2rem;">{{ $requests->total() }}</div>
            </div>
            <div style="width:36px; height:36px; border-radius:10px; background:var(--primary-dim); display:flex; align-items:center; justify-content:center; color:var(--primary);">
                <i class="bi bi-send-fill" style="font-size:.95rem;"></i>
            </div>
        </div>
    </div>
</div>

{{-- Table --}}
<div class="card" style="padding:0; overflow:hidden;">
    <table class="tbl">
        <thead>
            <tr>
                <th>Ref</th>
                <th>Knjiga</th>
                <th>Čitalac</th>
                <th>Kontakt</th>
                <th>Napomena</th>
                <th>Datum</th>
                <th>Status</th>
                <th>Akcija</th>
            </tr>
        </thead>
        <tbody>
            @forelse($requests as $req)
            <tr>
                {{-- Reference --}}
                <td>
                    <span class="num" style="font-size:.78rem; color:var(--ink-3);">
                        BIB-{{ str_pad($req->id, 5, '0', STR_PAD_LEFT) }}
                    </span>
                </td>

                {{-- Book --}}
                <td>
                    @php
                        $bColors = ['#2b4a25','#6b4f3a','#3d5a7a','#4a2b4a','#6b3a1f','#1a3a4a','#3a4a1a','#4a3a1a'];
                        $bc = $bColors[$req->book_id % 8];
                        $bw = explode(' ', $req->book->title ?? '');
                        $bi = strtoupper($bw[0][0] ?? '?');
                        if (isset($bw[1])) $bi .= strtoupper($bw[1][0]);
                    @endphp
                    <div class="d-flex align-items-center gap-2">
                        @if($req->book && $req->book->imageUrl())
                            <img src="{{ $req->book->imageUrl() }}" alt="{{ $req->book->title }}"
                                 style="width:36px;height:48px;object-fit:cover;border-radius:5px;box-shadow:0 2px 6px rgba(15,18,40,0.12);flex-shrink:0;">
                        @else
                            <div class="book-cover" style="background: {{ $bc }}; flex-shrink:0;">
                                {{ $bi }}
                            </div>
                        @endif
                        <div>
                            <div style="font-weight:600; color:var(--ink-1); font-size:.84rem; line-height:1.3;">
                                {{ $req->book->title ?? '—' }}
                            </div>
                            <div style="font-size:.75rem; color:var(--ink-4);">{{ $req->book->author ?? '' }}</div>
                        </div>
                    </div>
                </td>

                {{-- Reader --}}
                <td>
                    @php
                        $nameParts = explode(' ', $req->reader_name);
                        $av = strtoupper($nameParts[0][0] ?? '?');
                        if (isset($nameParts[1])) $av .= strtoupper($nameParts[1][0]);
                    @endphp
                    <div class="d-flex align-items-center gap-2">
                        <div class="borrower-av" style="flex-shrink:0;">{{ $av }}</div>
                        <span style="font-weight:500; font-size:.84rem;">{{ $req->reader_name }}</span>
                    </div>
                </td>

                {{-- Contact --}}
                <td style="font-size:.82rem; color:var(--ink-3); max-width:160px; word-break:break-all;">
                    {{ $req->contact }}
                </td>

                {{-- Notes --}}
                <td style="font-size:.8rem; color:var(--ink-4); max-width:180px;">
                    @if($req->notes)
                        <span title="{{ $req->notes }}">{{ Str::limit($req->notes, 50) }}</span>
                    @else
                        <span style="color:var(--ink-4); opacity:.4;">—</span>
                    @endif
                </td>

                {{-- Date --}}
                <td class="num" style="font-size:.8rem; color:var(--ink-3); white-space:nowrap;">
                    {{ $req->created_at->format('d.m.Y') }}<br>
                    <span style="font-size:.72rem; opacity:.6;">{{ $req->created_at->format('H:i') }}</span>
                </td>

                {{-- Status badge --}}
                <td>
                    @if($req->status === 'na čekanju')
                        <span class="badge dot" style="background:var(--warning-soft); color:var(--warning-ink);">
                            <span class="dot" style="background:var(--warning);"></span>
                            Na čekanju
                        </span>
                    @elseif($req->status === 'odobreno')
                        <span class="badge dot" style="background:var(--success-soft); color:var(--success-ink);">
                            <span class="dot" style="background:var(--success);"></span>
                            Odobreno
                        </span>
                    @else
                        <span class="badge dot" style="background:var(--danger-soft); color:var(--danger-ink);">
                            <span class="dot" style="background:var(--danger);"></span>
                            Odbijeno
                        </span>
                    @endif
                </td>

                {{-- Action --}}
                <td>
                    <div class="d-flex gap-1 align-items-center">
                        @if($req->status !== 'odobreno')
                        <form method="POST" action="{{ route('admin.requests.update', $req) }}">
                            @csrf @method('PATCH')
                            <input type="hidden" name="status" value="odobreno">
                            <button type="submit" class="btn btn-sm"
                                    style="background:var(--success-soft); color:var(--success-ink); border:1px solid rgba(29,170,110,.2); border-radius:6px; font-size:.75rem; font-weight:600; padding:.25rem .6rem;"
                                    title="Odobri">
                                <i class="bi bi-check-lg"></i>
                            </button>
                        </form>
                        @endif

                        @if($req->status !== 'odbijeno')
                        <form method="POST" action="{{ route('admin.requests.update', $req) }}">
                            @csrf @method('PATCH')
                            <input type="hidden" name="status" value="odbijeno">
                            <button type="submit" class="btn btn-sm"
                                    style="background:var(--danger-soft); color:var(--danger-ink); border:1px solid rgba(229,66,75,.2); border-radius:6px; font-size:.75rem; font-weight:600; padding:.25rem .6rem;"
                                    title="Odbij">
                                <i class="bi bi-x-lg"></i>
                            </button>
                        </form>
                        @endif

                        @if($req->status !== 'na čekanju')
                        <form method="POST" action="{{ route('admin.requests.update', $req) }}">
                            @csrf @method('PATCH')
                            <input type="hidden" name="status" value="na čekanju">
                            <button type="submit" class="btn btn-sm"
                                    style="background:var(--warning-soft); color:var(--warning-ink); border:1px solid rgba(217,119,6,.2); border-radius:6px; font-size:.75rem; font-weight:600; padding:.25rem .6rem;"
                                    title="Vrati na čekanje">
                                <i class="bi bi-clock"></i>
                            </button>
                        </form>
                        @endif
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" style="text-align:center; padding:3rem; color:var(--ink-4); font-size:.88rem;">
                    <i class="bi bi-send" style="font-size:2rem; display:block; margin-bottom:.75rem; opacity:.25;"></i>
                    Nema zahteva za pozajmicu.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- Pagination --}}
@if($requests->hasPages())
<div class="d-flex justify-content-center mt-4">
    {{ $requests->links('pagination::bootstrap-5') }}
</div>
@endif

@endsection
