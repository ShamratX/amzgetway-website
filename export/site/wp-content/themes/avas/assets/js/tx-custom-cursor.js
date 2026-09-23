document.addEventListener("DOMContentLoaded", function () {
  // Create cursor elements dynamically
  var cursor = document.createElement("div");
  cursor.classList.add("tx-cursor-ring");
  document.body.appendChild(cursor);

  var cursorinner = document.createElement("div");
  cursorinner.classList.add("tx-cursor-pointer");
  document.body.appendChild(cursorinner);

  document.addEventListener("mousemove", function (e) {
    cursor.style.transform = `translate3d(calc(${e.clientX}px - 50%), calc(${e.clientY}px - 50%), 0)`;
    cursorinner.style.left = e.clientX + "px";
    cursorinner.style.top = e.clientY + "px";
  });

  document.addEventListener("mousedown", function () {
    cursor.classList.add("click");
    cursorinner.classList.add("tx-cursor-inner");
  });

  document.addEventListener("mouseup", function () {
    cursor.classList.remove("click");
    cursorinner.classList.remove("tx-cursor-inner");
  });
});