let btnModifMail = document.querySelector("#btnModifMail");
let btnValidModifMail = document.querySelector("#btnValidModifMail");
let divMail = document.querySelector("#email");
let divModificationMail = document.querySelector("#modificationMail");
// Des que je clique sur le btnModifMail je veux vouloir cassé le div qui porte id=email et je veux afficheé le div qui porte id=modificationMail
btnModifMail.addEventListener("click", function(){
    // le premiere div que je veux cassé
    divMail.classList.add("d-none");
    divModificationMail.classList.remove("d-none");
})
document.querySelector("#btnSupCompte").addEventListener("click", function(){
    console.log("test");
    document.querySelector("#suppressionCompte").classList.remove("d-none");
})

