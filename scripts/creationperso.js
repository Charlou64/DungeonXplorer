const select = document.getElementById('class-select');
const image = document.getElementById('icon');
const desc = document.getElementById('desc');
const stats = document.getElementById('stats').getElementsByClassName('stat');

select.addEventListener('change', ()=> {
    const selected=select.value;
    switch(selected){
        case "warrior":
            image.src="../images/warrior.jpg";
            desc.textContent=
            "Un guerrier redoutable très robuste et fort physiquement. Il ne peut pas utiliser la magie mais est la classe idéale pour infliger de gros dégats au corps à corps.";
            for(const stat of stats) {
                switch(stat){

                }
            };
            break;
        case "rogue":
            image.src="../images/rogue.jpg";
            desc.textContent=
            "Le voleur est très agile et furtif. Au combat, il prend la main au cas où il y a égalité au lancer d'initiative.";
            for(const stat of stats) {
                switch(stat){
                    
                }
            };
            break;
        case "mage":
            image.src="../images/mage.jpg";
            desc.textContent=
            "Le mage la classe pour ceux qui aiment bien utiliser des sorts. Il peut faire des dégats importants avec sa magie.";
            for(const stat of stats) {
                switch(stat){
                    
                }
            };
            break;
        }
});