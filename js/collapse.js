const coll = document.getElementById("collapse");
const navSide = document.querySelectorAll("nav-side");

console.log(navSide);

coll.addEventListener("click", function () {
  minimizeSideBar();
  expandSideBar();
});

function minimizeSideBar() {
  document.querySelector("body").classList.toggle("short");
}

function expandSideBar() {
  document.querySelector("body").classList.toggle("expand");
}
