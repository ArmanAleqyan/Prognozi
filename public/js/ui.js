document.addEventListener("DOMContentLoaded", () => {
  document.querySelector(".language__title").addEventListener("click", () => {
    document.querySelector(".language__list").classList.toggle("active");
  });

  document
    .querySelector(".language-mobile__title")
    .addEventListener("click", () => {
      document
        .querySelector(".language-mobile__list")
        .classList.toggle("active");
    });

  document.querySelector(".utc").addEventListener("click", () => {
    document.querySelector(".utc__list").classList.toggle("active");
  });
  document.querySelector(".utc-mobile").addEventListener("click", () => {
    document.querySelector(".utc-mobile__list").classList.toggle("active");
  });

  document.querySelectorAll("img.arrow").forEach((element) => {
    element.addEventListener("click", (e) => {
      e.currentTarget.classList.toggle("toggle");
      e.currentTarget.parentNode.nextElementSibling.classList.toggle("toggle");
    });
  });

  document.querySelector(".menu-button").addEventListener("click", () => {
    document.querySelector(".navbar-mobile").classList.toggle("active");
    document.querySelector(".menu-button").classList.toggle("active");
  });

  function mediaUI() {
    const mediaQuery = window.matchMedia("(max-width: 1100px)");

    if (mediaQuery.matches) {
      try {
        let filter = document.querySelector(".list-filter");
        let items = filter.querySelectorAll("li");
        items.forEach((element) => {
          if (element.childNodes.length >= 2) {
            element.lastChild.data = "";
          } else {
          }
        });
      } catch (error) {}
    }

    try {
      let rows = document.querySelectorAll(".row-1");
      rows.forEach((row) => {
        if (row.innerText) {
        } else {
          row.style.display = "none";
        }
      });
    } catch (error) {}
  }

  mediaUI();
});
