import { CommonModule } from '@angular/common';
import { Component, OnInit } from '@angular/core';
import { Product } from '../models/product';
import { ProductService } from '../services/product.service';
import { Subscription } from 'rxjs';

@Component({
  selector: 'app-products',
  standalone: true,
  imports: [CommonModule],
  templateUrl: './products.component.html',
  styleUrl: './products.component.css'
})
export class ProductsComponent implements OnInit {
  products: Product[] = [];
  sub:Subscription| null = null;

  constructor(private productService: ProductService) { }
  ngOnInit(): void {
    this.sub = this.productService.getAllProducts().subscribe({
      next: data=>{
        this.products = data;}
    }
    )
  }

  ngOnDestroy(): void {
    this.sub?.unsubscribe();
  }

}
