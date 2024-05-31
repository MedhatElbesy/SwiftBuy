import { CommonModule } from '@angular/common';
import { Component, OnInit } from '@angular/core';
import { Product } from '../models/product';
import { ProductService } from '../services/product.service';
import { Subscription } from 'rxjs';
import { FormsModule } from '@angular/forms';
import { CartService } from '../services/cart.service.';
import { RouterLink } from '@angular/router';
import { HeaderComponent } from '../components/header/header.component';


@Component({
  selector: 'app-products',
  standalone: true,
  imports: [CommonModule, FormsModule,RouterLink,HeaderComponent],
  templateUrl: './products.component.html',
  styleUrl: './products.component.css',
})
export class ProductsComponent implements OnInit {
  products: Product[] = [];
  sub: Subscription | null = null;
  filteredProducts: Product[] = [];
  searchQuery: string = '';
  imageDirectoryPath: any = "http://127.0.0.1:8000/images/";
  // cart: { product_id: number }[] = []; // Store products in the cart


  constructor(
    private productService: ProductService,
    private cartService: CartService
  ) {}
  ngOnInit(): void {
    this.sub = this.productService.getAllProducts().subscribe({
      next: (data) => {
        this.products = data;
        this.filteredProducts = data;
      },
    });
    // this.loadCartItems();

  }
  onSearch(): void {
    if (this.searchQuery) {
      this.filteredProducts = this.products.filter((product) =>
        product.title.toLowerCase().includes(this.searchQuery.toLowerCase())
      );
    } else {
      this.filteredProducts = this.products;
    }
  }
  addToCart(product: Product): void {
    const userId = localStorage.getItem('id'); // Retrieve the user_id from local storage
    // console.log(userId);
    // const userId = 2;


    if (!userId) {
      console.error('User ID is not available in local storage');
      return;
    }

    const newItem = {
      user_id: Number(userId), // Ensure user_id is a number
      // id:3,
      // user_id: 2, // Ensure user_id is a number
      product_id: product.id,
      quantity: 1,
      price: product.price, // Assuming price is part of the product object
    };

    this.cartService.addToCart(newItem).subscribe(
      (response) => {
        console.log('Item added to cart:', response);
      },
      (error) => {
        console.error('Error adding item to cart:', error);
      }
    );
  }


  ngOnDestroy(): void {
    this.sub?.unsubscribe();
  }
  // loadCartItems(): void {
  //   const userId = localStorage.getItem('id');
  //   if (!userId) {
  //     console.error('User ID is not available in local storage');
  //     return;
  //   }

  //   this.cartService.getCartItems(Number(userId)).subscribe(
  //     (response) => {
  //       this.cart = response;
  //     },
  //     (error) => {
  //       console.error('Error loading cart items:', error);
  //     }
  //   );
  // }

  // isProductInCart(productId: number): boolean {
  //   return this.cart.some((item) => item.product_id === productId);
  // }

  // toggleCart(product: Product): void {
  //   if (this.isProductInCart(product.id)) {
  //     this.removeFromCart(product.id);
  //   } else {
  //     this.addToCart(product);
  //   }
  // }

  // addToCart(product: Product): void {
  //   const userId = localStorage.getItem('id');
  //   if (!userId) {
  //     console.error('User ID is not available in local storage');
  //     return;
  //   }

  //   const newItem = {
  //     user_id: Number(userId),
  //     product_id: product.id,
  //     quantity: 1,
  //     price: product.price,
  //   };

  //   this.cartService.addToCart(newItem).subscribe(
  //     (response) => {
  //       console.log('Item added to cart:', response);
  //       this.loadCartItems(); // Refresh cart items
  //     },
  //     (error) => {
  //       console.error('Error adding item to cart:', error);
  //     }
  //   );
  // }

  // removeFromCart(productId: number): void {
  //   this.cartService.delete(productId).subscribe(
  //     (response) => {
  //       console.log('Item removed from cart:', response);
  //       this.loadCartItems(); // Refresh cart items
  //     },
  //     (error) => {
  //       console.error('Error removing item from cart:', error);
  //     }
  //   );
  // }
  // addToCart(product: any): void {
  //   const cart_id = localStorage.getItem('cart_id');


  //   const newItem = {
  //     product_id: product.id,
  //     quantity: 1,
  //     cart_id: cart_id,
  //   };

  //   this.cartService.addToCart(newItem).subscribe(
  //     (response) => {
  //       console.log('Item added to cart:', response);
  //       if (!localStorage.getItem('cart_id')) {
  //         localStorage.setItem('cart_id', response.data.id);
  //       }

  //     },
  //     (error) => {
  //       console.error('Error adding item to cart:', error);

  //     }
  //   );
  // }
}
