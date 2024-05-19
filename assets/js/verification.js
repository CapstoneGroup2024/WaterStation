document.addEventListener('DOMContentLoaded', function() {
  'use strict';

  var inputs = document.querySelectorAll('input');

  function goToNextInput(e) {
      var key = e.which || e.keyCode;
      var target = e.target;

      // Allow tab key (key code 9) and numeric keys (key codes 48-57)
      if (key !== 9 && (key < 48 || key > 57)) {
          e.preventDefault();
          return false;
      }

      if (key === 9) {
          return true;
      }

      var nextInputIndex = Array.from(inputs).indexOf(target) + 1;
      var nextInput = inputs[nextInputIndex];

      if (!nextInput) {
          nextInput = inputs[0];
      }

      nextInput.focus();
      nextInput.select();
  }

  function onKeyDown(e) {
      var key = e.which || e.keyCode;

      // Allow tab key (key code 9) and numeric keys (key codes 48-57)
      if (key === 9 || (key >= 48 && key <= 57)) {
          return true;
      }

      e.preventDefault();
      return false;
  }

  function onFocus(e) {
      e.target.select();
  }

  inputs.forEach(function(input) {
      input.addEventListener('keyup', goToNextInput);
      input.addEventListener('keydown', onKeyDown);
      input.addEventListener('click', onFocus);
  });
});
