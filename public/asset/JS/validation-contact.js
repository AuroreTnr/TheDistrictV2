console.log("hello");
// Sélectionner le formulaire et le bouton
const form = document.querySelector(".formulaire");
const btnSubmit = document.querySelector(".btn-submit");

// Sélectionner les messages d'erreur
const errorMsgNom = document.querySelector(".errorMsg-nom");
const errorMsgPrenom = document.querySelector(".errorMsg-prenom");
const errorMsgAdresse = document.querySelector(".errorMsg-adresse");
const errorMsgchekbox = document.querySelector(".errorMsg-checkbox");
const allErrorMsg = document.querySelectorAll(".errorMsg");

// Sélectionner les inputs
const nom = document.querySelector("#name");
const prenom = document.querySelector("#prenom");
const adresseEmail = document.querySelector("#email");
const checkbox = document.querySelector("#checkbox");

// REGEX pour validation des champs
const charValid = /^[a-zA-ZéèîïÉÈÎÏ][a-zéèêàçîï]+([-'\s][a-zA-ZéèîïÉÈÎÏ][a-zéèêàçîï]+)?$/;
const adresseValid = /^[0-9]+[\s][a-zA-ZéèîïÉÈÎÏ]+([\s][a-zA-ZéèîïÉÈÎÏ]+)*([-'\s][a-zA-ZéèîïÉÈÎÏ]+([\s][a-zéèêàçîï ]+)*)?$/;
const postalValid = /^[0-9]{5}$/;
const emailValid = /^[a-z0-9.-]+@[a-z0-9.-]{2,}\.[a-z]{2,4}$/;

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

  // Validation pour l'email
  if (adresseEmail.validity.valueMissing) {
    e.preventDefault();
    errorMsgAdresse.textContent = "Entrez votre adresse email";
  } else if (!emailValid.test(adresseEmail.value)) {
    e.preventDefault();
    errorMsgAdresse.textContent = "Format incorrect";
  }

  // Validation de la case à cocher
  if (!checkbox.checked) {
    e.preventDefault();
    errorMsgchekbox.style.color="red";
  }else{
    errorMsgchekbox.style.color="green";
  }
}




