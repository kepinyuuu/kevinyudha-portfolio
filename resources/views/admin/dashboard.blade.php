<x-admin-shell :page-title="'Dashboard'">
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    @foreach([
        ['label'=>'Proyek','value'=>$stats['projects'],'color'=>'bg-blue-50 text-blue-700','icon'=>'M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01'],
        ['label'=>'Skills','value'=>$stats['skills'],'color'=>'bg-amber-50 text-amber-700','icon'=>'M13 10V3L4 14h7v7l9-11h-7z'],
        ['label'=>'Karya Desain','value'=>$stats['design_works'],'color'=>'bg-purple-50 text-purple-700','icon'=>'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z'],
        ['label'=>'Pesan Baru','value'=>$stats['messages_unread'],'color'=>'bg-green-50 text-green-700','icon'=>'M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z'],
    ] as $stat)
    <div class="bg-white rounded-2xl border border-gray-200 p-5 flex items-center gap-4">
        <div class="w-10 h-10 rounded-xl {{ $stat['color'] }} flex items-center justify-center flex-shrink-0">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $stat['icon'] }}"/></svg>
        </div>
        <div>
            <p class="text-2xl font-bold text-gray-900">{{ $stat['value'] }}</p>
            <p class="text-xs text-gray-500">{{ $stat['label'] }}</p>
        </div>
    </div>
    @endforeach
</div>

<div class="bg-white rounded-2xl border border-gray-200 p-6">
    <div class="flex items-center justify-between mb-5">
        <h2 class="font-semibold text-gray-800">Pesan Terbaru</h2>
        <a href="{{ route('admin.messages.index') }}" class="text-sm text-amber-700 hover:underline">Lihat semua</a>
    </div>
    @if($recentMessages->isEmpty())
    <p class="text-gray-400 text-sm py-4 text-center">Belum ada pesan masuk.</p>
    @else
    <div class="space-y-3">
        @foreach($recentMessages as $msg)
        <a href="{{ route('admin.messages.show', $msg) }}" class="flex items-start gap-3 p-3 rounded-xl hover:bg-gray-50 transition-colors group">
            <div class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center flex-shrink-0 text-sm font-semibold text-gray-600">{{ strtoupper(substr($msg->name,0,1)) }}</div>
            <div class="flex-1 min-w-0">
                <div class="flex items-center gap-2">
                    <p class="font-medium text-gray-800 text-sm truncate">{{ $msg->name }}</p>
                    @if(!$msg->read_at)<span class="w-2 h-2 bg-amber-500 rounded-full flex-shrink-0"></span>@endif
                </div>
                <p class="text-xs text-gray-500 truncate">{{ $msg->subject }}</p>
            </div>
            <p class="text-xs text-gray-400 flex-shrink-0">{{ $msg->created_at->diffForHumans() }}</p>
        </a>
        @endforeach
    </div>
    @endif
</div>
</x-admin-shell>
