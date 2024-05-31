import { CommonModule } from '@angular/common';
import { Component, OnInit } from '@angular/core';
import { Product } from '../../models/product';
import { ProductService } from '../../services/product.service';
import { FormsModule } from '@angular/forms';
import { RouterLink } from '@angular/router';
import { Subscription } from 'rxjs';
import { HeaderComponent } from '../header/header.component';
import { FooterComponent } from '../footer/footer.component';
// import { CarouselModule, OwlOptions } from 'ngx-owl-carousel-o';

@Component({
    selector: 'app-user-home',
    standalone: true,
    templateUrl: './user-home.component.html',
    styleUrl: './user-home.component.css',
    imports: [FormsModule,RouterLink,HeaderComponent,FooterComponent, CommonModule]
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


    //   customOptions: OwlOptions = {
    //     loop: true,
    //     mouseDrag: true,
    //     touchDrag: true,
    //     pullDrag: true,
    //     dots: true,
    //     navSpeed: 700,
    //     navText: ['', ''],
    //     responsive: {
    //       0: {
    //         items: 1
    //       },
    //       400: {
    //         items: 2
    //       },
    //       740: {
    //         items: 3
    //       },
    //       940: {
    //         items: 4
    //       }
    //     },
    //     nav: true
    // }
}
