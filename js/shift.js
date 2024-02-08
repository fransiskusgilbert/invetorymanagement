document.addEventListener("DOMContentLoaded", function () {
  var tables = document.querySelectorAll(".tb-dataobat");

  tables.forEach(function (table) {
    var shiftElements = table.querySelectorAll(".jenisShift");

    shiftElements.forEach(function (element) {
      var shift = element.textContent.trim();

      if (shift === "shift1") {
        element.innerText = "Pagi - Sore";
      } else {
        element.innerText = "Sore - Malam";
      }
    });
  });
});
