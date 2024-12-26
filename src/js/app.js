setTimeout(() => {
    const alert = document.querySelector('.alert.success');
    if (alert) {
        alert.remove();
    }
}, 5000); // 5 seconds

// document.addEventListener('DOMContentLoaded', () => {
//     startApp();
// });

// function startApp(){
//     cart();
// }

// function cart(){
//     const buttons = document.querySelectorAll('.cart-button');
//     buttons.forEach(button => {
//         button.addEventListener('click', (e) => {
//             addToCart(e.target.dataset.product)
//         });
//     });
// }

// function addToCart(productId){
//     alert('Se agregó el producto ' + productId + ' al carrito');
// }