(function() {
  "use strict";
  // Hide the message box after a few seconds
  var QmessageBox = document.querySelector("#messagebox");
  if (!QmessageBox.classList.contains("hidden")) {
    window.setTimeout(function() {
      QmessageBox.classList.add("hidden");
    }, 2 * 1000);
  }
}());
