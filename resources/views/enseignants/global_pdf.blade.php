<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Planning des Examens</title>
    <style>
        body {
            font-family: "DejaVu Sans", sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .session-info {
            margin-bottom: 20px;
        }
        .salle-info, .surveillant-info {
            padding-bottom: 5px;
            margin-bottom: 5px;
        }
        .page-break {
            page-break-after: always; /* Forces a page break */
        }
    </style>
</head>
<body>
    <h2 class="header">Faculté des Sciences - El Jadida</h2>

    <div class="session-info">
        @php
            $currentYear = $session ? \Carbon\Carbon::parse($session->date)->year : now()->year;
            $previousYear = $currentYear - 1;
        @endphp
        <p><strong>Année Universitaire:</strong> {{ $previousYear }}/{{ $currentYear }}</p>
        <p><strong>Centre d'Examen :</strong> El Jadida</p>
    </div>

    @foreach ($groupedExams as $date => $examsByDate)
        @if (!$loop->first)
            <div class="page-break"></div> <!-- Page break before new date -->
        @endif

        <h3>Date : {{ \Carbon\Carbon::parse($date)->format('d/m/Y') }}</h3>

        <!-- Séance du matin -->
        @if($examsByDate['morning']->isNotEmpty())
            <h4>1ère et 2ème Séance - Matin</h4>
            <table>
                <thead>
                    <tr>
                        <th>Module</th>
                        <th>LC I (1ère Séance)</th>
                        <th>Surv I</th>
                        <th>LC II (2ème Séance)</th>
                        <th>Surv II</th>
                        <th>Observations</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($examsByDate['morning']->chunk(2) as $chunk) <!-- Group exams by two (S1 and S2) -->
                        @php
                            // Gather S1 and S2 room data
                            $sallesS1 = isset($chunk[0]) ? $chunk[0]->salles : [];
                            $sallesS2 = isset($chunk[1]) ? $chunk[1]->salles : [];
                            $maxSalles = max(count($sallesS1), count($sallesS2)); // Maximum number of rooms
                        @endphp
                        @for($i = 0; $i < $maxSalles; $i++) <!-- Iterate over all rooms -->
                        <tr>
                            <td>
                                @if(isset($chunk[0]))
                                    <strong>S1:</strong><br>
                                    @foreach ($chunk[0]->modules as $module)
                                        {{ $module->lib_elp ?? 'N/A' }} <br>
                                        <strong>Responsable:</strong> {{ $chunk[0]->enseignant->name ?? 'N/A' }} <br>
                                    @endforeach
                                @endif
                                @if(isset($chunk[1]))
                                    <strong>S2:</strong><br>
                                    @foreach ($chunk[1]->modules as $module)
                                        {{ $module->lib_elp ?? 'N/A' }} <br>
                                        <strong>Responsable:</strong> {{ $chunk[1]->enseignant->name ?? 'N/A' }} <br>
                                    @endforeach
                                @endif
                            </td>

                            <!-- LC I (1ère Séance) -->
                            <td>
                                @if(isset($sallesS1[$i]))
                                    <div class="salle-info">{{ $sallesS1[$i]->name }}</div>
                                @else
                                    --
                                @endif
                            </td>

                            <!-- Surv I (Invigilators for Salle S1) -->
                            <td>
                                @if(isset($sallesS1[$i]))
                                    @php
                                        $surveillantsS1 = $sallesS1[$i]->enseignants()->where('id_examen', $chunk[0]->id)->get();
                                    @endphp
                                    <div class="surveillant-info">
                                        @if($surveillantsS1->isNotEmpty())
                                            @foreach ($surveillantsS1 as $surveillant)
                                                {{ $surveillant->name ?? 'N/A' }}<br>
                                            @endforeach
                                        @else
                                            Aucun surveillant
                                        @endif
                                    </div>
                                @else
                                    --
                                @endif
                            </td>

                            <!-- LC II (2ème Séance) -->
                            <td>
                                @if(isset($sallesS2[$i]))
                                    <div class="salle-info">{{ $sallesS2[$i]->name }}</div>
                                @else
                                    --
                                @endif
                            </td>

                            <!-- Surv II (Invigilators for Salle S2) -->
                            <td>
                                @if(isset($sallesS2[$i]))
                                    @php
                                        $surveillantsS2 = $sallesS2[$i]->enseignants()->where('id_examen', $chunk[1]->id)->get();
                                    @endphp
                                    <div class="surveillant-info">
                                        @if($surveillantsS2->isNotEmpty())
                                            @foreach ($surveillantsS2 as $surveillant)
                                                {{ $surveillant->name ?? 'N/A' }}<br>
                                            @endforeach
                                        @else
                                            Aucun surveillant
                                        @endif
                                    </div>
                                @else
                                    --
                                @endif
                            </td>

                            <td>--</td> <!-- Observations -->
                        </tr>
                        @endfor
                    @endforeach
                </tbody>
            </table>

            <!-- Surveillants réservistes du matin -->
            <div class="surveillant-section">
                <h4>Surveillants Réservistes - Matin</h4>
                <ul>
                    @if (isset($reservists[$date]) && !empty($reservists[$date]->where('demi_journee', 'matin')))
                        @foreach ($reservists[$date]->where('demi_journee', 'matin') as $reservist)
                            <li>{{ $reservist->enseignant->name }}</li>
                        @endforeach
                    @else
                        <li>Aucun surveillant réserviste disponible pour le matin.</li>
                    @endif
                </ul>
            </div>

        @endif

        <!-- Page break before the afternoon session -->
        @if($examsByDate['afternoon']->isNotEmpty())
            <div class="page-break"></div> <!-- Start afternoon session on a new page -->

            <h4>1ère et 2ème Séance - Après-midi</h4>
            <table>
                <thead>
                    <tr>
                        <th>Module</th>
                        <th>LC I (1ère Séance)</th>
                        <th>Surv I</th>
                        <th>LC II (2ème Séance)</th>
                        <th>Surv II</th>
                        <th>Observations</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($examsByDate['afternoon']->chunk(2) as $chunk)
                        @php
                            $sallesS1 = isset($chunk[0]) ? $chunk[0]->salles : [];
                            $sallesS2 = isset($chunk[1]) ? $chunk[1]->salles : [];
                            $maxSalles = max(count($sallesS1), count($sallesS2));
                        @endphp
                        @for($i = 0; $i < $maxSalles; $i++)
                        <tr>
                            <td>
                                @if(isset($chunk[0]))
                                    <strong>S1:</strong><br>
                                    @foreach ($chunk[0]->modules as $module)
                                        {{ $module->lib_elp ?? 'N/A' }} <br>
                                        <strong>Responsable:</strong> {{ $chunk[0]->enseignant->name ?? 'N/A' }} <br>
                                    @endforeach
                                @endif
                                @if(isset($chunk[1]))
                                    <strong>S2:</strong><br>
                                    @foreach ($chunk[1]->modules as $module)
                                        {{ $module->lib_elp ?? 'N/A' }} <br>
                                        <strong>Responsable:</strong> {{ $chunk[1]->enseignant->name ?? 'N/A' }} <br>
                                    @endforeach
                                @endif
                            </td>

                            <!-- LC I (1ère Séance) -->
                            <td>
                                @if(isset($sallesS1[$i]))
                                    <div class="salle-info">{{ $sallesS1[$i]->name }}</div>
                                @else
                                    --
                                @endif
                            </td>

                            <!-- Surv I -->
                            <td>
                                @if(isset($sallesS1[$i]))
                                    @php
                                        $surveillantsS1 = $sallesS1[$i]->enseignants()->where('id_examen', $chunk[0]->id)->get();
                                    @endphp
                                    <div class="surveillant-info">
                                        @if($surveillantsS1->isNotEmpty())
                                            @foreach ($surveillantsS1 as $surveillant)
                                                {{ $surveillant->name ?? 'N/A' }}<br>
                                            @endforeach
                                        @else
                                            Aucun surveillant
                                        @endif
                                    </div>
                                @else
                                    -- 
                                @endif
                            </td>

                            <!-- LC II (2ème Séance) -->
                            <td>
                                @if(isset($sallesS2[$i]))
                                    <div class="salle-info">{{ $sallesS2[$i]->name }}</div>
                                @else
                                    --
                                @endif
                            </td>

                            <!-- Surv II -->
                            <td>
                                @if(isset($sallesS2[$i]))
                                    @php
                                        $surveillantsS2 = $sallesS2[$i]->enseignants()->where('id_examen', $chunk[1]->id)->get();
                                    @endphp
                                    <div class="surveillant-info">
                                        @if($surveillantsS2->isNotEmpty())
                                            @foreach ($surveillantsS2 as $surveillant)
                                                {{ $surveillant->name ?? 'N/A' }}<br>
                                            @endforeach
                                        @else
                                            Aucun surveillant
                                        @endif
                                    </div>
                                @else
                                    --
                                @endif
                            </td>

                            <td>--</td> <!-- Observations -->
                        </tr>
                        @endfor
                    @endforeach
                </tbody>
            </table>

            <!-- Surveillants réservistes de l'après-midi -->
            <div class="surveillant-section">
                <h4>Surveillants Réservistes - Après-midi</h4>
                <ul>
                    @if (isset($reservists[$date]) && !empty($reservists[$date]->where('demi_journee', 'apres-midi')))
                        @foreach ($reservists[$date]->where('demi_journee', 'apres-midi') as $reservist)
                            <li>{{ $reservist->enseignant->name }}</li>
                        @endforeach
                    @else
                        <li>Aucun surveillant réserviste disponible pour l'après-midi.</li>
                    @endif
                </ul>
            </div>
        @endif
    @endforeach
</body>
</html>
