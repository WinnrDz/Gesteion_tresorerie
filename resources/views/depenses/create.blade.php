<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>

<body>
    <form action="{{ route('depenses.store') }}" method="POST">
        @csrf
        
        <!-- 
        <label>Choisissez une anne</label>
        <input type="text" name="annee">
            
        <label>Choisissez un mois</label>
        <select name="mois">
            <option>Janvier</option>
            <option>Fevrier</option>
            <option>Mars</option>
            <option>Avril</option>
            <option>Mai</option>
            <option>Juin</option>
            <option>Juillet</option>
            <option>Aout</option>
            <option>Septembre</option>
            <option>Octobre</option>
            <option>Novembre</option>
            <option>Decembre</option>
        </select>

        <label>Choisissez une periode</label>
        <select name="periode">
            <option>1-7</option>
            <option>8-15</option>
            <option>16-23</option>
            <option>24-fin</option>
        </select> -->
        <label>date</label>
        <input type="date" name="date">

        <label>periode type</label>
        <select name="periode_type">
            <option>date</option>
            <option>semaine</option>
        </select> 


        <label>fixes</label>
        <input type="text" placeholder="salaire_net" name="salaire_net">
        <input type="text" placeholder="irg" name="irg">
        <input type="text" placeholder="secu_35" name="secu_35">
        <input type="text" placeholder="abon_tel" name="abon_tel">
        <input type="text" placeholder="loyer" name="loyer">

        <label>variables</label>
        <input type="text" placeholder="g50_tap" name="g50_tap">
        <input type="text" placeholder="g50_tva" name="g50_tva">
        <input type="text" placeholder="g50_acompte_ibs" name="g50_acompte_ibs">
        <input type="text" placeholder="achats_materiels" name="achats_materiels">
        <input type="text" placeholder="autres" name="autres">

        <button type="submit">submit</button>
    </form>
</body>

</html>