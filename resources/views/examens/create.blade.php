<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center bg-gray-100 p-4 rounded-lg shadow-md">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                @lang('Créer un nouvel examen')
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                @if ($errors->any())
                    <div class="mb-4">
                        <div class="font-medium text-red-600">@lang('Whoops! Quelque chose s\'est mal passé.')</div>
                        <ul class="mt-3 list-disc list-inside text-sm text-red-600">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('success'))
                    <div class="mb-4">
                        <ul class="mt-3 list-disc list-inside text-sm text-green-600">
                            <li>{{ session('success') }}</li>
                        </ul>
                    </div>
                @endif


                <form action="{{ route('examens.store') }}" method="POST">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                        <!-- Date -->
                        <div class="form-group">
                            <label for="date"
                                class="block text-gray-700 dark:text-gray-300">@lang('Date')</label>
                            <input type="date" name="date" id="date" value="{{ old('date') }}"
                                class="form-input mt-1 block w-full py-2 px-3 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                required>
                            @error('date')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Filière -->
                        <div class="form-group">
                            <label for="filiere"
                                class="block text-gray-700 dark:text-gray-300">@lang('Filière')</label>
                            <select
                                class="form-select select2 mt-1 block w-full py-2 px-3 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                id="filiere" name="code_etape" required>
                                <option value="">@lang('Sélectionnez une filière')</option>

                                <!-- New Filière -->
                                <optgroup label="@lang('Nouveaux Filières')">
                                    @foreach ($filieres as $filiere)
                                        @if ($filiere->type === 'new')
                                            <option value="{{ $filiere->code_etape }}">
                                                {{ $filiere->version_etape }}
                                            </option>
                                        @endif
                                    @endforeach
                                </optgroup>

                                <!-- Normal Filière -->
                                <optgroup label="@lang('Filières Normales')">
                                    @foreach ($filieres as $filiere)
                                        @if ($filiere->type === 'old')
                                            <option value="{{ $filiere->code_etape }}">
                                                {{ $filiere->version_etape }}
                                            </option>
                                        @endif
                                    @endforeach
                                </optgroup>
                            </select>
                            @error('code_etape')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>


                        <!-- Heure de Début -->
                        <div class="form-group">
                            <label for="heure_debut"
                                class="block text-gray-700 dark:text-gray-300">@lang('Heure de Début')</label>
                            <select name="heure_debut" id="heure_debut"
                                class="form-select mt-1 block w-full py-2 px-3 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                required>
                                <option value="">@lang('Sélectionnez une heure de début')</option>
                                <option value="08:30">08:30</option>
                                <option value="10:15">10:15</option>
                                <option value="14:30">14:30</option>
                                <option value="16:15">16:15</option>
                            </select>
                            @error('heure_debut')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>


                        <!-- Module -->
                        <div class="form-group">
                            <label for="module"
                                class="block text-gray-700 dark:text-gray-300">@lang('Module')</label>
                            <select
                                class="form-select mt-1 block w-full py-2 px-3 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                id="module" name="id_module" required>
                                <option value="">@lang('Sélectionnez un module')</option>
                                <!-- Les modules seront remplis dynamiquement -->
                            </select>
                            @error('id_module')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Heure de Fin -->
                        <div class="form-group">
                            <label for="heure_fin"
                                class="block text-gray-700 dark:text-gray-300">@lang('Heure de Fin')</label>
                            <select name="heure_fin" id="heure_fin"
                                class="form-select mt-1 block w-full py-2 px-3 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                required>
                                <option value="">@lang('Sélectionnez une heure de fin')</option>
                                <option value="10:00">10:00</option>
                                <option value="11:45">11:45</option>
                                <option value="16:00">16:00</option>
                                <option value="17:45">17:45</option>
                            </select>
                            @error('heure_fin')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                     <!-- Enseignant avec barre de recherche intégrée -->
                        <div class="form-group mt-4">
                            <label for="id_enseignant" class="block text-gray-700 dark:text-gray-300">@lang('Enseignant')</label>
                            <select name="id_enseignant" id="id_enseignant"
                                class="form-select mt-1 block w-full py-2 px-3 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                <option value="">@lang('Choisir un enseignant')</option>
                                @foreach ($enseignants as $enseignant)
                                    <option value="{{ $enseignant->id }}"
                                        {{ old('id_enseignant') == $enseignant->id ? 'selected' : '' }}>
                                        {{ $enseignant->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_enseignant')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>


                        <!-- Session -->
                        <div class="form-group">
                            <label for="id_session"
                                class="block text-gray-700 dark:text-gray-300">@lang('Session')</label>
                            <select id="id_session" name="id_session"
                                class="form-select mt-1 block w-full py-2 px-3 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                readonly>
                                <option value="{{ $selected_session->id }}">{{ $selected_session->type }}
                                    ({{ $selected_session->date_debut }} - {{ $selected_session->date_fin }})</option>
                            </select>
                            @error('id_session')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="allocation_mode"
                                class="block text-gray-700 dark:text-gray-300">@lang('Mode d\'affectation des salles')</label>
                            <select name="allocation_mode" id="allocation_mode"
                                class="form-select mt-1 block w-full py-2 px-3 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                <option value="manual" selected>@lang('Affectation Manuelle')</option>
                                <option value="automatic">@lang('Affectation Automatique')</option>
                            </select>
                        </div>

                        <!-- Affectation Manuelle -->
                        <div id="manual_allocation" class="grid grid-cols-1 gap-6">
                            <!-- Salle Principale -->
                            <div class="form-group">
                                <label for="id_salle"
                                    class="block text-gray-700 dark:text-gray-300">@lang('Salle Principale')</label>
                                <select name="id_salle" id="id_salle"
                                    class="form-select mt-1 block w-full py-2 px-3 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <option value="">@lang('Choisir une salle')</option>
                                    @foreach ($salles as $salle)
                                        <option value="{{ $salle->id }}" data-capacite="{{ $salle->capacite }}"
                                            {{ old('id_salle') == $salle->id ? 'selected' : '' }}>
                                            {{ $salle->name }} (Capacité: {{ $salle->capacite }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('id_salle')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Salles Additionnelles -->
                            <div class="form-group">
                                <label for="additional_salles"
                                    class="block text-gray-700 dark:text-gray-300">@lang('Salles Additionnelles')</label>
                                <div id="additional_salles">
                                    <!-- Les salles additionnelles seront ajoutées ici -->
                                </div>
                                <button type="button" id="add_salle_button"
                                    class="mt-2 px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                                    @lang('Ajouter une Salle')
                                </button>
                            </div>
                        </div>

                        <!-- Mode d'affectation des salles -->

                        <!-- Affectation Automatique -->
                        <div id="automatic_allocation" class="grid grid-cols-1 gap-6 hidden">
                            <div class="form-group">
                                <!-- Label hidden -->
                                <label for="automatic_allocation_summary" class="hidden">@lang('Résumé de l\'affectation automatique')</label>
                                <!-- Textarea hidden and readonly -->
                                <textarea id="automatic_allocation_summary" name="automatic_allocation_summary" rows="4" class="hidden"
                                    readonly></textarea>
                            </div>
                        </div>

                        <!-- Inscriptions et Capacité Totale -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                            <div class="form-group">
                                <label for="inscriptions_count"
                                    class="block text-gray-700 dark:text-gray-300">@lang('Inscriptions')</label>
                                <input type="number" id="inscriptions_count" name="inscriptions_count"
                                    class="form-input mt-1 block w-full py-2 px-3 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                    readonly>
                            </div>

                            <div class="form-group">
                                <label for="remaining_inscriptions" class="block text-gray-700 dark:text-gray-300">
                                    @lang('Restes des Inscriptions')
                                </label>
                                <input type="number" id="remaining_inscriptions" name="remaining_inscriptions"
                                    class="form-input mt-1 block w-full py-2 px-3 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                    readonly>
                            </div>
                        </div>

                        <!-- Boutons -->
                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('examens.index', ['sessionId' => $selected_session->id]) }}"
                                class="inline-flex items-center bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded-md transition focus:outline-none focus:ring-2 focus:ring-gray-500">
                                <i class="fas fa-arrow-left mr-2"></i> @lang('Retour')
                            </a>
                            <button type="submit"
                                class="py-2 px-4 bg-green-500 hover:bg-green-700 text-white font-semibold rounded-md shadow-md focus:outline-none focus:ring-2 focus:ring-green-400 focus:ring-opacity-75">
                                <i class="fas fa-save mr-2"></i> @lang('Créer Examen')
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const departementSelect = document.getElementById('departement');
            const enseignantSelect = document.getElementById('enseignant');
            const filiereSelect = document.getElementById('filiere');
            const moduleSelect = document.getElementById('module');
            const salleSelect = document.getElementById('id_salle');
            const inscriptionsCount = document.getElementById('inscriptions_count');
            const remainingInscriptions = document.getElementById('remaining_inscriptions');
            const addSalleButton = document.getElementById('add_salle_button');
            const additionalSallesDiv = document.getElementById('additional_salles');
            const allocationModeSelect = document.getElementById('allocation_mode');
            const manualAllocationDiv = document.getElementById('manual_allocation');
            const automaticAllocationDiv = document.getElementById('automatic_allocation');
            const automaticAllocationSummary = document.getElementById('automatic_allocation_summary');
            const selectedSalles = new Set();
            const scheduledModuleIds = @json($scheduled_module_ids);

            // Fetch modules when the filiere is changed
            filiereSelect.addEventListener('change', function() {
                const code_etape = this.value;
                moduleSelect.innerHTML = '<option value="">@lang('Sélectionnez un module')</option>';

                if (code_etape) {
                    fetch(`/examens/getModulesByFiliere/${code_etape}`)
                        .then(response => response.json())
                        .then(data => {
                            // Debugging: Log fetched modules
                            console.log('Fetched Modules:', data);

                            if (data.length === 0) {
                                // Si aucun module disponible
                                const option = document.createElement('option');
                                option.textContent = '@lang('Aucun module disponible')';
                                option.disabled = true;
                                moduleSelect.appendChild(option);
                            } else {
                                data.forEach(module => {
                                    const option = document.createElement('option');
                                    option.value = module.id;
                                    option.textContent =
                                        `${module.lib_elp} (${module.inscriptions_count} @lang('inscrits'))`;
                                    moduleSelect.appendChild(option);
                                });
                            }
                        })
                        .catch(error => console.error('Error fetching modules:', error));
                }
            });

            // Update inscription count when a module is selected
            moduleSelect.addEventListener('change', function() {
                const selectedModule = moduleSelect.options[moduleSelect.selectedIndex];
                const inscriptions = selectedModule.getAttribute('data-inscriptions') || 0;
                inscriptionsCount.value = inscriptions;
            });

            function updateRemainingInscriptions() {
                let totalCapacity = 0;

                const mainSalleCapacity = salleSelect.options[salleSelect.selectedIndex]?.getAttribute(
                    'data-capacite');
                if (mainSalleCapacity) {
                    totalCapacity += parseInt(mainSalleCapacity);
                }

                const additionalSalleSelects = additionalSallesDiv.querySelectorAll('select');
                additionalSalleSelects.forEach(salleSelect => {
                    const capacity = salleSelect.options[salleSelect.selectedIndex]?.getAttribute(
                        'data-capacite');
                    if (capacity) {
                        totalCapacity += parseInt(capacity);
                    }
                });

                const inscriptions = parseInt(inscriptionsCount.value) || 0;
                const remaining = inscriptions - totalCapacity;
                remainingInscriptions.value = remaining;
            }

            function getSelectedSalles() {
                const selectedSalles = [];
                const mainSalleValue = salleSelect.value;
                if (mainSalleValue) selectedSalles.push(mainSalleValue);

                const additionalSalleSelects = additionalSallesDiv.querySelectorAll('select');
                additionalSalleSelects.forEach(select => {
                    if (select.value) selectedSalles.push(select.value);
                });

                return selectedSalles;
            }

            function filterAvailableSalles() {
                const selectedSalles = getSelectedSalles();

                // Désactiver les salles déjà sélectionnées dans la salle principale
                Array.from(salleSelect.options).forEach(option => {
                    option.disabled = selectedSalles.includes(option.value) && option.value !== salleSelect
                        .value;
                });

                // Désactiver les salles déjà sélectionnées dans les salles additionnelles
                const additionalSalleSelects = additionalSallesDiv.querySelectorAll('select');
                additionalSalleSelects.forEach(select => {
                    Array.from(select.options).forEach(option => {
                        option.disabled = selectedSalles.includes(option.value) && option.value !==
                            select.value;
                    });
                });
            }

            salleSelect.addEventListener('change', function() {
                filterAvailableSalles();
                updateRemainingInscriptions();
            });

            addSalleButton.addEventListener('click', function() {
                const salleCount = additionalSallesDiv.children.length;
                const newSalleDiv = document.createElement('div');
                newSalleDiv.className = 'mt-2 flex items-center';

                const newSalleSelect = salleSelect.cloneNode(true); // Cloner le select de salle
                newSalleSelect.name = `additional_salles[${salleCount}]`;
                newSalleSelect.id = `additional_salle_${salleCount}`;

                const removeButton = document.createElement('button');
                removeButton.type = 'button';
                removeButton.innerText = '@lang('Supprimer')';
                removeButton.className =
                    'ml-2 py-1 px-2 bg-red-500 hover:bg-red-700 text-white font-semibold rounded-md shadow-md';
                removeButton.addEventListener('click', function() {
                    additionalSallesDiv.removeChild(newSalleDiv);
                    filterAvailableSalles
                        (); // Mettre à jour les options disponibles après suppression
                });

                newSalleDiv.appendChild(newSalleSelect);
                newSalleDiv.appendChild(removeButton);
                additionalSallesDiv.appendChild(newSalleDiv);

                // Appliquer Select2 après l'ajout de la nouvelle salle
                $(newSalleSelect).select2({
                    placeholder: "@lang('Choisir une salle')",
                    allowClear: true
                });

                newSalleSelect.addEventListener('change', filterAvailableSalles);

                filterAvailableSalles(); // Appliquer les restrictions après l'ajout d'une nouvelle salle
            });

            filterAvailableSalles();

            // Gestion du mode d'affectation (manuel ou automatique)
            allocationModeSelect.addEventListener('change', function() {
                if (this.value === 'manual') {
                    manualAllocationDiv.classList.remove('hidden');
                    automaticAllocationDiv.classList.add('hidden');
                } else {
                    manualAllocationDiv.classList.add('hidden');
                    automaticAllocationDiv.classList.remove('hidden');
                }
            });

            // Initialisation de l'affichage
            allocationModeSelect.dispatchEvent(new Event('change'));
        });
    </script>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- Script pour activer Select2 -->
    <script>
        $(document).ready(function() {
            // Appliquer Select2 à la liste déroulante des enseignants
            $('#id_enseignant').select2({
                placeholder: "@lang('Choisir un enseignant')", // Placeholder par défaut
                allowClear: true // Permet de désélectionner
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            // Appliquer Select2 pour la filière
            $('#filiere').select2({
                placeholder: "@lang('Sélectionnez une filière')",
                allowClear: true
            });

            // Appliquer Select2 pour le module
            $('#module').select2({
                placeholder: "@lang('Sélectionnez un module')",
                allowClear: true
            });

            // Lorsque la filière change
            $('#filiere').on('change', function() {
                const code_etape = $(this).val();
                $('#module').empty().append(
                    '<option value="">@lang('Sélectionnez un module')</option>'
                ); // Réinitialiser le sélecteur de modules

                if (code_etape) {
                    fetch(`/examens/getModulesByFiliere/${code_etape}`)
                        .then(response => response.json())
                        .then(data => {
                            data.forEach(module => {
                                // Ajouter les modules avec le nombre d'inscriptions
                                $('#module').append(
                                    `<option value="${module.lib_elp}" data-inscriptions="${module.inscriptions_count}">${module.lib_elp} (${module.inscriptions_count} @lang('inscrits'))</option>`
                                );
                            });
                            $('#module').trigger('change'); // Mettre à jour Select2
                        })
                        .catch(error => console.error('Error fetching modules:', error));
                }
            });

            // Lorsque le module change
            $('#module').on('change', function() {
                const selectedModule = $(this).find(':selected');
                const inscriptionsCount = selectedModule.data('inscriptions') ||
                    0; // Récupérer les inscriptions

                // Mettre à jour la valeur du champ caché
                $('#inscriptions_count').val(inscriptionsCount);
            });

            // Appliquer Select2 pour les autres champs (si nécessaire)
            $('#id_salle').select2({
                placeholder: "@lang('Choisir une salle')",
                allowClear: true
            });

            $('#id_enseignant').select2({
                placeholder: "@lang('Choisir un enseignant')",
                allowClear: true
            });
        });
    </script>

</x-app-layout>
