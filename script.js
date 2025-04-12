// Function to add an item to the cart using name, price, and image
function addToCart(name, price, image) {
    let cart = JSON.parse(localStorage.getItem('cart')) || [];

    const existing = cart.find(item => item.name === name);
    if (existing) {
        existing.quantity += 1;
    } else {
        cart.push({ name, price, image, quantity: 1 });
    }

    localStorage.setItem('cart', JSON.stringify(cart));
    alert(`${name} has been added to your cart.`);
    updateCart();
}

// Function to update the cart display
function updateCart() {
    const cart = JSON.parse(localStorage.getItem('cart')) || [];
    const cartItems = document.getElementById('cart-items');
    const totalPriceElement = document.getElementById('total-price');
    const checkoutButton = document.getElementById('checkout-button');

    cartItems.innerHTML = '';
    let total = 0;

    cart.forEach((item, index) => {
        const li = document.createElement('li');
        li.innerHTML = `${item.name} (x${item.quantity}) - $${(item.price * item.quantity).toFixed(2)} 
        <button onclick="removeFromCart(${index})">Remove</button>`;
        cartItems.appendChild(li);
        total += item.price * item.quantity;
    });

    totalPriceElement.textContent = total.toFixed(2);
    checkoutButton.disabled = cart.length === 0;
}

// Function to remove an item from the cart
function removeFromCart(index) {
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    cart.splice(index, 1);
    localStorage.setItem('cart', JSON.stringify(cart));
    updateCart();
}

// Load cart when page is loaded
window.onload = () => {
    updateCart();
};

// Checkout button functionality
document.addEventListener('DOMContentLoaded', () => {
    const checkoutButton = document.getElementById('checkout-button');
    if (checkoutButton) {
        checkoutButton.addEventListener('click', () => {
            window.location.href = 'checkout.html';
        });
    }
});
