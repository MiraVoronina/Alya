<h3>Ваши питомцы</h3>
<ul>
    @foreach($pets as $pet)
        <li>{{ $pet->name }} @if($pet->breed) ({{ $pet->breed }}) @endif</li>
    @endforeach
</ul>
<a href="{{ route('pets.create') }}">Добавить нового питомца</a>
