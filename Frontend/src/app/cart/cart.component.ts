// src/app/cart/cart.component.ts
import { Component, OnInit } from '@angular/core';
import { Cart } from '../models/cart';
import { CartService } from '../services/cart.service';
import { CommonModule } from '@angular/common';
import { Route, Router } from '@angular/router';

@Component({
  selector: 'app-cart',
  standalone: true,
  templateUrl: './cart.component.html',
  styleUrls: ['./cart.component.css'],
  imports : [CommonModule],
})
export class CartComponent implements OnInit {
  cartItems: Cart[] = [];

  constructor(private cartService: CartService,private router:Router) { }

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
    this.cartService.updateCartItem(item).subscribe(
      () => {
        this.updateCartItem(item);
      },
      (error) => {
        console.error('Error updating cart item:', error);
      }
    );
  }

  decreaseQuantity(item: Cart): void {
    if (item.quantity > 1) {
      item.quantity--;
      this.cartService.updateCartItem(item).subscribe(
        () => {
          this.updateCartItem(item);
        },
        (error) => {
          console.error('Error updating cart item:', error);
        }
      );
    } else {
      // Remove from UI first
      this.cartItems = this.cartItems.filter(cartItem => cartItem.id !== item.id);
      // Call the delete API
      this.cartService.deleteCartItem(item.id).subscribe(
        () => {
          console.log('Cart item deleted successfully');
        },
        (error) => {
          console.error('Error deleting cart item:', error);
        }
      );
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
  checkout(): void {
    const totalPrice = this.cartItems.reduce((total, item) => total + (item.price * item.quantity), 0);
    console.log("total price is" , totalPrice)

    const date = new Date();
    const formattedDate = `${date.getFullYear()}-${(date.getMonth() + 1).toString().padStart(2, '0')}-${date.getDate().toString().padStart(2, '0')} ${date.getHours().toString().padStart(2, '0')}:${date.getMinutes().toString().padStart(2, '0')}:${date.getSeconds().toString().padStart(2, '0')}`;
    const storedUserId = localStorage.getItem('id');
    const userId = storedUserId ? +storedUserId : 0;
    const orderRequest = {
      user_id: userId,
      total_price: totalPrice,
      date: formattedDate,
      status: 'pending',
      items: this.cartItems
    };

    this.cartService.createOrder(orderRequest).subscribe(
      (order) => {
        console.log('Order created successfully:', order);
        this.router.navigate(['/users']); // Navigate to order confirmation page
      },
      (error) => {
        console.error('Error creating order:', error);
      }
    );
  }
}
