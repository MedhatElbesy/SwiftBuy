import { Component, OnInit } from '@angular/core';
import { Product } from '../../models/product';
import { ActivatedRoute, RouterLink } from '@angular/router';
import { ProductService } from '../../services/product.service';
import { CartService } from '../../services/cart.service.';
import { HeaderComponent } from '../../components/header/header.component';
import { CommonModule } from '@angular/common';

@Component({
  selector: 'app-product-details',
  standalone: true,
  imports: [RouterLink,HeaderComponent,CommonModule],
  templateUrl: './product-details.component.html',
  styleUrl: './product-details.component.css'
})
export class ProductDetailsComponent implements OnInit {
  product: Product | null = null;
  imageDirectoryPath: any = "http://127.0.0.1:8000/images/";
  successMessage: string | null = null;
  constructor(public activatedRoute: ActivatedRoute, public productService: ProductService,public cartService: CartService) { }
  ngOnInit(): void {
    this.activatedRoute.params.subscribe((params) => {
      this.productService.getProductById(params['id']).subscribe((product) => {
        this.product = product
      })
    })
  }
  addToCart(product: any): void {
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
}
