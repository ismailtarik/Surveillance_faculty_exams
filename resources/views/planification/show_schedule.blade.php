<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Emploi du Temps</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            background-color: #f0f4f8;
        }
        .container {
            max-width: 1200px;
            margin: auto;
            padding: 20px;
            box-sizing: border-box;
        }
        header, footer {
            text-align: center;
            padding: 20px;
            background-color: white;
            color: #000;
            border-radius: 8px;
        }
        header h1, footer p {
            margin: 0;
        }
        header h3 {
            margin-top: 5px;
            font-weight: 300;
        }
        main {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .alert {
            padding: 15px;
            background-color: #f44336;
            color: white;
            border-radius: 5px;
            margin-bottom: 20px;
            text-align: center;
        }
        .schedule-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .schedule-table th, .schedule-table td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: center;
        }
        .schedule-table th {
            background-color: #a5b1be;
            color: #000;
        }
        .schedule-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .schedule-table tr:hover {
            background-color: #f1f1f1;
        }
        footer p {
            font-size: 0.9rem;
            margin: 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>Emploi du Temps de Surveillance de {{ $name_enseignant }}</h1>
            <div class="session-info">
                @php
                    $currentYear = $session ? \Carbon\Carbon::parse($session->date)->year : now()->year;
                    $previousYear = $currentYear - 1;
                @endphp
                <p><strong>Année Universitaire:</strong> {{ $previousYear }}/{{ $currentYear }}</p>
                @if ($session->type == 'S_N_1' || $session->type == 'S_N_2')
                    @if ($session->type == 'S_N_1')
                        <p><strong>Semestres:</strong> Automne</p>
                    @else
                        <p><strong>Session:</strong> Printemps</p>
                    @endif
                    <p><strong>Session :</strong> Normale</p>
                @elseif($session->type == 'S_R_1' || $session->type == 'S_R_2')
                    @if ($session->type == 'S_R_1')
                        <p><strong>Session:</strong> Automne</p>
                    @else
                        <p><strong>Session:</strong> Printemps</p>
                    @endif
                    <p><strong>Session :</strong> Rattrapage</p>
                @endif
                <p><strong>Centre d'Examen :</strong> El Jadida</p>
            </div>
        
        </header>

        <main>
            @if (session('error'))
                <div class="alert">
                    <p>{{ session('error') }}</p>
                </div>
            @endif

            <table class="schedule-table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Heure de début</th>
                        <th>Heure de fin</th>
                        <th>Locale</th>
                    </tr>
                </thead>
                <tbody>
                    @if (isset($schedule))
                        @foreach ($schedule->sortBy(['examen.date', 'examen.heure_debut']) as $item)
                            <tr>
                                <td>{{ $item->examen->date }}</td>
                                <td>{{ $item->examen->heure_debut }}</td>
                                <td>{{ $item->examen->heure_fin }}</td>
                                <td>{{ $item->salle->name }}</td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </main>

        <footer>
            <p>Faculté des Sciences El Jadida - Université Chouaib Dokkali</p>
        </footer>
    </div>
</body>
</html>
