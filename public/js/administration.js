function A(entity){
    document.getElementById(entity).style.height = "100%";
}

function M(entity){
    console.log('Modifier',entity)
}

function S(entity){
    console.log('Suprimer',entity)
}

function closeNav(entity){
    document.getElementById(entity).style.height = "0%";
}