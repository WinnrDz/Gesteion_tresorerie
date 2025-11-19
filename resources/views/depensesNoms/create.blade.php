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
    <form action="{{ route('depensesNoms.store') }}" method="POST">
        @csrf

        <label>nom</label>
        <input type="text" name="nom">

        <label>type</label>
        <select name="type">
            <option value="fix">fix</option>
            <option value="variable">variable</option>
        </select>



        <button type="submit">submit</button>
    </form>
</body>

</html>