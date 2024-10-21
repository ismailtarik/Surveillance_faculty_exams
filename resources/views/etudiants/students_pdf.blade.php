<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des étudiants et leurs examens</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            font-size: 12px;
            margin: 20px;
            color: #333;
        }
        h1, h2 {
            color: #2C3E50;
            text-align: center;
        }
        hr {
            border: 1px solid #ccc;
            margin: 10px 0;
        }
        .department-info {
            margin-bottom: 20px;
        }
        .department-info p {
            margin: 5px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th {
            background-color: #f8f8f8;
            color: #333;
            font-weight: bold;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        td {
            text-align: center;
        }
        tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>UNIVERSITÉ CHOUAIB DOUKKALI</h1>
    <h1>FACULTÉ DES SCIENCES EL JADIDA</h1>
    <hr>
    <h1>Liste des Étudiants</h1>
    <hr>
    <div class="department-info">
        @php
            $currentYear = $session ? \Carbon\Carbon::parse($session->date)->year : now()->year;
            $previousYear = $currentYear - 1;
        @endphp
        <p><strong>Année Universitaire:</strong> {{ $previousYear }}/{{ $currentYear }}</p>
        <p><strong>Session:</strong> {{ $session->type == 'S_N_1' || $session->type == 'S_N_2' ? 'Normale' : 'Rattrapage' }}</p>
        <p><strong>Centre d'Examen:</strong> El Jadida</p>
    </div>
    <h2>Filière: {{ $filiere->version_etape ?? 'Inconnu' }}</h2>

    <table>
        <thead>
            <tr>
                <th>CNE</th>
                <th>Nom de l'étudiant</th>
                @foreach($modules as $module)
                    <th>{{ $module->lib_elp }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($students as $student)
            <tr>
                <td>{{ $student->cne }}</td>
                <td>{{ $student->nom }} {{ $student->prenom }}</td>
                @foreach($modules as $module)
                    @php
                        $examData = $organizedExams[$module->id] ?? null;
                        $salleInfo = '-'; // Default value
                        if ($examData && isset($examData['salles'])) {
                            $salleInfo = getSalleInfo($examData['salles'], $module->id);
                        }
                    @endphp
                    <td>{{ $salleInfo }}</td>
                @endforeach
            </tr>
            @endforeach
        </tbody>
    </table>

    @php
        function getSalleInfo($salleInfos, $moduleId) {
            static $assignedCount = []; // Static counter to track allocations
            $salleInfo = "-"; // Default value

            foreach ($salleInfos as $index => $salle) {
                if (!isset($assignedCount[$moduleId][$index])) {
                    $assignedCount[$moduleId][$index] = 0;
                }

                if ($assignedCount[$moduleId][$index] < $salle->capacite) {
                    $assignedCount[$moduleId][$index]++;
                    $salleInfo = "S: {$salle->name} / N°: {$assignedCount[$moduleId][$index]}";
                    break; // Stop once a room is assigned
                }
            }

            return $salleInfo;
        }
    @endphp
</body>
</html>
