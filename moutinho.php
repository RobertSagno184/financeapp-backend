<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    $montableau = array(
        array('robert','moutinho', 24, 'robertsagno184@gmail.com'),
        array('david','dopaye', 22, 'daved@gmail.com'),
        array('akess','goumou', 26, 'goumou@gmail.com'),
    );
    
    echo'mon nom complet est: '.$montableau[0][0].' '.$montableau[0][1].' et j\'ai: '.$montableau[0][2].' mon adresse mail est:'.$montableau[0][3].'</br>';
    echo'mon nom complet est: '.$montableau[1][0].' '.$montableau[1][1].' et j\'ai: '.$montableau[1][2].' mon adresse mail est:'.$montableau[1][3].'</br>';
    echo'mon nom complet est: '.$montableau[2][0].' '.$montableau[2][1].' et j\'ai: '.$montableau[2][2].' mon adresse mail est:'.$montableau[2][3].'</br>';
    
    for ($Ligne=0; $Ligne < 3 ; $Ligne++) {
        $nombreLigne = $Ligne +1;
        echo 'Membre numero '.$nombreLigne.'</br>';
        echo '<ul>';
        for ($col=0; $col <3 ; $col++) { 
            echo '<li>'.$montableau[$Ligne][$col].'</li>';
            # code...
        }
        echo'</ul>';

        # code...
    }

    ?>
</body>
</html>