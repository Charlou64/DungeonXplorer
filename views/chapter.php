<div style="position: relative; display: inline-block; width: 100%;">
    <img src="<?php echo $chapter->getImage(); ?>" alt="Image de chapitre" style="max-width: 100%; height: auto; display: block;">
    
    <!-- Titre en haut -->
    <div style="position: absolute; top: 20px; left: 20px; right: 20px;">
        <h1 style="margin: 0; background-color: rgba(0, 0, 0, 0.7); color: white; padding: 10px 15px; border-radius: 10px; display: inline-block;">Chapitre <?php echo $chapter->getId(); ?></h1>
        <h2 style="margin: 10px 0 0 0; background-color: rgba(0, 0, 0, 0.7); color: white; padding: 10px 15px; border-radius: 10px; display: inline-block;"><?php echo $chapter->getTitle(); ?></h2>
    </div>

    <!-- Texte descriptif -->
    <div style="position: absolute; bottom: 50%; left: 50px; right: 50px; background-color: rgba(255, 255, 255, 0.8); color: black; padding: 15px; border-radius: 30px; font-size: 25px; line-height: 1.5;">
        <?php echo $chapter->getDescription(); ?>
    </div>

    <!-- Choix en bas (au-dessus du texte) -->
    <div style="position: absolute; bottom: 20px; left: 20px; right: 20px;">
        <?php 
            $choices = $chapter->getChoices();
            if (count($choices) > 0) {
                //echo '<ul class="list-group" style="margin: 0; background-color: rgba(0, 0, 0, 0.7); padding: 10px; border-radius: 10px;">';
                foreach ($choices as $choice) {
                    echo //'<li class="list-group-item" style="background-color: rgba(255, 255, 255, 0.9); margin-bottom: 8px; border-radius: 5px;">
                            '<a href="' . $_SESSION["basepath"] . '/chapter/' . $choice['next_chapter_id'] . '" class="button" style="color: black; text-decoration: none; display: block; padding: 10px;">
                                ' . htmlspecialchars($choice['description']) . '
                            </a>
                        </li>';
                }
                echo '</ul>';
            }
        ?>
    </div>
</div>