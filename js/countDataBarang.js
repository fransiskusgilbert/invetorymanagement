function updateSisaStock() {
  // Get the values from the input fields
  var databarangkeluar_stockAwal = parseFloat(document.getElementById("stockAwal").value) || 0;
  var databarangkeluar_stockKeluar = parseFloat(document.getElementById("stockKeluar").value) || 0;

  // Calculate the total penjualan
  var databarangkeluar_sisaStock = databarangkeluar_stockAwal - databarangkeluar_stockKeluar;

  // Update the value in the totalPenjualan input field
  document.getElementById("stockSisa").value = databarangkeluar_sisaStock;
}
