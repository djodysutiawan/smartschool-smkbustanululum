@php $role = auth()->user()->role; @endphp

<ul class="p-4 space-y-2">

@if($role == 'admin')
    <li><a href="/admin/dashboard">Dashboard</a></li>
    <li><a href="/admin/users">Manajemen User</a></li>
@endif

@if($role == 'guru')
    <li><a href="/guru/dashboard">Dashboard</a></li>
@endif

@if($role == 'siswa')
    <li><a href="/siswa/dashboard">Dashboard</a></li>
@endif

@if($role == 'orang_tua')
    <li><a href="/orangtua/dashboard">Dashboard</a></li>
@endif

@if($role == 'guru_piket')
    <li><a href="/piket/dashboard">Dashboard</a></li>
@endif

</ul>