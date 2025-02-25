console.log("hello");

// Sélectionner le formulaire et le bouton
const form = document.querySelector(".formulaire");
const btnSubmit = document.querySelector(".btn-submit");

// Sélectionner les messages d'erreur
const errorMsgNom = document.querySelector(".errorMsg-nom");
const errorMsgPrenom = document.querySelector(".errorMsg-prenom");
const errorMsgAdresse = document.querySelector(".errorMsg-adresse");
const errorMsgPostal = document.querySelector(".errorMsg-postal");
const allErrorMsg = document.querySelectorAll(".errorMsg");

// Sélectionner les inputs
const nom = document.querySelector("#name");
const prenom = document.querySelector("#prenom");
const adresse = document.querySelector("#adresse");
const postal = document.querySelector("#postal");

// REGEX pour validation des champs
const charValid = /^[a-zA-ZéèîïÉÈÎÏ][a-zéèêàçîï]+([-'\s][a-zA-ZéèîïÉÈÎÏ][a-zéèêàçîï]+)?$/;
const adresseValid = /^[0-9]+[\s][a-zA-ZéèîïÉÈÎÏ]+([\s][a-zA-ZéèîïÉÈÎÏ]+)*([-'\s][a-zA-ZéèîïÉÈÎÏ]+([\s][a-zéèêàçîï ]+)*)?$/;
const postalValid = /^[0-9]{5}$/;

form.addEventListener('submit', handleSubmit);

function handleSubmit(e) {
  // Réinitialiser les messages d'erreur
  allErrorMsg.forEach(msg => msg.textContent = "");

  // Validation pour le nom
  if (nom.validity.valueMissing) {
    e.preventDefault();
    errorMsgNom.textContent = "Entrez votre nom";
  } else if (!charValid.test(nom.value)) {
    e.preventDefault();
    errorMsgNom.textContent = "Format incorrect";
  }

  // Validation pour le prénom
  if (prenom.validity.valueMissing) {
    e.preventDefault();
    errorMsgPrenom.textContent = "Entrez votre prénom";
  } else if (!charValid.test(prenom.value)) {
    e.preventDefault();
    errorMsgPrenom.textContent = "Format incorrect";
  }

  // Validation pour le adresse
  if (adresse.validity.valueMissing) {
    e.preventDefault();
    errorMsgAdresse.textContent = "Entrez votre adresse";
  } else if (!adresseValid.test(adresse.value)) {
    e.preventDefault();
    errorMsgAdresse.textContent = "Format incorrect";
  }

  // Validation pour le postal
  if (postal.validity.valueMissing) {
    e.preventDefault();
    errorMsgPostal.textContent = " Entrez votre code postal";
  } else if (!postalValid.test(postal.value)) {
    e.preventDefault();
    errorMsgPostal.textContent = " Il doit contenir 5 chiffres";
  }

}




