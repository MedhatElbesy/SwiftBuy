import { CommonModule } from '@angular/common';
import { Component, OnInit } from '@angular/core';
import { Product } from '../models/product';
import { ProductService } from '../services/product.service';
import { Subscription } from 'rxjs';
import { FormsModule } from '@angular/forms';
import { CartService } from '../services/cart.service.';
import { RouterLink } from '@angular/router';


@Component({
  selector: 'app-products',
  standalone: true,
  imports: [CommonModule, FormsModule,RouterLink],
  templateUrl: './products.component.html',
  styleUrl: './products.component.css',
})
export class ProductsComponent implements OnInit {
  products: Product[] = [];
  sub: Subscription | null = null;
  filteredProducts: Product[] = [];
  searchQuery: string = '';
  imageDirectoryPath: any = "http://127.0.0.1:8000/images/";

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
  addToCart(product: any): void {
    const cart_id = localStorage.getItem('cart_id');


    const newItem = {
      product_id: product.id,
      quantity: 1,
      cart_id: cart_id,
    };

    this.cartService.addToCart(newItem).subscribe(
      (response) => {
        console.log('Item added to cart:', response);
        if (!localStorage.getItem('cart_id')) {
          localStorage.setItem('cart_id', response.data.id);
        }

      },
      (error) => {
        console.error('Error adding item to cart:', error);

      }
    );
  }

  ngOnDestroy(): void {
    this.sub?.unsubscribe();
  }
}
