// src/app/cart/cart.component.ts
import { Component, OnInit } from '@angular/core';
import { Cart } from '../models/cart';
import { CartService } from '../services/cart.service';
import { CommonModule } from '@angular/common';

@Component({
  selector: 'app-cart',
  standalone: true,
  templateUrl: './cart.component.html',
  styleUrls: ['./cart.component.css'],
  imports : [CommonModule],
})
export class CartComponent implements OnInit {
  cartItems: Cart[] = [];

  constructor(private cartService: CartService) { }

  ngOnInit(): void {
    this.cartService.getCart().subscribe(
      (cartItems: Cart[]) => {
        this.cartItems = cartItems;
      },
      (error) => {
        console.error('Error fetching cart data:', error);
      }
    );
  }

  increaseQuantity(item: Cart): void {
    item.quantity++;
    this.updateCartItem(item);
  }

  decreaseQuantity(item: Cart): void {
    if (item.quantity > 1) {
      item.quantity--;
      this.updateCartItem(item);
    }
  }

  updateCartItem(item: Cart): void {
    this.cartService.updateCartItem(item).subscribe(
      (updatedItem: Cart) => {
        console.log('Cart item updated:', updatedItem);
      },
      (error) => {
        console.error('Error updating cart item:', error);
      }
    );
  }
}
