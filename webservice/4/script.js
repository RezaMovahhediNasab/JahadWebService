document.addEventListener('DOMContentLoaded', () => {
    const url = 'https://dummyjson.com/products';
    const productContainer = document.getElementById('product-container');

    fetch(url)
        .then(response => response.json())
        .then(data => {
            const products = data.products;
            products.forEach(product => {
                const productDiv = document.createElement('div');
                productDiv.classList.add('product');

                const productImage = document.createElement('img');
                productImage.src = product.thumbnail;
                productDiv.appendChild(productImage);

                const productTitle = document.createElement('h3');
                productTitle.textContent = product.title;
                productDiv.appendChild(productTitle);

                const productDescription = document.createElement('p');
                productDescription.textContent = product.description;
                productDiv.appendChild(productDescription);

                productContainer.appendChild(productDiv);
            });
        })
        .catch(error => console.error('Error fetching the products:', error));
});
