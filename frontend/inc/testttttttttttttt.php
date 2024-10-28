list select label :Localisation générale has 3 filds : 
1- is empty fild.
2- Pont
3- Digue quai
list select label: Sub localisation 1, has 7 filds :
1- is empty fild.
2 Pieu
3 chevêtre B.A
4 chevêtre métallique
5 Appareil d'appui
6 Digue secondaire 
7 Digue principale
checkbox list multiselect label : Sub localisation 2. has 21 filds:
1 P1
2 P2
3 P3
4 P4
5 P5
6 P25
7 P26
8 P27
9 P28
10 P29
11 P30
12 P26*
13 P27*
14 P28*
15 P29*
16 Fabrication du caisson
17 Travaux Offshore
18 P1*
19 P2*
20 fabrication caisson
21 travaux ofshore
checkbox list multiselect label :Sub localisation 3. has 30 filds:
1 A
2 B
3 C
4 D
5 E
6 A1
7 A2
8 A3
9 A4
10 A5
11 B01
12 B02
13 B03
14 B04
15 B05
16 B06
17 B07
18 BC
19 Inspection Pré-béton (ferraillage,coffrage et bétonnage) du bouchon de pieux en béton 
20 Inspection de ferraillage, ferraillage,coffrage et bétonnage du chevêtre 
21 Inspection post béton (après décoffrage) des poutres de chevêtre en béton
22 Inspection de réception matériel
23 Inspection de soudage et de CND pour le chevêtre métallique  (NDT)
24 Inspection de la préparation surfacique et de la peinture pour le chevêtre 
25 Inspection visuelle de soudage et contrôle CND des plaques de bossage
26 Inspection de la préparation de surface et peinture des plaques de bossage
27 Inspection ferraillage, coffrage et mortier pour le bossage d'appareil d'appui
28 Vérification finale de la longueur de coupe et de la verticalité des pieux
29 Réception de la longueur et la verticalité des pieux , avant installation de chevêtre 
30 Verifier la préparation des joints/ inspection de l'emboitement pour l'installation de chevêtre métalliques

Condition logic:
When user select ' ' from sub localisation 1 then this filds is shown : Localisation générale & Sub localisation 1
and this filds is hidden : Sub localisation 2 & Sub localisation 3
1- When user select Pont do :
show option Pieu
show option chevêtre B.A
show option chevêtre métallique
show option Appareil d'appui
hide option Digue secondaire 
hide option Digue principale
2- When user select Digue quai do :
 hide option Pieu
hide option chevêtre B.A
hide option chevêtre métallique
hide option Appareil d'appui
show option Digue secondaire 
show option Digue principale
3- When user select pieu from sub localisation 1 do :
show fild Sub localisation 2
hide option P1
hide option P2
hide option P3
hide option P4
hide option P5
hide option P25
hide option P26
hide option P27
hide option P28
hide option P29
hide option P30
hide option P26*
hide option P27*
hide option P28*
hide option P29*
hide option Fabrication du caisson
hide option Travaux Offshore
show option P1*
show option P2*
hide option fabrication caisson
hide option travaux ofshore
4- When user select chevêtre B.A  from sub localisation 1 do :
show fild Sub localisation 2
show option P1
show option P2
show option P3
show option P4
show option P5
hide option P25
hide option P26
hide option P27
hide option P28
hide option P29
hide option P30
hide option P26*
hide option P27*
hide option P28*
hide option P29*
hide option Fabrication du caisson
hide option Travaux Offshore
hide option P1*
hide option P2*
hide option fabrication caisson
hide option travaux ofshore
5- When user select chevêtre métallique  from sub localisation 1 do :
show fild Sub localisation 2
hide option P1
hide option P2
hide option P3
hide option P4
hide option P5
show option P25
show option P26
show option P27
show option P28
show option P29
show option P30
hide option P26*
hide option P27*
hide option P28*
hide option P29*
hide option Fabrication du caisson
hide option Travaux Offshore
hide option P1*
hide option P2*
hide option fabrication caisson
hide option travaux ofshore
6- When user select Appareil d'appui  from sub localisation 1 do :
show fild Sub localisation 2
hide option P1
hide option P2
hide option P3
hide option P4
hide option P5
hide option P25
hide option P26
hide option P27
hide option P28
hide option P29
hide option P30
show option P26*
show option P27*
show option P28*
show option P29*
hide option Fabrication du caisson
hide option Travaux Offshore
hide option P1*
hide option P2*
hide option fabrication caisson
hide option travaux ofshore
7- When user select Digue secondaire  from sub localisation 1 do :
show fild Sub localisation 2
hide option P1
hide option P2
hide option P3
hide option P4
hide option P5
hide option P25
hide option P26
hide option P27
hide option P28
hide option P29
hide option P30
hide option P26*
hide option P27*
hide option P28*
hide option P29*
show option Fabrication du caisson
show option Travaux Offshore
hide option P1*
hide option P2*
hide option fabrication caisson
hide option travaux ofshore
8- When user select Digue principale  from sub localisation 1 do :
show fild Sub localisation 2
hide option P1
hide option P2
hide option P3
hide option P4
hide option P5
hide option P25
hide option P26
hide option P27
hide option P28
hide option P29
hide option P30
hide option P26*
hide option P27*
hide option P28*
hide option P29*
hide option Fabrication du caisson
hide option Travaux Offshore
hide option P1*
hide option P2*
show option fabrication caisson
show option travaux ofshore
9- When user select P1 or P2 or P3 or P4 or P5 from sub localisation 2 do :
show fild Sub localisation 3
hide option A
hide option B
hide option C
hide option D
hide option E
hide option A1
hide option A2
hide option A3
hide option A4
hide option A5
hide option B01
hide option B02
hide option B03
hide option B04
hide option B05
hide option B06
hide option B07
hide option BC
show option Inspection Pré-béton (ferraillage,coffrage et bétonnage) du bouchon de pieux en béton 
show option Inspection de ferraillage, ferraillage,coffrage et bétonnage du chevêtre 
show option Inspection post béton (après décoffrage) des poutres de chevêtre en béton
hide option Inspection de réception matériel
hide option Inspection de soudage et de CND pour le chevêtre métallique  (NDT)
hide option Inspection de la préparation surfacique et de la peinture pour le chevêtre 
hide option Inspection visuelle de soudage et contrôle CND des plaques de bossage
hide option Inspection de la préparation de surface et peinture des plaques de bossage
hide option Inspection ferraillage, coffrage et mortier pour le bossage d'appareil d'appui
show option Vérification finale de la longueur de coupe et de la verticalité des pieux
hide option Réception de la longueur et la verticalité des pieux , avant installation de chevêtre 
hide option Verifier la préparation des joints/ inspection de l'emboitement pour l'installation de chevêtre métalliques
10- When user select P25 or P26 or P27 or P28 or P29 or P30 from sub localisation 2 do :
show fild Sub localisation 3
hide option A
hide option B
hide option C
hide option D
hide option E
hide option A1
hide option A2
hide option A3
hide option A4
hide option A5
hide option B01
hide option B02
hide option B03
hide option B04
hide option B05
hide option B06
hide option B07
hide option BC
hide option Inspection Pré-béton (ferraillage,coffrage et bétonnage) du bouchon de pieux en béton 
hide option Inspection de ferraillage, ferraillage,coffrage et bétonnage du chevêtre 
hide option Inspection post béton (après décoffrage) des poutres de chevêtre en béton
show option Inspection de réception matériel
show option Inspection de soudage et de CND pour le chevêtre métallique  (NDT)
hide option Inspection de la préparation surfacique et de la peinture pour le chevêtre 
hide option Inspection visuelle de soudage et contrôle CND des plaques de bossage
show option Inspection de la préparation de surface et peinture des plaques de bossage
hide option Inspection ferraillage, coffrage et mortier pour le bossage d'appareil d'appui
hide option Vérification finale de la longueur de coupe et de la verticalité des pieux
show option Réception de la longueur et la verticalité des pieux , avant installation de chevêtre 
show option Verifier la préparation des joints/ inspection de l'emboitement pour l'installation de chevêtre métalliques
11- When user select P26* or P27* or P28* or P29* from sub localisation 2 do :
show fild Sub localisation 3
hide option A
hide option B
hide option C
hide option D
hide option E
hide option A1
hide option A2
hide option A3
hide option A4
hide option A5
hide option B01
hide option B02
hide option B03
hide option B04
hide option B05
hide option B06
hide option B07
hide option BC
hide option Inspection Pré-béton (ferraillage,coffrage et bétonnage) du bouchon de pieux en béton 
hide option Inspection de ferraillage, ferraillage,coffrage et bétonnage du chevêtre 
hide option Inspection post béton (après décoffrage) des poutres de chevêtre en béton
show option Inspection de réception matériel
hide option Inspection de soudage et de CND pour le chevêtre métallique  (NDT)
hide option Inspection de la préparation surfacique et de la peinture pour le chevêtre 
show option Inspection visuelle de soudage et contrôle CND des plaques de bossage
show option Inspection de la préparation de surface et peinture des plaques de bossage
show option Inspection ferraillage, coffrage et mortier pour le bossage d'appareil d'appui
hide option Vérification finale de la longueur de coupe et de la verticalité des pieux
hide option Réception de la longueur et la verticalité des pieux , avant installation de chevêtre 
hide option Verifier la préparation des joints/ inspection de l'emboitement pour l'installation de chevêtre métalliques
12- When user select Fabrication du caisson or Travaux Offshore from sub localisation 2 do :
show fild Sub localisation 3
hide option A
hide option B
hide option C
hide option D
hide option E
hide option A1
hide option A2
hide option A3
hide option A4
hide option A5
show option B01
show option B02
show option B03
show option B04
show option B05
show option B06
show option B07
show option BC
hide option Inspection Pré-béton (ferraillage,coffrage et bétonnage) du bouchon de pieux en béton 
hide option Inspection de ferraillage, ferraillage,coffrage et bétonnage du chevêtre 
hide option Inspection post béton (après décoffrage) des poutres de chevêtre en béton
hide option Inspection de réception matériel
hide option Inspection de soudage et de CND pour le chevêtre métallique  (NDT)
hide option Inspection de la préparation surfacique et de la peinture pour le chevêtre 
hide option Inspection visuelle de soudage et contrôle CND des plaques de bossage
hide option Inspection de la préparation de surface et peinture des plaques de bossage
hide option Inspection ferraillage, coffrage et mortier pour le bossage d'appareil d'appui
hide option Vérification finale de la longueur de coupe et de la verticalité des pieux
hide option Réception de la longueur et la verticalité des pieux , avant installation de chevêtre 
hide option Verifier la préparation des joints/ inspection de l'emboitement pour l'installation de chevêtre métalliques
13- When user select fabrication caisson or travaux ofshore from sub localisation 2 do :
show fild Sub localisation 3
hide option A
hide option B
hide option C
hide option D
hide option E
show option A1
show option A2
show option A3
show option A4
show option A5
hide option B01
hide option B02
hide option B03
hide option B04
hide option B05
hide option B06
hide option B07
hide option BC
hide option Inspection Pré-béton (ferraillage,coffrage et bétonnage) du bouchon de pieux en béton 
hide option Inspection de ferraillage, ferraillage,coffrage et bétonnage du chevêtre 
hide option Inspection post béton (après décoffrage) des poutres de chevêtre en béton
hide option Inspection de réception matériel
hide option Inspection de soudage et de CND pour le chevêtre métallique  (NDT)
hide option Inspection de la préparation surfacique et de la peinture pour le chevêtre 
hide option Inspection visuelle de soudage et contrôle CND des plaques de bossage
hide option Inspection de la préparation de surface et peinture des plaques de bossage
hide option Inspection ferraillage, coffrage et mortier pour le bossage d'appareil d'appui
hide option Vérification finale de la longueur de coupe et de la verticalité des pieux
hide option Réception de la longueur et la verticalité des pieux , avant installation de chevêtre 
hide option Verifier la préparation des joints/ inspection de l'emboitement pour l'installation de chevêtre métalliques
14- When user select P1* or P2* from sub localisation 2 do :
show fild Sub localisation 3
show option A
show option B
show option C
show option D
show option E
hide option A1
hide option A2
hide option A3
hide option A4
hide option A5
hide option B01
hide option B02
hide option B03
hide option B04
hide option B05
hide option B06
hide option B07
hide option BC
hide option Inspection Pré-béton (ferraillage,coffrage et bétonnage) du bouchon de pieux en béton 
hide option Inspection de ferraillage, ferraillage,coffrage et bétonnage du chevêtre 
hide option Inspection post béton (après décoffrage) des poutres de chevêtre en béton
hide option Inspection de réception matériel
hide option Inspection de soudage et de CND pour le chevêtre métallique  (NDT)
hide option Inspection de la préparation surfacique et de la peinture pour le chevêtre 
hide option Inspection visuelle de soudage et contrôle CND des plaques de bossage
hide option Inspection de la préparation de surface et peinture des plaques de bossage
hide option Inspection ferraillage, coffrage et mortier pour le bossage d'appareil d'appui
hide option Vérification finale de la longueur de coupe et de la verticalité des pieux
hide option Réception de la longueur et la verticalité des pieux , avant installation de chevêtre 
hide option Verifier la préparation des joints/ inspection de l'emboitement pour l'installation de chevêtre métalliques
****************************************************************************************************************************

checkbox list multiselect label :Sub localisation 4. has 16 filds:
1 -
2 MRR/Material receving report
3 Fabrication sur site 
4 Battage
5 Inspection de coffrage ferraillage et bétonnage Radier 
6 Inspection après décoffrage bétonnage Radier 
7 Inspection de coffrage ferraillage et bétonnage des voiles  
8 Inspection après décoffrage bétonnage des voiles  
9 Inspection de réparation des voiles 
10 Réception draggage 
11 Réception couche de fondation 45/125mm sous caisson 
12 Réception de caisson aprés pose 
13 Inspection de réparation des anomalies après pose
14 Réception couche de fondation 45/125mm sous anti affouilement 
15 Réception couche anti-affouilement 1-500 Kg
16 Réception de remplissage caisson

****************************************************************************************************************************
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conditional Form</title>
    <style>
        .hidden { display: none; }
    </style>
</head>
<body>
    <form method="post" action="process_form.php">
        <!-- Localisation générale -->
        <label for="localisation">Localisation générale:</label>
        <select id="localisation" name="localisation">
            <option value="">&nbsp;</option>
            <option value="Pont">Pont</option>
            <option value="Digue quai">Digue quai</option>
        </select>

        <!-- Sub localisation 1 -->
        <label for="sub_localisation_1">Sub localisation 1:</label>
        <select id="sub_localisation_1" name="sub_localisation_1">
            <option value="">&nbsp;</option>
            <option value="Pieu">Pieu</option>
            <option value="chevetre_BA">chevêtre B.A</option>
            <option value="chevetre_metallique">chevêtre métallique</option>
            <option value="Appareil_d_appui">Appareil d'appui</option>
            <option value="Digue_secondaire">Digue secondaire</option>
            <option value="Digue_principale">Digue principale</option>
        </select>

        <!-- Sub localisation 2 -->
        <div id="sub_localisation_2_container" class="hidden">
            <label>Sub localisation 2:</label><br>
            <input type="checkbox" id="p1" name="sub_localisation_2[]" value="P1"> P1<br>
            <input type="checkbox" id="p2" name="sub_localisation_2[]" value="P2"> P2<br>
            <input type="checkbox" id="p3" name="sub_localisation_2[]" value="P3"> P3<br>
            <!-- Add all other checkboxes here -->
        </div>

        <!-- Sub localisation 3 -->
        <div id="sub_localisation_3_container" class="hidden">
            <label>Sub localisation 3:</label><br>
            <input type="checkbox" id="a" name="sub_localisation_3[]" value="A"> A<br>
            <input type="checkbox" id="b" name="sub_localisation_3[]" value="B"> B<br>
            <input type="checkbox" id="c" name="sub_localisation_3[]" value="C"> C<br>
            <!-- Add all other checkboxes here -->
        </div>

        <input type="submit" value="Submit">
    </form>

    <script>
        document.getElementById('localisation').addEventListener('change', function() {
            const subLoc1 = document.getElementById('sub_localisation_1');
            const subLoc2Container = document.getElementById('sub_localisation_2_container');
            const subLoc3Container = document.getElementById('sub_localisation_3_container');
            
            // Reset visibility
            subLoc1.value = '';
            subLoc2Container.classList.add('hidden');
            subLoc3Container.classList.add('hidden');
            
            if (this.value === '') {
                subLoc1.parentElement.classList.remove('hidden');
                subLoc2Container.classList.add('hidden');
                subLoc3Container.classList.add('hidden');
            }
        });

        document.getElementById('sub_localisation_1').addEventListener('change', function() {
            const subLoc2Container = document.getElementById('sub_localisation_2_container');
            const subLoc3Container = document.getElementById('sub_localisation_3_container');

            // Logic based on sub localisation 1 selection
            switch (this.value) {
                case 'Pieu':
                    subLoc2Container.classList.remove('hidden');
                    subLoc3Container.classList.add('hidden');
                    // Manage checkbox visibility
                    // ... (implement checkbox show/hide logic here)
                    break;
                case 'chevetre_BA':
                    subLoc2Container.classList.remove('hidden');
                    subLoc3Container.classList.add('hidden');
                    // Manage checkbox visibility
                    // ... (implement checkbox show/hide logic here)
                    break;
                // Continue with the rest of the logic for other selections
                default:
                    subLoc2Container.classList.add('hidden');
                    subLoc3Container.classList.add('hidden');
                    break;
            }
        });

        document.querySelectorAll('input[name="sub_localisation_2[]"]').forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                const subLoc3Container = document.getElementById('sub_localisation_3_container');

                // Logic to manage Sub localisation 3 visibility
                if (checkbox.checked) {
                    subLoc3Container.classList.remove('hidden');
                    // ... (implement checkbox show/hide logic here)
                } else {
                    subLoc3Container.classList.add('hidden');
                }
            });
        });
    </script>
</body>
</html>

<!-- process_form.php -->
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $localisation = $_POST['localisation'] ?? '';
    $sub_localisation_1 = $_POST['sub_localisation_1'] ?? '';
    $sub_localisation_2 = $_POST['sub_localisation_2'] ?? [];
    $sub_localisation_3 = $_POST['sub_localisation_3'] ?? [];

    // Process and validate input data
    // Example: print data
    echo "Localisation: " . htmlspecialchars($localisation) . "<br>";
    echo "Sub Localisation 1: " . htmlspecialchars($sub_localisation_1) . "<br>";
    echo "Sub Localisation 2: " . implode(", ", array_map('htmlspecialchars', $sub_localisation_2)) . "<br>";
    echo "Sub Localisation 3: " . implode(", ", array_map('htmlspecialchars', $sub_localisation_3)) . "<br>";
}
?>
*****************************************
<script>
	document.addEventListener('DOMContentLoaded', function() {
    const localisationGenerale = document.getElementById('localisation_generale');
    const subLocalisation1 = document.getElementById('sub_localisation_1');
    const subLocalisation2Container = document.getElementById('sub_localisation_2_container');
    const subLocalisation2 = document.getElementById('sub_localisation_2');
    const subLocalisation3Container = document.getElementById('sub_localisation_3_container');
    const subLocalisation3 = document.getElementById('sub_localisation_3');

    const subLoc2OptionsMap = {
        'Pieu': ['P1*', 'P2*'],
        'chevetreBA': ['P1', 'P2', 'P3', 'P4', 'P5'],
        'chevetreMetallique': ['P25', 'P26', 'P27', 'P28', 'P29', 'P30'],
        'appareilAppui': ['P26*', 'P27*', 'P28*', 'P29*'],
        'digueSecondaire': ['Fabrication du caisson', 'Travaux Offshore'],
        'diguePrincipale': ['fabrication caisson', 'travaux ofshore']
    };

    const subLoc3OptionsMap = {
        'Pieu': ['A', 'B', 'C', 'D', 'E'],
        'chevetreBA': [
            'Inspection Pré-béton (ferraillage,coffrage et bétonnage) du bouchon de pieux en béton',
            'Inspection de ferraillage, ferraillage,coffrage et bétonnage du chevêtre',
            'Inspection post béton (après décoffrage) des poutres de chevêtre en béton',
            'Vérification finale de la longueur de coupe et de la verticalité des pieux'
        ],
        'chevetreMetallique': [
            'Inspection de réception matériel',
            'Inspection de soudage et de CND pour le chevêtre métallique  (NDT)',
            'Inspection de la préparation surfacique et de la peinture pour le chevêtre',
            'Réception de la longueur et la verticalité des pieux , avant installation de chevêtre',
            'Verifier la préparation des joints/ inspection de l\'emboitement pour l\'installation de chevêtre métalliques'
        ],
        'appareilAppui': [
            'Inspection de réception matériel',
            'Inspection visuelle de soudage et contrôle CND des plaques de bossage',
            'Inspection de la préparation de surface et peinture des plaques de bossage',
            'Inspection ferraillage, coffrage et mortier pour le bossage d\'appareil d\'appui'
        ],
        'digueSecondaire': ['B01', 'B02', 'B03', 'B04', 'B05', 'B06', 'B07', 'BC'],
        'diguePrincipale': ['A1', 'A2', 'A3', 'A4', 'A5']
    };

    function updateSubLocalisation1() {
        const value = localisationGenerale.value;
        Array.from(subLocalisation1.options).forEach(option => {
            if (value === 'Pont') {
                option.style.display = ['', 'Pieu', 'chevetreBA', 'chevetreMetallique', 'appareilAppui'].includes(option.value) ? '' : 'none';
            } else if (value === 'Digue_quai') {
                option.style.display = ['', 'digueSecondaire', 'diguePrincipale'].includes(option.value) ? '' : 'none';
            } else {
                option.style.display = '';
            }
        });
        subLocalisation1.value = '';
        updateSubLocalisation2();
    }

    function updateSubLocalisation2() {
        const value = subLocalisation1.value;
        subLocalisation2Container.style.display = value ? 'block' : 'none';
        const options = subLoc2OptionsMap[value] || [];
        
        // Clear existing checkboxes
        subLocalisation2.innerHTML = '';
        
        // Add new checkboxes
        options.forEach(option => {
            const label = document.createElement('label');
            const checkbox = document.createElement('input');
            checkbox.type = 'checkbox';
            checkbox.name = 'sub_localisation_2[]';
            checkbox.value = option;
            label.appendChild(checkbox);
            label.appendChild(document.createTextNode(option));
            subLocalisation2.appendChild(label);
            checkbox.addEventListener('change', updateSubLocalisation3);
        });
        
        updateSubLocalisation3();
    }

    function updateSubLocalisation3() {
        const value = subLocalisation1.value;
        const selectedOptions = Array.from(subLocalisation2.querySelectorAll('input[type="checkbox"]:checked')).map(cb => cb.value);
        subLocalisation3Container.style.display = selectedOptions.length > 0 ? 'block' : 'none';
        
        let options = [];
        if (value === 'Pieu' && (selectedOptions.includes('P1*') || selectedOptions.includes('P2*'))) {
            options = ['A', 'B', 'C', 'D', 'E'];
        } else {
            options = subLoc3OptionsMap[value] || [];
        }
        
        // Clear existing checkboxes
        subLocalisation3.innerHTML = '';
        
        // Add new checkboxes
        options.forEach(option => {
            const label = document.createElement('label');
            const checkbox = document.createElement('input');
            checkbox.type = 'checkbox';
            checkbox.name = 'sub_localisation_3[]';
            checkbox.value = option;
            label.appendChild(checkbox);
            label.appendChild(document.createTextNode(option));
            subLocalisation3.appendChild(label);
        });
    }

    localisationGenerale.addEventListener('change', updateSubLocalisation1);
    subLocalisation1.addEventListener('change', updateSubLocalisation2);

    // Initial setup
    updateSubLocalisation1();
});
	</script>

i want you to add a checkbox list multiselect label :Sub localisation 4. has 16 filds:
1 -
2 MRR/Material receving report
3 Fabrication sur site 
4 Battage
5 Inspection de coffrage ferraillage et bétonnage Radier 
6 Inspection après décoffrage bétonnage Radier 
7 Inspection de coffrage ferraillage et bétonnage des voiles  
8 Inspection après décoffrage bétonnage des voiles  
9 Inspection de réparation des voiles 
10 Réception draggage 
11 Réception couche de fondation 45/125mm sous caisson 
12 Réception de caisson aprés pose 
13 Inspection de réparation des anomalies après pose
14 Réception couche de fondation 45/125mm sous anti affouilement 
15 Réception couche anti-affouilement 1-500 Kg
16 Réception de remplissage caisson
condition logical :
show only options 2, 3, 4 from Sub localisation 4 when A,B,C,D or E are selected from Sub localisation 3, and hide all other options
show only options 5, 6, 7,8,9 from Sub localisation 4 when A1,A2,A3,A4 or A5 are selected from Sub localisation 3, and hide all other options
show only options 5, 6, 7,8,9 from Sub localisation 4 when A1,A2,A3,A4 or A5 are selected from Sub localisation 3, and hide all other options