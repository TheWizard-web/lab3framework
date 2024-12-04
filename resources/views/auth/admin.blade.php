<h1>Panoul Admin</h1>
@foreach ($users as $user)
    <p>{{ $user->name }} - {{ $user->email }}</p>
@endforeach
