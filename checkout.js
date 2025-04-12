// Function to display the cart items and total price
function displayCartItems() {
    const cartItemsList = document.getElementById('cartItemsList');
    let totalPrice = 0;

    cartItemsList.innerHTML = ""; // Clear any existing cart items

    const cart = JSON.parse(localStorage.getItem('cart')) || [];

    cart.forEach(item => {
        const listItem = document.createElement('li');
        listItem.innerHTML = `${item.name} - $${item.price} x ${item.quantity} = $${item.price * item.quantity}`;
        cartItemsList.appendChild(listItem);
        totalPrice += item.price * item.quantity;
    });

    document.getElementById('totalPrice').textContent = `$${totalPrice.toFixed(2)}`;
}

// Handle the form submission for shipping details
document.getElementById('shippingForm').addEventListener('submit', function (e) {
    e.preventDefault();
    
    // Get the form data
    const name = document.getElementById('name').value;
    const address = document.getElementById('address').value;
    const email = document.getElementById('email').value;
    const phone = document.getElementById('phone').value;

    // Simple validation to ensure all fields are filled
    if (name && address && email && phone) {
        alert(`Thank you for your purchase, ${name}! Your order will be shipped to: ${address}`);
        console.log("Order Summary:");
        console.log("Shipping Info:", name, address, email, phone);
        console.log("Cart Details:", JSON.parse(localStorage.getItem('cart')));
    } else {
        alert("Please fill out all the fields.");
    }
});

// On page load, display cart items
window.onload = function () {
    displayCartItems();
};

function goBack() {
    window.history.back();
}

