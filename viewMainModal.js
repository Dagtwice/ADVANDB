// Get the modal
var modals = document.getElementsByClassName('modal');

// Get the button that opens the modal
var btns = document.getElementsByClassName("viewMainbtn");

// Get the <span> element that closes the modal
var spans = document.getElementsByClassName("close");
// When the user clicks on the button, open the modal 

for(let i=0;i<btns.length;i++){
    btns[i].onclick = function() {
        modals[i].style.display = "block";
    }
}

for(let i=0;i<spans.length;i++){
    spans[i].onclick = function() {
        modals[i].style.display = "none";
    }
}
// When the user clicks anywhere outside of the modal, close it

window.onclick = function(event) {
    for(let i=0; i<modals.length; i++)
        if (event.target == modals[i]) {
            modals[i].style.display = "none";
        }
}