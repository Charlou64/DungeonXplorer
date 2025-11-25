const select = document.getElementById('class-select');
const image = document.getElementById('icon');

select.addEventListener('change', ()=> {
    const selected=select.value;
    switch(selected){
        case "warrior":
            image.src="../images/warrior.jpg";
            break;
        case "rogue":
            image.src="../images/rogue.jpg";
            break;
        case "mage":
            image.src="../images/mage.jpg";
            break;
        }
});