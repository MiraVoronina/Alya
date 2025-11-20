<form method="POST" action="{{ route('pets.store') }}">
    @csrf
    <div>
        <label>Кличка питомца</label>
        <input type="text" name="name" required>
    </div>
    <div>
        <label>Порода или размер</label>
        <input type="text" name="breed">
    </div>
    <button type="submit">Добавить питомца</button>
</form>
