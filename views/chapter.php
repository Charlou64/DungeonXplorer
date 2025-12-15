<h1>Chapitre <?php echo $chapter->getId(); ?></h1>
<h2><?php echo $chapter->getTitle(); ?></h2>
<img src="<?php echo $chapter->getImage(); ?>" alt="Image de chapitre" style="max-width: 100%; height: auto;">
<p><?php echo $chapter->getDescription(); ?></p>

<?php 
    $choices = $chapter->getChoices(); // Récupération des choix

    if (count($choices) > 0) {
        echo '
        <h2>Choisissez votre chemin:</h2>
        <ul class="list-group">'; 
        
        foreach ($choices as $choice) {
            // Syntaxe PHP correcte et bonnes clés : 'next_chapter_id' et 'description'
            echo '<li class="list-group-item">
                    <a href="' . $_SESSION["basepath"] . '/chapter/' . $choice['next_chapter_id'] . '" class="button">
                        ' . htmlspecialchars($choice['description']) . '
                    </a>
                </li>';
        }
        echo '</ul>';
    } 
?>