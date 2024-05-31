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
  cart: { product_id: number }[] = []; // Store products in the cart
  successMessage: string | null = null;



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

    const userId = localStorage.getItem('id');
    if (userId) {
      // Check if each product is in the cart and update UI accordingly
      this.products.forEach((product) => {
        this.cartService.isProductInCart(product.id).subscribe((isInCart) => {
          if (isInCart) {
            // If product is in cart, update its status to "Already in Cart"
          }
        });
      });
    }
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
    this.cartService.isProductInCart(product.id).subscribe({
      next: (isInCart) => {
        if (isInCart) {
          this.successMessage = `${product.title} is already in your cart.`;
          this.autoCloseAlert();
        } else {
          const newItem = {
            user_id: userId,
            product_id: product.id,
            quantity: 1,
            price: product.price,
          };

          this.cartService.addToCart(newItem).subscribe({
            next: (response) => {
              console.log('Item added to cart:', response);
              this.successMessage = `${product.title} has been added to your cart!`;
              this.autoCloseAlert();
            },
            error: (error) => {
              console.error('Error adding item to cart:', error);
            },
          });
        }
      },
      error: (error) => {
        console.error('Error checking cart:', error);
      },
    });
  }
  autoCloseAlert(): void {
    setTimeout(() => {
      this.successMessage = null;
    }, 3000);
  }


  ngOnDestroy(): void {
    this.sub?.unsubscribe();
  }

}
