<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Localisation Form</title>
    <style>
        .hidden {
            display: none;
        }
    </style>
</head>
<body>
    <form id="localisationForm">
        <div>
            <label for="localisationGenerale">Localisation générale:</label>
            <select id="localisationGenerale" name="localisationGenerale">
                <option value=""></option>
                <option value="Pont">Pont</option>
                <option value="DigueQuai">Digue quai</option>
            </select>
        </div>

        <div>
            <label for="subLocalisation1">Sub localisation 1:</label>
            <select id="subLocalisation1" name="subLocalisation1">
                <option value=""></option>
                <option value="Pieu">Pieu</option>
                <option value="chevêtreBA">chevêtre B.A</option>
                <option value="chevêtreMétallique">chevêtre métallique</option>
                <option value="AppareilAppui">Appareil d'appui</option>
                <option value="DigueSecondaire">Digue secondaire</option>
                <option value="DiguePrincipale">Digue principale</option>
            </select>
        </div>

        <div id="subLocalisation2Container" class="hidden">
            <label>Sub localisation 2:</label>
            <div id="subLocalisation2Options"></div>
        </div>

        <div id="subLocalisation3Container" class="hidden">
            <label>Sub localisation 3:</label>
            <div id="subLocalisation3Options"></div>
        </div>
    </form>

    <script>
        const subLocalisation2Options = [
            'P1', 'P2', 'P3', 'P4', 'P5', 'P25', 'P26', 'P27', 'P28', 'P29', 'P30',
            'P26*', 'P27*', 'P28*', 'P29*', 'Fabrication du caisson', 'Travaux Offshore',
            'P1*', 'P2*', 'fabrication caisson', 'travaux ofshore'
        ];

        const subLocalisation3Options = [
            'A', 'B', 'C', 'D', 'E', 'A1', 'A2', 'A3', 'A4', 'A5',
            'B01', 'B02', 'B03', 'B04', 'B05', 'B06', 'B07', 'BC',
            'Inspection Pré-béton (ferraillage,coffrage et bétonnage) du bouchon de pieux en béton',
            'Inspection de ferraillage, ferraillage,coffrage et bétonnage du chevêtre',
            'Inspection post béton (après décoffrage) des poutres de chevêtre en béton',
            'Inspection de réception matériel',
            'Inspection de soudage et de CND pour le chevêtre métallique  (NDT)',
            'Inspection de la préparation surfacique et de la peinture pour le chevêtre',
            'Inspection visuelle de soudage et contrôle CND des plaques de bossage',
            'Inspection de la préparation de surface et peinture des plaques de bossage',
            'Inspection ferraillage, coffrage et mortier pour le bossage d\'appareil d\'appui',
            'Vérification finale de la longueur de coupe et de la verticalité des pieux',
            'Réception de la longueur et la verticalité des pieux , avant installation de chevêtre',
            'Verifier la préparation des joints/ inspection de l\'emboitement pour l\'installation de chevêtre métalliques'
        ];

        function createCheckboxes(container, options) {
            container.innerHTML = '';
            options.forEach(option => {
                const checkbox = document.createElement('input');
                checkbox.type = 'checkbox';
                checkbox.id = option;
                checkbox.name = option;
                checkbox.value = option;

                const label = document.createElement('label');
                label.htmlFor = option;
                label.appendChild(document.createTextNode(option));

                container.appendChild(checkbox);
                container.appendChild(label);
                container.appendChild(document.createElement('br'));
            });
        }

        function updateSubLocalisation1(value) {
            const subLocalisation1 = document.getElementById('subLocalisation1');
            subLocalisation1.innerHTML = '<option value=""></option>';
            if (value === 'Pont') {
                ['Pieu', 'chevêtre B.A', 'chevêtre métallique', 'Appareil d\'appui'].forEach(option => {
                    const optionElement = document.createElement('option');
                    optionElement.value = option;
                    optionElement.textContent = option;
                    subLocalisation1.appendChild(optionElement);
                });
            } else if (value === 'DigueQuai') {
                ['Digue secondaire', 'Digue principale'].forEach(option => {
                    const optionElement = document.createElement('option');
                    optionElement.value = option;
                    optionElement.textContent = option;
                    subLocalisation1.appendChild(optionElement);
                });
            }
        }

        function updateSubLocalisation2(value) {
            const container = document.getElementById('subLocalisation2Container');
            const optionsContainer = document.getElementById('subLocalisation2Options');
            container.classList.remove('hidden');
            let visibleOptions;

            switch(value) {
                case 'Pieu':
                    visibleOptions = ['P1*', 'P2*'];
                    break;
                case 'chevêtre B.A':
                    visibleOptions = ['P1', 'P2', 'P3', 'P4', 'P5'];
                    break;
                case 'chevêtre métallique':
                    visibleOptions = ['P25', 'P26', 'P27', 'P28', 'P29', 'P30'];
                    break;
                case 'Appareil d\'appui':
                    visibleOptions = ['P26*', 'P27*', 'P28*', 'P29*'];
                    break;
                case 'Digue secondaire':
                    visibleOptions = ['Fabrication du caisson', 'Travaux Offshore'];
                    break;
                case 'Digue principale':
                    visibleOptions = ['fabrication caisson', 'travaux ofshore'];
                    break;
                default:
                    container.classList.add('hidden');
                    return;
            }

            createCheckboxes(optionsContainer, visibleOptions);
        }

        function updateSubLocalisation3(selectedOptions) {
            const container = document.getElementById('subLocalisation3Container');
            const optionsContainer = document.getElementById('subLocalisation3Options');
            container.classList.remove('hidden');
            let visibleOptions;

            if (selectedOptions.some(option => ['P1', 'P2', 'P3', 'P4', 'P5'].includes(option))) {
                visibleOptions = [
                    'Inspection Pré-béton (ferraillage,coffrage et bétonnage) du bouchon de pieux en béton',
                    'Inspection de ferraillage, ferraillage,coffrage et bétonnage du chevêtre',
                    'Inspection post béton (après décoffrage) des poutres de chevêtre en béton',
                    'Vérification finale de la longueur de coupe et de la verticalité des pieux'
                ];
            } else if (selectedOptions.some(option => ['P25', 'P26', 'P27', 'P28', 'P29', 'P30'].includes(option))) {
                visibleOptions = [
                    'Inspection de réception matériel',
                    'Inspection de soudage et de CND pour le chevêtre métallique  (NDT)',
                    'Inspection de la préparation de surface et peinture des plaques de bossage',
                    'Réception de la longueur et la verticalité des pieux , avant installation de chevêtre',
                    'Verifier la préparation des joints/ inspection de l\'emboitement pour l\'installation de chevêtre métalliques'
                ];
            } else if (selectedOptions.some(option => ['P26*', 'P27*', 'P28*', 'P29*'].includes(option))) {
                visibleOptions = [
                    'Inspection de réception matériel',
                    'Inspection visuelle de soudage et contrôle CND des plaques de bossage',
                    'Inspection de la préparation de surface et peinture des plaques de bossage',
                    'Inspection ferraillage, coffrage et mortier pour le bossage d\'appareil d\'appui'
                ];
            } else if (selectedOptions.includes('Fabrication du caisson') || selectedOptions.includes('Travaux Offshore')) {
                visibleOptions = ['B01', 'B02', 'B03', 'B04', 'B05', 'B06', 'B07', 'BC'];
            } else if (selectedOptions.includes('fabrication caisson') || selectedOptions.includes('travaux ofshore')) {
                visibleOptions = ['A1', 'A2', 'A3', 'A4', 'A5'];
            } else {
                container.classList.add('hidden');
                return;
            }

            createCheckboxes(optionsContainer, visibleOptions);
        }

        document.getElementById('localisationGenerale').addEventListener('change', function(e) {
            updateSubLocalisation1(e.target.value);
            document.getElementById('subLocalisation1').value = '';
            document.getElementById('subLocalisation2Container').classList.add('hidden');
            document.getElementById('subLocalisation3Container').classList.add('hidden');
        });

        document.getElementById('subLocalisation1').addEventListener('change', function(e) {
            updateSubLocalisation2(e.target.value);
            document.getElementById('subLocalisation3Container').classList.add('hidden');
        });

        document.getElementById('subLocalisation2Options').addEventListener('change', function() {
            const selectedOptions = Array.from(this.querySelectorAll('input:checked')).map(input => input.value);
            updateSubLocalisation3(selectedOptions);
        });
    </script>
</body>
</html>