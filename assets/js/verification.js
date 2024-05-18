window.addEventListener("DOMContentLoaded", () => {
    const inputs = document.querySelectorAll(".input-field input"),
      button = document.querySelector("button");

    inputs.forEach((input, index1) => {
      input.addEventListener("input", () => {
        const currentInput = input,
          nextInput = input.nextElementSibling,
          prevInput = input.previousElementSibling;

        if (currentInput.value.length > 1) {
          currentInput.value = currentInput.value.slice(0, 1);
          return;
        }

        if (nextInput && nextInput.hasAttribute("disabled") && currentInput.value !== "") {
          nextInput.removeAttribute("disabled");
          nextInput.focus();
        }

        if (currentInput.value === "") {
          if (prevInput) {
            prevInput.focus();
          }
        }

        inputs.forEach((input, index2) => {
          if (index1 <= index2 && prevInput) {
            input.setAttribute("disabled", true);
            input.value = "";
            prevInput.focus();
          }
        });

        if (!inputs[5].disabled && inputs[5].value !== "") {
          button.classList.add("active");
          return;
        }
        button.classList.remove("active");
      });
    });
  });