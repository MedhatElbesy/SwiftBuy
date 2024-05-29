import { CommonModule } from '@angular/common';
import { Component, OnInit } from '@angular/core';
import { Product } from '../../models/product';
import { ProductService } from '../../services/product.service';
import { FormsModule } from '@angular/forms';
import { RouterLink } from '@angular/router';
import { Subscription } from 'rxjs';
import { HeaderComponent } from '../header/header.component';
import { FooterComponent } from '../footer/footer.component';

@Component({
    selector: 'app-user-home',
    standalone: true,
    templateUrl: './user-home.component.html',
    styleUrl: './user-home.component.css',
    imports: [CommonModule, FormsModule,RouterLink,HeaderComponent,FooterComponent]
})
export class UserHomeComponent {
    products: Product[] = [];
    filteredProducts: Product[] = [];
    imageDirectoryPath: any = "http://127.0.0.1:8000/images/";
    sub: Subscription | null = null;

    constructor(
        private productService: ProductService,
      ) {}

    ngOnInit(): void {
        this.sub = this.productService.getAllProducts().subscribe({
          next: (data) => {
            this.products = data;
            this.filteredProducts = data;
          },
        });
      }
}
