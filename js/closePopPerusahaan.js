function closePopUp() {
  var popUpAddData = document.getElementById("popUpAddData");
  popUpAddData.style.display = "none";

  // Reload the current page after a short delay
  setTimeout(function () {
    window.location.href = "halaman_dataperusahaan.php";
    console.log("Page reloaded");
  }, 20); // Adjust the delay time as needed
}
