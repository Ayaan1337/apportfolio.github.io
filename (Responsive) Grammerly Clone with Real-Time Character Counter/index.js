const charVal = document.getElementById("textarea");
let totalCount = document.getElementById("total-character");
let remainingCount = document.getElementById("remaining-counter");

let Char = 0;

const updateCounter = () => {
    userChar = charVal.value.length;

    totalCount.innerText = userChar;

    remainingCount.innerText = 280 - userChar;
};

charVal.addEventListener("keyup", () => updateCounter());   

const copyText = () => {
    // charVal.select();
    charVal.setSelectionRange(0, 99999);
    navigator.clipboard.writeText(charVal.value); //IMP
};