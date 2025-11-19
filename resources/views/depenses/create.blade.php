<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<script>
</script>

<body>
    <form action="{{ route('depenses.store') }}" method="POST">
        @csrf

        <label>nom</label>
        <select name="depensenom_id">
            @foreach($depensenoms as $depensenom)
            <option value="{{ $depensenom->id }}">{{ $depensenom->nom }}</option>
            @endforeach
        </select>

        <label>valeur</label>
        <input type="text" name="valeur">

        <label>date</label>
        <input type="date" name="date">



        <button type="submit">submit</button>
    </form>
</body>

</html>