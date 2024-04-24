function changeStyle() {
    var element = document.getElementById("myElement");
    element.classList.add("card-style");
  
    setTimeout(function() {
      element.classList.add("no-transition");
      element.classList.remove("card-style");
      setTimeout(function() {
        element.classList.remove("no-transition");
      }, 20);
    }, 2000); // 2 seconds
  };
  
  function buttonStyle() {
    var button = document.getElementById("myButton");
    button.classList.add("button-style");
  
    setTimeout(function() {
      button.classList.remove("button-style");
    }, 200); // 0.2 seconds
  }
  
  const myButton = document.getElementById("myButton");
  
  myButton.addEventListener("click", () => {
    myButton.setAttribute("disabled", true);
  
    setTimeout(() => {
      myButton.removeAttribute("disabled");
    }, 2000); // 2 seconds
  });
  
  function animateButton() {
    var btn = document.querySelector('.button-default');
    btn.classList.add('animate');
    setTimeout(function() {
      btn.classList.remove('animate');
    }, 2000); // 2 seconds
  }