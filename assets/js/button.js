function changeStyle() { // FUNCTION TO CHANGE STYLE OF AN ELEMENT WITH TRANSITION
  var element = document.getElementById("myElement");
  element.classList.add("card-style"); // ADD CARD-STYLE CLASS TO THE ELEMENT

  setTimeout(function() { // DELAY THE REMOVAL OF CARD-STYLE CLASS TO CREATE A TRANSITION EFFECT
      element.classList.add("no-transition"); // ADD NO-TRANSITION CLASS TO DISABLE TRANSITION
      element.classList.remove("card-style"); // REMOVE CARD-STYLE CLASS
      setTimeout(function() {
          element.classList.remove("no-transition"); // REMOVE NO-TRANSITION CLASS AFTER A SHORT DELAY
      }, 20); // 20 MILLISECONDS
  }, 2000); // 2 SECONDS
}

function buttonStyle() { // FUNCTION TO TEMPORARILY CHANGE STYLE OF A BUTTON
  var button = document.getElementById("myButton");
  button.classList.add("button-style"); // ADD BUTTON-STYLE CLASS TO THE BUTTON

  setTimeout(function() { // REMOVE BUTTON-STYLE CLASS AFTER A SHORT DELAY TO CREATE A TEMPORARY STYLE CHANGE
      button.classList.remove("button-style"); // REMOVE BUTTON-STYLE CLASS
  }, 200); // 200 MILLISECONDS (0.2 SECONDS)
}

const myButton = document.getElementById("myButton"); 

myButton.addEventListener("click", () => { // ADD EVENT LISTENER TO THE BUTTON TO DISABLE IT TEMPORARILY WHEN CLICKED
  myButton.setAttribute("disabled", true); // DISABLE THE BUTTON WHEN CLICKED

  setTimeout(() => { // ENABLE THE BUTTON AFTER A DELAY TO SIMULATE A TEMPORARY DISABLE STATE
      myButton.removeAttribute("disabled"); // REMOVE THE DISABLED ATTRIBUTE AFTER A DELAY
  }, 2000); // 2 SECONDS
});

function animateButton() { // FUNCTION TO ANIMATE A BUTTON BY ADDING AND REMOVING A CLASS
  var btn = document.querySelector('.button-default');
  btn.classList.add('animate'); // ADD ANIMATE CLASS TO THE BUTTON TO TRIGGER ANIMATION

  setTimeout(function() { // REMOVE ANIMATE CLASS AFTER A DELAY TO STOP THE ANIMATION
      btn.classList.remove('animate'); // REMOVE ANIMATE CLASS
  }, 2000); // 2 SECONDS
}
