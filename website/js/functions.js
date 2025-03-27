function changeAddToCartIcon() {
    const icon = this.querySelector('i');
    icon.classList.remove('bi-cart-plus-fill');
    icon.classList.add('bi-check-lg');
    setTimeout(() => {
        icon.classList.remove('bi-check-lg');
        icon.classList.add('bi-cart-plus-fill');
    }, 1500);
}