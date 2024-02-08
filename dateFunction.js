function myDate() {
  const date = new Date();
  arr_bulan = [
    "Januari",
    "Februari",
    "Maret",
    "April",
    "Mei",
    "Juni",
    "Juli",
    "Agustus",
    "September",
    "Oktober",
    "November",
    "Desember",
  ];

  let dayNow = date.getDate();
  let monthNow = arr_bulan[date.getMonth()];
  let yearNow = date.getFullYear();

  var dateZ = dayNow + "/" + monthNow + "/" + yearNow;

  document.getElementById("dateNow").innerHTML = dateZ;
}
setInterval(myDate, 100);
