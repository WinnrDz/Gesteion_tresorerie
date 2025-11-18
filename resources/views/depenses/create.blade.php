<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<script>
    function addFix() {
        console.log("pressed")
        let inputValue = document.getElementById("fixInput").value;
        document.getElementById("fixesContainer").innerHTML += `<input type='text' placeholder='${inputValue}' name='${inputValue}'>`;
    }

    function addVariable() {
        console.log("pressed")
        let inputValue = document.getElementById("variableInput").value;
        document.getElementById("variablesContainer").innerHTML += `<input type='text' placeholder='${inputValue}' name='${inputValue}'>`;
    }
</script>

<body>
    <form action="{{ route('depenses.store') }}" method="POST">
        @csrf

        <label>date</label>
        <input type="date" name="date">

        <label>periode type</label>
        <select name="periode_type">
            <option>date</option>
            <option>semaine</option>
        </select> 


        <br><label>fixes</label>
        
        <div id="fixesContainer">
        </div>

        <div onclick="addFix()" id="add" style="padding: 5px 10px;border-radius:5px;cursor:pointer;display:inline-block;">+</div>
        <input type="text" placeholder="Ajuter Fixe" id="fixInput"> <!-- this input will be the paramater name -->
            
        <br><label>variables</label>
        
        <div id="variablesContainer">
        </div>

        <div onclick="addVariable()" id="add" style="padding: 5px 10px;border-radius:5px;cursor:pointer;display:inline-block;">+</div>
        <input type="text" placeholder="Ajuter Fixe" id="variableInput"> <!-- this input will be the paramater name -->


        <button type="submit">submit</button>
    </form>
</body>

</html>