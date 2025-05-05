document.addEventListener("DOMContentLoaded", function () {
    const items = document.querySelectorAll(".col.home-timeline-item");
    items.forEach((item, index) => {
      if ((index + 1) % 2 === 0) {
        item.classList.add("even");
      }
    });
  });