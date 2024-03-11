const items = document.querySelectorAll("#btns .btn");
const pro = document.querySelectorAll(".pro-container .pro");



const productsContainer = document.getElementById('products');
products = productsContainer.querySelectorAll('.pro');
const itemsPerPage = 8; 
totalPages = Math.ceil(products.length / itemsPerPage);




items.forEach((item) => {
  item.addEventListener("click", () => {
    items.forEach((item) => {
      item.classList.remove("active");
    });
    totalPages = Math.ceil(products.length / itemsPerPage);
    createPageButtons();
    showPage(1);
    item.classList.add("active");

    const valueAttr = item.getAttribute("data-filter");
    
    products = [];

    pro.forEach((item) => {
      item.style.display = "none";
      if (
        item.getAttribute("data-filter").toLowerCase() ==
          valueAttr.toLowerCase() ||
        valueAttr == "all"
      ) {
        item.style.display = "block";
        products = products.concat([item]);
      }
    });
    totalPages = Math.ceil(products.length / itemsPerPage);
    createPageButtons();
    showPage(1);
  });
});

function createPageButtons() {
    paginationContainer = document.getElementById('pagination-container');
    paginationContainer.innerHTML = ''; 
    for (let i = 1; i <= totalPages; i++) {
      const button = document.createElement('button');
      button.textContent = i;
      button.addEventListener('click', () => {
        showPage(i);
      });
      paginationContainer.appendChild(button);
    }
  }

  function showPage(pageNumber) {
    const startIndex = (pageNumber - 1) * itemsPerPage;
    const endIndex = startIndex + itemsPerPage;
  
    products.forEach((product, index) => {
      product.style.display = index >= startIndex && index < endIndex ? 'block' : 'none';
    });
  }
  createPageButtons();
  showPage(1);
  


  
  
  